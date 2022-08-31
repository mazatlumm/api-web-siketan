<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Standard_kualitas_tanah extends RestController
{
    public function index_post(){
        $data = [
            'nitrogen' => $this->post('nitrogen'),
            'nitrogen_max' => $this->post('nitrogen_max'),
            'nitrogen_kurang' => $this->post('nitrogen_kurang'),
            'nitrogen_sesuai' => $this->post('nitrogen_sesuai'),
            'nitrogen_berlebih' => $this->post('nitrogen_berlebih'),
            'phosporus' => $this->post('phosporus'),
            'phosporus_max' => $this->post('phosporus_max'),
            'phosporus_kurang' => $this->post('phosporus_kurang'),
            'phosporus_sesuai' => $this->post('phosporus_sesuai'),
            'phosporus_berlebih' => $this->post('phosporus_berlebih'),
            'kalium' => $this->post('kalium'),
            'kalium_max' => $this->post('kalium_max'),
            'kalium_kurang' => $this->post('kalium_kurang'),
            'kalium_sesuai' => $this->post('kalium_sesuai'),
            'kalium_berlebih' => $this->post('kalium_berlebih'),
            'suhu' => $this->post('suhu'),
            'suhu_max' => $this->post('suhu_max'),
            'suhu_kurang' => $this->post('suhu_kurang'),
            'suhu_sesuai' => $this->post('suhu_sesuai'),
            'suhu_berlebih' => $this->post('suhu_berlebih'),
            'kelembaban' => $this->post('kelembaban'),
            'kelembaban_max' => $this->post('kelembaban_max'),
            'kelembaban_kurang' => $this->post('kelembaban_kurang'),
            'kelembaban_sesuai' => $this->post('kelembaban_sesuai'),
            'kelembaban_berlebih' => $this->post('kelembaban_berlebih'),
            'ph' => $this->post('ph'),
            'ph_max' => $this->post('ph_max'),
            'ph_kurang' => $this->post('ph_kurang'),
            'ph_sesuai' => $this->post('ph_sesuai'),
            'ph_berlebih' => $this->post('ph_berlebih'),
            'konduktifitas' => $this->post('konduktifitas'),
            'konduktifitas_max' => $this->post('konduktifitas_max'),
            'konduktifitas_kurang' => $this->post('konduktifitas_kurang'),
            'konduktifitas_sesuai' => $this->post('konduktifitas_sesuai'),
            'konduktifitas_berlebih' => $this->post('konduktifitas_berlebih'),
            'salinitas' => $this->post('salinitas'),
            'salinitas_max' => $this->post('salinitas_max'),
            'salinitas_kurang' => $this->post('salinitas_kurang'),
            'salinitas_sesuai' => $this->post('salinitas_sesuai'),
            'salinitas_berlebih' => $this->post('salinitas_berlebih'),
            'tds' => $this->post('tds'),
            'tds_max' => $this->post('tds_max'),
            'tds_kurang' => $this->post('tds_kurang'),
            'tds_sesuai' => $this->post('tds_sesuai'),
            'tds_berlebih' => $this->post('tds_berlebih'),
            'updated' => date('Y-m-d H:i:s'),
        ];

        $get_standard_tanah = $this->db->get('standard_tanah')->result_array();
        if($get_standard_tanah){
            //update standard tanah
            $this->db->where('id', $get_standard_tanah[0]['id']);
            $this->db->update('standard_tanah', $data);
            if($this->db->affected_rows()){
                $this->response([
                    'status' => true,
                    'message' => 'success update soil standard'
                ],200);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'failed update soil standard'
                ],404);
            }
        }else{
            //insert standard tanah
            $insert = $this->db->insert('standard_tanah', $data);
            if($insert){
                $this->response([
                    'status' => true,
                    'message' => 'success create soil standard'
                ],200);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'failed create soil standard'
                ],404);
            }
        }
    }

    public function index_get(){
        $get_standard_tanah = $this->db->get('standard_tanah')->result_array();
        if($get_standard_tanah){
            $this->response([
                'status' => true,
                'message' => 'standard tanah ditemukan',
                'result' => $get_standard_tanah
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'standard tanah tidak ditemukan'
            ],404);
        }
    }
}