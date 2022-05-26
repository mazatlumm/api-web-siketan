<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Coba extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }

    public function index_get()
    {
        $get_users = $this->db->get_where('users', ['id_user' => 1])->result_array();
        if($get_users){
            $this->response([
                'status' => true,
                'message' => 'success',
                'result' => $get_users
            ], 200 );
        }else{
            $this->response( [
                'status' => false,
                'message' => 'User Tidak Ditemukan'
            ], 404 );
        }
    }
}