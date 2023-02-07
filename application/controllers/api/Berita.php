<?php

defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Berita extends RestController
{

    public function teks_post()
    {
        $id_user = $this->post('id_user');
        $judul = $this->post('judul');
        $deskripsi = $this->post('deskripsi');
        $content_berita = $this->post('content_berita');

        $this->load->library('image_lib');

        $uploaddir = "./upload/berita/";
        if (isset($_FILES['file'])) {
            $nama_file = $_FILES['file']['name'];
            $explode = explode('.', $nama_file);
            if (!empty($explode)) {
                $count = count($explode);
                $array_index = $count - 1;
                $type = strtolower($explode[$array_index]);
            } else {
                $type = "Undefined";
            }
            $allowedfileExtensions = array('jpg', 'png', 'jpeg', 'gif');
            if (in_array($type, $allowedfileExtensions)) {
                $ukuran_file = $_FILES['file']['size'] / 1000000;
                if ($ukuran_file <= 6) {
                    $nama_file_baru = "Berita-" . $id_user . md5(sha1(date('Y-m-d H:i:s') . $nama_file . $type)) . "." . $type;
                    $uploadfile = $uploaddir . "$nama_file_baru";
                    $upload = move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
                    if ($upload) {
                        //insert berita
                        $data = [
                            'id_user' => $id_user,
                            'judul' => $judul,
                            'tumbnail' => $nama_file_baru,
                            'deskripsi' => $deskripsi,
                            'content_berita' => $content_berita,
                            'tanggal_dibuat' => date('Y-m-d'),
                            'tipe' => 'teks',
                        ];

                        $insert_berita = $this->db->insert('berita', $data);
                        if ($insert_berita) {
                            $get_users = $this->db->get_where('users', ['token !=' => null])->result_array();

                            foreach ($get_users as $key => $value) {
                                $token = $value['token'];
                                //kirim notif ke tiap pengguna
                                $dataNotifikasi = [
                                    'to' => $token,
                                    'notification' => [
                                        'body' => $deskripsi,
                                        'title' => $judul,
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
                            redirect('dashboard');
                        } else {
                            redirect('dashboard');
                        }
                    }
                } else {
                    redirect('dashboard');
                }
            } else {
                redirect('dashboard');
            }
        } else {
            redirect('dashboard');
        }
    }

    public function teks_edit_post()
    {
        $id_user = $this->fungsi->user_login()->id_user;
        $id_berita = $this->post('id_berita');
        $judul = $this->post('judul');
        $deskripsi = $this->post('deskripsi');
        $content_berita = $this->post('content_berita');

        $this->load->library('image_lib');

        $uploaddir = "./upload/berita/";
        $id_user = $this->fungsi->user_login()->id_user;
        if (isset($_FILES['file'])) {
            $nama_file = $_FILES['file']['name'];
            $explode = explode('.', $nama_file);
            if (!empty($explode)) {
                $count = count($explode);
                $array_index = $count - 1;
                $type = strtolower($explode[$array_index]);
            } else {
                $type = "Undefined";
            }
            $allowedfileExtensions = array('jpg', 'png', 'jpeg', 'gif');
            if (in_array($type, $allowedfileExtensions)) {
                $ukuran_file = $_FILES['file']['size'] / 1000000;
                if ($ukuran_file <= 6) {
                    $nama_file_baru = "Berita-" . $id_user . md5(sha1(date('Y-m-d H:i:s') . $nama_file . $type)) . "." . $type;
                    $uploadfile = $uploaddir . "$nama_file_baru";
                    $upload = move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
                    $get_berita = $this->db->get_where('berita', ['id_berita' => $id_berita])->result_array();
                    if ($get_berita) {
                        $file_tumbnail = $get_berita[0]['tumbnail'];
                        if ($file_tumbnail != null) {
                            if (file_exists($uploaddir . $file_tumbnail)) {
                                unlink($uploaddir . $file_tumbnail);
                            }
                        }
                    }
                    if ($upload) {
                        //edit berita
                        $data = [
                            'id_user' => $id_user,
                            'judul' => $judul,
                            'tumbnail' => $nama_file_baru,
                            'deskripsi' => $deskripsi,
                            'content_berita' => $content_berita,
                            'tanggal_dibuat' => date('Y-m-d'),
                        ];

                        $this->db->where('id_berita', $id_berita);
                        $this->db->update('berita', $data);
                        if ($this->db->affected_rows()) {
                            $this->session->set_flashdata('success', '');
                            redirect('website/berita_teks');
                        } else {
                            $this->session->set_flashdata('failed', '');
                            redirect('website/berita_teks');
                        }
                    }
                } else {
                    $this->session->set_flashdata('failed', '');
                    redirect('website/berita_teks');
                }
            } else {
                $data = [
                    'id_user' => $id_user,
                    'judul' => $judul,
                    'deskripsi' => $deskripsi,
                    'content_berita' => $content_berita,
                    'tanggal_dibuat' => date('Y-m-d'),
                ];

                $this->db->where('id_berita', $id_berita);
                $this->db->update('berita', $data);
                if ($this->db->affected_rows()) {
                    $this->session->set_flashdata('success', '');
                    redirect('website/berita_teks');
                } else {
                    $this->session->set_flashdata('failed', '');
                    redirect('website/berita_teks');
                }
            }
        } else {
            $data = [
                'id_user' => $id_user,
                'judul' => $judul,
                'deskripsi' => $deskripsi,
                'content_berita' => $content_berita,
                'tanggal_dibuat' => date('Y-m-d'),
            ];

            $this->db->where('id_berita', $id_berita);
            $this->db->update('berita', $data);
            if ($this->db->affected_rows()) {
                $this->session->set_flashdata('success', '');
                redirect('website/berita_teks');
            } else {
                $this->session->set_flashdata('failed', '');
                redirect('website/berita_teks');
            }
        }
    }

    public function hapus_teks_get()
    {
        $id_berita = $this->get('id_berita');
        $id_user = $this->get('id_user');
        // $uploaddir = "./upload/berita/";

        // $get_berita = $this->db->get_where('berita', ['id' => $id_berita])->result_array();
        // if ($get_berita) {
        //     $file_tumbnail = $get_berita[0]['tumbnail'];
        //     if ($file_tumbnail != null) {
        //         if (file_exists($uploaddir . $file_tumbnail)) {
        //             unlink($uploaddir . $file_tumbnail);
        //         }
        //     }
        // }

        $this->db->where('id', $id_berita);
        $this->db->update('berita', ['id_user' => $id_user, 'status' => 'deleted']);
        if ($this->db->affected_rows()) {
            redirect('dashboard');
        } else {
            redirect('dashboard');
        }
    }
}
