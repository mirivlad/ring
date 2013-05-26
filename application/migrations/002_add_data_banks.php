<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_data_banks extends CI_Migration {

    public function up() {
        //таблица списка банков данных
        $fields_list_db = array(
            'id_db' => array(
                'type' => 'INT',
                'constraint' => 3,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            )
        );
        //таблица списка основных данных
        $fields_list_data = array(
            'id_data' => array(
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'db_id' => array(
                'type' => 'INT',
                'constraint' => 3,
                'unsigned' => TRUE,
            ),
            'author_id' => array(
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE
            ),
            'create_date' => array(
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE
            ),
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => '400',
                'default' => 'Data title'
            ),
            'decsription' => array(
                'type' => 'VARCHAR',
                'constraint' => '400',
                'default' => 'Data description'
            ),
            'content' => array(
                'type' => 'LONGTEXT'
            ),
            'access' => array(
                'type' => 'VARCHAR',
                'constraint' => '400',
            )
        );
        //таблица тегов
        $fields_list_tags = array(
            'id_tag' => array(
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
            )
        );
        //таблица связей тегов и данных
        $fields_tags_data = array(
            'id_tagdata' => array(
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'tag_id' => array(
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE
            ),
            'data_id' => array(
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE
            )
        );
        //таблица обсуждения данных
        $fields_list_comment = array(
            'id_comment' => array(
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'data_id' => array(
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
            ),
            'author_id' => array(
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
            ),
            'create_date' => array(
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE
            ),
            'comment' => array(
                'type' => 'TEXT'
            )
        );


        $this->dbforge->add_field($fields_list_db);
        $this->dbforge->add_key('id_db', TRUE);
        $this->dbforge->create_table("list_db", TRUE);


        $this->dbforge->add_field($fields_list_data);
        $this->dbforge->add_key('id_data', TRUE);
        $this->dbforge->add_key('db_id');
        $this->dbforge->add_key('author_id');
        $this->dbforge->create_table("list_data", TRUE);
        

        $this->dbforge->add_field($fields_list_tags);
        $this->dbforge->add_key('id_tag', TRUE);
        $this->dbforge->create_table("list_tags", TRUE);
        
  
        $this->dbforge->add_field($fields_tags_data);
        $this->dbforge->add_key('id_tagdata', TRUE);
        $this->dbforge->add_key('tag_id');
        $this->dbforge->add_key('data_id');
        $this->dbforge->create_table("tags_data", TRUE);      
        

        $this->dbforge->add_field($fields_list_comment);
        $this->dbforge->add_key('id_comment', TRUE);
        $this->dbforge->add_key('data_id');
        $this->dbforge->add_key('author_id');  
        $this->dbforge->create_table("list_comment", TRUE);

    }

    public function down() {
        $this->dbforge->drop_table("list_db");
        $this->dbforge->drop_table("list_data");
        $this->dbforge->drop_table("list_tags");
        $this->dbforge->drop_table("tags_data");
        $this->dbforge->drop_table("list_comment");
    }

}