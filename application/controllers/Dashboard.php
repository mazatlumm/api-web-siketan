<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
		$this->db->order_by('created', 'desc');
		$data['berita'] = $this->db->get_where('berita', ['status' => null])->result_array();
		$this->load->view('dashboard', $data);
	}
}
