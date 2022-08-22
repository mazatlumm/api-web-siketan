<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Chat_pakar extends RestController
{
    public function index_get(){
        $this->db->order_by('id_chat', 'desc');
        $get_chat_pakar = $this->db->get_where('chat_pakar')->result_array();
        if($get_chat_pakar){
            foreach ($get_chat_pakar as $key => $value) {
                $pengirim = $value['pengirim'];
                $arrPengirim[] = $pengirim;
            }
            $dataPengirim = array_values(array_unique($arrPengirim));
            foreach ($dataPengirim as $key => $value_pengirim) {
                $id_pengirim = $value_pengirim;
                //cek waktu pengiriman
                $this->db->order_by('id_chat', 'desc');
                $get_chat_pakar_user = $this->db->get_where('chat_pakar', ['pengirim' => $id_pengirim])->result_array();
                if($get_chat_pakar_user){
                    $createdAt = $get_chat_pakar_user[0]['createdAt'];
                    $pesan = $get_chat_pakar_user[0]['pesan'];
                    $id_pakar = $get_chat_pakar_user[0]['id_pakar'];
                }else{
                    $createdAt = date('Y-m-d H:i:s');
                    $pesan = 'Tidak ada pesan';
                    $id_pakar = null;
                }
                $get_users = $this->db->get_where('users', ['id_user' => $id_pengirim])->result_array();
                if($get_users){
                    $nama = $get_users[0]['nama'];
                    $photo = $get_users[0]['photo'];
                    $pekerjaan = $get_users[0]['pekerjaan'];
                    $role = $get_users[0]['role'];
                    if($role == 'penyuluh'){
                        $dataListChat[] = [
                            'nama' => $nama,
                            'photo' => $photo,
                            'pesan' => $pesan,
                            'pekerjaan' => $pekerjaan,
                            'id_user' => $value_pengirim,
                            'createdAt' => $createdAt,
                            'role' => $role,
                            'id_pakar' => $id_pakar,
                        ];
                    }
                }else{
                    $dataListChat = [];
                }
            }
            $this->response([
                'status' => true,
                'message' => 'success',
                'result' => $dataListChat
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'tidak ada chat masuk'
            ],404);
        }
    }

// Catatan Chat Pakar API chat_get, tidak selamanya yang mengirim adalah penyuluh, terkadang yang mengirim adalah id_pakar, untuk membedakannya, jika id_pakar kosong, maka yang mengirim adalah penyuluh, namun jika kedua duanya terisi maka yang mengirim adalah pakar.

    public function chat_get(){
        $id_user = $this->get('id_user');
        $role = $this->get('role');
        if($role == 'penyuluh'){
            $this->db->order_by('id_chat', 'desc');
            $get_chat_pakar = $this->db->get_where('chat_pakar', ['pengirim' => $id_user])->result_array();
            if($get_chat_pakar){
                foreach ($get_chat_pakar as $key => $value) {
                    $id_pengirim = $value['pengirim'];
                    if($id_user == $id_pengirim){
                        $id_pengirim = $value['id_pakar'];
                        if($id_pengirim == null){
                            $id_pengirim = $value['pengirim'];
                        }
                    }
                    $ArrayChatFix[] = [
                        '_id' => $value['penerima'],
                        'text' => $value['pesan'],
                        'createdAt' => $value['createdAt'],
                        'user' => [
                            '_id' => $id_pengirim,
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
        }else{
            $this->db->order_by('id_chat', 'desc');
            $get_chat_pakar = $this->db->get_where('chat_pakar', ['pengirim' => $id_user])->result_array();
            if($get_chat_pakar){
                foreach ($get_chat_pakar as $key => $value) {
                    $ArrayChatFix[] = [
                        '_id' => $value['penerima'],
                        'text' => $value['pesan'],
                        'createdAt' => $value['createdAt'],
                        'user' => [
                            '_id' => $value['id_pakar'],
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
    }

    public function chat_post(){
        $nama_pengirim = $this->post('nama_pengirim');
        $pesan = $this->post('pesan');
        $pengirim = $this->post('pengirim');
        $penerima = md5(sha1(date('Y-m-d H:i:s').$pengirim.$pesan));
        $avatar_pengirim = $this->post('avatar_pengirim');
        $createdAt = $this->post('createdAt');
        $id_penanya = $this->post('id_penanya');
        $role_user = $this->post('role_user');
        if($role_user == 'penyuluh'){
            $data = [
                'pengirim' => $pengirim,
                'nama_pengirim' => $nama_pengirim,
                'penerima' => $penerima,
                'pesan' => $pesan,
                'avatar_pengirim' => $avatar_pengirim,
                'createdAt' => $createdAt,
            ];
        }else{
            $data = [
                'pengirim' => $id_penanya,
                'id_pakar' => $pengirim,
                'nama_pengirim' => $nama_pengirim,
                'penerima' => $penerima,
                'pesan' => $pesan,
                'avatar_pengirim' => $avatar_pengirim,
                'createdAt' => $createdAt,
            ];
        }

        //cek pengirim, pakar atau tidak?
        $get_users = $this->db->get_where('users', ['id_user' => $pengirim])->result_array();
        if($get_users){
            $role = $get_users[0]['role'];
        }else{
            $role = null;
        }

        if($role == 'admin' || $role == 'pakar'){
            //yang dapat notifikasi adalah penanya
            $get_users_penanya = $this->db->get_where('users', ['id_user' => $id_penanya])->result_array();
            if($get_users_penanya){
                $token = $get_users_penanya[0]['token'];
            }
            $postdata = json_encode(
                [
                    'notification' => 
                        [
                            'title' => "Tanya Pakar",
                            'body' => $nama_pengirim. ": " .$pesan,
                            // 'click_action' => "kelasbertani://topik/diskusi"
                        ]
                    ,
                    'to' => $token
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
            if($token != null){
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
            }
            //simpan chat
            $insert = $this->db->insert('chat_pakar', $data);
            if($insert){
                $this->response([
                    'status' => true,
                    'message' => 'success',
                    'token' => $token,
                    'notification' => $statusNotifikasi
                ],200);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'failed',
                ],404);
            }
        } else{
            //yang dapat notifikasi adalah pakar
        }
        $this->db->where('role !=', 'penyuluh');
        $get_users = $this->db->get('users')->result_array();
        if($get_users){
            $arrToken = [];
            foreach ($get_users as $key => $value) {
                if($get_users){
                    $token = $get_users[0]['token'];
                }else{
                    $token = null;
                }
                if($token != null){
                    $arrToken[] = $token;
                }
            }
            $arrayTokenChat = (array_values(array_unique($arrToken)));
            //kirim notifikasi 
            $postdata = json_encode(
                [
                    'notification' => 
                        [
                            'title' => "Tanya Pakar",
                            'body' => $nama_pengirim. ": " .$pesan,
                            // 'click_action' => "kelasbertani://topik/diskusi"
                        ]
                    ,
                    'to' => $token
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
            if(count($arrayTokenChat) != 0){
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
            }
            //simpan chat
            $insert = $this->db->insert('chat_pakar', $data);
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
            $this->response([
                'status' => false,
                'message' => 'admin & pakar tidak ditemukan',
            ],404);
        }
    }

    public function hapus_chat_get(){
        $id_chat = $this->get('id_chat');
        $this->db->where('id_chat', $id_chat);
        $this->db->delete('chat_pakar');
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