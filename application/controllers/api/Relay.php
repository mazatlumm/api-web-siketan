<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Relay extends RestController
{
//masih salah
    public function index_get(){
        $id_device = $this->get('id_device');
        $get_controller = $this->db->get_where('controller', ['id_device' => $id_device])->result_array();
        if($get_controller){
            $kanal1 = $get_controller[0]['kanal1'];
            $kanal2 = $get_controller[0]['kanal2'];
            $kanal3 = $get_controller[0]['kanal3'];
            $kanal4 = $get_controller[0]['kanal4'];
            $this->response([
                'status' => true,
                'message' => 'success',
                'kanal1' => $kanal1,
                'kanal2' => $kanal2,
                'kanal3' => $kanal3,
                'kanal4' => $kanal4,
            ], 200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed',
            ], 404);
        }
    }
}