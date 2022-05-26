<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Controller extends RestController
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }

    public function index_post()
    {
        $id_user = $this->post('id_user');
        $id_device = $this->post('id_device');
        $nama_perangkat = $this->post('nama_perangkat');
        $tanaman = $this->post('tanaman');
        $hum_min = $this->post('hum_min');
        $hum_max = $this->post('hum_max');
        $status = 0;
        $lokasi = $this->post('lokasi');
        $kanal1 = $this->post('kanal1');
        $kanal2 = $this->post('kanal2');
        $kanal3 = $this->post('kanal3');
        $kanal4 = $this->post('kanal4');

        if ($id_device != null || $id_device != '') {
            $data = [
                'id_user' => $id_user,
                'id_device' => $id_device,
                'nama_perangkat' => $nama_perangkat,
                'tanaman' => $tanaman,
                'hum_min' => $hum_min,
                'hum_max' => $hum_max,
                'status' => $status,
                'lokasi' => $lokasi,
                'updated' => date('Y-m-d H:i:s')
            ];

            //Cek ID Device & ID_Ueser Terlebih Dahulu
            $dataWhere = [
                'id_device' => $id_device,
            ];

            $get_controller = $this->db->get_where('controller', $dataWhere)->result_array();
            if ($get_controller) {
                $this->response([
                    'status' => false,
                    'message' => 'duplicate'
                ], 404);
            } else {
                $insertController = $this->db->insert('controller', $data);
                if ($insertController) {
                    if ($kanal1 != null || $kanal1 != '') {
                        $parseKanal1 = explode(',', $kanal1);
                        if (count($parseKanal1) != 0) {
                            for ($i = 0; $i < count($parseKanal1); $i++) {
                                $dataKanal1Insert = [
                                    'id_device_induk' => $id_device,
                                    'id_device' => $parseKanal1[$i],
                                    'jenis' => 'kanal1'
                                ];
                                if ($parseKanal1[$i] != null || $parseKanal1[$i] != '') {
                                    $get_hum_sensor = $this->db->get_where('hum_sensor', ['id_device' => $parseKanal1[$i], 'id_device_induk' => $id_device])->result_array();
                                    if (!$get_hum_sensor) {
                                        $this->db->insert('hum_sensor', $dataKanal1Insert);
                                    }
                                }
                            }
                        }
                    }
                    if ($kanal2 != null || $kanal2 != '') {
                        $parseKanal2 = explode(',', $kanal2);
                        if (count($parseKanal2) != 0) {
                            for ($i = 0; $i < count($parseKanal2); $i++) {
                                $dataKanal2Insert = [
                                    'id_device_induk' => $id_device,
                                    'id_device' => $parseKanal2[$i],
                                    'jenis' => 'kanal2'
                                ];
                                if ($parseKanal2[$i] != null || $parseKanal2[$i] != '') {
                                    $get_hum_sensor = $this->db->get_where('hum_sensor', ['id_device' => $parseKanal2[$i], 'id_device_induk' => $id_device])->result_array();
                                    if (!$get_hum_sensor) {
                                        $this->db->insert('hum_sensor', $dataKanal2Insert);
                                    }
                                }
                            }
                        }
                    }
                    if ($kanal3 != null || $kanal3 != '') {
                        $parseKanal3 = explode(',', $kanal3);
                        if (count($parseKanal3) != 0) {
                            for ($i = 0; $i < count($parseKanal3); $i++) {
                                $dataKanal3Insert = [
                                    'id_device_induk' => $id_device,
                                    'id_device' => $parseKanal3[$i],
                                    'jenis' => 'kanal3'
                                ];
                                if ($parseKanal3[$i] != null || $parseKanal3[$i] != '') {
                                    $get_hum_sensor = $this->db->get_where('hum_sensor', ['id_device' => $parseKanal3[$i], 'id_device_induk' => $id_device])->result_array();
                                    if (!$get_hum_sensor) {
                                        $this->db->insert('hum_sensor', $dataKanal3Insert);
                                    }
                                }
                            }
                        }
                    }
                    if ($kanal4 != null || $kanal4 != '') {
                        $parseKanal4 = explode(',', $kanal4);
                        if (count($parseKanal4) != 0) {
                            for ($i = 0; $i < count($parseKanal4); $i++) {
                                $dataKanal4Insert = [
                                    'id_device_induk' => $id_device,
                                    'id_device' => $parseKanal4[$i],
                                    'jenis' => 'kanal4'
                                ];
                                if ($parseKanal4[$i] != null || $parseKanal4[$i] != '') {
                                    $get_hum_sensor = $this->db->get_where('hum_sensor', ['id_device' => $parseKanal4[$i], 'id_device_induk' => $id_device])->result_array();
                                    if (!$get_hum_sensor) {
                                        $this->db->insert('hum_sensor', $dataKanal4Insert);
                                    }
                                }
                            }
                        }
                    }
                    $this->response([
                        'status' => true,
                        'message' => 'success'
                    ], 200);
                } else {
                    $this->response([
                        'status' => false,
                        'message' => 'duplicate'
                    ], 404);
                }
            }
        }
    }

    public function index_put()
    {
        $id_controller = $this->put('id_controller');
        $id_user = $this->put('id_user');
        $id_device = $this->put('id_device');
        $nama_perangkat = $this->put('nama_perangkat');
        $tanaman = $this->put('tanaman');
        $hum_min = $this->put('hum_min');
        $hum_max = $this->put('hum_max');
        $lokasi = $this->put('lokasi');
        $kanal1 = $this->put('kanal1');
        $kanal2 = $this->put('kanal2');
        $kanal3 = $this->put('kanal3');
        $kanal4 = $this->put('kanal4');

        if ($id_controller != null || $id_controller != '') {
            //get id_device sebelumnya
            $get_controller = $this->db->get_where('controller', ['id_controller' => $id_controller])->result_array();
            if ($get_controller) {
                $id_device_lama = $get_controller[0]['id_device'];
                if ($id_device_lama != $id_device) {
                    $this->db->where('id_device_induk', $id_device_lama);
                    $this->db->delete('hum_sensor');
                    if ($kanal1 != null || $kanal1 != '') {
                        $parseKanal1 = explode(',', $kanal1);
                        if (count($parseKanal1) != 0) {
                            for ($i = 0; $i < count($parseKanal1); $i++) {
                                $dataKanal1Insert = [
                                    'id_device_induk' => $id_device,
                                    'id_device' => $parseKanal1[$i],
                                    'jenis' => 'kanal1'
                                ];
                                if ($parseKanal1[$i] != null || $parseKanal1[$i] != '') {
                                    $get_hum_sensor = $this->db->get_where('hum_sensor', ['id_device' => $parseKanal1[$i], 'id_device_induk' => $id_device])->result_array();
                                    if (!$get_hum_sensor) {
                                        $this->db->insert('hum_sensor', $dataKanal1Insert);
                                    }
                                }
                            }
                        }
                    }
                    if ($kanal2 != null || $kanal2 != '') {
                        $parseKanal2 = explode(',', $kanal2);
                        if (count($parseKanal2) != 0) {
                            for ($i = 0; $i < count($parseKanal2); $i++) {
                                $dataKanal2Insert = [
                                    'id_device_induk' => $id_device,
                                    'id_device' => $parseKanal2[$i],
                                    'jenis' => 'kanal2'
                                ];
                                if ($parseKanal2[$i] != null || $parseKanal2[$i] != '') {
                                    $get_hum_sensor = $this->db->get_where('hum_sensor', ['id_device' => $parseKanal2[$i], 'id_device_induk' => $id_device])->result_array();
                                    if (!$get_hum_sensor) {
                                        $this->db->insert('hum_sensor', $dataKanal2Insert);
                                    }
                                }
                            }
                        }
                    }
                    if ($kanal3 != null || $kanal3 != '') {
                        $parseKanal3 = explode(',', $kanal3);
                        if (count($parseKanal3) != 0) {
                            for ($i = 0; $i < count($parseKanal3); $i++) {
                                $dataKanal3Insert = [
                                    'id_device_induk' => $id_device,
                                    'id_device' => $parseKanal3[$i],
                                    'jenis' => 'kanal3'
                                ];
                                if ($parseKanal3[$i] != null || $parseKanal3[$i] != '') {
                                    $get_hum_sensor = $this->db->get_where('hum_sensor', ['id_device' => $parseKanal3[$i], 'id_device_induk' => $id_device])->result_array();
                                    if (!$get_hum_sensor) {
                                        $this->db->insert('hum_sensor', $dataKanal3Insert);
                                    }
                                }
                            }
                        }
                    }
                    if ($kanal4 != null || $kanal4 != '') {
                        $parseKanal4 = explode(',', $kanal4);
                        if (count($parseKanal4) != 0) {
                            for ($i = 0; $i < count($parseKanal4); $i++) {
                                $dataKanal4Insert = [
                                    'id_device_induk' => $id_device,
                                    'id_device' => $parseKanal4[$i],
                                    'jenis' => 'kanal4'
                                ];
                                if ($parseKanal4[$i] != null || $parseKanal4[$i] != '') {
                                    $get_hum_sensor = $this->db->get_where('hum_sensor', ['id_device' => $parseKanal4[$i], 'id_device_induk' => $id_device])->result_array();
                                    if (!$get_hum_sensor) {
                                        $this->db->insert('hum_sensor', $dataKanal4Insert);
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $dataEdit = [
                'id_user' => $id_user,
                'id_device' => $id_device,
                'nama_perangkat' => $nama_perangkat,
                'tanaman' => $tanaman,
                'hum_min' => $hum_min,
                'hum_max' => $hum_max,
                'lokasi' => $lokasi,
                'updated' => date('Y-m-d H:i:s')
            ];

            $this->db->where('id_controller', $id_controller);
            $this->db->update('controller', $dataEdit);
            if ($this->db->affected_rows()) {
                $this->response([
                    'status' => true,
                    'message' => 'success'
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'failed'
                ], 404);
            }
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed'
            ], 404);
        }
    }

    public function index_get()
    {
        $id_user = $this->get('id_user');
        $id_controller = $this->get('id_controller');
        if($id_controller){
            if ($id_user != null || $id_user != '') {
                $get_controller = $this->db->get_where('controller', ['id_user' => $id_user, 'id_controller' => $id_controller])->result_array();
                if ($get_controller) {
                    //cari last update
                    $updated = date_create($get_controller[0]['updated']);
                    $current_time = date_create();
                    $selisih_watku = date_diff($updated, $current_time);
                    if($get_controller[0]['updated'] != null){
                        if($selisih_watku->h >= 1){
                            $status_device = 'Offline';
                        }else{
                            $status_device = 'Online';
                        }
                    }else{
                        $status_device = 'Offline';
                    }

                    $this->response([
                        'status' => true,
                        'message' => 'success',
                        'result' => $get_controller,
                        'selisih_waktu' => $selisih_watku->h."j ". $selisih_watku->i ."m ". $selisih_watku->s. "d",
                        'status_device' => $status_device
                    ], 200);
                } else {
                    $this->response([
                        'status' => false,
                        'message' => 'failed',
                        'result' => []
                    ], 404);
                }
            }
        }else{
            if ($id_user != null || $id_user != '') {
                $get_controller = $this->db->get_where('controller', ['id_user' => $id_user])->result_array();
                if ($get_controller) {
                    $updated = date_create($get_controller[0]['updated']);
                    $current_time = date_create();
                    $selisih_watku = date_diff($updated, $current_time);
                    if($get_controller[0]['updated'] != null){
                        if($selisih_watku->h >= 1){
                            $status_device = 'Offline';
                        }else{
                            $status_device = 'Online';
                        }
                    }else{
                        $status_device = 'Offline';
                    }

                    $this->response([
                        'status' => true,
                        'message' => 'success',
                        'result' => $get_controller,
                        'selisih_waktu' => $selisih_watku->h."j ". $selisih_watku->i ."m ". $selisih_watku->s. "d",
                        'status_device' => $status_device
                    ], 200);
                } else {
                    $this->response([
                        'status' => false,
                        'message' => 'failed',
                        'result' => []
                    ], 404);
                }
            }
        } 
    }

    public function hapus_get()
    {
        $id_device = $this->get('id_device');
        $this->db->where('id_device', $id_device);
        $this->db->delete('controller');
        if ($this->db->affected_rows()) {
            $this->db->where('id_device_induk', $id_device);
            $this->db->delete('hum_sensor');
            if ($this->db->affected_rows()) {
                $this->response([
                    'status' => true,
                    'message' => 'success',
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

    public function last_get(){
        $id_user = $this->get('id_user');
        $this->db->order_by('created', 'DESC');
        $this->db->limit(1);
        $get_controller = $this->db->get_where('controller', ['id_user' => $id_user])->result_array();
        if($get_controller){
            $this->response([
                'status' => true,
                'message' => 'success',
                'result' => $get_controller,
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed',
            ], 404);
        }
    }

    public function control_button_get(){
        $id_device = $this->get('id_device');
        $kanal = $this->get('kanal');
        $switch = $this->get('switch');
        if($id_device != null || $id_device != ''){
            $this->db->where('id_device', $id_device);
            $this->db->update('controller', [$kanal => $switch, 'updated' => date('Y-m-d H:i:s')]);
            if($this->db->affected_rows()){
                $this->response([
                    'status' => true,
                    'message' => 'success'
                ],200);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'failed'
                ],404);
            }
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed'
            ],404);
        }
    }
}
