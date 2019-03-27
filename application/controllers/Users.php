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

      $crud->columns('username', 'first_name', 'last_name', 'auth_level');

      $crud->add_fields('user_id', 'username', 'first_name', 'last_name', 'auth_level', 'passwd', 'created_at');
      $crud->edit_fields('user_id', 'username', 'first_name', 'last_name', 'auth_level', 'created_at');
      // the following 2 fields are hidden because their values are automatically generated
      $crud->change_field_type('user_id', 'invisible');
      $crud->change_field_type('created_at', 'invisible');

      $crud
        ->display_as('username', 'Username')
        ->display_as('first_name', 'First name')
        ->display_as('last_name', 'Last name')
        ->display_as('email', 'Email')
        ->display_as('auth_level', 'Role')
        ->display_as('passwd', 'Password');
      
      $crud->required_fields('username', 'first_name', 'last_name', 'passwd', 'auth_level');
      $crud->unique_fields(array('username', 'email'));

      $crud->set_rules('username', 'Username', 'required|alpha_dash|min_length[4]|max_length[12]');
      $crud->set_rules('first_name', 'First name', 'required|alpha');
      $crud->set_rules('last_name', 'Last name', 'required|alpha');
      $crud->set_rules('auth_level', 'Role', 'required|integer|in_list[6,9]');
      $crud->set_rules('passwd', 'Password', 'required|callback_check_password_strength');

			$crud->unset_print();
      $crud->unset_export();
      $crud->unset_clone();

      // $crud->unset_bootstrap();
      $crud->unset_jquery();

      $crud->callback_before_insert(array($this, 'before_insert'));
      $crud->callback_add_field('auth_level', array($this, 'auth_level_field'));
      $crud->callback_edit_field('auth_level', array($this, 'auth_level_field'));
      $crud->callback_add_field('passwd', array($this, 'passwd_field'));
      $crud->callback_edit_field('passwd', array($this, 'passwd_field'));

      $output = $crud->render();

			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
		}
  }
  
  public function before_insert($post_array)
  {
    $this->load->remove_package_path(APPPATH.'third_party/community_auth/');
    $this->load->model('users_model');

    $post_array['user_id'] = $this->users_model->get_unused_id();
    $post_array['passwd'] = $this->authentication->hash_passwd($post_array['passwd']);
    $post_array['created_at'] = date('Y-m-d H:i:s');

    return $post_array;
  }

  public function auth_level_field($value = '')
  {
    return '
      <select name="auth_level" class="form-control">
        <option value="6" ' . (($value == 6) ? 'selected' : '') . '>Employee</option>
        <option value="9" ' . (($value == 9) ? 'selected' : '') . '>Administrator</option>
      </select>
    ';
  }

  public function passwd_field($value = '')
  {
    return '<input type="password" name="passwd" class="form-control" value="' . $value . '" />';
  }

  public function check_password_strength($password)
  {
    $min_chars_for_password = 8;
    $max_chars_for_password = 72;
    $min_lowercase_chars_for_password = 1;
    $min_uppercase_chars_for_password = 1;
    $min_non_alphanumeric_chars_for_password = 1;

    // Password length
    $max = $max_chars_for_password > 0
      ? $max_chars_for_password 
      : '';
    $regex = '(?=.{' . $min_chars_for_password . ',' . $max . '})';
    $error = '<li>At least ' . $min_chars_for_password . ' characters</li>';

    if( $max_chars_for_password > 0 )
      $error .= '<li>Not more than ' . $max_chars_for_password . ' characters</li>';
    
    // Lower case letter(s) required
    if( $min_lowercase_chars_for_password > 0 )
    {
      $regex .= '(?=(?:.*[a-z].*){' . $min_lowercase_chars_for_password . ',})';
      $plural = $min_lowercase_chars_for_password > 1 ? 's' : '';
      $error .= '<li>' . $min_lowercase_chars_for_password . ' lower case letter' . $plural . '</li>';
    }
    
    // Upper case letter(s) required
    if( $min_uppercase_chars_for_password > 0 )
    {
      $regex .= '(?=(?:.*[A-Z].*){' . $min_uppercase_chars_for_password . ',})';
      $plural = $min_uppercase_chars_for_password > 1 ? 's' : '';
      $error .= '<li>' . $min_uppercase_chars_for_password . ' upper case letter' . $plural . '</li>';
    }
    
    // Non-alphanumeric char(s) required
    if( $min_non_alphanumeric_chars_for_password > 0 )
    {
      $regex .= '(?=(?:.*[^a-zA-Z0-9].*){' . $min_non_alphanumeric_chars_for_password . ',})';
      $plural = $min_non_alphanumeric_chars_for_password > 1 ? 's' : '';
      $error .= '<li>' . $min_non_alphanumeric_chars_for_password . ' non-alphanumeric character' . $plural . '</li>';
    }
    
    if( preg_match( '/^' . $regex . '.*$/', $password ) )
    {
      return TRUE;
    }
    
    $this->form_validation->set_message(
      'check_password_strength', 
      '<span class="redfield">Password</span> must contain:
        <ol>
          ' . $error . '
        </ol>
      </span>'
    );

    return FALSE;
  }

}
