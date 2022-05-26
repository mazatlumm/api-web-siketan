<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Kanal extends RestController
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }

    public function index_get()
    {
        $id_device_induk = $this->get('id_device_induk');
        $get_kanal = $this->db->get_where('hum_sensor', ['id_device_induk' => $id_device_induk])->result_array();
        if($get_kanal){
            $dataKanal1 = [];
            $dataKanal2 = [];
            $dataKanal3 = [];
            $dataKanal4 = [];
            foreach ($get_kanal as $key => $value) {
                if($value['jenis'] == 'kanal1'){
                    $dataKanal1[] = [
                        'id_hum_sensor' => $value['id_hum_sensor'],
                        'id_device' => $value['id_device'],
                        'id_device_induk' => $value['id_device_induk'],
                        'temp_udara' => $value['temp_udara'],
                        'hum_udara' => $value['hum_udara'],
                        'hum_tanah' => $value['hum_tanah'],
                        'jenis' => $value['jenis'],
                        'updated' => $value['updated'],
                        'created' => $value['created'],
                    ];
                }
                if($value['jenis'] == 'kanal2'){
                    $dataKanal2[] = [
                        'id_hum_sensor' => $value['id_hum_sensor'],
                        'id_device' => $value['id_device'],
                        'id_device_induk' => $value['id_device_induk'],
                        'temp_udara' => $value['temp_udara'],
                        'hum_udara' => $value['hum_udara'],
                        'hum_tanah' => $value['hum_tanah'],
                        'jenis' => $value['jenis'],
                        'updated' => $value['updated'],
                        'created' => $value['created'],
                    ];
                }
                if($value['jenis'] == 'kanal3'){
                    $dataKanal3[] = [
                        'id_hum_sensor' => $value['id_hum_sensor'],
                        'id_device' => $value['id_device'],
                        'id_device_induk' => $value['id_device_induk'],
                        'temp_udara' => $value['temp_udara'],
                        'hum_udara' => $value['hum_udara'],
                        'hum_tanah' => $value['hum_tanah'],
                        'jenis' => $value['jenis'],
                        'updated' => $value['updated'],
                        'created' => $value['created'],
                    ];
                }
                if($value['jenis'] == 'kanal4'){
                    $dataKanal4[] = [
                        'id_hum_sensor' => $value['id_hum_sensor'],
                        'id_device' => $value['id_device'],
                        'id_device_induk' => $value['id_device_induk'],
                        'temp_udara' => $value['temp_udara'],
                        'hum_udara' => $value['hum_udara'],
                        'hum_tanah' => $value['hum_tanah'],
                        'jenis' => $value['jenis'],
                        'updated' => $value['updated'],
                        'created' => $value['created'],
                    ];
                }
            }
            $this->response([
                'status' => true,
                'message' => 'success',
                'dataKanal1' => $dataKanal1,
                'dataKanal2' => $dataKanal2,
                'dataKanal3' => $dataKanal3,
                'dataKanal4' => $dataKanal4,
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed',
                'result' => [],
            ],404);
        }

    }
}