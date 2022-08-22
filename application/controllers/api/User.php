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
        $username = $this->post('username');
        $password = $this->post('password');

        $data = [
            'username' => $username,
            'password' => md5($password),
        ];
        $this->db->select('id_user, username, nama, pekerjaan, role, alamat, no_telp, email, photo, gender, birthday, token');
        $get_users = $this->db->get_where('users', $data)->result_array();
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

    public function register_post(){
        $nama = $this->post('nama');
        $username = $this->post('username');
        $email = $this->post('email');
        $gender = $this->post('gender');
        $birthday = $this->post('birthday');
        $pekerjaan = $this->post('pekerjaan');
        $no_telp = $this->post('no_telp');
        $alamat = $this->post('alamat');
        $role = $this->post('role');
        $password = $this->post('password');

        $data = [
         'nama' => $nama,
         'username' => $username,
         'email' => $email,
         'gender' => $gender,
         'birthday' => $birthday,
         'pekerjaan' => $pekerjaan,
         'no_telp' => $no_telp,
         'alamat' => $alamat,
         'role' => $role,
         'password' => md5($password),
        ];

        //cek username
        $get_username = $this->db->get_where('users', ['username' => $username])->result_array();
        if(!$get_username){
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
        }else{
            $this->response([
                'status' => false,
                'message' => 'Username Sudah Terdaftar, Silahkan Menggunakan Username Lainnya'
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
        $username = $this->post('username');
        $nama = $this->post('nama');
        $pekerjaan = $this->post('pekerjaan');
        $no_telp = $this->post('no_telp');
        $alamat = $this->post('alamat');
        $email = $this->post('email');
        $password = $this->post('password');
        $gender = $this->post('gender');
        $birthday = $this->post('birthday');

        if($password != null || $password != ''){
            $data = [
                'username' => $username,
                'nama' => $nama,
                'pekerjaan' => $pekerjaan,
                'no_telp' => $no_telp,
                'alamat' => $alamat,
                'email' => $email,
                'gender' => $gender,
                'birthday' => $birthday,
                'password' => md5($password),
                'updated' => date('Y-m-d H:i:s')
            ];
        }else{
            $data = [
                'username' => $username,
                'nama' => $nama,
                'pekerjaan' => $pekerjaan,
                'no_telp' => $no_telp,
                'alamat' => $alamat,
                'email' => $email,
                'gender' => $gender,
                'birthday' => $birthday,
                'updated' => date('Y-m-d H:i:s')
            ];
        }

        //cek username terlebih dahulu
        $get_users = $this->db->get_where('users', ['id_user' => $id_user])->result_array();

        if($get_users){
            $username_lama = $get_users[0]['username'];
        }else{
            $username_lama = null;
        }

        if($username_lama == $username){
            $this->db->where('id_user', $id_user);
            $this->db->update('users', $data);
    
            if ($this->db->affected_rows()) {
                $this->db->select('id_user, username, nama, pekerjaan, role, alamat, no_telp, email, photo, gender, birthday, token');
                $get_users = $this->db->get_where('users', ['id_user' => $id_user])->result_array();
                $this->response([
                    'status' => true,
                    'message' => 'success',
                    'result' => $get_users,
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'failed',
                ], 404);
            }
        }else{
            $get_users_scan_username = $this->db->get_where('users', ['username' => $username])->result_array();
            if($get_users_scan_username){
                $this->response([
                    'status' => false,
                    'message' => 'Username Tidak Tersedia',
                ], 404);
            }else{
                $this->db->where('id_user', $id_user);
                $this->db->update('users', $data);
        
                if ($this->db->affected_rows()) {
                    $this->db->select('id_user, username, nama, pekerjaan, role, alamat, no_telp, email, photo, gender, birthday, token');
                    $get_users = $this->db->get_where('users', ['id_user' => $id_user])->result_array();
                    $this->response([
                        'status' => true,
                        'message' => 'success',
                        'result' => $get_users,
                    ], 200);
                } else {
                    $this->response([
                        'status' => false,
                        'message' => 'failed',
                    ], 404);
                }
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
                $this->response([
                    'status' => true,
                    'message' => 'success',
                    'photo' => $file
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
}
