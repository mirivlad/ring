<?php

class Auth extends CI_Controller {

    // Used for registering and changing password form validation
    var $min_username = 4;
    var $max_username = 20;
    var $min_password = 4;
    var $max_password = 20;

    public function __construct() {
        parent::__construct();

        $this->load->library('form_validation');
        //$this->load->library('dx_auth');			

        $this->load->helper('url');
        $this->load->helper('form');
        //log_message('debug', "Auth Class Initialized");
    }

    function index() {
        $this->login();
    }

    /* Callback function */

    function username_check($username) {
        $result = $this->dx_auth->is_username_available($username);
        if (!$result) {
            //$this->notify->error('Такое имя уже есть. Выберите другое.');
            $this->form_validation->set_message('username_check', 'Такое имя уже есть. Выберите другое.');
        }

        return $result;
    }

    function email_check($email) {
        $result = $this->dx_auth->is_email_available($email);
        if (!$result) {
            //$this->notify->error('Такой email уже зарегистрирован. Укажите другой.');
            $this->form_validation->set_message('email_check', 'Такой email уже зарегистрирован. Укажите другой.');
        }

        return $result;
    }

    function captcha_check($code) {
        $result = TRUE;

        if ($this->dx_auth->is_captcha_expired()) {
            // Will replace this error msg with $lang
            //$this->notify->error('Срок действия кода с картинки истёк. Попробуйте заново.');
            $this->form_validation->set_message('captcha_check', 'Срок действия кода с картинки истёк. Попробуйте заново.');
            $result = FALSE;
        } elseif (!$this->dx_auth->is_captcha_match($code)) {
            //$this->notify->error('Введеный вами код с картинки неправильный. Попробуйте заново.');
            $this->form_validation->set_message('captcha_check', 'Введеный вами код с картинки неправильный. Попробуйте заново.');
            $result = FALSE;
        }

        return $result;
    }

    function recaptcha_check() {
        $result = $this->dx_auth->is_recaptcha_match();
        if (!$result) {
            //$this->notify->error('Введеный вами код с картинки неправильный. Попробуйте заново.');
            $this->form_validation->set_message('recaptcha_check', 'Введеный вами код с картинки неправильный. Попробуйте заново.');
        }

        return $result;
    }

    /* End of Callback function */

    function login() {
        $data['title'] = 'Вход в систему';
        if (!$this->dx_auth->is_logged_in()) {
            $val = $this->form_validation;

            // Set form validation rules
            $val->set_rules('username', 'Имя', 'trim|required|xss_clean');
            $val->set_rules('password', 'Пароль', 'trim|required|xss_clean');
            $val->set_rules('remember', 'Запомнить меня', 'integer');

            // Set captcha rules if login attempts exceed max attempts in config
            if ($this->dx_auth->is_max_login_attempts_exceeded()) {
                $val->set_rules('captcha', 'Символы с картинки', 'trim|required|xss_clean|callback_captcha_check');
            }

            if ($val->run() AND $this->dx_auth->login($val->set_value('username'), $val->set_value('password'), $val->set_value('remember'))) {
                // Redirect to homepage
                $redirect = $this->input->post('redirect_url', TRUE);
                redirect($redirect, 'location');
            } else {
                // Check if the user is failed logged in because user is banned user or not
                if ($this->dx_auth->is_banned()) {
                    // Redirect to banned uri
                    $this->dx_auth->deny_access('banned');
                } else {
                    // Default is we don't show captcha until max login attempts eceeded
                    $data['show_captcha'] = FALSE;

                    // Show captcha if login attempts exceed max attempts in config
                    if ($this->dx_auth->is_max_login_attempts_exceeded()) {
                        // Create catpcha						
                        $this->dx_auth->captcha();

                        // Set view data to show captcha on view file
                        $data['show_captcha'] = TRUE;
                    }
                    //$data['ip']=  $this->input->ip_address();
                    // Load login page view
                    $this->parser->parse('auth/login', $data);
                }
            }
        } else {
            $redirect = $this->input->post('redirect_url', TRUE);
            redirect($redirect, 'location');

            //$data['auth_message'] = 'You are already logged in.';
            //$this->load->view($this->dx_auth->logged_in_view, $data);
        }
    }

