<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Products extends MY_Controller {
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
    $this->load->view('products/crud.php', (array) $output);
    $this->load->view('templates/footer.php');
	}
  
  public function index()
	{
    if (!$this->verify_min_level(6))
      redirect(site_url(LOGIN_PAGE));
    
		try{
			$crud = new grocery_CRUD();

      $crud->set_table('products');
      $crud->set_crud_url_path(site_url('products/index'));

      $crud->set_theme('tablestrap');
      $crud->set_subject('Product');

      $crud->columns('image_url', 'name', 'price', 'quantity', 'platform');

      $crud->fields('product_id', 'name', 'price', 'quantity', 'developer', 'publisher', 'platform', 'description', 'image_url', 'created_at');
      $crud->set_field_upload('image_url','assets/uploads/products_images');
      // the following 2 fields are hidden because their values are automatically generated
      $crud->change_field_type('product_id', 'invisible');
      $crud->change_field_type('created_at', 'invisible');

      $crud
        ->display_as('name', 'Name')
        ->display_as('price', 'Price')
        ->display_as('quantity', 'Quantity')
        ->display_as('developer', 'Developer')
        ->display_as('publisher', 'Publisher')
        ->display_as('platform', 'Platform')
        ->display_as('image_url', 'Cover')
        ->display_as('created_at', 'Created at');
      
      $crud->required_fields('name', 'price');
      $crud->unique_fields(array('name'));

      $crud->set_rules('name', 'Name', 'required|alpha_numeric_spaces|min_length[4]|max_length[255]');
      $crud->set_rules('price', 'Price', 'required|numeric');
      $crud->set_rules('quantity', 'Quantity', 'integer|greater_than_equal_to[0]');
      $crud->set_rules('developer', 'Developer', 'alpha_numeric_spaces|max_length[255]');
      $crud->set_rules('publisher', 'Publisher', 'alpha_numeric_spaces|max_length[255]');
      $crud->set_rules('platform', 'Platform', 'alpha_numeric_spaces|max_length[255]');

			$crud->unset_print();
      $crud->unset_export();
      $crud->unset_clone();
      $crud->unset_texteditor('description');

      // $crud->unset_bootstrap();
      $crud->unset_jquery();

      $crud->callback_before_insert(array($this, 'before_insert'));
      $crud->callback_before_update(array($this, 'before_update'));

      $output = $crud->render();

			$this->_example_output($output);

		}catch(Exception $e){
			show_error($e->getMessage().' --- '.$e->getTraceAsString());
    }
  }

  public function before_insert($post_array)
  {
    $this->load->remove_package_path(APPPATH.'third_party/community_auth/');
    $this->load->model('products_model');

    $post_array['product_id'] = $this->products_model->get_unused_id();
    $post_array['created_at'] = date('Y-m-d H:i:s');

    return $post_array;
  }
}