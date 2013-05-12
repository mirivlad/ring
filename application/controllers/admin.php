<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('table');
        $this->lang->load('dx_auth');
        $this->dx_auth->check_uri_permissions();
        $this->load->helper('url');
        $this->load->helper('form');
//        if (!$this->dx_auth->logged_in()) {
//            //redirect them to the login page
//            redirect('auth/login', 'refresh');
//        } elseif (!$this->dx_auth->is_admin()) {
//            //redirect them to the home page because they must be an administrator to view this
//            redirect('/', 'refresh');
//        }
    }

    function index() {
        $this->data['title'] = "Панель администратора";
        $this->data['current_db'] = $this->migration->get_db_version();
        $this->data['actual_db'] = $this->migration->get_fs_version();

        $this->parser->parse('admin/admin_panel', $this->data);
        
    }
    
    public function update_db() {
        if ($this->dx_auth->is_admin()){
            $this->data['title'] = 'Обновление Базы Данных';
            if ( ! $this->migration->current()) {
                $this->data['error'] = $this->migration->error_string();
                $this->notify->error($this->migration->error_string());
            }	
            $this->data['error'] = "Все операции выполнены.";
            $this->parser->parse('admin/update_db', $this->data);
        }else{
            redirect("/auth/login");
        }
    }
    function users() {

        $this->load->model('dx_auth/users', 'users');
        $this->load->model('dx_auth/user_profile', 'user_profile');
        // Search checkbox in post array
        foreach ($_POST as $key => $value) {
            // If checkbox found
            if (substr($key, 0, 9) == 'checkbox_') {
                // If ban button pressed
                if (isset($_POST['ban'])) {
                    // Ban user based on checkbox value (id)
		    $this->notify->success('Пользователь забанен');
                    $this->users->ban_user($value);
                }
                // If unban button pressed
                else if (isset($_POST['unban'])) {
                    // Unban user
		    $this->notify->success('Пользователь разбанен');
                    $this->users->unban_user($value);
                } else if (isset($_POST['reset_pass'])) {
                    // Set default message
                    $data['reset_message'] = 'Сброс пароля не удался';

                    // Get user and check if User ID exist
                    if ($query = $this->users->get_user_by_id($value) AND $query->num_rows() == 1) {
                        // Get user record				
                        $user = $query->row();

                        // Create new key, password and send email to user
                        if ($this->dx_auth->forgot_password($user->username)) {
                            // Query once again, because the database is updated after calling forgot_password.
                            $query = $this->users->get_user_by_id($value);
                            // Get user record
                            $user = $query->row();

                            // Reset the password
                            if ($this->dx_auth->reset_password($user->username, $user->newpass_key)) {
				$this->notify->success('Сброс пароля выполнен');
                            }else{
				$this->notify->error('Сброс пароля невыполнен');
			    }
                        }
                    }
                }
            }
        }

        /* Showing page to user */

        // Get offset and limit for page viewing
        $offset = (int) $this->uri->segment(3);
        // Number of record showing per page
        $row_count = 10;

        // Get all users
        $data['users'] = $this->users->get_all($offset, $row_count)->result();
        //$data['user_profile'] = $this->user_profile;
        // Pagination config
        $p_config['base_url'] = '/admin/users/';
        $p_config['uri_segment'] = 3;
        $p_config['num_links'] = 2;
        $p_config['total_rows'] = $this->users->get_all()->num_rows();
        $p_config['per_page'] = $row_count;

        // Init pagination
        $this->pagination->initialize($p_config);
        // Create pagination links
        $data['pagination'] = $this->pagination->create_links();
        $data['title'] = "Пользователи";
        // Load view
        $this->parser->parse('admin/users', $data);
    }

    function unactivated_users() {
        $data['title'] = "Неактивированные пользователи";
        $this->load->model('dx_auth/user_temp', 'user_temp');

        /* Database related */

        // If activate button pressed
        if ($this->input->post('activate')) {
            // Search checkbox in post array
            foreach ($_POST as $key => $value) {
                // If checkbox found
                if (substr($key, 0, 9) == 'checkbox_') {
                    // Check if user exist, $value is username
                    if ($query = $this->user_temp->get_login($value) AND $query->num_rows() == 1) {
                        // Activate user
			$this->notify->success('Активация выполнена');
                        $this->dx_auth->activate($value, $query->row()->activation_key);
                    }
                }
            }
        }

        /* Showing page to user */

        // Get offset and limit for page viewing
        $offset = (int) $this->uri->segment(3);
        // Number of record showing per page
        $row_count = 10;

        // Get all unactivated users
        $data['users'] = $this->user_temp->get_all($offset, $row_count)->result();

        // Pagination config
        $p_config['base_url'] = '/admin/unactivated_users/';
        $p_config['uri_segment'] = 3;
        $p_config['num_links'] = 2;
        $p_config['total_rows'] = $this->user_temp->get_all()->num_rows();
        $p_config['per_page'] = $row_count;

        // Init pagination
        $this->pagination->initialize($p_config);
        // Create pagination links
        $data['pagination'] = $this->pagination->create_links();

        // Load view
        $this->parser->parse('admin/unactivated_users', $data);
    }

    function roles() {
        $data['title'] = "Роли";
        $this->load->model('dx_auth/roles', 'roles');

        /* Database related */

        // If Add role button pressed
        if ($this->input->post('add')) {
            // Create role
	    $this->notify->success('Роль добавлена');
            $this->roles->create_role($this->input->post('role_name'), $this->input->post('role_parent'));
        } else if ($this->input->post('delete')) {
            // Loop trough $_POST array and delete checked checkbox
            foreach ($_POST as $key => $value) {
                // If checkbox found
                if (substr($key, 0, 9) == 'checkbox_') {
                    // Delete role
		    $this->notify->success('Роль удалена');
                    $this->roles->delete_role($value);
                }
            }
        }

        /* Showing page to user */

        // Get all roles from database
        $data['roles'] = $this->roles->get_all()->result();

        // Load view
        $this->parser->parse('admin/roles', $data);
    }

    function uri_permissions() {
        $data['title'] = "Права доступа к URI";
        function trim_value(&$value) {
            $value = trim($value);
        }

        $this->load->model('dx_auth/roles', 'roles');
        $this->load->model('dx_auth/permissions', 'permissions');

        if ($this->input->post('save')) {
            // Convert back text area into array to be stored in permission data
            $allowed_uris = explode("\n", $this->input->post('allowed_uris'));

            // Remove white space if available
            array_walk($allowed_uris, 'trim_value');

            // Set URI permission data
            // IMPORTANT: uri permission data, is saved using 'uri' as key.
            // So this key name is preserved, if you want to use custom permission use other key.
	    $this->notify->success('Права доступа к URI сохранены');
            $this->permissions->set_permission_value($this->input->post('role'), 'uri', $allowed_uris);
        }

        /* Showing page to user */

        // Default role_id that will be showed
        $role_id = $this->input->post('role') ? $this->input->post('role') : 1;

        // Get all role from database
        $data['roles'] = $this->roles->get_all()->result();
        // Get allowed uri permissions
        $data['allowed_uris'] = $this->permissions->get_permission_value($role_id, 'uri');

        // Load view
        $this->parser->parse('admin/uri_permissions', $data);
    }

    function custom_permissions() {
        $data['title'] = "Настройка доступа";
        // Load models
        $this->load->model('dx_auth/roles', 'roles');
        $this->load->model('dx_auth/permissions', 'permissions');

        /* Get post input and apply it to database */

        // If button save pressed
        if ($this->input->post('save')) {
            // Note: Since in this case we want to insert two key with each value at once,
            // it's not advisable using set_permission_value() function						
            // If you calling that function twice that means, you will query database 4 times,
            // because set_permission_value() will access table 2 times, 
            // one for get previous permission and the other one is to save it.
            // For this case (or you need to insert few key with each value at once) 
            // Use the example below
            // Get role_id permission data first. 
            // So the previously set permission array key won't be overwritten with new array with key $key only, 
            // when calling set_permission_data later.
            $permission_data = $this->permissions->get_permission_data($this->input->post('role'));

            // Set value in permission data array
            $permission_data['edit'] = $this->input->post('edit');
            $permission_data['delete'] = $this->input->post('delete');
	    $this->notify->success('Права доступа сохранены');
            // Set permission data for role_id
            $this->permissions->set_permission_data($this->input->post('role'), $permission_data);
        }

        /* Showing page to user */

        // Default role_id that will be showed
        $role_id = $this->input->post('role') ? $this->input->post('role') : 1;
	$data['selected_role'] = $role_id;
        // Get all role from database
        $data['roles'] = $this->roles->get_all()->result();
        // Get edit and delete permissions
        $data['edit'] = $this->permissions->get_permission_value($role_id, 'edit');
        $data['delete'] = $this->permissions->get_permission_value($role_id, 'delete');

        // Load view
        $this->parser->parse('admin/custom_permissions', $data);
    }
    
    function create_user() {
        
            $val = $this->form_validation;
            $data['title'] = "Создание пользователя";
            // Set form validation rules			
            $val->set_rules('username', 'Логин', 'trim|required|xss_clean|min_length[' . $this->config->item("min_username") . ']|max_length[' . $this->config->item("max_username") . ']|callback_username_check|alpha_dash');
            $val->set_rules('password', 'Пароль', 'trim|required|xss_clean|min_length[' . $this->config->item("min_password") . ']|max_length[' . $this->config->item("max_password") . ']|matches[confirm_password]');
            $val->set_rules('confirm_password', 'Подтверждение пароля', 'trim|required|xss_clean');
            $val->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email|callback_email_check');


            // Run form validation and register user if it's pass the validation
            if ($val->run() AND $this->dx_auth->register($val->set_value('username'), $val->set_value('password'), $val->set_value('email'))) {
                // Set success message accordingly
                if ($this->dx_auth->email_activation) {
                    $data['auth_message'] = 'Пользователь зарегистрирован. На его email высланы данные об активации. <br> 
                        Так же вы можете активировать пользователя вручную <a href="/admin/unactivated_users"> по этой ссылке</a>.';
                } else {
                    $data['auth_message'] = 'Пользователь зарегистрирован. Вы можете сообщить ему данные для входа любым доступным вам способом, так как вы отключили активацию по email.';
                }

                // Load registration success page
                $this->parser->parse($this->dx_auth->register_success_view, $data);
            } else {
                // Load registration page
                $this->parser->parse($this->dx_auth->register_view, $data);
            }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */