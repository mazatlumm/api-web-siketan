<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Rating extends RestController
{
    public function index_post(){
        $id_user = $this->post('id_user');
        $id_user_rating = $this->post('id_user_rating');
        $rating = $this->post('rating') * 20;

        $where_update = [
            'id_user' => $id_user, 
            'id_user_rating' => $id_user_rating
        ];
        $get_rating = $this->db->get_where('rating', $where_update)->result_array();
        if($get_rating){
            //update rating
            $this->db->where($where_update);
            $this->db->update('rating', ['nilai' => $rating, 'updated' => date('Y-m-d H:i:s')]);
            if($this->db->affected_rows()){
                $get_count_rating = $this->db->get_where('rating', ['id_user_rating' => $id_user_rating])->result_array();
                if($get_count_rating){
                    $total_nilai_rating = 0;
                    $nilai_rating = 0;
                    foreach ($get_count_rating as $key => $value) {
                        $nilai_rating = $value['nilai'] + $nilai_rating;
                    }
                    $total_nilai_rating = $nilai_rating/count($get_count_rating);
                    $this->db->where('id_user', $id_user_rating);
                    $this->db->update('users', ['rating' => $total_nilai_rating]);
                }
                $this->response([
                    'status' => true,
                    'message' => 'success update rating',
                    'rating' => $total_nilai_rating
                ],200);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'failed update rating'
                ],404);
            }
        }else{
            //insert rating
            $insert = $this->db->insert('rating', ['id_user' => $id_user, 'id_user_rating' => $id_user_rating, 'nilai' => $rating]);
            if($insert){
                $get_count_rating = $this->db->get_where('rating', ['id_user_rating' => $id_user_rating])->result_array();
                if($get_count_rating){
                    $total_nilai_rating = 0;
                    $nilai_rating = 0;
                    foreach ($get_count_rating as $key => $value) {
                        $nilai_rating = $value['nilai'] + $nilai_rating;
                    }
                    $total_nilai_rating = $nilai_rating/count($get_count_rating);
                    $this->db->where('id_user', $id_user_rating);
                    $this->db->update('users', ['rating' => $total_nilai_rating]);
                }
                $this->response([
                    'status' => true,
                    'message' => 'success insert rating',
                    'rating' => $total_nilai_rating
                ],200);
            }else{
                $this->response([
                    'status' => false,
                    'message' => 'failed insert rating'
                ],404);
            }
        }
    }
}