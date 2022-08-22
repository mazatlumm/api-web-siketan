<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Laporan_kegiatan extends RestController
{

    public function index_get()
    {
        $id_user = $this->get('id_user');
        $this->db->order_by('id', 'desc');
        $get_laporan_kegiatan = $this->db->get_where('laporan_kegiatan', ['id_user' => $id_user])->result_array();
        if($get_laporan_kegiatan){
            $this->response([
                'status' => true,
                'message' => 'success',
                'result' => $get_laporan_kegiatan
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed',
            ],404);
        }
    }

    public function index_post(){
        $id_user = $this->post('id_user');
        $jenis_tanaman = $this->post('jenis_tanaman');
        $varietas = $this->post('varietas');
        $luas_lahan = $this->post('luas_lahan');

        $data = [
            'id_user' => $id_user, 
            'jenis_tanaman' => $jenis_tanaman, 
            'varietas' => $varietas, 
            'luas_lahan' => $luas_lahan, 
        ];

        $insert = $this->db->insert('laporan_kegiatan', $data);
        if($insert){
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

    public function edit_post(){
        $id = $this->post('id');
        $jenis_tanaman = $this->post('jenis_tanaman');
        $varietas = $this->post('varietas');
        $luas_lahan = $this->post('luas_lahan');

        $data = [
            'jenis_tanaman' => $jenis_tanaman, 
            'varietas' => $varietas, 
            'luas_lahan' => $luas_lahan, 
            'updated' => date('Y-m-d H:i:s')
        ];

        $this->db->where('id', $id);
        $this->db->update('laporan_kegiatan', $data);
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
        $id = $this->get('id');
        $this->db->where('id', $id);
        $this->db->delete('laporan_kegiatan');
        if($this->db->affected_rows()){        
            $this->db->where('id_laporan', $id);
            $this->db->delete('catatan_kegiatan');
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