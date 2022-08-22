<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Catatan_kegiatan extends RestController
{

    public function index_get()
    {
        $id_user = $this->get('id_user');
        $id_laporan = $this->get('id_laporan');
        
        $where = [
            'id_user' => $id_user,
            'id_laporan' => $id_laporan,
        ];
        
        $this->db->order_by('id', 'desc');
        $get_catatan_kegiatan = $this->db->get_where('catatan_kegiatan', $where)->result_array();
        if($get_catatan_kegiatan){
            $this->response([
                'status' => true,
                'message' => 'success',
                'result' => $get_catatan_kegiatan
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
        $id_laporan = $this->post('id_laporan');
        $uraian_kegiatan = $this->post('uraian_kegiatan');
        $tanggal_pelaksanaan = $this->post('tanggal_pelaksanaan');
        $alat_bahan = $this->post('alat_bahan');
        $pengeluaran = $this->post('pengeluaran');
        $jenis_tanaman = $this->post('jenis_tanaman');

        $data = [
            'id_user' => $id_user, 
            'id_laporan' => $id_laporan, 
            'uraian_kegiatan' => $uraian_kegiatan, 
            'tanggal_pelaksanaan' => $tanggal_pelaksanaan, 
            'alat_bahan' => $alat_bahan, 
            'pengeluaran' => $pengeluaran, 
        ];

        $insert = $this->db->insert('catatan_kegiatan', $data);
        $id_catatan_kegiatan = $this->db->insert_id();
        if($insert){
            $dataPengeluaran = [
                'id_catatan_kegiatan' => $id_catatan_kegiatan, 
                'id_user' => $id_user, 
                'judul' => "Kegiatan Bertani ".$jenis_tanaman, 
                'catatan' => $uraian_kegiatan, 
                'total' => $pengeluaran, 
                'tanggal' => $tanggal_pelaksanaan, 
            ];
            $this->db->insert('pengeluaran', $dataPengeluaran);
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
        $uraian_kegiatan = $this->post('uraian_kegiatan');
        $tanggal_pelaksanaan = $this->post('tanggal_pelaksanaan');
        $alat_bahan = $this->post('alat_bahan');
        $pengeluaran = $this->post('pengeluaran');
        $jenis_tanaman = $this->post('jenis_tanaman');

        $data = [
            'uraian_kegiatan' => $uraian_kegiatan, 
            'tanggal_pelaksanaan' => $tanggal_pelaksanaan, 
            'alat_bahan' => $alat_bahan, 
            'pengeluaran' => $pengeluaran, 
            'updated' => date('Y-m-d H:i:s'),
        ];

        $this->db->where('id', $id);
        $this->db->update('catatan_kegiatan', $data);
        if($this->db->affected_rows()){
            $dataPengeluaran = [
                'judul' => "Kegiatan Bertani ".$jenis_tanaman, 
                'catatan' => $uraian_kegiatan, 
                'total' => $pengeluaran, 
                'tanggal' => $tanggal_pelaksanaan, 
                'updated' => date('Y-m-d H:i:s'),
            ];
            $this->db->where('id_catatan_kegiatan', $id);
            $this->db->update('pengeluaran', $dataPengeluaran);

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
        //cek apakah ada foto
        $get_catatan_kegiatan = $this->db->get_where('catatan_kegiatan', ['id' => $id])->result_array();
        if($get_catatan_kegiatan){
            $photo = $get_catatan_kegiatan[0]['foto'];
            if(file_exists("./upload/foto_kegiatan/$photo")){
                unlink("./upload/foto_kegiatan/$photo");
            }
        }
        $this->db->where('id', $id);
        $this->db->delete('catatan_kegiatan');
        if($this->db->affected_rows()){
            $this->db->where('id_catatan_kegiatan', $id);
            $this->db->delete('pengeluaran');
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

    public function foto_post(){
        $id_catatan_kegiatan = $this->post('id_catatan_kegiatan');
        $file = $id_catatan_kegiatan . "ID" . time() . "_" . basename($_FILES['image']['name']);
        $tmp_name = $_FILES['image']['tmp_name'];
        if (move_uploaded_file($tmp_name, "./upload/foto_kegiatan/" . $file)) {

            $get_catatan_kegiatan = $this->db->get_where('catatan_kegiatan', ['id' => $id_catatan_kegiatan])->result_array();
            if($get_catatan_kegiatan){
                $photo = $get_catatan_kegiatan[0]['foto'];
                if(file_exists("./upload/foto_kegiatan/$photo")){
                    unlink("./upload/foto_kegiatan/$photo");
                }
            }
            $this->db->where('id', $id_catatan_kegiatan);
            $this->db->update('catatan_kegiatan', ['foto' => $file, 'updated' => date('Y-m-d H:i:s')]);
            if ($this->db->affected_rows()) {
                $this->response([
                    'status' => true,
                    'message' => 'success',
                    'foto' => $file
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'failed',
                ], 404);
            }
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed',
            ], 404);
        }
    }
}