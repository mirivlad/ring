<?php

class Bank_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function bank_list() {
        $this->db->order_by('id_db', 'asc');
        return $this->db->get("list_db");
    }

    function bank_info($id_db) {
        //$this->db->where('id_db', (int) $id_db, TRUE);
        $res = $this->db->get("list_db",array('id_db'=>$id_db));
        
        if ($res->num_rows()>0) {
            return $res->row();
        } else {
            return FALSE;
        }
    }

    function check_bank_id($id_db = 0) {
        $id = (int) $id_db;
        if ($id <= 0) {
            return FALSE;
        }
        $this->db->where("id_db", $id);
        $this->db->from('list_db');
        $count = $this->db->count_all_results();
        if ($count > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function get_data($data_id) {
        $res = $this->db->get_where("list_data",array("id_data"=>$data_id));
        if($res->num_rows()>0){
            return $res->row();
        } else {
            return FALSE;
        }
    }

    function get_all_data($bank_id, $offset = 0, $row_count = 0) {
        if ($offset >= 0 AND $row_count > 0) {
            //$this->db->select("list_db.*", FALSE);
            
            $this->db->select("*");
            $this->db->where("db_id", $bank_id);
            //$this->db->join("list_data", "list_data.db_id = list_db.id_db");
            $this->db->order_by("create_date", "DESC");
            $query = $this->db->get("list_data", $row_count, ($offset - 1) * $row_count);
        } else {
            $this->db->select("*");
            $this->db->where("db_id", $bank_id);
            $query = $this->db->get("list_data");
        }
        return $query;
    }

    function check_owner_data($data_id = 0) {
        if ($this->dx_auth->is_admin())
            return TRUE;

        $id = (int) $data_id;

        if (!$this->check_data_id($id)) {
            return FALSE;
        }
        $data = $this->db->get_where('list_data', array('id_data' => $id), 1)->result_array();
        if (is_array($data) AND count($data) > 0) {
            $info = $data[0];
            if ($info['author_id'] == $this->dx_auth->get_user_id()) {
                return TRUE;
            } else {
                return FALSE;
            }
            //$this->firephp->log($data);
        } else {
            return FALSE;
        }
        return FALSE;
    }

    function check_data_id($data_id = 0) {
        $count = $this->db->get('list_data', array("id_data"=>$data_id));
        if ($count->num_rows > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function like_tag($tag = '') {
        if (!isset($tag) OR empty($tag) OR $tag == '' or !is_string($tag)) {
            return array();
        } else {
            $this->db->like('name', $tag);
            $res = $this->db->get("list_tags");
            $res = $res->result_array();
            return $res;
        }
    }

    function check_tag($tag = '') {
        $this->db->where("name", $tag);
        $this->db->from("list_tags");
        if ($this->db->count_all_results() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function save_tags($tags = '') {
        $tags = (string) $tags;
        if ($tags == '') {
            return TRUE;
        }
        $array = explode(",", $tags);
        $succ = 0;
        foreach ($array as $value) {
            if (!$this->check_tag($value)) {
                $data = array(
                    'id_tag' => null,
                    'name' => strip_tags($value)
                );
                $data = $this->security->xss_clean($data);
                if (!$this->db->insert('list_tags', $data)) {
                    $succ++;
                }
            }
        }
        if ($succ == 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function search_tags($array_tags) {
        $return_array = array();
        foreach ($array_tags as $tag) {
            $this->db->where('name', $tag);
            $res = $this->db->get("list_tags");
            $res = $res->result_array();
            $return_array[] = $res[0]['id_tag'];
        }

        if (count($return_array) > 0) {
            return $return_array;
        } else {
            return FALSE;
        }
    }

    function get_data_tags($data_id) {
        $this->db->where('data_id', $data_id);
        $res = $this->db->get("tags_data");
        $res = $res->result_array();
        if (is_array($res)) {
            return $res;
        } else {
            return FALSE;
        }
    }

    function get_tag($tag_id) {
        $this->db->where('id_tag', $tag_id);
        $res = $this->db->get("list_tags");
        $res = $res->result_array();
        if (is_array($res) AND count($res) > 0) {
            return $res[0];
        } else {
            return FALSE;
        }
    }

    function save_data() {
        if ($this->check_bank_id($this->input->post("bank_id"))) {
            //сохраняем теги в БД
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
            //Сохраняем запись в БД.
            $this->db->insert('list_data', $this->security->xss_clean($data));
            $data_id = $this->db->insert_id();
            //массив тегов
            $tags = explode(",", $this->input->post("data_tags"));
            //находим теги в БД и их ID
            $array_tags = $this->search_tags($tags);
            if (is_array($array_tags)) {
                $data2 = array();
                foreach ($array_tags as $val) {
                    $data2 = array('id_tagdata' => NULL, 'tag_id' => $val, 'data_id' => $data_id);
                    $data2 = $this->security->xss_clean($data2);
                    $this->db->insert('tags_data', $data2);
                }
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function update_data() {
        $data_id = (int) $this->input->post("data_id");
        if ($this->check_data_id($data_id) AND $this->check_owner_data($data_id)) {
            //сохраняем теги в БД
            $this->save_tags($this->input->post("data_tags"));
            if ($this->dx_auth->is_admin()) {
                $data = array(
                    'create_date' => time(),
                    'author_id' => strip_tags($this->input->post("data_author")),
                    'title' => strip_tags($this->input->post("data_title")),
                    'description' => strip_tags($this->input->post("data_description")),
                    'content' => $this->input->post("data_text")
                );
            } else {
                $data = array(
                    'create_date' => time(),
                    'title' => strip_tags($this->input->post("data_title")),
                    'description' => strip_tags($this->input->post("data_description")),
                    'content' => $this->input->post("data_text")
                );
            }
            //Сохраняем запись в БД.
            $this->db->update('list_data', $this->security->xss_clean($data), array("id_data" => $data_id));

            //находим теги записи и удаляем их
            $data_tags = $this->get_data_tags($data_id);
            if (is_array($data_tags)) {
                foreach ($data_tags as $data_tag) {
                    $this->db->delete('tags_data', array('data_id' => $data_id));
                }
            }

            //массив тегов
            $tags = explode(",", $this->input->post("data_tags"));
            //находим теги в БД и их ID
            $array_tags = $this->search_tags($tags);
            if (is_array($array_tags)) {
                $data2 = array();
                foreach ($array_tags as $val) {
                    $data2 = array('id_tagdata' => NULL, 'tag_id' => $val, 'data_id' => $data_id);
                    $data2 = $this->security->xss_clean($data2);
                    $this->db->insert('tags_data', $data2);
                }
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function delete_data($id) {
        $data_id = (int) $id;
        if ($this->check_data_id($data_id) AND $this->check_owner_data($data_id)) {
            //Удаляем запись в БД.
            $this->db->delete('list_data', array("id_data" => $data_id));

            //находим теги записи и удаляем их
            $data_tags = $this->get_data_tags($data_id);
            if (is_array($data_tags)) {
                foreach ($data_tags as $data_tag) {
                    $this->db->delete('tags_data', array('data_id' => $data_id));
                }
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function show_tag_array($id) {
        $id = (int) $id;
        $data_tags = $this->get_data_tags($id);
        $tags_arr = array();
        $var1 = '';
        foreach ($data_tags as $tag) {
            $var1 = $this->get_tag($tag['tag_id']);
            $tags_arr[$var1['id_tag']] = $var1['name'];
        }
        if (count($tags_arr) > 0) {
            return $tags_arr;
        } else {
            return FALSE;
        }
    }

}
