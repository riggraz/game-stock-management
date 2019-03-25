<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->helper('url');
	}

	public function index()
	{
		$data['logged_in'] = $this->is_logged_in() ? 'yes' : 'no';
		$this->load->view('templates/header');
		$this->load->view('welcome_message', $data);
		$this->load->view('templates/footer');
	}
}
