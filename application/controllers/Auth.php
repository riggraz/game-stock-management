<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller {
  public function __construct()
	{
    parent::__construct();

		// Force SSL
		//$this->force_ssl();

		// Form and URL helpers always loaded (just for convenience)
		$this->load->helper('url');
		$this->load->helper('form');
  }
  
  public function login()
	{
    if ($this->is_logged_in())
      redirect(site_url(''));

		if (strtolower( $_SERVER['REQUEST_METHOD'] ) == 'post')
			$this->require_min_level(1);

    $this->setup_login_form();
    
    $this->load->remove_package_path(APPPATH.'third_party/community_auth/');
    $this->load->view('templates/header');
    $this->load->view('auth/login_form');
    $this->load->view('templates/footer');
  }
  
  public function logout()
	{
		$this->authentication->logout();

		// Set redirect protocol
		$redirect_protocol = USE_SSL ? 'https' : NULL;

		redirect(site_url(LOGIN_PAGE . '?' . AUTH_LOGOUT_PARAM . '=1', $redirect_protocol));
	}
}
