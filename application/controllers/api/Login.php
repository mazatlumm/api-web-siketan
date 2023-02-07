<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Login extends RestController
{
    public function index_post(){
        $email = $this->post('email');
        $password = $this->post('password');

        $data_where = [
            'email' => $email,
            'password' => md5($password)
        ];
        $this->db->select('id_user, nama, email');
        $login = $this->db->get_where('users', $data_where)->result_array();
        if($login){
            $this->response([
                'status' => true,
                'message' => 'success login',
                'result' => $login
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed login',
            ],404);
        }
    }
}