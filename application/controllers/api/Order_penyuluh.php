<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Order_penyuluh extends RestController
{
    public function index_post(){
        $id_user_pemesan = $this->post('id_user_pemesan');
        $id_user_penyuluh = $this->post('id_user_penyuluh');
        $alamat_tujuan = $this->post('alamat_tujuan');
        $status = $this->post('status');
        $lat_pemesan = $this->post('lat_pemesan');
        $long_pemesan = $this->post('long_pemesan');

        $data = [
            'id_user_pemesan' => $id_user_pemesan,
            'id_user_penyuluh' => $id_user_penyuluh,
            'alamat_tujuan' => $alamat_tujuan,
            'status' => $status,
            'lat_pemesan' => $lat_pemesan,
            'long_pemesan' => $long_pemesan,
            'updated' => date('Y-m-d H:i:s')
        ];

        $where = [
            'id_user_pemesan' => $id_user_pemesan,
            'id_user_penyuluh' => $id_user_penyuluh,
            'status' => $status,
        ];

        $get_order_penyuluh = $this->db->get_where('order_penyuluh', $where)->result_array();
        if($get_order_penyuluh){
            $this->db->where($where);
            $this->db->update('order_penyuluh', $data);
            if($this->db->affected_rows()){
                $this->response([
                    'status' => true,
                    'message' => 'success update order',
                ],200);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'failed update order',
                ],404);
            }
        }else{
            $insert = $this->db->insert('order_penyuluh', $data);
            if($insert){
                $this->response([
                    'status' => true,
                    'message' => 'success added order',
                ],200);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'failed added order',
                ],404);
            }
        }
    }
    
    public function update_post(){
        $id_order = $this->post('id_order');
        $status = $this->post('status');
        $lat_penyuluh = $this->post('lat_penyuluh');
        $long_penyuluh = $this->post('long_penyuluh');

        $data = [
            'status' => $status,
            'lat_penyuluh' => $lat_penyuluh,
            'long_penyuluh' => $long_penyuluh,
            'updated' => date('Y-m-d H:i:s')
        ];

        $where = [
            'id_order' => $id_order
        ];

        $get_order_penyuluh = $this->db->get_where('order_penyuluh', $where)->result_array();
        if($get_order_penyuluh){
            $this->db->where($where);
            $this->db->update('order_penyuluh', $data);
            if($this->db->affected_rows()){
                $this->db->where('id_user', $get_order_penyuluh[0]['id_user_penyuluh']);
                $this->db->update('user_location', ['status' => 'Berjalan']);
                $this->response([
                    'status' => true,
                    'message' => 'success update order',
                ],200);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'failed update order',
                ],404);
            }
        }else{
            $this->response([
                'status' => false,
                'message' => 'order not found',
            ],404);
        }
    }

    public function status_get(){
        $id_user_pemesan = $this->get('id_user_pemesan');
        $status = $this->get('status');

        $where = [
            'id_user_pemesan' => $id_user_pemesan,
            'status' => $status
        ];

        $this->db->order_by('id_order', 'desc');
        $get_order_penyuluh = $this->db->get_where('order_penyuluh', $where)->result_array();

        if($get_order_penyuluh){
            foreach ($get_order_penyuluh as $key => $value) {
                $get_user_pemesan = $this->db->get_where('users', ['id_user' => $value['id_user_pemesan']])->result_array();
                if($get_user_pemesan){
                    $nama_pemesan = $get_user_pemesan[0]['nama'];
                    $photo_pemesan = $get_user_pemesan[0]['photo'];
                }else{
                    $nama_pemesan = null;
                }
                
                $get_user_penyuluh = $this->db->get_where('users', ['id_user' => $value['id_user_penyuluh']])->result_array();
                if($get_user_penyuluh){
                    $nama_penyuluh = $get_user_penyuluh[0]['nama'];
                    $photo_penyuluh = $get_user_penyuluh[0]['photo'];
                }else{
                    $nama_penyuluh = null;
                }

                $arrData[] = [
                    'id_order' => $value['id_order'],
                    'id_user_pemesan' => $value['id_user_pemesan'],
                    'id_user_penyuluh' => $value['id_user_penyuluh'],
                    'nama_pemesan' => $nama_pemesan,
                    'nama_penyuluh' => $nama_penyuluh,
                    'photo_pemesan' => $photo_pemesan,
                    'photo_penyuluh' => $photo_penyuluh,
                    'status' => $value['status'],
                    'pesan' => $value['pesan'],
                    'alamat_tujuan' => $value['alamat_tujuan'],
                    'lat_pemesan' => $value['lat_pemesan'],
                    'long_pemesan' => $value['long_pemesan'],
                    'lat_penyuluh' => $value['lat_penyuluh'],
                    'long_penyuluh' => $value['long_penyuluh'],
                    'created' => $value['created'],
                    'updated' => $value['updated'],
                ];
            }
            $this->response([
                'status' => true,
                'message' => 'success get status',
                'result' => $arrData,
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => "Status $status Not Found",
            ],404);
        }
    }

    public function list_order_get(){
        $id_user_penyuluh = $this->get('id_user_penyuluh');
        $status = $this->get('status');

        $where = [
            'id_user_penyuluh' => $id_user_penyuluh,
            'status' => $status
        ];

        $this->db->order_by('id_order', 'desc');
        $get_order_penyuluh = $this->db->get_where('order_penyuluh', $where)->result_array();

        if($get_order_penyuluh){
            foreach ($get_order_penyuluh as $key => $value) {
                $get_user_pemesan = $this->db->get_where('users', ['id_user' => $value['id_user_pemesan']])->result_array();
                if($get_user_pemesan){
                    $nama_pemesan = $get_user_pemesan[0]['nama'];
                    $photo_pemesan = $get_user_pemesan[0]['photo'];
                }else{
                    $nama_pemesan = null;
                }
                
                $get_user_penyuluh = $this->db->get_where('users', ['id_user' => $value['id_user_penyuluh']])->result_array();
                if($get_user_penyuluh){
                    $nama_penyuluh = $get_user_penyuluh[0]['nama'];
                    $photo_penyuluh = $get_user_penyuluh[0]['photo'];
                }else{
                    $nama_penyuluh = null;
                }

                $arrData[] = [
                    'id_order' => $value['id_order'],
                    'id_user_pemesan' => $value['id_user_pemesan'],
                    'id_user_penyuluh' => $value['id_user_penyuluh'],
                    'nama_pemesan' => $nama_pemesan,
                    'nama_penyuluh' => $nama_penyuluh,
                    'photo_pemesan' => $photo_pemesan,
                    'photo_penyuluh' => $photo_penyuluh,
                    'status' => $value['status'],
                    'pesan' => $value['pesan'],
                    'alamat_tujuan' => $value['alamat_tujuan'],
                    'lat_pemesan' => $value['lat_pemesan'],
                    'long_pemesan' => $value['long_pemesan'],
                    'lat_penyuluh' => $value['lat_penyuluh'],
                    'long_penyuluh' => $value['long_penyuluh'],
                    'created' => $value['created'],
                    'updated' => $value['updated'],
                ];
            }
            $this->response([
                'status' => true,
                'message' => 'success get status',
                'result' => $arrData,
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => "Status $status Not Found",
            ],404);
        }
    }

    public function tracking_penyuluh_get(){
        $id_order = $this->get('id_order');
        $get_order_penyuluh = $this->db->get_where('order_penyuluh', ['id_order' => $id_order])->result_array();
        if($get_order_penyuluh){
            $this->response([
                'status' => true,
                'message' => 'success get order',
                'result' => $get_order_penyuluh,
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed'
            ],404);
        }
    }

    public function pesan_post(){
        $id_order = $this->post('id_order');
        $pesan = $this->post('pesan');

        $this->db->where('id_order', $id_order);
        $this->db->update('order_penyuluh', ['pesan' => $pesan, 'updated' => date('Y-m-d H:i:s')]);
        if($this->db->affected_rows()){
            $this->response([
                'status' => true,
                'message' => 'success ubah pesan',
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'gagal ubah pesan'
            ],404);
        }
    }

    public function detail_get(){
        $id_order = $this->get('id_order');
        $get_order_penyuluh = $this->db->get_where('order_penyuluh', ['id_order' => $id_order])->result_array();
        if($get_order_penyuluh){
            foreach ($get_order_penyuluh as $key => $value) {
                $get_user_pemesan = $this->db->get_where('users', ['id_user' => $value['id_user_pemesan']])->result_array();
                if($get_user_pemesan){
                    $nama_pemesan = $get_user_pemesan[0]['nama'];
                }else{
                    $nama_pemesan = null;
                }
                $get_user_penyuluh = $this->db->get_where('users', ['id_user' => $value['id_user_penyuluh']])->result_array();
                if($get_user_penyuluh){
                    $nama_penyuluh = $get_user_penyuluh[0]['nama'];
                }else{
                    $nama_penyuluh = null;
                }

                $dataArray[] = [
                    'id_order' => $id_order,
                    'id_user_pemesan' => $value['id_user_pemesan'],
                    'id_user_penyuluh' => $value['id_user_penyuluh'],
                    'nama_pemesan' => $nama_pemesan,
                    'nama_penyuluh' => $nama_penyuluh,
                    'alamat_tujuan' => $value['alamat_tujuan'],
                    'pesan' => $value['pesan'],
                    'status' => $value['status'],
                    'lat_pemesan' => $value['lat_pemesan'],
                    'long_pemesan' => $value['long_pemesan'],
                    'lat_penyuluh' => $value['lat_penyuluh'],
                    'long_penyuluh' => $value['long_penyuluh'],
                    'keterangan' => $value['keterangan'],
                    'foto' => $value['foto'],
                    'rating' => $value['rating'],
                    'created' => $value['created'],
                    'updated' => $value['updated'],
                    'tanggal' => date('d-m-Y H:i:s', strtotime($value['updated'])),
                ];
            }
            $this->response([
                'status' => true,
                'message' => 'success get order',
                'result' => $dataArray
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed get order'
            ],404);
        }
    }

    public function foto_post(){
        $id_order = $this->post('id_order');
        $keterangan = $this->post('keterangan');
        $status = $this->post('status');
        $rating = $this->post('rating');
        $file = $id_order . "ID" . time() . "_" . basename($_FILES['image']['name']);
        $tmp_name = $_FILES['image']['tmp_name'];
        if (move_uploaded_file($tmp_name, "./upload/go_penyuluh/" . $file)) {

            $get_order_penyuluh = $this->db->get_where('order_penyuluh', ['id_order' => $id_order])->result_array();
            if($get_order_penyuluh){
                $photo = $get_order_penyuluh[0]['foto'];
                if(file_exists("./upload/go_penyuluh/$photo")){
                    unlink("./upload/go_penyuluh/$photo");
                }
            }
            $dataUpdate = [
                'foto' => $file, 
                'keterangan' => $keterangan, 
                'status' => $status, 
                'rating' => $rating, 
                'updated' => date('Y-m-d H:i:s')
            ];
            $this->db->where('id_order', $id_order);
            $this->db->update('order_penyuluh', $dataUpdate);
            if ($this->db->affected_rows()) {
                $this->response([
                    'status' => true,
                    'message' => 'success upload foto',
                    'foto' => $file
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'failed upload foto',
                ], 404);
            }
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed upload foto',
            ], 404);
        }
    }

    public function selesai_post(){
        $id_order = $this->post('id_order');
        $status = $this->post('status');
        $pesan = $this->post('pesan');
        $keterangan = $this->post('keterangan');
        $rating = $this->post('rating');

        $data = [
            'status' => $status,
            'pesan' => $pesan,
            'keterangan' => $keterangan,
            'rating' => $rating,
            'updated' => date('Y-m-d H:i:s')
        ];

        $this->db->where('id_order', $id_order);
        $this->db->update('order_penyuluh', $data);
        if ($this->db->affected_rows()) {
            $this->response([
                'status' => true,
                'message' => 'success update data',
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed update data',
            ], 404);
        }
    }

    public function update_lokasi_penyuluh_get(){
        $id_order = $this->get('id_order');
        $lat_penyuluh = $this->get('lat_penyuluh');
        $long_penyuluh = $this->get('long_penyuluh');

        $data = [
            'lat_penyuluh' => $lat_penyuluh,
            'long_penyuluh' => $long_penyuluh,
            'updated' => date('Y-m-d H:i:s')
        ];

        $this->db->where('id_order', $id_order);
        $this->db->update('order_penyuluh', $data);
        if ($this->db->affected_rows()) {
            $this->response([
                'status' => true,
                'message' => 'success update lokasi',
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed update lokasi',
            ], 404);
        }
    }
}