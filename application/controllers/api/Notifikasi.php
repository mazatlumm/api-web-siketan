<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Notifikasi extends RestController
{
    public function index_get(){
        $get_users = $this->db->get_where('users', ['token !=' => null])->result_array();

        foreach ($get_users as $key => $value) {
            $token = $value['token'];
            //kirim notif ke tiap pengguna
            $dataNotifikasi = [
                'to' => $token,
                'notification' => [
                    'body' => 'Selamat Datang Di Aplikasi SIKeTan',
                    'title' => "Testing Notifikasi",
                ]
            ];
            $curl = curl_init();
    
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($dataNotifikasi),
            CURLOPT_HTTPHEADER => array(
                'Authorization: key=AAAA4JFifGg:APA91bHENYCSJmm28lW5zQ_0_ATtXmuqY8UcjFXhOnPJ38azca7GCbsKp8iFk9JHgODwKg7a2bSUq9oiGe_Axq2MmW9q2H-bskPHoTjrgfI1YEtRepwDbQwfektSM-MaRg_716RjcBFK',
                'Content-Type: application/json'
            ),
            ));
    
            $response = curl_exec($curl);
            curl_close($curl);
        }

        $this->response([
            'status' => true,
            'message' => 'notification success',
            'result' => $response
        ],200);
    }
}