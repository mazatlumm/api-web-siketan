<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class User extends RestController
{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
    }

    public function login_post()
    {
        $email = $this->post('email');
        $password = $this->post('password');

        $data = [
            'email' => $email,
            'password' => md5($password),
        ];

        $get_users = $this->db->get_where('users', $data)->result_array();
        if ($get_users) {
            foreach ($get_users as $key => $value) {
                $dataResponse[] = [
                    'id_user' => $value['id_user'],
                    'nama' => $value['nama'],
                    'pekerjaan' => $value['pekerjaan'],
                    'role' => $value['role'],
                    'alamat' => $value['alamat'],
                    'no_telp' => $value['no_telp'],
                    'email' => $value['email'],
                    'photo' => $value['photo'],
                    'gender' => $value['gender'],
                    'birthday' => $value['birthday'],
                    'token' => $value['token'],
                    'pengalaman' => $value['pengalaman'],
                    'rating' => $value['rating']/20,
                ];
            }
            $this->response([
                'status' => true,
                'message' => 'success',
                'result' => $dataResponse
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed',
                'result' => []
            ], 404);
        }
    }

    public function register_post(){
        $nama = $this->post('nama');
        $no_telp = $this->post('no_telp');
        $email = $this->post('email');
        $role = $this->post('role');
        $password = $this->post('password');

        $data = [
         'nama' => $nama,
         'no_telp' => $no_telp,
         'email' => $email,
         'role' => $role,
         'password' => md5($password),
        ];

        //cek email
        $get_email = $this->db->get_where('users', ['email' => $email])->result_array();
        if(!$get_email){
            //cek no handphone
            $get_no_telp = $this->db->get_where('users', ['no_telp' => $no_telp])->result_array();
            if(!$get_no_telp){
                $insert_user = $this->db->insert('users', $data);
                if($insert_user){
                    $this->response([
                        'status' => true,
                        'message' => 'Berhasil Mendaftarkan Akun'
                    ],200);
                }else{
                    $this->response([
                        'status' => false,
                        'message' => 'Gagal Mendaftarkan Akun'
                    ],404);
                }
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'Nomor Handphone Sudah Terdaftar'
                ],404);
            }
        }else{
            $this->response([
                'status' => false,
                'message' => 'Email Sudah Terdaftar'
            ],404);
        }
    }

    public function list_get()
    {
        $this->db->select('id_user, username, nama, pekerjaan, role, alamat, no_telp, email, photo, gender, birthday, token');
        $get_users = $this->db->get_where('users', ['role !=' => 'admin' ])->result_array();
        if ($get_users) {
            $this->response([
                'status' => true,
                'message' => 'success',
                'result' => $get_users
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed',
                'result' => []
            ], 404);
        }
    }

    public function detail_get()
    {
        $id_user = $this->get('id_user');
        $this->db->select('id_user, username, nama, pekerjaan, role, alamat, no_telp, email, photo, gender, birthday, token');
        $get_users = $this->db->get_where('users', ['id_user' => $id_user])->result_array();
        if ($get_users) {
            $this->response([
                'status' => true,
                'message' => 'success',
                'result' => $get_users
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed',
                'result' => []
            ], 404);
        }
    }

    public function tambah_post()
    {
        $username = $this->post('username');
        $nama = $this->post('nama');
        $pekerjaan = $this->post('pekerjaan');
        $role = $this->post('role');
        $password = $this->post('password');
        $email = $this->post('email');
        $alamat = $this->post('alamat');
        $no_telp = $this->post('no_telp');

        if ($username != null || $username != '') {
            //Cek Username apakah sudah pernah digunakan
            $get_users = $this->db->get_where('users', ['username' => $username])->result_array();
            if($get_users){
                $this->response([
                    'status' => false,
                    'message' => 'Duplicate',
                ], 404);
            }else{
                $data = [
                    'username' => $username,
                    'nama' => $nama,
                    'pekerjaan' => $pekerjaan,
                    'email' => $email,
                    'alamat' => $alamat,
                    'no_telp' => $no_telp,
                    'role' => $role,
                    'password' => md5($password),
                ];
    
                $insert = $this->db->insert('users', $data);
    
                if ($insert) {
                    $this->response([
                        'status' => true,
                        'message' => 'Success',
                    ], 200);
                } else {
                    $this->response([
                        'status' => false,
                        'message' => 'Failed',
                    ], 404);
                }
            }
        } else {
            $this->response([
                'status' => false,
                'message' => 'Username Belum Diisi',
            ], 404);
        }
    }

    public function edit_post()
    {
        $id_user = $this->post('id_user');
        $nama = $this->post('nama');
        $pekerjaan = $this->post('pekerjaan');
        $pengalaman = $this->post('pengalaman');
        $no_telp = $this->post('no_telp');
        $email = $this->post('email');
        $password = $this->post('password');

        if($password){
            $data = [
                'nama' => $nama,
                'pekerjaan' => $pekerjaan,
                'pengalaman' => $pengalaman,
                'no_telp' => $no_telp,
                'email' => $email,
                'password' => md5($password),
                'updated' => date('Y-m-d H:i:s')
            ];
        }else{
            $data = [
                'nama' => $nama,
                'pekerjaan' => $pekerjaan,
                'pengalaman' => $pengalaman,
                'no_telp' => $no_telp,
                'email' => $email,
                'updated' => date('Y-m-d H:i:s')
            ];
        }

        $cek_email = $this->db->get_where('users', ['email' => $email])->result_array();
        if($cek_email){
            if($id_user == $cek_email[0]['id_user']){
                //update user
                $this->db->where('id_user', $id_user);
                $this->db->update('users', $data);
                if($this->db->affected_rows()){
                    $this->db->select('id_user, nama, pekerjaan, role, alamat, no_telp, email, photo, gender, birthday, token, pengalaman, rating');
                    $get_users = $this->db->get_where('users', ['id_user' => $id_user])->result_array();
                    foreach ($get_users as $key => $value) {
                        $data[] = [
                            'id_user' => $value['id_user'],
                            'nama' => $value['nama'],
                            'pekerjaan' => $value['pekerjaan'],
                            'role' => $value['role'],
                            'alamat' => $value['alamat'],
                            'no_telp' => $value['no_telp'],
                            'email' => $value['email'],
                            'photo' => $value['photo'],
                            'gender' => $value['gender'],
                            'birthday' => $value['birthday'],
                            'token' => $value['token'],
                            'pengalaman' => $value['pengalaman'],
                            'rating' => $value['rating']/20,
                        ];
                    }
                    $this->response([
                        'status' => true,
                        'message' => 'success update users',
                        'result' => $data,
                    ],200);
                }else{
                    $this->response([
                        'status' => false,
                        'message' => 'failed update users'
                    ],404);
                }
            }else{
                //dilarang update user karena email sudah dimiliki orang lain
                $this->response([
                    'status' => false,
                    'message' => 'email duplicated'
                ],404);
            }
        }else{
            //update user
            $this->db->where('id_user', $id_user);
            $this->db->update('users', $data);
            if($this->db->affected_rows()){
                $this->db->select('id_user, nama, pekerjaan, role, alamat, no_telp, email, photo, gender, birthday, token, pengalaman, rating');
                $get_users = $this->db->get_where('users', ['id_user' => $id_user])->result_array();
                foreach ($get_users as $key => $value) {
                    $data[] = [
                        'id_user' => $value['id_user'],
                        'nama' => $value['nama'],
                        'pekerjaan' => $value['pekerjaan'],
                        'role' => $value['role'],
                        'alamat' => $value['alamat'],
                        'no_telp' => $value['no_telp'],
                        'email' => $value['email'],
                        'photo' => $value['photo'],
                        'gender' => $value['gender'],
                        'birthday' => $value['birthday'],
                        'token' => $value['token'],
                        'pengalaman' => $value['pengalaman'],
                        'rating' => $value['rating']/20,
                    ];
                }
                $this->response([
                    'status' => true,
                    'message' => 'success update users',
                    'result' => $data,
                ],200);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'failed update users'
                ],404);
            }
        }

    }

    public function hapus_post(){
        $id_user = $this->post('id_user');
        $this->db->where('id_user', $id_user);
        $this->db->delete('users');
        if($this->db->affected_rows()){
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
    }

    public function photo_profile_post(){
        $id_user = $this->post('id_user');
        $file = $id_user . "ID" . time() . "_" . basename($_FILES['image']['name']);
        $tmp_name = $_FILES['image']['tmp_name'];
        if (move_uploaded_file($tmp_name, "./upload/profile/" . $file)) {
            $get_users = $this->db->get_where('users', ['id_user' => $id_user])->result_array();
            if($get_users){
                $photo = $get_users[0]['photo'];
                if(file_exists("./upload/profile/$photo")){
                    unlink("./upload/profile/$photo");
                }
            }
            $this->db->where('id_user', $id_user);
            $this->db->update('users', ['photo' => $file, 'updated' => date('Y-m-d H:i:s')]);
            if ($this->db->affected_rows()) {
                $get_user = $this->db->get_where('users', ['id_user'=> $id_user])->result_array();
                foreach ($get_users as $key => $value) {
                    $data[] = [
                        'id_user' => $value['id_user'],
                        'nama' => $value['nama'],
                        'pekerjaan' => $value['pekerjaan'],
                        'role' => $value['role'],
                        'alamat' => $value['alamat'],
                        'no_telp' => $value['no_telp'],
                        'email' => $value['email'],
                        'photo' => $value['photo'],
                        'gender' => $value['gender'],
                        'birthday' => $value['birthday'],
                        'token' => $value['token'],
                        'pengalaman' => $value['pengalaman'],
                        'rating' => $value['rating']/20,
                    ];
                }
                $this->response([
                    'status' => true,
                    'message' => 'success',
                    'result' => $data
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

    public function reset_password_post(){
       
        $email = $this->post('email');
        //membuat Password Baru
        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcodefghijklmnopqrstuvwkyz';
        $PasswordNew = substr(str_shuffle($permitted_chars), 0, 8);

        //cek keberadaan email
        $cek_email_reset = $this->db->get_where('users', ['email' => $email])->result_array();
        if ($cek_email_reset) {

            $config = [
                'protocol'  => 'smtp',
                //'smtp_host' => 'ssl://smtp.googlemail.com',
                'smtp_host' => 'smtp.gmail.com',
                'smtp_user' => 'bkknoreplay@gmail.com',
                'smtp_pass' => 'perijrhfgqjfceur',
                'smtp_port' => '587',
                'smtp_crypto' => 'tls',
                'smtp_timeout' => '30',
                'charset' => 'iso-8859-1',
                'newline' => "\r\n",
                'wordwrap' => TRUE,
                'mailtype' => 'html'
            ];

            $this->email->initialize($config);
            $this->email->from('bkknoreplay@gmail.com', 'BERTANI');
            $this->email->to($email);
            $this->email->subject('RESET PASSWORD BERTANI');
            $this->email->message("<p>Silahkan Login Menggunakan Passsword :  <b>$PasswordNew</b>. <br>Setelah Berhasil Login, Silahkan Ubah Kembali Password Anda di Menu Profile</p>");

            if ($this->email->send()) {
                $this->db->where('email', $email);
                $this->db->update('users', ['password' => md5($PasswordNew)]);
                $this->response([
                    'status' => true,
                    'message' => 'Email Terkirim'
                ],200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Ulangi Sekali Lagi'
                ],404);
            }
        } else {
            $this->response([
                'status' => false,
                'message' => 'Email Tidak Ditemukan'
            ],404);
        }
    }

    public function location_post(){
        $id_user = $this->post('id_user');
        $role = $this->post('role');
        $latitude = $this->post('latitude');
        $longitude = $this->post('longitude');

        $data = [
            'id_user' => $id_user,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'role' => $role,
            'updated' => date('Y-m-d H:i:s'),
        ];

        if($id_user != null){
            $get_user_location = $this->db->get_where('user_location', ['id_user' => $id_user])->result_array();
            if($get_user_location){
                //update data
                $this->db->where('id_user', $id_user);
                $this->db->update('user_location', $data);
                if($this->db->affected_rows()){
                    $this->response([
                        'status' => true,
                        'message' => 'Location Updated'
                    ],200);
                } else {
                    $this->response([
                        'status' => false,
                        'message' => 'Failed Update Location'
                    ],404);
                }
            }else{
                //tambah data
                $insert = $this->db->insert('user_location', $data);
                if($insert){
                    $this->response([
                        'status' => true,
                        'message' => 'Location Added'
                    ],200);
                } else {
                    $this->response([
                        'status' => false,
                        'message' => 'Failed Added Location'
                    ],404);
                }
            }
        }else{
            $this->response([
                'status' => false,
                'message' => 'id_user is null'
            ],404);
        }
    }

    public function penyuluh_location_get(){
        $get_penyuluh = $this->db->get_where('user_location', ['role' => 'Penyuluh'])->result_array();
        if($get_penyuluh){
            foreach ($get_penyuluh as $key => $value) {
                $get_users = $this->db->get_where('users', ['id_user' => $value['id_user']])->result_array();
                if($get_users){
                    $nama_user = $get_users[0]['nama'];
                }else{
                    $nama_user = null;
                }
                $dataArray[] = [
                    'id_user' => $value['id_user'],
                    'role' => 'Penyuluh',
                    'nama' => $nama_user,
                    'latitude' => $value['latitude'],
                    'longitude' => $value['longitude'],
                    'status' => $value['status'],
                ];
            }
            $this->response([
                'status' => true,
                'message' => 'success',
                'result' => $dataArray
            ],200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed',
            ],404);
        }
    }

    public function cari_get(){
        $email = $this->get('email');
        $get_user = $this->db->get_where('users', ['email' => $email])->result_array();
        if($get_user){
            $this->response([
                'status' => true,
                'message' => 'success',
                'result' => $get_user
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed',
            ],404);
        }
    }

    public function ganti_role_post(){
        $email = $this->post('email');
        $role = $this->post('role');
        $where = [
            'role !=' => 'admin',
            'email' => $email,
        ];
        $this->db->where($where);
        $this->db->update('users', ['role' => $role, 'updated' => date('Y-m-d H:i:s')]);
        if($this->db->affected_rows()){
            $this->response([
                'status' => true,
                'message' => 'success',
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed',
            ],404);
        }
    }

    public function new_up_post(){
        $id_user = $this->post('id_user');
        $token = $this->post('token');
        $this->db->where('id_user', $id_user);
        $this->db->update('users', ['token' => $token, 'updated' => date('Y-m-d H:i:s')]);
        if($this->db->affected_rows()){
            $this->db->select('id_user, nama, pekerjaan, role, alamat, no_telp, email, photo, gender, birthday, token, pengalaman, rating');
            $get_users = $this->db->get_where('users', ['id_user' => $id_user])->result_array();
            $this->response([
                'status' => true,
                'message' => 'success update status',
                'result' => $get_users
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed update status',
            ],404);
        }
    }

    public function list_ready_get(){
        $this->db->limit(2);
        $this->db->order_by('updated', 'desc');
        $this->db->where('role !=', 'Pengguna Umum');
        $this->db->select('id_user,nama,email,gender,birthday,role,pekerjaan,pengalaman,rating,no_telp,alamat,photo,token,created,updated');
        $get = $this->db->get('users')->result_array();
        if($get){
            $this->response([
                'status' => true,
                'message' => 'ready penyuluh/admin',
                'result' => $get
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed update status',
            ],404);
        }
    }
    public function list_all_get(){
        $this->db->order_by('updated', 'desc');
        $this->db->where('role !=', 'Pengguna Umum');
        $this->db->select('id_user,nama,email,gender,birthday,role,pekerjaan,pengalaman,rating,no_telp,alamat,photo,token,created,updated');
        $get = $this->db->get('users')->result_array();
        if($get){
            $no = 1;
            foreach ($get as $key => $value) {
                $ArrDataPenggunaUmum[] = [
                    'id' => $no++,
                    'id_user' => $value['id_user'],
                    'nama' => $value['nama'],
                    'email' => $value['email'],
                    'gender' => $value['gender'],
                    'birthday' => $value['birthday'],
                    'role' => $value['role'],
                    'pekerjaan' => $value['pekerjaan'],
                    'pengalaman' => $value['pengalaman'],
                    'rating' => $value['rating'],
                    'no_telp' => $value['no_telp'],
                    'alamat' => $value['alamat'],
                    'photo' => $value['photo'],
                    'token' => $value['token'],
                    'created' => $value['created'],
                    'updated' => $value['updated'],
                    'total_pesan' => 0,
                    'pesan_terakhir' => '',
                    'status' => 'Sudah Dijawab',
                    'nama_penyuluh' => '',
                ];
            }
            $this->response([
                'status' => true,
                'message' => 'ready penyuluh/admin',
                'result' => $ArrDataPenggunaUmum
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed update status',
            ],404);
        }
    }
    public function list_pengguna_chat_get(){
        $id_user2 = $this->get('id_user2');
        if($id_user2){
            $this->db->order_by('updated', 'desc');
            $get_chat = $this->db->get_where('chat', ['id_user2' => $id_user2])->result_array();
        }else{
            $this->db->order_by('updated', 'desc');
            $get_chat = $this->db->get('chat')->result_array();
        }
        $ArrValue = [];
        $IDUSER1 = [];
        if($get_chat){
            foreach ($get_chat as $key => $value) {
                $IDUSER1[] = $value['id_user1'];
            }
        }
        $NewArrUser1 = array_values(array_unique($IDUSER1));
        if($NewArrUser1){
            foreach ($NewArrUser1 as $key => $value) {
                $id_user1 = $value;
                $this->db->order_by('updated', 'desc');
                $this->db->where('role', 'Pengguna Umum');
                $this->db->select('id_user,nama,email,gender,birthday,role,pekerjaan,pengalaman,rating,no_telp,alamat,photo,token,created,updated');
                $get = $this->db->get_where('users', ['id_user' => $id_user1])->result_array();
                $ArrValue[] = [
                    'id_user' => $get[0]['id_user'],
                    'nama' => $get[0]['nama'],
                    'email' => $get[0]['email'],
                    'gender' => $get[0]['gender'],
                    'birthday' => $get[0]['birthday'],
                    'role' => $get[0]['role'],
                    'pekerjaan' => $get[0]['pekerjaan'],
                    'pengalaman' => $get[0]['pengalaman'],
                    'rating' => $get[0]['rating'],
                    'no_telp' => $get[0]['no_telp'],
                    'alamat' => $get[0]['alamat'],
                    'photo' => $get[0]['photo'],
                    'token' => $get[0]['token'],
                    'created' => $get[0]['created'],
                    'updated' => $get[0]['updated'],
                ];
            }
        }
        if($get){
            $this->response([
                'status' => true,
                'message' => 'ready penyuluh/admin',
                'result' => $ArrValue
            ],200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'failed update status',
            ],404);
        }
    }
}
