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
        if ($this->data_id == 0){
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

    public function add_data($bank_id=0) {
        //$this->firephp->log($bank_id);
        $this->bank_id = (int) $bank_id;
        if (!$this->bank_model->check_bank_id($this->bank_id)){
            redirect("/");
        }
        $bank_info = $this->bank_model->bank_info($this->bank_id);
        //$this->firephp->log($bank_info);
        $data['bank_id'] = $this->bank_id;
        $data['title'] = "Добавление данных в Банк : ".$bank_info['name'];
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
            $this->notify->returnSuccess('Данные сохранены.');
        }
        $this->load->view("bank/add_data", $data);
    }

    public function show_data() {
        // Get offset and limit for page viewing
        $offset = (int) $this->uri->segment(4, 0);
        $row_count = 10;
        $p_config['base_url'] = '/data/' . $this->bank_id . '/';
        $p_config['uri_segment'] = $offset;
        $p_config['num_links'] = 2;
        $p_config['total_rows'] = $this->bank_model->get_all_data($this->bank_id, $offset, $row_count)->num_rows();
        $p_config['per_page'] = $row_count;
        if ($p_config['total_rows'] > 0) {
            $data['list_data'] = $this->bank_model->get_all_data($this->bank_id, $offset, $row_count)->result_array();
            // Init pagination
            $this->pagination->initialize($p_config);
            // Create pagination links
            $data['pagination'] = $this->pagination->create_links();
            $data['title'] = $data['list_data'][0]['name'];
            $this->load->view("bank/data_list", $data);
        } else {
            $bank_info = $this->bank_model->bank_info($this->bank_id)->result_array();
            $data['list_data'] = "Этот Банк Данных пока пуст";
            $data['title'] = $bank_info[0]['name'];
            $this->load->view("bank/data_list", $data);
        }
    }
    function ajax_tags (){
        $var= 0;
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */