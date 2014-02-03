<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tags extends CI_Controller {

    /**
     * Контроллер Банков данных.
     * Индекс выводит список банков. Остальные - выводят список данных в этих банках.
     * Для записи будет отдельный контроллер.
     */
    function __construct() {
        parent::__construct();
        $this->lang->load('dx_auth');
        //$this->load->library('form_validation');
        $this->dx_auth->check_uri_permissions();
        $this->load->helper('url');
        //$this->load->helper('form');
        $this->load->model("bank/bank_model", "bank_model");
    }

    public function index($tag_id=0) {
        $this->tag_id = (int) $tag_id;
        if ($this->tag_id == 0 OR !$this->bank_model->get_tag($this->tag_id)) {
            redirect("/tags/list_tags");
        }else{
                //$bank_info = $this->bank_model->bank_info($this->tag_id);
                $offset = (int) $this->uri->segment(4,1);
                $row_count = 3;
                $p_config['base_url'] = '/tags/index/' . $this->tag_id . '/';
                $p_config['uri_segment'] = 4;
                $p_config['num_links'] = 2;
                $p_config['total_rows'] = $this->bank_model->get_data_by_tag($this->tag_id)->num_rows();
                $p_config['per_page'] = $row_count;
                if ($p_config['total_rows'] > 0) {
                    $data['list_data'] = $this->bank_model->get_data_by_tag($this->tag_id, $offset, $row_count)->result();
                    // Init pagination
                    $this->pagination->initialize($p_config);
                    // Create pagination links
                    $data['pagination'] = $this->pagination->create_links();
                    $data['title'] = "Данные по тегу: ".$this->bank_model->get_tag($this->tag_id)['name'];
                    $this->load->view("bank/data_list_tags", $data);
                }else{
                    $data['list_data'] = $this->bank_model->get_data_by_tag($this->tag_id, $offset, $row_count)->result();
                    redirect("/");
                }
        }
    }

    public function list_tags() {
       $list_tags = $this->bank_model->get_list_tags();
       $data['title'] = "Список тегов";
       $data['tags'] = $list_tags;
       
       $this->load->view("bank/list_tags", $data);
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