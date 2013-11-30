<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bank extends CI_Controller {

    /**
     * Контроллер Банков данных.
     * Индекс выводит список банков. Остальные - выводят список данных в этих банках.
     * Для записи будет отдельный контроллер.
     */
    function __construct() {
        parent::__construct();
        $this->lang->load('dx_auth');
        $this->dx_auth->check_uri_permissions();
        $this->load->helper('url');
    }

    public function index() {
        $this->bank_id = (int) $this->uri->segment(3,0);
        //если не вошли в систему
        if (!$this->dx_auth->is_logged_in()) {
            redirect("/github");
        } else {
            //$this->bank_id = $bank_id;
            if ($this->bank_id == 0) {
                $this->list_banks();
            } else {
                $this->list_data();
            }
        }
    }
    public function list_banks(){
                $data['title'] = "Банки данных";
                $data['banks'] = $this->bank_model->bank_list()->result_array();
                $this->load->view("bank/bank_list", $data);
    }
    
    public function list_data(){
                // Get offset and limit for page viewing
                        
                if (!$this->bank_model->check_bank_id($this->bank_id)) {
                    redirect("/");
                }
                $bank_info = $this->bank_model->bank_info($this->bank_id);
                $offset = (int) $this->uri->segment(4,1);
                $row_count = 3;
                $p_config['base_url'] = '/bank/index/' . $this->bank_id . '/';
                $p_config['uri_segment'] = 4;
                $p_config['num_links'] = 2;
                $p_config['total_rows'] = $this->bank_model->get_all_data($this->bank_id)->num_rows();
                $p_config['per_page'] = $row_count;
                
                if ($p_config['total_rows'] > 0) {
                    $data['list_data'] = $this->bank_model->get_all_data($this->bank_id, $offset, $row_count)->result_array();
                    // Init pagination
                    $this->pagination->initialize($p_config);
                    // Create pagination links
                    $data['pagination'] = $this->pagination->create_links();
                    $data['title'] = $bank_info->name;
                    $data['bank_id'] = $this->bank_id;
                    $this->load->view("bank/data_list", $data);
                }else{
                    $data['list_data'] = "Этот Банк Данных пока пуст";
                    $data['title'] = $bank_info->name;
                    $data['bank_id'] = $this->bank_id;
                    $this->load->view("bank/data_list", $data);
                }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */