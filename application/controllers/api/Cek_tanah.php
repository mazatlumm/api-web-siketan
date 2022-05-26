<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Cek_tanah extends RestController
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }

    public function index_post(){
        $data_arr = json_encode($this->post('data_arr'));
        $decode_data = json_decode($data_arr, true);
        $ArrayResult = json_decode($decode_data, true);
        for ($i=0; $i < count($ArrayResult); $i++) { 
            $insert = $this->db->insert('cek_tanah', $ArrayResult[$i][0]);
        }
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

    public function index_get()
    {
        $id_device = $this->get('id_device');
        $id_user = $this->get('id_user');
        $role = $this->get('role');
        if($id_device != null || $id_device != ''){
            $this->db->order_by('created', 'DESC');
            $get_cek_tanah = $this->db->get_where('cek_tanah', ['id_device' => $id_device, 'id_user' => $id_user])->result_array();
            if($get_cek_tanah){
                $this->response([
                    'status' => true,
                    'message' => 'success',
                    'result' => $get_cek_tanah
                ],200);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'failed',
                    'result' => []
                ],404);
            }
        }else{
            if($role == 'admin'){
                $this->db->order_by('created', 'DESC');
                $get_cek_tanah = $this->db->get('cek_tanah')->result_array();
                if($get_cek_tanah){
                    $this->response([
                        'status' => true,
                        'message' => 'success',
                        'result' => $get_cek_tanah
                    ],200);
                }else{
                    $this->response([
                        'status' => false,
                        'message' => 'failed',
                        'result' => []
                    ],404);
                }
            }else{
                $this->db->order_by('created', 'DESC');
                $get_cek_tanah = $this->db->get_where('cek_tanah', ['id_user' => $id_user])->result_array();
                if($get_cek_tanah){
                    $this->response([
                        'status' => true,
                        'message' => 'success',
                        'result' => $get_cek_tanah
                    ],200);
                }else{
                    $this->response([
                        'status' => false,
                        'message' => 'failed',
                        'result' => []
                    ],404);
                }
            }
        }
    }

    public function tes_alat_get(){
        $id_device = $this->get('id_device');
        $get_cek_tanah = $this->db->get_where('cek_tanah', ['id_device' => $id_device])->result_array();
        if($get_cek_tanah){
            $this->response([
                'status' => true,
                'message' => 'success',
                'result' => $get_cek_tanah
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed',
                'result' => []
            ],404);
        }

    }

    public function hapus_get(){
        $id_cek_tanah = $this->get('id_cek_tanah');
        $this->db->where('id_cek_tanah', $id_cek_tanah);
        $this->db->delete('cek_tanah');
        if($this->db->affected_rows()){
            $this->response([
                'status' => true,
                'message' => 'success',
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed',
                'result' => []
            ],404);
        }
    }
    
    public function edit_post(){
        $id_cek_tanah = $this->post('id_cek_tanah');
        $komoditas = $this->post('komoditas');
        $keterangan = $this->post('keterangan');

        $data = [
            'komoditas' => $komoditas,
            'keterangan' => $keterangan,
            'created' => date('Y-m-d H:i:s')
        ];

        $this->db->where('id_cek_tanah', $id_cek_tanah);
        $this->db->update('cek_tanah', $data);
        if($this->db->affected_rows()){
            $this->response([
                'status' => true,
                'message' => 'success',
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed',
                'result' => []
            ],404);
        }
    }

}