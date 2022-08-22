<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Topik_diskusi extends RestController
{
    public function index_get(){
        $get_topik_diskusi = $this->db->get_where('topik_diskusi', ['status !=' => 'dihapus' ])->result_array();
        $arrData = [];
        if($get_topik_diskusi){
            foreach ($get_topik_diskusi as $key => $value) {
                $id_user = $value['id_user'];
                $get_users = $this->db->get_where('users', ['id_user' => $id_user])->result_array();
                if($get_users){
                    $username = $get_users[0]['username'];
                }else{
                    $username = 'anonymous';
                }
                $arrData[] = [
                    'id_user' => $value['id_user'],
                    'id_topik' => $value['id_topik'],
                    'judul_topik' => $value['judul_topik'],
                    'deskripsi' => $value['deskripsi'],
                    'status' => $value['status'],
                    'follower' => $value['follower'],
                    'dilihat' => $value['dilihat'],
                    'created_by' => $username,
                    'created' => $value['created'],
                    'updated' => $value['updated'],
                ];
            }
        }
        $this->response([
            'status' => true,
            'message' => 'success',
            'result' => $arrData
        ],200);
    }

    public function index_post(){
        $id_user = $this->post('id_user');
        $judul_topik = $this->post('judul_topik');
        $deskripsi = $this->post('deskripsi');

        $data = [
            'id_user' => $id_user,
            'judul_topik' => $judul_topik,
            'deskripsi' => $deskripsi,
            'status' => 'Baru Dibuat',
            'follower' => 0,
            'dilihat' => 0,
            'updated' => date('Y-m-d H:i:s')
        ];

        $insert_topik = $this->db->insert('topik_diskusi', $data);
        if($insert_topik){
            $this->response([
                'status' => true,
                'message' => 'success',
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed',
            ],404);
        }
    }

    public function cek_chat_get(){
        $this->db->order_by('id_chat', 'desc');
        $id_topik = $this->get('id_topik');
        $get_chat_diskusi = $this->db->get_where('chat_diskusi', ['id_topik' => $id_topik])->result_array();
        if($get_chat_diskusi){
            foreach ($get_chat_diskusi as $key => $value) {
                $ArrayChatFix[] = [
                    '_id' => $value['penerima'],
                    'text' => $value['pesan'],
                    'createdAt' => $value['createdAt'],
                    'user' => [
                        '_id' => $value['pengirim'],
                        'name' => $value['nama_pengirim'],
                        'avatar' => $value['avatar_pengirim'],
                        'id_chat' => $value['id_chat'],
                    ],
                ];
            }
            $this->response([
                'status' => true,
                'message' => 'success',
                'result' => $ArrayChatFix
            ],200);
        }else{
            $this->response([
                'status' => true,
                'message' => 'success',
                'result' => []
            ],200);
        }
    }

    public function chat_post(){
        $id_topik = $this->post('id_topik');
        $nama_pengirim = $this->post('nama_pengirim');
        $pesan = $this->post('pesan');
        $pengirim = $this->post('pengirim');
        $penerima = md5(sha1(date('Y-m-d H:i:s').$id_topik.$pengirim.$pesan));
        $avatar_pengirim = $this->post('avatar_pengirim');
        $createdAt = $this->post('createdAt');

        $data = [
            'id_topik' => $id_topik,
            'pengirim' => $pengirim,
            'nama_pengirim' => $nama_pengirim,
            'penerima' => $penerima,
            'pesan' => $pesan,
            'avatar_pengirim' => $avatar_pengirim,
            'createdAt' => $createdAt,
        ];

        $get_topik_diskusi = $this->db->get_where('topik_diskusi', ['id_topik' => $id_topik])->result_array();
        if($get_topik_diskusi){
            $judul_topik = "Ruang Diskusi (".$get_topik_diskusi[0]['judul_topik'].")";
        }else{
            $judul_topik = "Ruang Diskusi";
        }

        $get_chat_diskusi = $this->db->get_where('chat_diskusi', ['id_topik' => $id_topik])->result_array();
        if($get_chat_diskusi){
            $arrToken = [];
            foreach ($get_chat_diskusi as $key => $value) {
                $id_user_pengirim = $value['pengirim'];
                $get_users = $this->db->get_where('users', ['id_user' => $id_user_pengirim])->result_array();
                if($get_users){
                    $token = $get_users[0]['token'];
                }else{
                    $token = null;
                }
                if($token != null){
                    $arrToken[] = $token;
                }
            }
            if(count($arrToken) != 0){
                $arrayTokenChat = (array_values(array_unique($arrToken)));
                //kirim notifikasi
                $postdata = json_encode(
                    [
                        'notification' => 
                            [
                                'title' => $judul_topik,
                                'body' => $nama_pengirim. ": " .$pesan,
                                // 'click_action' => "kelasbertani://topik/diskusi"
                            ]
                        ,
                        'registration_ids' => $arrayTokenChat
                    ]
                );
            
                $opts = array('http' =>
                    array(
                        'method'  => 'POST',
                        'header'  => 'Content-type: application/json'."\r\n"
                                    .'Authorization:'.'key=AAAAWBfv5Pg:APA91bFkM2F9IDLmOFl10IXt4exFpDkrFiWPmpNFRF2Pv0wwsZZKVDLeO_PQKQHtk0iYaSFD3B5LwJYaCGjmGNjP_nRTTy9j0rUETR9p92oRhwYomnL4eXqKv5hX3EKXu_P-1dVQ4q7d'."\r\n",
                        'content' => $postdata
                    )
                );
            
                $context  = stream_context_create($opts);
                $statusNotifikasi = 0;
                $result = file_get_contents('https://fcm.googleapis.com/fcm/send', false, $context);
                if($result) {
                    $decoded_json = json_decode($result, false);
                    if($decoded_json->success == 1){
                        $statusNotifikasi = 1;
                    }else{
                        $statusNotifikasi = 0;
                    }
                } else {
                    $statusNotifikasi = 0;
                }
            }else{
                $statusNotifikasi = 0;
                $arrayTokenChat = [];
            }

            $insert = $this->db->insert('chat_diskusi', $data);
            if($insert){
                $this->response([
                    'status' => true,
                    'message' => 'success',
                    'token' => $arrayTokenChat,
                    'notification' => $statusNotifikasi
                ],200);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'failed',
                ],404);
            }
        }else{
            $insert = $this->db->insert('chat_diskusi', $data);
            if($insert){
                $this->response([
                    'status' => true,
                    'message' => 'success',
                    'token' => [],
                    'notification' => 0
                ],200);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'failed',
                ],404);
            }
        }

    }

    public function hapus_chat_get(){
        $id_chat = $this->get('id_chat');
        $this->db->where('id_chat', $id_chat);
        $this->db->delete('chat_diskusi');
        if($this->db->affected_rows()){
            $this->response([
                'status' => true,
                'message' => 'success',
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed',
            ],404);
        }
    }

    public function favorit_get(){
        $id_topik = $this->get('id_topik');
        $id_user = $this->get('id_user');
        $cek_favorit = $this->db->get_where('topik_diskusi_favorit', ['id_user' => $id_user, 'id_topik' => $id_topik])->result_array();
        if(!$cek_favorit){
            $insert_favorit = $this->db->insert('topik_diskusi_favorit', ['id_topik' => $id_topik, 'id_user' => $id_user]);
            if($insert_favorit){
                $this->response([
                    'status' => true,
                    'message' => 'success',
                ],200);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'failed',
                ],404);
            }
        }else{
            $this->response([
                'status' => true,
                'message' => 'sudah masuk ke dalam daftar favorit',
            ],200);
        }
    }

    public function favorit_list_get(){
        $id_user = $this->get('id_user');
        $where = [
            'id_user' => $id_user,
        ];
        $arrData = [];
        $get_topik_diskusi_favorit = $this->db->get_where('topik_diskusi_favorit', $where)->result_array();
        if($get_topik_diskusi_favorit){
            foreach ($get_topik_diskusi_favorit as $key => $value) {
                $id_topik = $value['id_topik'];
                $get_topik_diskusi = $this->db->get_where('topik_diskusi', ['id_topik' => $id_topik])->result_array();
                if($get_topik_diskusi){
                    $get_users = $this->db->get_where('users', ['id_user' => $get_topik_diskusi[0]['id_user']])->result_array();
                    if($get_users){
                        $username = $get_users[0]['username'];
                    }else{
                        $username = 'anonymous';
                    }
                    $arrData[] = [
                        'id_user' => $get_topik_diskusi[0]['id_user'],
                        'id_topik' => $id_topik,
                        'judul_topik' => $get_topik_diskusi[0]['judul_topik'],
                        'deskripsi' => $get_topik_diskusi[0]['deskripsi'],
                        'status' => $get_topik_diskusi[0]['status'],
                        'follower' => $get_topik_diskusi[0]['follower'],
                        'dilihat' => $get_topik_diskusi[0]['dilihat'],
                        'created_by' => $username,
                        'created' => $get_topik_diskusi[0]['created'],
                        'updated' => $get_topik_diskusi[0]['updated'],
                    ];
                }else{
                    $arrData = [];
                }
            }
        }
        $this->response([
            'status' => true,
            'message' => 'success',
            'result' => $arrData,
        ],200);
    }

    public function favorit_hapus_get(){
        $id_user = $this->get('id_user');
        $id_topik = $this->get('id_topik');

        $where = [
            'id_user' => $id_user,
            'id_topik' => $id_topik,
        ];
        $this->db->where($where);
        $this->db->delete('topik_diskusi_favorit');
        if($this->db->affected_rows()){
            $this->response([
                'status' => true,
                'message' => 'success',
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed',
            ],404);
        }
    }

    public function hapus_get(){
        $id_topik = $this->get('id_topik');
        $this->db->where('id_topik', $id_topik);
        $this->db->update('topik_diskusi', ['status' => 'dihapus']);
        if($this->db->affected_rows()){
            $this->response([
                'status' => true,
                'message' => 'success',
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed',
            ],404);
        }
    }
}