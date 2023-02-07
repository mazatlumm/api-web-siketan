<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Search extends RestController
{
    public function index_post(){
        $query = $this->post('query');
        $this->db->like('judul', $query);
        $this->db->select('id, id_user, tumbnail, judul, deskripsi, tanggal_dibuat, created, updated');
        $get = $this->db->get('berita')->result_array();
        if($get){
            $this->response([
                'status' => true,
                'message' => 'success get news',
                'result' => $get
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed get news',
            ],404);
        }
    }
}