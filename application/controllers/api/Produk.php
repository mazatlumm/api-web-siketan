<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Produk extends RestController
{
    public function index_post(){
        $id_user = $this->post('id_user');
        $nama_produk = $this->post('nama_produk');
        $harga = $this->post('harga');
        $stok = $this->post('stok');
        $deskripsi = $this->post('deskripsi');
        $file = time() . "_" . basename($_FILES['image']['name']);
        $tmp_name = $_FILES['image']['tmp_name'];
        if (move_uploaded_file($tmp_name, "./upload/produk/" . $file)) {
            $dataInsert = [
                'id_user' => $id_user,
                'nama_produk' => $nama_produk,
                'harga' => $harga,
                'stok' => $stok,
                'deskripsi' => $deskripsi,
                'foto' => $file,
                'updated' => date('Y-m-d H:i:s')
            ];
            $insert = $this->db->insert('produk', $dataInsert);
            if ($insert) {
                $this->response([
                    'status' => true,
                    'message' => 'created product success',
                ], 200);
            } else {
                if(file_exists("./upload/produk/$file")){
                    unlink("./upload/produk/$file");
                }
                $this->response([
                    'status' => false,
                    'message' => 'created product failed, db problem',
                ], 404);
            }
        } else {
            $this->response([
                'status' => false,
                'message' => 'created product failed, directory problem',
            ], 404);
        }
    }
    
    public function update_post(){
        $id_produk = $this->post('id_produk');
        $nama_produk = $this->post('nama_produk');
        $harga = $this->post('harga');
        $stok = $this->post('stok');
        $deskripsi = $this->post('deskripsi');
        $file = time() . "_" . basename($_FILES['image']['name']);
        $tmp_name = $_FILES['image']['tmp_name'];
        if (move_uploaded_file($tmp_name, "./upload/produk/" . $file)) {
            //hapus foto sebelumnya
            $get_produk = $this->db->get_where('produk', ['id_produk' => $id_produk])->result_array();
            if($get_produk){
                $foto = $get_produk[0]['foto'];
                if(file_exists("./upload/produk/$foto")){
                    unlink("./upload/produk/$foto");
                }
            }
            $dataUpdate = [
                'nama_produk' => $nama_produk,
                'harga' => $harga,
                'stok' => $stok,
                'deskripsi' => $deskripsi,
                'foto' => $file,
                'updated' => date('Y-m-d H:i:s')
            ];
            $this->db->where('id_produk', $id_produk);
            $this->db->update('produk', $dataUpdate);
            if ($this->db->affected_rows()) {
                $this->response([
                    'status' => true,
                    'message' => 'updated product success',
                ], 200);
            } else {
                if(file_exists("./upload/produk/$file")){
                    unlink("./upload/produk/$file");
                }
                $this->response([
                    'status' => false,
                    'message' => 'updated product failed, db problem',
                ], 404);
            }
        } else {
            $dataUpdate = [
                'nama_produk' => $nama_produk,
                'harga' => $harga,
                'stok' => $stok,
                'deskripsi' => $deskripsi,
                'updated' => date('Y-m-d H:i:s')
            ];
            $this->db->where('id_produk', $id_produk);
            $this->db->update('produk', $dataUpdate);
            if ($this->db->affected_rows()) {
                $this->response([
                    'status' => true,
                    'message' => 'updated product success with no file',
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'updated product failed with no file, db problem',
                ], 404);
            }
        }
    }

    public function index_get(){
        $id_user = $this->get('id_user');
        $get_users = $this->db->get_where('users', ['id_user' => $id_user])->result_array();
        if($get_users){
            $no_telp = $get_users[0]['no_telp'];
        }else{
            $no_telp = null;
        }
        $get_produk = $this->db->get_where('produk', ['id_user' => $id_user])->result_array();
        if($get_produk){
            foreach ($get_produk as $key => $value) {
                $dataProduk[] = [
                    'id_produk' => $value['id_produk'],
                    'id_user' => $value['id_user'],
                    'nama_produk' => $value['nama_produk'],
                    'harga' => $value['harga'],
                    'stok' => $value['stok'],
                    'deskripsi' => $value['deskripsi'],
                    'foto' => $value['foto'],
                    'no_telp' => $no_telp,
                    'created' => $value['created'],
                    'updated' => $value['updated'],
                ];
            }
            $this->response([
                'status' => true,
                'message' => 'success get product',
                'result' => $dataProduk,
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed get product',
            ],404);
        }
    }

    public function list_get(){
        $get_produk = $this->db->get('produk')->result_array();
        if($get_produk){
            foreach ($get_produk as $key => $value) {
                $id_user = $value['id_user'];
                $get_users = $this->db->get_where('users', ['id_user' => $id_user])->result_array();
                if($get_users){
                    $no_telp = $get_users[0]['no_telp'];
                    $nama_penjual = $get_users[0]['nama'];
                }else{
                    $no_telp = null;
                    $nama_penjual = null;
                }
                $dataProduk[] = [
                    'id_produk' => $value['id_produk'],
                    'id_user' => $value['id_user'],
                    'nama_produk' => $value['nama_produk'],
                    'harga' => $value['harga'],
                    'stok' => $value['stok'],
                    'deskripsi' => $value['deskripsi'],
                    'foto' => $value['foto'],
                    'no_telp' => $no_telp,
                    'penjual' => $nama_penjual,
                    'created' => $value['created'],
                    'updated' => $value['updated'],
                ];
            }
            $this->response([
                'status' => true,
                'message' => 'success get product',
                'result' => $dataProduk,
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed get product',
            ],404);
        }
    }

    public function hapus_get(){
        $id_produk = $this->get('id_produk');
        $get_produk = $this->db->get_where('produk', ['id_produk' => $id_produk])->result_array();
        if($get_produk){
            $foto = $get_produk[0]['foto'];
            if(file_exists("./upload/produk/$foto")){
                unlink("./upload/produk/$foto");
            }
        }
        $this->db->where('id_produk', $id_produk);
        $this->db->delete('produk');
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