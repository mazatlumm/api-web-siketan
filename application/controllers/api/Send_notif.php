<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Send_notif extends RestController
{
    public function index_post(){
        $title = $this->post('title');
        $body = $this->post('body');
        $icon = $this->post('icon');
        $url = $this->post('url');
        $to = $this->post('to');

        $postdata = json_encode(
            [
                'notification' => 
                    [
                        'title' => $title,
                        'body' => $body,
                        'icon' => $icon,
                        'click_action' => $url
                    ]
                ,
                'to' => $to
            ]
        );
    
        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/json'."\r\n"
                            .'Authorization:'.'key=AAAAWBfv5Pg:APA91bFkM2F9IDLmOFl10IXt4exFpDkrFiWPmpNFRF2Pv0wwsZZKVDLeO_PQKQHtk0iYaSFD3B5LwJYaCGjmGNjP_nRTTy9j0rUETR9p92oRhwYomnL4eXqKv5hX3EKXu_P-1dVQ4q7d'."\r\n",
                'content' => $postdata
            )
        );
    
        $context  = stream_context_create($opts);
    
        $result = file_get_contents('https://fcm.googleapis.com/fcm/send', false, $context);
        if($result) {
            $decoded_json = json_decode($result, false);
            if($decoded_json->success == 1){
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
        } else return false;
    }
}