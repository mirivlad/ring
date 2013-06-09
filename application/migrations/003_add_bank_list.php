<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_bank_list extends CI_Migration {

    public function up() {
        //добавление банков данных в таблицу list_db
        $data = array(
            array(
                'id_db' => NULL,
                'name' => 'Предостережения'
            ),
            array(
                'id_db' => NULL,
                'name' => 'Методики'
            ),
            array(
                'id_db' => NULL,
                'name' => 'Отзывы'
            ),
            array(
                'id_db' => NULL,
                'name' => 'Хозяйство'
            ),
            array(
                'id_db' => NULL,
                'name' => 'Проблемы'
            ),
            array(
                'id_db' => NULL,
                'name' => 'Мероприятия'
            ),
            array(
                'id_db' => NULL,
                'name' => 'Помощь'
            ),
            array(
                'id_db' => NULL,
                'name' => 'Идеи'
            ),
        );

        $this->db->insert_batch('list_db', $data);
        
        $fields = array(
                        'decsription' => array(
                                                         'name' => 'description',
                                                         'type' => 'varchar(400)',
                                                ),
        );
        $this->dbforge->modify_column('list_data', $fields);
    }

    public function down() {
        $this->db->empty_table('list_db'); 
    }

}