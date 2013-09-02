<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Change_user_register extends CI_Migration {

    public function up() {
        //добавление банков данных в таблицу list_db
        $data = array(
            'first_name'=> array(
                'type' => 'VARCHAR', 
                'constraint' => '255'
                ),
            'surname'=> array(
                'type' => 'VARCHAR', 
                'constraint' => '255'
                )
        );

        $this->dbforge->add_column('user_temp', $data);
    }

    public function down() {
        $this->dbforge->drop_column('user_temp', 'first_name');
        $this->dbforge->drop_column('user_temp', 'surname');
    }

}