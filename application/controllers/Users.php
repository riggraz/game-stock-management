<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users extends MY_Controller {
  public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');

    $this->load->library('grocery_CRUD');
	}

	private function _example_output($output = null)
	{
    $this->load->view('templates/header.php', (array) $output);
    $this->load->view('users/crud.php', (array) $output);
    $this->load->view('templates/footer.php');
	}
  
  public function index()
	{
    if (!$this->verify_role('admin'))
      redirect(site_url(LOGIN_PAGE));
    
		try{
			$crud = new grocery_CRUD();

      $crud->set_table('users');

      $crud->set_theme('tablestrap');
      $crud->set_subject('User');

      $crud->columns('username', 'email', 'auth_level');

      $crud->add_fields('user_id', 'username', 'email', 'auth_level', 'passwd', 'created_at');
      $crud->edit_fields('user_id', 'username', 'email', 'auth_level', 'created_at');
      // the following 2 fields are hidden because their values are automatically generated
      $crud->change_field_type('user_id', 'invisible');
      $crud->change_field_type('created_at', 'invisible');

      $crud
        ->display_as('username', 'Username')
        ->display_as('email', 'Email')
        ->display_as('auth_level', 'Role')
        ->display_as('passwd', 'Password');
      
      $crud->required_fields('username', 'passwd', 'auth_level');
      $crud->unique_fields(array('username', 'email'));

      $crud->set_rules('username', 'Username', 'required|alpha_dash|min_length[4]|max_length[12]');
      $crud->set_rules('email', 'Email', 'valid_email');
      $crud->set_rules('auth_level', 'Role', 'required|integer|in_list[6,9]');
      $crud->set_rules('passwd', 'Password', 'required|alpha_dash|min_length[8]|max_length[72]');

			$crud->unset_print();
      $crud->unset_export();
      $crud->unset_clone();

      // $crud->unset_bootstrap();
      $crud->unset_jquery();

      $crud->callback_before_insert(array($this, 'before_insert'));

      $output = $crud->render();

			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
  }
  
  public function before_insert($post_array)
  {
    $this->load->model('examples/examples_model');

    $post_array['user_id'] = $this->examples_model->get_unused_id();
    $post_array['passwd'] = $this->authentication->hash_passwd($post_array['passwd']);
    $post_array['created_at'] = date('Y-m-d H:i:s');

    return $post_array;
  }

}
