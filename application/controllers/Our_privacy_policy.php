<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Our_privacy_policy extends CI_Controller {

	public function index()
	{
		$this->load->view('privacy_policy');
	}
}
