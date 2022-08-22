<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Token extends RestController
{
    public function index_get(){
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $key1 = substr(str_shuffle($permitted_chars), 0, 30);
        $data_hash = md5(date('Y-m-d H:i:s')).$key1;

        //cek token apakah udah ada yg pakek
        $get_token = $this->db->get_where('token', ['key_token' => $data_hash])->result_array();
        if($get_token){
            //token harus diganti
            //caranya dengan menambahkan id_token terakhir
            $this->db->order_by('id_token', 'desc');
            $get_tokenGo = $this->db->get_where('token')->result_array();
            if($get_tokenGo){
                $last_id_token = $get_tokenGo[0]['id_token'] + 1;
                $data_hash = md5(date('Y-m-d H:i:s')).$key1.$last_id_token;
                $insert = $this->db->insert('token', ['key_token' => $data_hash]);
                if($insert){
                    $this->response([
                        'status' => true,
                        'message' => 'success',
                        'token' => $data_hash,
                    ],200);
                }else{
                    $this->response([
                        'status' => false,
                        'message' => 'failed',
                    ],404);
                }
            }
        }else{
            $insert = $this->db->insert('token', ['key_token' => $data_hash]);
            if($insert){
                $this->response([
                    'status' => true,
                    'message' => 'success',
                    'token' => $data_hash,
                ],200);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'failed',
                ],404);
            }
        }
    }

    public function change_post(){
        $id_user = $this->post('id_user');
        $token = $this->post('token');

        $this->db->where('id_user', $id_user);
        $this->db->update('users', ['token' => $token, 'updated' => date('Y-m-d H:i:s')]);
        if($this->db->affected_rows()){
            $this->response([
                'status' => true,
                'message' => 'token berhasil masuk server',
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'token gagal masuk server',
            ],404);
        }
    }
}