    function logout() {
        $this->dx_auth->logout();
        redirect('', 'location');
        //$data['auth_message'] = 'You have been logged out.';
        //$this->load->view($this->dx_auth->logout_view, $data);
    }

    function register() {
        if (!$this->dx_auth->is_logged_in() AND $this->dx_auth->allow_registration) {
            $val = $this->form_validation;
            $data['title'] = "Регистрация";
            // Set form validation rules			
            $val->set_rules('username', 'Логин', 'trim|required|xss_clean|min_length[' . $this->config->item("min_username") . ']|max_length[' . $this->config->item("max_username") . ']|callback_username_check|alpha_dash');
            $val->set_rules('password', 'Пароль', 'trim|required|xss_clean|min_length[' . $this->config->item("min_password") . ']|max_length[' . $this->config->item("max_password") . ']|matches[confirm_password]');
            $val->set_rules('confirm_password', 'Подтверждение пароля', 'trim|required|xss_clean');
            $val->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email|callback_email_check');

            if ($this->dx_auth->captcha_registration) {
                $val->set_rules('captcha', 'Код с картинки', 'trim|xss_clean|required|callback_captcha_check');
            }

            // Run form validation and register user if it's pass the validation
            if ($val->run() AND $this->dx_auth->register($val->set_value('username'), $val->set_value('password'), $val->set_value('email'))) {
                // Set success message accordingly
                if ($this->dx_auth->email_activation) {
                    $data['auth_message'] = 'Вы зарегистрированны. Проверьте свой email для дальнейшей активации аккаунта.';
                } else {
                    $data['auth_message'] = 'Регистрация завершена. ' . anchor(site_url($this->dx_auth->login_uri), 'Войти на сайт.');
                }

                // Load registration success page
                $this->parser->parse($this->dx_auth->register_success_view, $data);
            } else {
                // Is registration using captcha
                if ($this->dx_auth->captcha_registration) {
                    $this->dx_auth->captcha();
                }

                // Load registration page
                $this->parser->parse($this->dx_auth->register_view, $data);
            }
        } elseif (!$this->dx_auth->allow_registration) {
            $data['auth_message'] = 'Регистрация отключена.';
            $this->parser->parse($this->dx_auth->register_disabled_view, $data);
        } else {
            $data['auth_message'] = 'Сначало нужно выполнить выход с сайта, чтобы можно было зарегистрироваться.';
            $this->parser->parse($this->dx_auth->logged_in_view, $data);
        }
    }
    
    
    function register_recaptcha() {
        if (!$this->dx_auth->is_logged_in() AND $this->dx_auth->allow_registration) {
            $val = $this->form_validation;

            // Set form validation rules
            $val->set_rules('username', 'Username', 'trim|required|xss_clean|min_length[' . $this->min_username . ']|max_length[' . $this->max_username . ']|callback_username_check|alpha_dash');
            $val->set_rules('password', 'Password', 'trim|required|xss_clean|min_length[' . $this->min_password . ']|max_length[' . $this->max_password . ']|matches[confirm_password]');
            $val->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean');
            $val->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email|callback_email_check');

            // Is registration using captcha
            if ($this->dx_auth->captcha_registration) {
                // Set recaptcha rules.
                // IMPORTANT: Do not change 'recaptcha_response_field' because it's used by reCAPTCHA API,
                // This is because the limitation of reCAPTCHA, not DX Auth library
                $val->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback_recaptcha_check');
            }

            // Run form validation and register user if it's pass the validation
            if ($val->run() AND $this->dx_auth->register($val->set_value('username'), $val->set_value('password'), $val->set_value('email'))) {
                // Set success message accordingly
                if ($this->dx_auth->email_activation) {
                    $data['auth_message'] = 'You have successfully registered. Check your email address to activate your account.';
                } else {
                    $data['auth_message'] = 'You have successfully registered. ' . anchor(site_url($this->dx_auth->login_uri), 'Login');
                }

                // Load registration success page
                $this->parser->parse($this->dx_auth->register_success_view, $data);
            } else {
                // Load registration page
                $this->parser->parse('auth/register_recaptcha_form');
            }
        } elseif (!$this->dx_auth->allow_registration) {
            $data['auth_message'] = 'Самостоятельная регистрация отключена. Обратитесь к администратору для ручной регистрации. Контакты администратора системы <a href="/contacts">здесь</a>.';
            $this->parser->parse($this->dx_auth->register_disabled_view, $data);
        } else {
            $data['auth_message'] = 'Вы уже вошли в систему. Регистрация невозможна.';
            $this->parser->parse($this->dx_auth->logged_in_view, $data);
        }
    }

