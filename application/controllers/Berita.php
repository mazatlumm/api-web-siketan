<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berita extends CI_Controller {

	public function detil($id=null)
	{
		$data['berita'] = $this->db->get_where('berita', ['id' => $id])->result_array();
		$this->load->view('berita', $data);
	}
}
