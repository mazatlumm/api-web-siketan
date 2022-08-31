<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Standard_nitrogen extends RestController
{
    public function index_post(){
        $data = [
            'rekesa1' => $this->post('rekesa1'),
            'rekesa2' => $this->post('rekesa2'),
            'rekesa3' => $this->post('rekesa3'),
            'rekesa4' => $this->post('rekesa4'),
            'rekesa5' => $this->post('rekesa5'),
            'rekesa6' => $this->post('rekesa6'),
            'rekesa7' => $this->post('rekesa7'),
            'rekesa8' => $this->post('rekesa8'),
            'updated' => date('Y-m-d H:i:s')
        ];
        $get_standard_nitrogen = $this->db->get('standard_nitrogen')->result_array();
        if($get_standard_nitrogen){
            //update data
            $this->db->where('id', $get_standard_nitrogen[0]['id']);
            $this->db->update('standard_nitrogen', $data);
            if($this->db->affected_rows()){
                $this->response([
                    'status' => true,
                    'message' => 'Berhasil Update Standard Nitrogen'
                ],200);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'Gagal Update Standard Nitrogen'
                ],404);
            }
        }else{
            //insert data
            $insert = $this->db->insert('standard_nitrogen', $data);
            if($insert){
                $this->response([
                    'status' => true,
                    'message' => 'Berhasil Membuat Standard Nitrogen'
                ],200);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'Gagal Membuat Standard Nitrogen'
                ],404);
            }
        }
    }

    public function index_get(){
        $get_standard_nitrogen = $this->db->get('standard_nitrogen')->result_array();
        if($get_standard_nitrogen){
            $this->response([
                'status' => true,
                'message' => 'success',
                'result' => $get_standard_nitrogen
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed'
            ],404);
        }
    }
}