    function activate() {
        // Get username and key
        $username = $this->uri->segment(3);
        $key = $this->uri->segment(4);
        $data['title'] = "Активация аккаунта";
        // Activate user
        if ($this->dx_auth->activate($username, $key)) {
            $data['auth_message'] = 'Ваш аккаунт активирован. ' . anchor(site_url($this->dx_auth->login_uri), 'Войти');
            $this->parser->parse($this->dx_auth->activate_success_view, $data);
        } else {
            $data['auth_message'] = 'Код активации неверен. Проверьте свой email и попробуйте снова.';
            $this->parser->parse($this->dx_auth->activate_failed_view, $data);
        }
    }

    function forgot_password() {
        $val = $this->form_validation;
        $data['title'] = 'Восстановление пароля';
        // Set form validation rules
        $val->set_rules('login', 'Логин или адрес email', 'trim|required|xss_clean');

        // Validate rules and call forgot password function
        if ($val->run() AND $this->dx_auth->forgot_password($val->set_value('login'))) {
            $data['auth_message'] = 'На ваш адрес email было отправлено письмо с инструкциями по активации вашего нового пароля.';
            $this->parser->parse($this->dx_auth->forgot_password_success_view, $data);
        } else {
            $this->parser->parse($this->dx_auth->forgot_password_view, $data);
        }
    }

    function reset_password() {
        // Get username and key
        $username = $this->uri->segment(3);
        $key = $this->uri->segment(4);
        $data['title'] = 'Сброс пароля';
        // Reset password
        if ($this->dx_auth->reset_password($username, $key)) {
            $data['auth_message'] = 'Ваш пароль успешно изменен, ' . anchor(site_url($this->dx_auth->login_uri), 'Вход');
            $this->parser->parse($this->dx_auth->reset_password_success_view, $data);
        } else {
            $data['auth_message'] = 'Сброс пароля не выполнен. Имя или ключ не правильные. Проверьте письмо которое мы вам отправили и следуйте инструкции.';
            $this->parser->parse($this->dx_auth->reset_password_failed_view, $data);
        }
    }

    function change_password() {
        // Check if user logged in or not
        if ($this->dx_auth->is_logged_in()) {
            $val = $this->form_validation;
            $data['title'] = "Смена пароля";
            // Set form validation
            $val->set_rules('old_password', 'Старый пароль', 'trim|required|xss_clean|min_length[' . $this->min_password . ']|max_length[' . $this->max_password . ']');
            $val->set_rules('new_password', 'Новый пароль', 'trim|required|xss_clean|min_length[' . $this->min_password . ']|max_length[' . $this->max_password . ']|matches[confirm_new_password]');
            $val->set_rules('confirm_new_password', 'Подтверждение нового пароля', 'trim|required|xss_clean');

            // Validate rules and change password
            if ($val->run() AND $this->dx_auth->change_password($val->set_value('old_password'), $val->set_value('new_password'))) {
                $data['auth_message'] = 'Ваш пароль успешно изменен.';
                $this->parser->parse($this->dx_auth->change_password_success_view, $data);
            } else {
                $this->parser->parse($this->dx_auth->change_password_view, $data);
            }
        } else {
            // Redirect to login page
            $this->dx_auth->deny_access('login');
        }
    }

    function cancel_account() {
        // Check if user logged in or not
        if ($this->dx_auth->is_logged_in()) {
            $val = $this->form_validation;
            $data['title'] = "Деактивация аккаунта";
            // Set form validation rules
            $val->set_rules('password', 'Пароль', "trim|required|xss_clean");

            // Validate rules and change password
            if ($val->run() AND $this->dx_auth->cancel_account($val->set_value('password'))) {
                // Redirect to homepage
                redirect('', 'location');
            } else {
                $data['password'] = array(
                    'name' => 'password',
                    'id' => 'password',
                    'size' => 30
                );
                //$this->load->view($this->dx_auth->cancel_account_view);
                $this->parser->parse('auth/cancel_account', $data);
            }
        } else {
            // Redirect to login page
            $this->dx_auth->deny_access('login');
        }
    }

