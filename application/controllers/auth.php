<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

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
    }

    //redirect if needed, otherwise display the user list
    function index() {

	if (!$this->ion_auth->logged_in()) {
	    //redirect them to the login page
	    redirect('auth/login', 'refresh');
	} elseif (!$this->ion_auth->is_admin()) {
	    //redirect them to the home page because they must be an administrator to view this
	    redirect('/', 'refresh');
	} else {
	    redirect('/admin_panel', 'refresh');
	}
    }

    //log the user in
    function login() {
	$this->data['title'] = "Вход в систему";

	//validate form input
	$this->form_validation->set_rules('identity', 'Identity', 'required');
	$this->form_validation->set_rules('password', 'Password', 'required');

	if ($this->form_validation->run() == true) {
	    //check to see if the user is logging in
	    //check for "remember me"
	    $remember = (bool) $this->input->post('remember');

	    if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {
		//if the login is successful
		//redirect them back to the home page
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('/', 'refresh');
	    } else {
		//if the login was un-successful
		//redirect them back to the login page
		$this->session->set_flashdata('message', $this->ion_auth->errors());
		redirect('auth/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
	    }
	} else {
	    //the user is not logging in so display the login page
	    //set the flash data error message if there is one
	    $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

	    $this->data['identity'] = array('name' => 'identity',
		'id' => 'identity',
		'type' => 'text',
		'value' => $this->form_validation->set_value('identity'),
	    );
	    $this->data['password'] = array('name' => 'password',
		'id' => 'password',
		'type' => 'password',
	    );

	    $this->_render_page('auth/login', $this->data);
	}
    }

    //log the user out
    function logout() {
	$this->data['title'] = "Выход";

	//log the user out
	$logout = $this->ion_auth->logout();

	//redirect them to the login page
	$this->session->set_flashdata('message', $this->ion_auth->messages());
	redirect('auth/login', 'refresh');
    }

    //change password
    function change_password() {
	$this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
	$this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
	$this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

	if (!$this->ion_auth->logged_in()) {
	    redirect('auth/login', 'refresh');
	}

	$user = $this->ion_auth->user()->row();

	if ($this->form_validation->run() == false) {
	    //display the form
	    //set the flash data error message if there is one
	    $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

	    $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
	    $this->data['old_password'] = array(
		'name' => 'old',
		'id' => 'old',
		'type' => 'password',
	    );
	    $this->data['new_password'] = array(
		'name' => 'new',
		'id' => 'new',
		'type' => 'password',
		'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
	    );
	    $this->data['new_password_confirm'] = array(
		'name' => 'new_confirm',
		'id' => 'new_confirm',
		'type' => 'password',
		'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
	    );
	    $this->data['user_id'] = array(
		'name' => 'user_id',
		'id' => 'user_id',
		'type' => 'hidden',
		'value' => $user->id,
	    );

	    //render
	    $this->_render_page('auth/change_password', $this->data);
	} else {
	    $identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));

	    $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

	    if ($change) {
		//if the password was successfully changed
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		$this->logout();
	    } else {
		$this->session->set_flashdata('message', $this->ion_auth->errors());
		redirect('auth/change_password', 'refresh');
	    }
	}
    }

    //forgot password
    function forgot_password() {
	$this->form_validation->set_rules('email', $this->lang->line('forgot_password_validation_email_label'), 'required');
	if ($this->form_validation->run() == false) {
	    //setup the input
	    $this->data['email'] = array('name' => 'email',
		'id' => 'email',
	    );

	    if ($this->config->item('identity', 'ion_auth') == 'username') {
		$this->data['identity_label'] = $this->lang->line('forgot_password_username_identity_label');
	    } else {
		$this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
	    }

	    //set any errors and display the form
	    $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	    $this->_render_page('auth/forgot_password', $this->data);
	} else {
	    // get identity for that email
	    $config_tables = $this->config->item('tables', 'ion_auth');
	    $identity = $this->db->where('email', $this->input->post('email'))->limit('1')->get($config_tables['users'])->row();

	    //run the forgotten password method to email an activation code to the user
	    $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

	    if ($forgotten) {
		//if there were no errors
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
	    } else {
		$this->session->set_flashdata('message', $this->ion_auth->errors());
		redirect("auth/forgot_password", 'refresh');
	    }
	}
    }

    //reset password - final step for forgotten password
    public function reset_password($code = NULL) {
	if (!$code) {
	    show_404();
	}

	$user = $this->ion_auth->forgotten_password_check($code);

	if ($user) {
	    //if the code is valid then display the password reset form

	    $this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
	    $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

	    if ($this->form_validation->run() == false) {
		//display the form
		//set the flash data error message if there is one
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

		$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
		$this->data['new_password'] = array(
		    'name' => 'new',
		    'id' => 'new',
		    'type' => 'password',
		    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
		);
		$this->data['new_password_confirm'] = array(
		    'name' => 'new_confirm',
		    'id' => 'new_confirm',
		    'type' => 'password',
		    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
		);
		$this->data['user_id'] = array(
		    'name' => 'user_id',
		    'id' => 'user_id',
		    'type' => 'hidden',
		    'value' => $user->id,
		);
		$this->data['csrf'] = $this->_get_csrf_nonce();
		$this->data['code'] = $code;

		//render
		$this->_render_page('auth/reset_password', $this->data);
	    } else {
		// do we have a valid request?
		if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {

		    //something fishy might be up
		    $this->ion_auth->clear_forgotten_password_code($code);

		    show_error($this->lang->line('error_csrf'));
		} else {
		    // finally change the password
		    $identity = $user->{$this->config->item('identity', 'ion_auth')};

		    $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

		    if ($change) {
			//if the password was successfully changed
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			$this->logout();
		    } else {
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect('auth/reset_password/' . $code, 'refresh');
		    }
		}
	    }
	} else {
	    //if the code is invalid then send them back to the forgot password page
	    $this->session->set_flashdata('message', $this->ion_auth->errors());
	    redirect("auth/forgot_password", 'refresh');
	}
    }

    function _get_csrf_nonce() {
	$this->load->helper('string');
	$key = random_string('alnum', 8);
	$value = random_string('alnum', 20);
	$this->session->set_flashdata('csrfkey', $key);
	$this->session->set_flashdata('csrfvalue', $value);

	return array($key => $value);
    }

    function _valid_csrf_nonce() {
	if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
		$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue')) {
	    return TRUE;
	} else {
	    return FALSE;
	}
    }

    function _render_page($view, $data = null, $render = false) {

	$this->viewdata = (empty($data)) ? $this->data : $data;

	//$view_html = $this->load->view($view, $this->viewdata, $render);
	$view_html = $this->parser->parse($view, $data);
	//if (!$render) return $view_html;
    }

}
