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
                return $this->db->get("list_db");
        }
        
        function get_all_data($bank_id, $offset = 0, $row_count = 0){
            if ($offset >= 0 AND $row_count > 0){
                $this->db->select("list_db.*", FALSE);
                $this->db->where("id_db", $bank_id);
		$this->db->select("list_data.*", FALSE);
		$this->db->join("list_data", "list_data.db_id = list_db.id_db");
		$this->db->order_by("list_data.create_date", "DESC");
		$query = $this->db->get("list_db", $row_count, $offset);
            }else{
                $this->db->select("list_db.*", FALSE);
		$this->db->select("list_data.*", FALSE);
		$this->db->join("list_data", "list_data.db_id = list_db.id_db");
		$this->db->order_by("list_data.create_date", "DESC");
		$query = $this->db->get("list_db");
            }
            return $query;
        }
}
