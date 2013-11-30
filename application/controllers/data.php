<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Data extends CI_Controller {

    /**
     * Контроллер Банков данных.
     * Индекс выводит список банков. Остальные - выводят список данных в этих банках.
     * Для записи будет отдельный контроллер.
     */
    function __construct() {
        parent::__construct();
        $this->lang->load('dx_auth');
        $this->load->library('form_validation');
        $this->dx_auth->check_uri_permissions();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->model("bank/bank_model", "bank_model");
    }

    public function index() {
        $this->data_id = (int) $this->uri->segment(3, 0);
        if ($this->data_id == 0) {
            redirect("/bank");
        }
        if (!$this->bank_model->check_data_id($this->data_id)) {
            $this->error_id();
        } else {
            $this->show_data($this->data_id);
        }
    }

    public function error_id() {
        $data['title'] = "Неверный идентификатор данных";
        $this->load->view("bank/error_id", $data);
    }

    public function add_data($bank_id = 0) {
        $this->bank_id = (int) $bank_id;
        if (!$this->bank_model->check_bank_id($this->bank_id)) {
            redirect("/");
        }
        $bank_info = $this->bank_model->bank_info($this->bank_id);

        $data['bank_id'] = $this->bank_id;
        $data['title'] = "Добавление данных в Банк : " . $bank_info['name'];
        $data['header_add'][] = "<link rel=\"stylesheet\" type=\"text/css\" href=\"/assets/css/bootstrap-wysihtml5.css\">\n
            <link rel=\"stylesheet\" type=\"text/css\" href='/assets/css/bootstrap-tagmanager.css'></script>\n
            ";
        $data['footer_add'][] = "
                    <script src='/assets/js/wysihtml5-0.3.0.min.js'></script>\n
                    <script src='/assets/js/bootstrap-wysihtml5.js'></script>\n
                    <script src='/assets/js/wysihtml5_locales/bootstrap-wysihtml5.ru-RU.js'></script>\n
                    <script src='/assets/js/bootstrap-tagmanager.js'></script>\n
                    <script type='text/javascript'>
                      $('#data_text').wysihtml5({locale: \"ru-RU\"});
                    </script>\n
                    <script type=\"text/javascript\">
                            jQuery(\".tm-input\").tagsManager({
                                typeahead: true,
                                typeaheadAjaxSource: '/data/ajax_tags',
                                typeaheadAjaxPolling: true,
                                hiddenTagListName: 'data_tags'
                            });
                    </script>
                    ";
        $data['data_title'] = array(
            'name' => 'data_title',
            'id' => 'data_title',
            'value' => $this->input->post('data_title'),
            'maxlength' => '255',
            'style' => 'width:50%',
            'placeholder' => 'Введите заголовок...',
        );
        $data['data_description'] = array(
            'name' => 'data_description',
            'id' => 'data_description',
            'value' => $this->input->post('data_description'),
            'cols' => '50',
            'rows' => '4',
            'style' => 'width:50%',
            'placeholder' => 'Введите описание...',
        );
        $data['data_text'] = array(
            'name' => 'data_text',
            'id' => 'data_text',
            'value' => $this->input->post('data_text'),
            'style' => 'width: 90%; height: 400px;',
            'placeholder' => 'Введите ваш текст записи сюда ...',
        );
        $add_data_validation = array(
            array(
                'field' => 'data_title',
                'label' => 'Заголовок записи',
                'rules' => 'required'
            ),
            array(
                'field' => 'data_description',
                'label' => 'Описание записи',
                'rules' => 'required'
            ),
            array(
                'field' => 'data_text',
                'label' => 'Текст записи',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($add_data_validation);
        if ($this->form_validation->run()) {
            if ($this->bank_model->save_data()) {
                $this->notify->returnSuccess('Данные сохранены.');
            } else {
                $this->notify->returnError('Не удалось сохранить данные.');
            }
        }
        $this->load->view("bank/add_data", $data);
    }

    public function edit_data($data_id = 0) {
        $this->data_id = (int) $data_id;
        if (!$this->bank_model->check_data_id($this->data_id) OR !$this->bank_model->check_owner_data($this->data_id)) {
            redirect("/");
        }
        $getdata = $this->bank_model->get_data($this->data_id);
        if ($this->dx_auth->is_admin()) {
            $this->load->model('dx_auth/users');
            $data['data_author_array'] = $this->users->get_users_array();
        }
        $data_info = $getdata[0];
        $data['data_id'] = $this->data_id;
        $data['tags'] = $this->bank_model->show_tag_array($this->data_id);
        $data['tags_string'] = "";
        if (is_array($data['tags']) AND count($data['tags']) > 0) {
            foreach ($data['tags'] as $tag => $value) {
                $data['tags_string'].= $value . ",";
            }
        }
        $data['data_author_select'] = $data_info['author_id'];
        $data['tags_string'] = mb_substr($data['tags_string'], 0, strlen($data['tags_string']) - 1);
        $data['title'] = "Редактирование записи : " . $data_info['title'];
        $data['header_add'][] = "<link rel=\"stylesheet\" type=\"text/css\" href=\"/assets/css/bootstrap-wysihtml5.css\">\n
            <link rel=\"stylesheet\" type=\"text/css\" href='/assets/css/bootstrap-tagmanager.css'></script>\n
            ";
        $data['footer_add'][] = "
                    <script src='/assets/js/wysihtml5-0.3.0.min.js'></script>\n
                    <script src='/assets/js/bootstrap-wysihtml5.js'></script>\n
                    <script src='/assets/js/wysihtml5_locales/bootstrap-wysihtml5.ru-RU.js'></script>\n
                    <script src='/assets/js/bootstrap-tagmanager.js'></script>\n
                    <script type='text/javascript'>
                      $('#data_text').wysihtml5({locale: \"ru-RU\"});
                    </script>\n
                    <script type=\"text/javascript\">
                            jQuery(\".tm-input\").tagsManager({
                                typeahead: true,
                                typeaheadAjaxSource: '/data/ajax_tags',
                                typeaheadAjaxPolling: true,
                                prefilled: '" . $data['tags_string'] . "',
                                hiddenTagListName: 'data_tags'
                            });
                    </script>
                    ";
        $data['data_title'] = array(
            'name' => 'data_title',
            'id' => 'data_title',
            'value' => $data_info['title'],
            'maxlength' => '255',
            'style' => 'width:50%',
            'placeholder' => 'Введите заголовок...',
        );
        $data['data_description'] = array(
            'name' => 'data_description',
            'id' => 'data_description',
            'value' => $data_info['description'],
            'cols' => '50',
            'rows' => '4',
            'style' => 'width:50%',
            'placeholder' => 'Введите описание...',
        );
        $data['data_text'] = array(
            'name' => 'data_text',
            'id' => 'data_text',
            'value' => $data_info['content'],
            'style' => 'width: 90%; height: 400px;',
            'placeholder' => 'Введите ваш текст записи сюда ...',
        );
        if ($this->dx_auth->is_admin()) {
            $data['data_author'] = array(
                'name' => 'data_author',
            );
        }

        $edit_data_validation = array(
            array(
                'field' => 'data_title',
                'label' => 'Заголовок записи',
                'rules' => 'required'
            ),
            array(
                'field' => 'data_description',
                'label' => 'Описание записи',
                'rules' => 'required'
            ),
            array(
                'field' => 'data_text',
                'label' => 'Текст записи',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($edit_data_validation);
        if ($this->form_validation->run()) {
            if ($this->bank_model->update_data()) {
                $this->notify->returnSuccess('Данные сохранены.');
            } else {
                $this->notify->returnError('Не удалось сохранить данные.');
            }
        }
        $this->load->view("bank/edit_data", $data);
    }

    public function delete_data($data_id = 0) {
        $this->data_id = (int) $data_id;
        if (!$this->bank_model->check_data_id($this->data_id) OR !$this->bank_model->check_owner_data($this->data_id)) {
            redirect("/");
        }

        if ($this->bank_model->delete_data($this->data_id)) {
            $this->notify->returnSuccess('Запись удалена.');
        } else {
            $this->notify->returnError('Не удалось удалить запись.');
        }
        redirect("/");
    }

    public function show_data($id) {
        //$id = $this->data_id = (int) $this->uri->segment(3, 0);

        $query = $this->bank_model->get_data($id);
        if (!$query) {
            $this->error_id();
            //die($data['info']->db_id);
        } else {
            $data['info'] = $query;
            //$data['info'] = $this->bank_model->get_data($id);
            $data['title'] = $data['info']->title;
            $data['author_name'] = $this->dx_auth->get_user_profile_name($data['info']->author_id);
            //$this->dx_auth->get_user_name($data['info']['author_id']);
            $data['tags'] = $this->bank_model->show_tag_array($id);
            $this->load->view("bank/show_data", $data);
        }
    }

    function ajax_tags() {
        if ($this->input->is_ajax_request()) {
            $tag = json_decode(file_get_contents("php://input"));
            if (!empty($tag)) {
                $return_array = $this->bank_model->like_tag($tag->typeahead);
                $json_return = "{\"tags\":[";
                if (is_array($return_array)) {
                    foreach ($return_array as $key => $value) {
                        $json_return .= "{\"tag\":\"" . $value['name'] . "\"},";
                    }
                }
                $json_return = preg_replace("/(.*).$/", "\\1", $json_return);
                echo $json_return . "]}";
            }
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */