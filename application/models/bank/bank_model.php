<?php

class Bank_model extends CI_Model {
    
	function __construct() {
	    parent::__construct();
	}
        
        function bank_list(){
                $this->db->order_by('id_db', 'asc');
                return $this->db->get("list_db");
        }
        
        function bank_info($id_db){
                $this->db->where('id_db', (int) $id_db, TRUE);
                $res = $this->db->get("list_db");
                $res = $res->result_array();
                
                return $res[0];
        }
        function check_bank_id($id_db=0){
            $id = (int)$id_db;
            if ($id <= 0){
                return FALSE;
            }
            $this->db->where("id_db", $id);
            $this->db->from('list_db');
            $count = $this->db->count_all_results();
            if ($count > 0){
                return TRUE;
            }else{
                return FALSE;
            }
        }

        function get_data($data_id){
            if ($this->check_data_id($data_id)){
                $this->db->where("id_data", $data_id);
		$res = $this->db->get("list_data");
                return $res->result_array();
            }else{
		return FALSE;
            }
        }
        function get_all_data($bank_id, $offset = 0, $row_count = 0){
            if ($offset >= 0 AND $row_count > 0){
                //$this->db->select("list_db.*", FALSE);
                $this->db->where("db_id", $bank_id);
		$this->db->select("*");
		//$this->db->join("list_data", "list_data.db_id = list_db.id_db");
		$this->db->order_by("create_date", "DESC");
		$query = $this->db->get("list_data", $row_count, ($offset-1)*$row_count);
            }else{
		$this->db->select("*");
                $this->db->where("db_id", $bank_id);
		$query = $this->db->get("list_data");
            }
            return $query;
        }
        function check_data_id($data_id=0){
            $id = (int)$data_id;
            if ($id <= 0){
                return FALSE;
            }
            $this->db->where("id_data", $id);
            $this->db->from('list_data');
            $count = $this->db->count_all_results();
            if ($count > 0){
                return TRUE;
            }else{
                return FALSE;
            }
        }
        function like_tag($tag=''){
            if (!isset($tag) OR empty($tag) OR $tag=='' or !is_string($tag)){
                return array();
            }else{
                $this->db->like('name', $tag);
                $res = $this->db->get("list_tags");
                $res = $res->result_array();
                return $res;
            }
        }
        function check_tag($tag=''){
            $this->db->where("name", $tag);
            $this->db->from("list_tags");
            if ($this->db->count_all_results()>0){
                return TRUE;
            }else{
                return FALSE;
            }
        }
        function save_tags($tags=''){
            $tags = (string) $tags;
            if ($tags == ''){
                return TRUE;
            }
            $array = explode(",", $tags);
            foreach ($array as $value){
                if (!$this->check_tag($value)){
                    $data = array(
                    'id_tag' => null ,
                    'name' => strip_tags($value)
                 );
                 $data = $this->security->xss_clean($data);
                 $this->db->insert('list_tags', $data);
                }
            }
        }
        function search_tags ($array_tags){
            foreach ($array_tags as $tag){
                $this->db->where('name', $tag);
                $res = $this->db->get("list_tags");
                $res = $res->result_array();
            }
            if (is_array($res)){
                return $res;
            }else{
                return FALSE;
            }
        }
        function save_data(){
            if ($this->check_bank_id($this->input->post("bank_id"))){
                $this->save_tags($this->input->post("data_tags"));
                $data = array(
                    'id_data' => NULL,
                    'db_id' => strip_tags($this->input->post("bank_id")),
                    'author_id' => $this->dx_auth->get_user_id(),
                    'create_date' => time(),
                    'title' => strip_tags($this->input->post("data_title")),
                    'description' => strip_tags($this->input->post("data_description")),
                    'content' => $this->input->post("data_text")
                );
                $this->db->insert('list_data', $this->security->xss_clean($data));
                $data_id = $this->db->insert_id();
                $tags = explode(",", $this->input->post("data_tags"));
                $array_tags = $this->search_tags($tags);
                $data2 = array();
                foreach ($array_tags as $val) {
                    $data2 = array('id_tagdata' => NULL, 'tag_id' => $val['id_tag'], 'data_id'=> $data_id);
                    $data2 = $this->security->xss_clean($data2);
                    $this->db->insert('tags_data', $data2);
                    
                }
//                $this->firephp->log($data2);
//                $this->firephp->log($array_tags);
//                
//                die();
                return TRUE;
            }else{
                return FALSE;
            }
        }
}
