<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Agenda extends RestController
{
    public function index_post(){
        $id_user = $this->post('id_user');
        $judul = $this->post('judul');
        $uraian = $this->post('uraian');
        $tanggal = $this->post('tanggal');
        $jam = $this->post('jam');
        
        $data = [
            'id_user' => $id_user,
            'judul' => $judul,
            'uraian' => $uraian,
            'tanggal' => $tanggal,
            'jam' => $jam,
        ];

        $insert  = $this->db->insert('agenda', $data);
        if($insert){
            $this->response([
                'status' => true,
                'message' => 'success'
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Agenda Gagal Dibuat, Coba Lagi'
            ],404);
        }
    }

    public function index_get(){
        $id_user = $this->get('id_user');
        $get_agenda = $this->db->get_where('agenda', ['id_user' => $id_user])->result_array();
        if($get_agenda){
            foreach ($get_agenda as $key => $value) {
                $id_agenda = $value['id_agenda'];
                $judul = $value['judul'];
                $uraian = $value['uraian'];
                $tanggal = $value['tanggal'];
                $jam = $value['jam'];
                $arrTanggal[$tanggal] = [[
                    'id_agenda' => $id_agenda,
                    'judul' => $judul,
                    'uraian' => $uraian,
                    'jam' => $jam,
                    'tanggal' => $tanggal,
                ]];
            } 
            $this->response([
                'status' => true,
                'message' => 'success',
                'result' => $arrTanggal
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Agenda Tidak Ditemukan',
            ],404);
        }
    }

    public function edit_post(){
        $id_agenda = $this->post('id_agenda');
        $judul = $this->post('judul');
        $uraian = $this->post('uraian');
        $tanggal = $this->post('tanggal');
        $jam = $this->post('jam');
        $data_update = [
            'judul' => $judul,
            'uraian' => $uraian,
            'tanggal' => $tanggal,
            'jam' => $jam,
            'updated' => date('Y-m-d H:i:s'),
        ];

        $this->db->where('id_agenda', $id_agenda);
        $this->db->update('agenda', $data_update);
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
        $id_agenda = $this->get('id_agenda');
        $this->db->where('id_agenda', $id_agenda);
        $this->db->delete('agenda');
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