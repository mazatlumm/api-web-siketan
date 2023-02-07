<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Data_panen extends RestController
{
    public function index_post(){
        $id_user = $this->post('id_user');
        $komoditas = $this->post('komoditas');
        $luas = $this->post('luas');
        $jumlah = $this->post('jumlah');
        $lokasi = $this->post('lokasi');

        $data = [
            'id_user' => $id_user,
            'komoditas' => $komoditas,
            'luas' => $luas,
            'jumlah' => $jumlah,
            'lokasi' => $lokasi,
        ];

        $insert = $this->db->insert('panen', $data);
        if($insert){
            $this->response([
                'status' => true,
                'message' => 'success'
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed'
            ],404);
        }
    }

    public function index_get(){
        // $id_user = $this->get('id_user');
        $id_user = null;
        if($id_user != null){
            $this->db->order_by('id_panen', 'desc');
            $get_panen = $this->db->get_where('panen', ['id_user' => $id_user])->result_array();
            if($get_panen){
                $this->response([
                    'status' => true,
                    'message' => 'success',
                    'result' => $get_panen
                ],200);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'failed'
                ],404);
            }
        }else{
            $this->db->order_by('id_panen', 'desc');
            $get_panen = $this->db->get('panen')->result_array();
            if($get_panen){
                $this->response([
                    'status' => true,
                    'message' => 'success',
                    'result' => $get_panen
                ],200);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'failed'
                ],404);
            }
        }
    }

    public function edit_post(){
        $id_panen = $this->post('id_panen');
        $komoditas = $this->post('komoditas');
        $luas = $this->post('luas');
        $jumlah = $this->post('jumlah');
        $lokasi = $this->post('lokasi');

        $data = [
            'komoditas' => $komoditas,
            'luas' => $luas,
            'jumlah' => $jumlah,
            'lokasi' => $lokasi,
            'updated' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_panen', $id_panen);
        $this->db->update('panen', $data);
        if($this->db->affected_rows()){
            $this->response([
                'status' => true,
                'message' => 'update panen success'
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'update panen failed'
            ],404);
        }
    }

    public function hapus_get(){
        $id_panen = $this->get('id_panen');
        $this->db->where('id_panen', $id_panen);
        $this->db->delete('panen');
        if($this->db->affected_rows()){
            $this->response([
                'status' => true,
                'message' => 'delete success',
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'delete failed'
            ],404);
        }
    }
}