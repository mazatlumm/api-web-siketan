<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Laporan extends RestController
{

    public function index_get(){
        $id_user = $this->get('id_user');
        $where = [
            'id_user' => $id_user,
        ];
        $this->db->order_by('id_laporan', 'desc');
        if($id_user){
            $get_laporan = $this->db->get_where('laporan', $where)->result_array();
            foreach ($get_laporan as $key => $value) {
                $id_user = $value['id_user'];
                $get_user = $this->db->get_where('users', ['id_user' => $id_user])->result_array();
                if($get_user){
                    $nama_penyuluh = $get_user[0]['nama'];
                }else{
                    $nama_penyuluh = null;
                }
                $dataResult[] = [
                    'id_laporan' => $value['id_laporan'],
                    'id_user' => $value['id_user'],
                    'nama_penyuluh' => $nama_penyuluh,
                    'catatan' => $value['catatan'],
                    'keluhan' => $value['keluhan'],
                    'alamat' => $value['alamat'],
                    'latitude' => $value['latitude'],
                    'longitude' => $value['longitude'],
                    'foto' => $value['foto'],
                    'created' => $value['created'],
                    'updated' => $value['updated'],
                ];
            }
        }else{
            $get_laporan = $this->db->get('laporan')->result_array();
            foreach ($get_laporan as $key => $value) {
                $id_user = $value['id_user'];
                $get_user = $this->db->get_where('users', ['id_user' => $id_user])->result_array();
                if($get_user){
                    $nama_penyuluh = $get_user[0]['nama'];
                }else{
                    $nama_penyuluh = null;
                }
                $dataResult[] = [
                    'id_laporan' => $value['id_laporan'],
                    'id_user' => $value['id_user'],
                    'nama_penyuluh' => $nama_penyuluh,
                    'catatan' => $value['catatan'],
                    'keluhan' => $value['keluhan'],
                    'alamat' => $value['alamat'],
                    'latitude' => $value['latitude'],
                    'longitude' => $value['longitude'],
                    'foto' => $value['foto'],
                    'created' => $value['created'],
                    'updated' => $value['updated'],
                ];
            }
        }
        if($get_laporan){
            $this->response([
                'status' => true,
                'message' => 'success get laporan',
                'result' => $dataResult,
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed get laporan'
            ],404);
        }
    }

    public function index_post(){
        $id_user = $this->post('id_user');
        $catatan = $this->post('catatan');
        $keluhan = $this->post('keluhan');
        $alamat = $this->post('alamat');
        $latitude = $this->post('latitude');
        $longitude = $this->post('longitude');
        $file = time() . "_" . basename($_FILES['image']['name']);
        $tmp_name = $_FILES['image']['tmp_name'];
        if (move_uploaded_file($tmp_name, "./upload/laporan/" . $file)) {
            $dataInsert = [
                'id_user' => $id_user,
                'catatan' => $catatan,
                'keluhan' => $keluhan,
                'alamat' => $alamat,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'foto' => $file,
                'updated' => date('Y-m-d H:i:s')
            ];
            $insert = $this->db->insert('laporan', $dataInsert);
            if ($insert) {
                $this->response([
                    'status' => true,
                    'message' => 'created laporan success',
                ], 200);
            } else {
                if(file_exists("./upload/laporan/$file")){
                    unlink("./upload/laporan/$file");
                }
                $this->response([
                    'status' => false,
                    'message' => 'created laporan failed, db problem',
                ], 404);
            }
        } else {
            $this->response([
                'status' => false,
                'message' => 'created laporan failed, directory problem',
            ], 404);
        }
    }

    public function update_post(){
        $id_laporan = $this->post('id_laporan');
        $catatan = $this->post('catatan');
        $keluhan = $this->post('keluhan');
        $alamat = $this->post('alamat');
        $latitude = $this->post('latitude');
        $longitude = $this->post('longitude');
        $file = time() . "_" . basename($_FILES['image']['name']);
        $tmp_name = $_FILES['image']['tmp_name'];
        if (move_uploaded_file($tmp_name, "./upload/laporan/" . $file)) {
            //hapus foto sebelumnya
            $get_laporan = $this->db->get_where('laporan', ['id_laporan' => $id_laporan])->result_array();
            if($get_laporan){
                $foto = $get_laporan[0]['foto'];
                if(file_exists("./upload/laporan/$foto")){
                    unlink("./upload/laporan/$foto");
                }
            }
            $dataUpdate = [
                'catatan' => $catatan,
                'keluhan' => $keluhan,
                'alamat' => $alamat,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'foto' => $file,
                'updated' => date('Y-m-d H:i:s')
            ];
            $this->db->where('id_laporan', $id_laporan);
            $this->db->update('laporan', $dataUpdate);
            if ($this->db->affected_rows()) {
                $this->response([
                    'status' => true,
                    'message' => 'updated laporan success',
                ], 200);
            } else {
                if(file_exists("./upload/laporan/$file")){
                    unlink("./upload/laporan/$file");
                }
                $this->response([
                    'status' => false,
                    'message' => 'updated laporan failed, db problem',
                ], 404);
            }
        } else {
            $dataUpdate = [
                'catatan' => $catatan,
                'keluhan' => $keluhan,
                'alamat' => $alamat,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'updated' => date('Y-m-d H:i:s')
            ];
            $this->db->where('id_laporan', $id_laporan);
            $this->db->update('laporan', $dataUpdate);
            if ($this->db->affected_rows()) {
                $this->response([
                    'status' => true,
                    'message' => 'updated laporan success with no file',
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'updated laporan failed with no file, db problem',
                ], 404);
            }
        }
    }

    public function hapus_get(){
        $id_laporan = $this->get('id_laporan');
        $get_laporan = $this->db->get_where('laporan', ['id_laporan' => $id_laporan])->result_array();
        if($get_laporan){
            $foto = $get_laporan[0]['foto'];
            if(file_exists("./upload/laporan/$foto")){
                unlink("./upload/laporan/$foto");
            }
        }
        $this->db->where('id_laporan', $id_laporan);
        $this->db->delete('laporan');
        if($this->db->affected_rows()){
            $this->response([
                'status' => true,
                'message' => 'success delete product',
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed delete product',
            ],404);
        }  
    }
}