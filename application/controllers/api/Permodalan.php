<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Permodalan extends RestController
{
    public function index_get(){
        $id_user = $this->get('id_user');
        if($id_user != null){
            $this->db->order_by('id_permodalan', 'desc');
            $get_permodalan = $this->db->get_where('permodalan', ['id_user' => $id_user])->result_array();
            if($get_permodalan){
                $this->response([
                    'status' => true,
                    'message' => 'success',
                    'result' => $get_permodalan
                ],200);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'failed',
                ],404);
            }
        }else{
            $this->db->order_by('id_permodalan', 'desc');
            $get_permodalan = $this->db->get_where('permodalan')->result_array();
            if($get_permodalan){
                foreach ($get_permodalan as $key => $value) {
                    $id_user = $value['id_user'];
                    $get_user = $this->db->get_where('users', ['id_user' => $id_user])->result_array();
                    if($get_user){
                        $nama_pencari_modal = $get_user[0]['nama'];
                    }else{
                        $nama_pencari_modal = 'Tidak Diketahui';
                    }

                    $arrayPermodalan[] = [
                        'id_permodalan' => $value['id_permodalan'],
                        'id_user' => $value['id_user'],
                        'nama' => $value['nama'],
                        'keperluan' => $value['keperluan'],
                        'jumlah' => $value['jumlah'],
                        'wa' => $value['wa'],
                        'foto' => $value['foto'],
                        'created' => $value['created'],
                        'updated' => $value['updated'],
                        'nama_pencari_modal' => $nama_pencari_modal,
                    ];
                }
                $this->response([
                    'status' => true,
                    'message' => 'success',
                    'result' => $arrayPermodalan
                ],200);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'failed',
                ],404);
            }
        }
    }

    public function index_post()
    {
        $id_user = $this->post('id_user');
        $nama = $this->post('nama');
        $keperluan = $this->post('keperluan');
        $jumlah = $this->post('jumlah');
        $wa = $this->post('wa');

        $data = [
            'id_user' => $id_user,
            'nama' => $nama,
            'keperluan' => $keperluan,
            'jumlah' => $jumlah,
            'wa' => $wa, 
        ];

        $insert = $this->db->insert('permodalan', $data);
        $insert_id = $this->db->insert_id();
        if($insert) {
            $this->response([
                'status' => true,
                'message' => 'success',
                'insert_id' => $insert_id
            ],200);
        }else{
            $this->response([
                'status' => true,
                'message' => 'success'
            ],200);
        }
    }

    public function edit_post()
    {
        $id_permodalan = $this->post('id_permodalan');
        $nama = $this->post('nama');
        $keperluan = $this->post('keperluan');
        $jumlah = $this->post('jumlah');
        $wa = $this->post('wa');

        $data = [
            'nama' => $nama,
            'keperluan' => $keperluan,
            'jumlah' => $jumlah,
            'wa' => $wa, 
            'updated' => date('Y-m-d H:i:s')
        ];

        $this->db->where('id_permodalan', $id_permodalan);
        $this->db->update('permodalan', $data);
        if($this->db->affected_rows()){
            $this->response([
                'status' => true,
                'message' => 'success',
            ],200);
        }else{
            $this->response([
                'status' => true,
                'message' => 'success'
            ],200);
        }
    }

    public function hapus_get(){
        $id_permodalan = $this->get('id_permodalan');
        $get_permodalan = $this->db->get_where('permodalan', ['id_permodalan' => $id_permodalan])->result_array();
        if($get_permodalan){
            $photo = $get_permodalan[0]['foto'];
            if(file_exists("./upload/permodalan/$photo")){
                unlink("./upload/permodalan/$photo");
            }
        }
        $this->db->where('id_permodalan', $id_permodalan);
        $this->db->delete('permodalan');
        if($this->db->affected_rows()){
            $this->response([
                'status' => true,
                'message' => 'success',
            ],200);
        }else{
            $this->response([
                'status' => true,
                'message' => 'success'
            ],200);
        }
    }

    public function foto_post(){
        $id_permodalan = $this->post('id_permodalan');
        $file = $id_permodalan . "ID" . time() . "_" . basename($_FILES['image']['name']);
        $tmp_name = $_FILES['image']['tmp_name'];
        if (move_uploaded_file($tmp_name, "./upload/permodalan/" . $file)) {

            $get_permodalan = $this->db->get_where('permodalan', ['id_permodalan' => $id_permodalan])->result_array();
            if($get_permodalan){
                $photo = $get_permodalan[0]['foto'];
                if(file_exists("./upload/permodalan/$photo")){
                    unlink("./upload/permodalan/$photo");
                }
            }
            $this->db->where('id_permodalan', $id_permodalan);
            $this->db->update('permodalan', ['foto' => $file, 'updated' => date('Y-m-d H:i:s')]);
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