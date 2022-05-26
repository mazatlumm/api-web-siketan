<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class User extends RestController
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }

    public function login_post()
    {
        $username = $this->post('username');
        $password = $this->post('password');

        $data = [
            'username' => $username,
            'password' => md5($password),
        ];
        $this->db->select('id_user, username, nama, pekerjaan, role');
        $get_users = $this->db->get_where('users', $data)->result_array();
        if ($get_users) {
            $this->response([
                'status' => true,
                'message' => 'success',
                'result' => $get_users
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed',
                'result' => []
            ], 404);
        }
    }

    public function list_get()
    {
        $this->db->select('id_user, username, nama, pekerjaan, role');
        $get_users = $this->db->get_where('users', ['role !=' => 'admin' ])->result_array();
        if ($get_users) {
            $this->response([
                'status' => true,
                'message' => 'success',
                'result' => $get_users
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed',
                'result' => []
            ], 404);
        }
    }

    public function detail_get()
    {
        $id_user = $this->get('id_user');
        $this->db->select('id_user, username, nama, pekerjaan, role');
        $get_users = $this->db->get_where('users', ['id_user' => $id_user])->result_array();
        if ($get_users) {
            $this->response([
                'status' => true,
                'message' => 'success',
                'result' => $get_users
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed',
                'result' => []
            ], 404);
        }
    }

    public function tambah_post()
    {
        $username = $this->post('username');
        $nama = $this->post('nama');
        $pekerjaan = $this->post('pekerjaan');
        $role = $this->post('role');
        $password = $this->post('password');

        if ($username != null || $username != '') {
            //Cek Username apakah sudah pernah digunakan
            $get_users = $this->db->get_where('users', ['username' => $username])->result_array();
            if($get_users){
                $this->response([
                    'status' => false,
                    'message' => 'Duplicate',
                ], 404);
            }else{
                $data = [
                    'username' => $username,
                    'nama' => $nama,
                    'pekerjaan' => $pekerjaan,
                    'role' => $role,
                    'password' => md5($password),
                ];
    
                $insert = $this->db->insert('users', $data);
    
                if ($insert) {
                    $this->response([
                        'status' => true,
                        'message' => 'Success',
                    ], 200);
                } else {
                    $this->response([
                        'status' => false,
                        'message' => 'Failed',
                    ], 404);
                }
            }
        } else {
            $this->response([
                'status' => false,
                'message' => 'Username Belum Diisi',
            ], 404);
        }
    }

    public function edit_post()
    {
        $id_user = $this->post('id_user');
        $username = $this->post('username');
        $nama = $this->post('nama');
        $pekerjaan = $this->post('pekerjaan');
        $password = $this->post('password');

        if($password != null || $password != ''){
            $data = [
                'username' => $username,
                'nama' => $nama,
                'pekerjaan' => $pekerjaan,
                'password' => md5($password),
                'updated' => date('Y-m-d H:i:s')
            ];
        }else{
            $data = [
                'username' => $username,
                'nama' => $nama,
                'pekerjaan' => $pekerjaan,
                'updated' => date('Y-m-d H:i:s')
            ];
        }

        //cek username terlebih dahulu
        $get_users = $this->db->get_where('users', ['id_user' => $id_user])->result_array();

        if($get_users){
            $username_lama = $get_users[0]['username'];
        }else{
            $username_lama = null;
        }

        if($username_lama == $username){
            $this->db->where('id_user', $id_user);
            $this->db->update('users', $data);
    
            if ($this->db->affected_rows()) {
                $this->db->select('id_user, username, nama, pekerjaan, role');
                $get_users = $this->db->get_where('users', ['id_user' => $id_user])->result_array();
                $this->response([
                    'status' => true,
                    'message' => 'success',
                    'result' => $get_users,
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'failed',
                ], 404);
            }
        }else{
            $get_users_scan_username = $this->db->get_where('users', ['username' => $username])->result_array();
            if($get_users_scan_username){
                $this->response([
                    'status' => false,
                    'message' => 'Username Tidak Tersedia',
                ], 404);
            }else{
                $this->db->where('id_user', $id_user);
                $this->db->update('users', $data);
        
                if ($this->db->affected_rows()) {
                    $this->db->select('id_user, username, nama, pekerjaan, role');
                    $get_users = $this->db->get_where('users', ['id_user' => $id_user])->result_array();
                    $this->response([
                        'status' => true,
                        'message' => 'success',
                        'result' => $get_users,
                    ], 200);
                } else {
                    $this->response([
                        'status' => false,
                        'message' => 'failed',
                    ], 404);
                }
            }
        }

    }

    public function hapus_post(){
        $id_user = $this->post('id_user');
        $this->db->where('id_user', $id_user);
        $this->db->delete('users');
        if($this->db->affected_rows()){
            $this->response([
                'status' => true,
                'message' => 'success',
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed',
            ], 404);
        }
    }
}
