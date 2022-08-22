<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Pendapatan extends RestController
{
    public function index_post(){
        $id_user = $this->post('id_user');
        $judul = $this->post('judul');
        $catatan = $this->post('catatan');
        $total = $this->post('total');
        $tanggal = $this->post('tanggal');

        $data = [
            'id_user' => $id_user,
            'judul' => $judul,
            'catatan' => $catatan,
            'total' => $total,
            'tanggal' => $tanggal,
        ];

        $insert = $this->db->insert('pendapatan', $data);
        if($insert){
            $this->response([
                'status' => true,
                'message' => 'success'
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Pendapatan belum tersimpan, ulangi lagi!'
            ],404);
        }
    }

    public function index_get(){
        $id_user = $this->get('id_user');
        $start_date = $this->get('start_date');
        $end_date = $this->get('end_date');

        $where = [
            'id_user' => $id_user,
            'tanggal <=' => $start_date,
            'tanggal >=' => $end_date,
        ];
        $this->db->order_by('tanggal', 'asc');
        $get_pendapatan = $this->db->get_where('pendapatan', $where)->result_array();
        if($get_pendapatan){
            foreach ($get_pendapatan as $key => $value) {
                $arrDataPendapatan[] = [
                    'id_pendapatan' => $value['id_pendapatan'],
                    'id_user' => $value['id_user'],
                    'judul' => $value['judul'],
                    'catatan' => $value['catatan'],
                    'total_format' => "Rp " . number_format($value['total'],0,',','.'),
                    'total' => $value['total'],
                    'tanggal' => $value['tanggal'],
                ];
            }
            $this->response([
                'status' => true,
                'message' => 'success',
                'result' => $arrDataPendapatan
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed'
            ],404);
        }  
    }

    public function edit_post(){
        $id_pendapatan = $this->post('id_pendapatan');
        $judul = $this->post('judul');
        $catatan = $this->post('catatan');
        $total = $this->post('total');
        $tanggal = $this->post('tanggal');

        $data = [
            'judul' => $judul,
            'catatan' => $catatan,
            'total' => $total,
            'tanggal' => $tanggal,
        ];

        $this->db->where('id_pendapatan', $id_pendapatan);
        $this->db->update('pendapatan', $data);
        if($this->db->affected_rows()){
            $this->response([
                'status' => true,
                'message' => 'success',
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed'
            ],404);
        }  
    }

    public function hapus_get(){
        $id_pendapatan = $this->get('id_pendapatan');
        $this->db->where('id_pendapatan', $id_pendapatan);
        $this->db->delete('pendapatan');
        if($this->db->affected_rows()){
            $this->response([
                'status' => true,
                'message' => 'success',
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed'
            ],404);
        }  
    }

    public function grafik_get(){
        $id_user = $this->get('id_user');
        $status = $this->get('status');
        if($status == 'previous'){
            //Januari - Juni
            $where1 = [
                'id_user' => $id_user,
                'tanggal >=' => date('Y').'-1-1',
                'tanggal <=' => date('Y').'-1-31',
            ];
            $get_januari = $this->db->get_where('pendapatan', $where1)->result_array();
            $total_januari = 0;
            if($get_januari){
                foreach ($get_januari as $key => $value) {
                    $total_januari = $total_januari + $value['total'];
                }
            }

            $where2 = [
                'id_user' => $id_user,
                'tanggal >=' => date('Y').'-2-1',
                'tanggal <=' => date('Y').'-2-27',
            ];
            $get_februari = $this->db->get_where('pendapatan', $where2)->result_array();
            $total_februari = 0;
            if($get_februari){
                foreach ($get_februari as $key => $value) {
                    $total_februari = $total_februari + $value['total'];
                }
            }
            
            $where3 = [
                'id_user' => $id_user,
                'tanggal >=' => date('Y').'-3-1',
                'tanggal <=' => date('Y').'-3-31',
            ];
            $get_maret = $this->db->get_where('pendapatan', $where3)->result_array();
            $total_maret = 0;
            if($get_maret){
                foreach ($get_maret as $key => $value) {
                    $total_maret = $total_maret + $value['total'];
                }
            }
            
            $where4 = [
                'id_user' => $id_user,
                'tanggal >=' => date('Y').'-4-1',
                'tanggal <=' => date('Y').'-4-30',
            ];
            $get_april = $this->db->get_where('pendapatan', $where4)->result_array();
            $total_april = 0;
            if($get_april){
                foreach ($get_april as $key => $value) {
                    $total_april = $total_april + $value['total'];
                }
            }
            
            $where5 = [
                'id_user' => $id_user,
                'tanggal >=' => date('Y').'-5-1',
                'tanggal <=' => date('Y').'-5-31',
            ];
            $get_mei = $this->db->get_where('pendapatan', $where5)->result_array();
            $total_mei = 0;
            if($get_mei){
                foreach ($get_mei as $key => $value) {
                    $total_mei = $total_mei + $value['total'];
                }
            }
            
            $where6 = [
                'id_user' => $id_user,
                'tanggal >=' => date('Y').'-6-1',
                'tanggal <=' => date('Y').'-6-30',
            ];
            $get_juni = $this->db->get_where('pendapatan', $where6)->result_array();
            $total_juni = 0;
            if($get_juni){
                foreach ($get_juni as $key => $value) {
                    $total_juni = $total_juni + $value['total'];
                }
            }

            $this->response([
                'status' => true,
                'message' => 'success',
                'bulan' => ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun"],
                'total' => [$total_januari/1000000, $total_februari/1000000, $total_maret/1000000, $total_april/1000000, $total_mei/1000000, $total_juni/1000000],
            ],200);

        }else{
            //Juli - Desember
            $where1 = [
                'id_user' => $id_user,
                'tanggal >=' => date('Y').'-7-1',
                'tanggal <=' => date('Y').'-7-31',
            ];
            $get_juli = $this->db->get_where('pendapatan', $where1)->result_array();
            $total_juli = 0;
            if($get_juli){
                foreach ($get_juli as $key => $value) {
                    $total_juli = $total_juli + $value['total'];
                }
            }

            $where2 = [
                'id_user' => $id_user,
                'tanggal >=' => date('Y').'-8-1',
                'tanggal <=' => date('Y').'-8-31',
            ];
            $get_agustus = $this->db->get_where('pendapatan', $where2)->result_array();
            $total_agustus = 0;
            if($get_agustus){
                foreach ($get_agustus as $key => $value) {
                    $total_agustus = $total_agustus + $value['total'];
                }
            }
            
            $where3 = [
                'id_user' => $id_user,
                'tanggal >=' => date('Y').'-9-1',
                'tanggal <=' => date('Y').'-9-30',
            ];
            $get_september = $this->db->get_where('pendapatan', $where3)->result_array();
            $total_september = 0;
            if($get_september){
                foreach ($get_september as $key => $value) {
                    $total_september = $total_september + $value['total'];
                }
            }
            
            $where4 = [
                'id_user' => $id_user,
                'tanggal >=' => date('Y').'-10-1',
                'tanggal <=' => date('Y').'-10-31',
            ];
            $get_oktober = $this->db->get_where('pendapatan', $where4)->result_array();
            $total_oktober = 0;
            if($get_oktober){
                foreach ($get_oktober as $key => $value) {
                    $total_oktober = $total_oktober + $value['total'];
                }
            }
            
            $where5 = [
                'id_user' => $id_user,
                'tanggal >=' => date('Y').'-11-1',
                'tanggal <=' => date('Y').'-11-30',
            ];
            $get_november = $this->db->get_where('pendapatan', $where5)->result_array();
            $total_november = 0;
            if($get_november){
                foreach ($get_november as $key => $value) {
                    $total_november = $total_november + $value['total'];
                }
            }
            
            $where6 = [
                'id_user' => $id_user,
                'tanggal >=' => date('Y').'-12-1',
                'tanggal <=' => date('Y').'-12-31',
            ];
            $get_desember = $this->db->get_where('pendapatan', $where6)->result_array();
            $total_desember = 0;
            if($get_desember){
                foreach ($get_desember as $key => $value) {
                    $total_desember = $total_desember + $value['total'];
                }
            }

            $this->response([
                'status' => true,
                'message' => 'success',
                'bulan' => ["Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
                'total' => [$total_juli/1000000, $total_agustus/1000000, $total_september/1000000, $total_oktober/1000000, $total_november/1000000, $total_desember/1000000],
            ],200);
        }

    }


}