    // Example how to get permissions you set permission in /backend/custom_permissions/
    function custom_permissions() {
        if ($this->dx_auth->is_logged_in()) {
            echo 'Моя роль: ' . $this->dx_auth->get_role_name() . '<br/>';
            echo 'Мои права: <br/>';

            if ($this->dx_auth->get_permission_value('edit') != NULL AND $this->dx_auth->get_permission_value('edit')) {
                echo 'Правка разрешена';
            } else {
                echo 'Правка не разрешена';
            }

            echo '<br/>';

            if ($this->dx_auth->get_permission_value('delete') != NULL AND $this->dx_auth->get_permission_value('delete')) {
                echo 'Удаление разрешено';
            } else {
                echo 'Удаление не разрешено';
            }
        }
    }

    function edit_profile($id = '') {
        $this->load->model('dx_auth/users', 'users');
        $this->load->model('dx_auth/user_profile', 'user_profile');
        if (!$this->dx_auth->is_logged_in()) {
            $this->dx_auth->deny_access('login');
        }
        if ($id == '' OR $this->dx_auth->is_admin()) {
            if (isset($id) AND $id != '') {
                $user_id = $id;
            } else {
                $user_id = $this->dx_auth->get_user_id();
            }
            if (!count($this->users->get_user_by_id($user_id)->result())) {
                $this->notify->setComeback('/auth/edit_profile');
                $this->notify->returnError('Такого пользователя не существует!');
                //redirect("/auth/edit_profile",'location');
            }


            $data['title'] = "Редактирование профиля пользователя";
            $val = $this->form_validation;
            // Set form validation rules
            $val->set_rules('first_name', 'Имя', "trim|alpha|max_length[255]|xss_clean");
            $val->set_rules('middle_name', 'Отчество', "trim|alpha|max_length[255]|xss_clean");
            $val->set_rules('surname', 'Фамилия', "trim|alpha|max_length[255]|xss_clean");
            $val->set_rules('country', 'Страна', "trim|alpha|max_length[255]|xss_clean");
            $val->set_rules('city', 'Город', "trim|alpha|max_length[255]|xss_clean");
            $val->set_rules('website', 'Сайт', "trim|prep_url|xss_clean");
            $val->set_rules('birthdate', 'Дата рождения', "trim|xss_clean");
            $val->set_rules('sex', 'Пол', "trim|description|xss_clean");
            $val->set_rules('description', 'Подпись', "trim|max_length[1000]|xss_clean");

            if ($val->run()) {
                $data = array(
                    "first_name" => $this->input->post('first_name', TRUE),
                    "middle_name" => $this->input->post('middle_name', TRUE),
                    "surname" => $this->input->post('surname', TRUE),
                    "country" => $this->input->post('country', TRUE),
                    "city" => $this->input->post('city', TRUE),
                    "website" => $this->input->post('website', TRUE),
                    "birthdate" => date("Y-m-d", strtotime($this->input->post('birthdate', TRUE))),
                    "sex" => $this->input->post('sex', TRUE),
                    "description" => $this->input->post('description', TRUE),
                );
                $this->user_profile->set_profile($user_id, $data);
                redirect($this->uri->uri_string());
            }
            $user_profile = $this->user_profile->get_profile($user_id)->result();
            $data['user_profile'] = $user_profile[0];
            $login = $this->users->get_user_by_id($user_id)->result();
            $data['user_profile']->login = $login[0]->username;
            $data['footer_add'][] = "
                <script src=\"/assets/js/bootstrap-datepicker.js\"></script>
                <script>
                $(function(){
                    $('#dp3').datepicker();
                    $('#dp3').datepicker();
                    });
                </script>";
            $data['header_add'][] = "<link href=\"/assets/css/datepicker.css\" rel=\"stylesheet\">";
            $this->parser->parse('auth/edit_profile', $data);
        }
    }

}

?>