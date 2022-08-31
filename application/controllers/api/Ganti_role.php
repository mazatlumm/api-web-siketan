<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Ganti_role extends RestController
{
    public function index_get(){
        $this->db->where('role', 'penyuluh');
        $this->db->update('users', ['role' => 'Pengguna Umum']);
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