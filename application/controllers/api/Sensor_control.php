<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Sensor_control extends RestController
{
    public function index_get(){
        
        $id_device = $this->get('id_device');
        $temp_udara = $this->get('temp_udara');
        $hum_udara = $this->get('hum_udara');
        $hum_tanah = $this->get('hum_tanah');
        $data = [
            'id_device' => $id_device,
            'temp_udara' => $temp_udara,
            'hum_udara' => $hum_udara,
            'hum_tanah' => $hum_tanah,
        ];
        $data_update = [
            'temp_udara' => $temp_udara,
            'hum_udara' => $hum_udara,
            'hum_tanah' => $hum_tanah,
            'updated' => date('Y-m-d H:i:s'),
        ];
        $get_hum_sensor = $this->db->get_where('hum_sensor', ['id_device' => $id_device])->result_array();
        if($get_hum_sensor){
            //update data di manifest_hum by id_device
            $this->db->where('id_device', $id_device);
            $this->db->update('hum_sensor', $data_update);
            //setelah update berhasil, data harus di periksa, apakah kelembaban tanah sesuai dengan batasnya
            $id_device_induk = $get_hum_sensor[0]['id_device_induk'];
            $kanal = $get_hum_sensor[0]['jenis'];
            $hum_tanah = $get_hum_sensor[0]['hum_tanah'];


            $get_controller = $this->db->get_where('controller', ['id_device' => $id_device_induk])->result_array();
            if($get_controller){
                $hum_min = $get_controller[0]['hum_min'];
                $hum_max = $get_controller[0]['hum_max'];
                
                //cek kanal pada device controller yg sama
                $get_sensor_kanal = $this->db->get_where('hum_sensor', ['jenis' => $kanal, 'id_device_induk' => $id_device_induk])->result_array();
                if($get_sensor_kanal){
                    //cari id device sensor
                    $totalCalculation = 0;
                    foreach ($get_sensor_kanal as $key => $value) {
                        if($value['hum_tanah'] < $hum_min){
                            $totalCalculation += 1;
                        }
                        if($value['hum_tanah'] >= $hum_max){
                            $totalCalculation += 0;
                        }
                        if($value['hum_tanah'] >= $hum_min && $value['hum_tanah'] <= $hum_max){
                            $totalCalculation += 1;
                        }
                    }
                    if($totalCalculation == 0){
                        $this->db->where('id_device', $id_device_induk);
                        $this->db->update('controller', [$kanal => 0]);
                    }
                    if($totalCalculation > 0){
                        $this->db->where('id_device', $id_device_induk);
                        $this->db->update('controller', [$kanal => 1]);
                    }
                }
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'induk tidak ditemukan'
                ],404);
            }
            $insert = $this->db->insert('manifest_hum', $data);
            if($insert){
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
                'message' => 'unregistered'
            ],404);
        }
    }
}