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
        //если не вошли в систему
        //$this->bank_id = $bank_id;
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
        //$this->firephp->log($_POST);
        $this->bank_id = (int) $bank_id;
        if (!$this->bank_model->check_bank_id($this->bank_id)) {
            redirect("/");
        }
        $bank_info = $this->bank_model->bank_info($this->bank_id);
        //$this->firephp->log($bank_info);
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
        //$data['banks'] = $this->bank_model->bank_list()->result_array();
        $add_data_validation = array(
            array(
                'field' => 'data_title',
                'label' => 'Заголовок',
                'rules' => 'required'
            ),
            array(
                'field' => 'data_description',
                'label' => 'Описание',
                'rules' => 'required'
            ),
            array(
                'field' => 'data_text',
                'label' => 'Текст',
                'rules' => 'required'
            )
        );
        $this->form_validation->set_rules($add_data_validation);
        if ($this->form_validation->run() != FALSE) {
            if ($this->bank_model->save_data()){
                $this->notify->returnSuccess('Данные сохранены.');
            }else{
                $this->notify->returnError('Не удалось сохранить данные.');
            }
        }
        $this->load->view("bank/add_data", $data);
    }

    public function show_data() {
            $id = $this->data_id = (int) $this->uri->segment(3, 0);
            
            $data['info'] = $this->bank_model->get_data($id);
            if (!is_array($data['info']) OR !isset($data['info'][0])){
                $this->error_id();
            }else{
                $data['info'] = $data['info'][0];
            
                $data['title'] = $data['info']['title'];
                $data['author_name'] = $this->dx_auth->get_user_name($data['info']['author_id']);
                $this->firephp->log($data);
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