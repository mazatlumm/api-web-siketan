<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Privacy_policy extends CI_Controller {

	public function index()
	{
		$this->load->view('privacy_policy');
	}
}
