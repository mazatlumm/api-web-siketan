<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Chat extends RestController
{
    public function send_post(){
        $id_user1 = $this->post('id_user1');
        $id_user2 = $this->post('id_user2');
        $chat = $this->post('chat');
        $id_chat = $this->post('id_chat');

        $data = [
            'id_user1' => $id_user1,
            'id_user2' => $id_user2,
            'chat' => $chat,
            'updated' => date('Y-m-d H:i:s')
        ];
        
        $dataUpdate = [
            'chat' => $chat,
            'updated' => date('Y-m-d H:i:s')
        ];

        //cek apakah chat sudah ada apa tidak
        if($id_chat == 0){
            $where1 = [
                'id_user1' => $id_user1,
                'id_user2' => $id_user2,
            ];
        }else{
            $where1 = [
                'id' => $id_chat,
            ];
        }

        if($id_chat == 0){
            $where2 = [
                'id_user1' => $id_user2,
                'id_user2' => $id_user1,
            ];
        }else{
            $where2= [
                'id' => $id_chat,
            ];
        }

        $get_chat1 = $this->db->get_where('chat', $where1)->result_array();
        $get_chat2 = $this->db->get_where('chat', $where2)->result_array();

        if($get_chat1){
            //update
            $this->db->where($where1);
            $this->db->update('chat', $dataUpdate);
            if($this->db->affected_rows()){
                $this->response([
                    'status' => true,
                    'message' => 'chat success',
                ],200);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'chat failed',
                ],404);
            }
        }

        if($get_chat2){
            //update
            $this->db->where($where2);
            $this->db->update('chat', $dataUpdate);
            if($this->db->affected_rows()){
                $this->response([
                    'status' => true,
                    'message' => 'chat success',
                ],200);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'chat failed',
                ],404);
            }
        }

        if(!$get_chat1 || !$get_chat2){
            $insert = $this->db->insert('chat', $data);
            if($insert){
                $this->response([
                    'status' => true,
                    'message' => 'chat success',
                ],200);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'chat failed',
                ],404);
            }
        }
    }

    public function conversation_get(){
        $id_user1 = $this->get('id_user1');
        $id_user2 = $this->get('id_user2');
        $role = $this->get('role');
        $id_chat = $this->get('id_chat');

        if($role != 'admin'){
            $where1 = [
                'id_user1' => $id_user1,
                'id_user2' => $id_user2,
            ];
    
            $where2 = [
                'id_user1' => $id_user2,
                'id_user2' => $id_user1,
            ];
        }else{
            $where1 = [
                'id' => $id_chat,
            ];
    
            $where2 = [
                'id' => $id_chat,
            ];
        }


        $get_chat1 = $this->db->get_where('chat', $where1)->result_array();
        $get_chat2 = $this->db->get_where('chat', $where2)->result_array();

        if($get_chat1){
            $this->response([
                'status' => true,
                'message' => 'success',
                'result' => $get_chat1,
            ],200);
        }
        
        if($get_chat2){
            $this->response([
                'status' => true,
                'message' => 'success',
                'result' => $get_chat2,
            ],200);
        }

        if(!$get_chat1 && !$get_chat2){
            $this->response([
                'status' => false,
                'message' => 'chat not found',
            ],404);
        } 
    }

    public function notifikasi_post(){
        $penerima = $this->post('penerima');
        $pesan = $this->post('pesan');
        $nama_pengirim = $pesan['user']['name'];
        $chat = $pesan['text'];

        $get_users_penerima = $this->db->get_where('users', ['id_user' => $penerima])->result_array();
        if($get_users_penerima){
            $nama_penerima = $get_users_penerima[0]['nama'];
            $token_penerima = $get_users_penerima[0]['token'];
            if($token_penerima){
                $dataNotifikasi = [
                    'to' => $token_penerima,
                    'notification' => [
                        'body' => $chat,
                        'title' => $nama_pengirim,
                    ]
                ];
                $curl = curl_init();
        
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($dataNotifikasi),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: key=AAAA4JFifGg:APA91bHENYCSJmm28lW5zQ_0_ATtXmuqY8UcjFXhOnPJ38azca7GCbsKp8iFk9JHgODwKg7a2bSUq9oiGe_Axq2MmW9q2H-bskPHoTjrgfI1YEtRepwDbQwfektSM-MaRg_716RjcBFK',
                    'Content-Type: application/json'
                ),
                ));
        
                $response = curl_exec($curl);
                curl_close($curl);
            }
        }else{
            $nama_penerima = null;
            $token_penerima = null;
        }

        $get_users_admin = $this->db->get_where('users', ['role' => 'admin'])->result_array();
        if($get_users_admin){
            foreach ($get_users_admin as $key => $value) {
                $token_admin = $value['token'];
                if($token_admin){
                    $dataNotifikasi = [
                        'to' => $token_admin,
                        'notification' => [
                            'body' => 'Kepada ' . $nama_penerima . ', isi pesan : ' . $chat,
                            'title' => 'Pesan '.$nama_pengirim,
                        ]
                    ];
                    $curl = curl_init();
            
                    curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($dataNotifikasi),
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: key=AAAA4JFifGg:APA91bHENYCSJmm28lW5zQ_0_ATtXmuqY8UcjFXhOnPJ38azca7GCbsKp8iFk9JHgODwKg7a2bSUq9oiGe_Axq2MmW9q2H-bskPHoTjrgfI1YEtRepwDbQwfektSM-MaRg_716RjcBFK',
                        'Content-Type: application/json'
                    ),
                    ));
            
                    $response = curl_exec($curl);
                    curl_close($curl);
                }
            }
        }

        $this->response([
            'status' => true,
            'message' => 'notification success',
        ],200);
    }

    public function hapus_get(){
        $id_chat = $this->get('id_chat');
        $this->db->where('id', $id_chat);
        $this->db->delete('chat');
        if($this->db->affected_rows()){
            $this->response([
                'status' => true,
                'message' => 'delete messages success'
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'delete messages failed'
            ],404);
        }
    }

    public function list_penyuluh_get(){
        $id_user2 = $this->get('id_user2');
        if($id_user2){
            $get_chat = $this->db->get_where('chat', ['id_user2' => $id_user2])->result_array();
        }else{
            $get_chat = $this->db->get('chat')->result_array();
        }
        if($get_chat){
            $ArrDataPenggunaUmum = [];
            foreach ($get_chat as $key => $value) {
                $chat = json_decode($value['chat'], true);
                $totalPesan = count($chat);
                $pesan_terakhir = $chat[$totalPesan-1]['text'];
                $id_user_chat_terakhir = $chat[$totalPesan-1]['user']['_id'];
                if($value['id_user1'] != $id_user_chat_terakhir){
                    $status = "Sudah Dijawab";
                }else{
                    $status = "Belum Dijawab";
                }
                $get_user_penyuluh = $this->db->get_where('users', ['id_user' => $value['id_user2']])->result_array();
                if($get_user_penyuluh){
                    $nama_penyuluh = $get_user_penyuluh[0]['nama'];
                }else{
                    $nama_penyuluh = null;
                }
                $get_pengguna_umum = $this->db->get_where('users', ['id_user' => $value['id_user1']])->result_array();
                if($get_pengguna_umum){
                    $ArrDataPenggunaUmum[] = [
                        'id' => $value['id'],
                        'id_user' => $get_pengguna_umum[0]['id_user'],
                        'nama' => $get_pengguna_umum[0]['nama'],
                        'email' => $get_pengguna_umum[0]['email'],
                        'gender' => $get_pengguna_umum[0]['gender'],
                        'birthday' => $get_pengguna_umum[0]['birthday'],
                        'role' => $get_pengguna_umum[0]['role'],
                        'pekerjaan' => $get_pengguna_umum[0]['pekerjaan'],
                        'pengalaman' => $get_pengguna_umum[0]['pengalaman'],
                        'rating' => $get_pengguna_umum[0]['rating'],
                        'no_telp' => $get_pengguna_umum[0]['no_telp'],
                        'alamat' => $get_pengguna_umum[0]['alamat'],
                        'photo' => $get_pengguna_umum[0]['photo'],
                        'token' => $get_pengguna_umum[0]['token'],
                        'created' => $get_pengguna_umum[0]['created'],
                        'updated' => $get_pengguna_umum[0]['updated'],
                        'total_pesan' => $totalPesan,
                        'pesan_terakhir' => $pesan_terakhir,
                        'status' => $status,
                        'nama_penyuluh' => $nama_penyuluh,
                    ];
                }
            }
            $this->response([
                'status' => true,
                'message' => 'list chat pengguna',
                'result' => $ArrDataPenggunaUmum
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'list chat pengguna kosong',
            ],404);
        }
    }
}