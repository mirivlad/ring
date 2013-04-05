<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_panel extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->database();

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->helper('language');
        if (!$this->ion_auth->logged_in()) {
            //redirect them to the login page
            redirect('auth/login', 'refresh');
        } elseif (!$this->ion_auth->is_admin()) {
            //redirect them to the home page because they must be an administrator to view this
            redirect('/', 'refresh');
        }
    }

    function index() {
        $this->data['title'] = "Администрирование системы";
        $this->parser->parse('admin/admin_panel', $this->data);
    }

    function list_users($page = 1) {
       // if (!isset($page) OR $page <= 0 OR !is_numeric($page)) {
        //    $page = 1;
        //}        
        $this->load->library('pagination');
        
        $this->data['title'] = "Список пользователей";
        //set the flash data error message if there is one
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
  
        $config['per_page'] = 2;
        $config['uri_segment'] = 3;
        $config['use_page_numbers'] = TRUE;
        $config['base_url'] = '/admin_panel/list_users/';
        $config['total_rows'] = $this->ion_auth->users()->num_rows();        

        //list the users
        $this->ion_auth->limit($config['per_page']);
        $this->ion_auth->offset(($page-1) * $config['per_page']);
        $this->data['users'] = $this->ion_auth->users()->result();
       
        foreach ($this->data['users'] as $k => $user) {
            $this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
        }
        


        $this->pagination->initialize($config);
        $this->data['pagination'] = $this->pagination->create_links();
        
        $this->parser->parse('admin/list_users', $this->data);

    }

    //deactivate the user
    function deactivate($id = NULL) {
        if ($this->ion_auth->logged_in() AND $this->ion_auth->is_admin()) {
            $deactivation = $this->ion_auth->deactivate($id);
        }

        if ($deactivation) {
            //redirect them to the auth page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("admin_panel/list_users", 'refresh');
        } else {
            //redirect them to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("auth/forgot_password", 'refresh');
        }
    }

    //activate the user
    function activate($id, $code = false) {
        if ($code !== false) {
            $activation = $this->ion_auth->activate($id, $code);
        } else if ($this->ion_auth->is_admin()) {
            $activation = $this->ion_auth->activate($id);
        }

        if ($activation) {
            //redirect them to the auth page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("admin_panel/list_users", 'refresh');
        } else {
            //redirect them to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("auth/forgot_password", 'refresh');
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */