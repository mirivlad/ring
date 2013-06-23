<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About extends CI_Controller {

	function __construct() {
            parent::__construct();
            $this->dx_auth->check_uri_permissions();
        }
        
	public function index()
	{
		$data = array(
		    'title' => 'О проекте',
		    'about' => 'active'
		);

		$this->load->view('about', $data);
		//$this->load->view('welcome_message');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */