<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Produk extends RestController
{
    public function index_get(){
        $id_user = $this->get('id_user');
        if($id_user != null){
            $this->db->order_by('id_produk', 'desc');
            $get_produk = $this->db->get_where('produk', ['id_user' => $id_user])->result_array();
            if($get_produk){
                $this->response([
                    'status' => true,
                    'message' => 'success',
                    'result' => $get_produk
                ],200);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'failed',
                ],404);
            }
        }else{
            $this->db->order_by('id_produk', 'desc');
            $get_produk = $this->db->get_where('produk')->result_array();
            if($get_produk){
                foreach ($get_produk as $key => $value) {
                    $id_user = $value['id_user'];
                    $get_user = $this->db->get_where('users', ['id_user' => $id_user])->result_array();
                    if($get_user){
                        $nama_penjual = $get_user[0]['nama'];
                    }else{
                        $nama_penjual = 'Tidak Diketahui';
                    }

                    $arrayProduk[] = [
                        'id_produk' => $value['id_produk'],
                        'id_user' => $value['id_user'],
                        'nama_produk' => $value['nama_produk'],
                        'stok' => $value['stok'],
                        'harga' => $value['harga'],
                        'wa' => $value['wa'],
                        'foto' => $value['foto'],
                        'created' => $value['created'],
                        'updated' => $value['updated'],
                        'nama_penjual' => $nama_penjual,
                    ];
                }
                $this->response([
                    'status' => true,
                    'message' => 'success',
                    'result' => $arrayProduk
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
        $nama_produk = $this->post('nama_produk');
        $stok = $this->post('stok');
        $harga = $this->post('harga');
        $wa = $this->post('wa');

        $data = [
            'id_user' => $id_user,
            'nama_produk' => $nama_produk,
            'stok' => $stok,
            'harga' => $harga,
            'wa' => $wa, 
        ];

        $insert = $this->db->insert('produk', $data);
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
        $id_produk = $this->post('id_produk');
        $nama_produk = $this->post('nama_produk');
        $stok = $this->post('stok');
        $harga = $this->post('harga');
        $wa = $this->post('wa');

        $data = [
            'nama_produk' => $nama_produk,
            'stok' => $stok,
            'harga' => $harga,
            'wa' => $wa, 
            'updated' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id_produk', $id_produk);
        $this->db->update('produk', $data);
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
        $id_produk = $this->get('id_produk');
        $get_produk = $this->db->get_where('produk', ['id_produk' => $id_produk])->result_array();
        if($get_produk){
            $photo = $get_produk[0]['foto'];
            if(file_exists("./upload/produk/$photo")){
                unlink("./upload/produk/$photo");
            }
        }
        $this->db->where('id_produk', $id_produk);
        $this->db->delete('produk');
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
        $id_produk = $this->post('id_produk');
        $file = $id_produk . "ID" . time() . "_" . basename($_FILES['image']['name']);
        $tmp_name = $_FILES['image']['tmp_name'];
        if (move_uploaded_file($tmp_name, "./upload/produk/" . $file)) {

            $get_produk = $this->db->get_where('produk', ['id_produk' => $id_produk])->result_array();
            if($get_produk){
                $photo = $get_produk[0]['foto'];
                if(file_exists("./upload/produk/$photo")){
                    unlink("./upload/produk/$photo");
                }
            }
            $this->db->where('id_produk', $id_produk);
            $this->db->update('produk', ['foto' => $file, 'updated' => date('Y-m-d H:i:s')]);
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