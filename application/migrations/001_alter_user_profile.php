<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Alter_user_profile extends CI_Migration {

	public function up()
	{
        $fields = array(
            'city'=> array(
                'type' => 'VARCHAR', 
                'constraint' => '255'
                ),
            'avatar'=> array(
                'type' => 'VARCHAR', 
                'constraint' => '255', 
                'default'=> 'default.png'
                ),
            'first_name'=> array(
                'type' => 'VARCHAR', 
                'constraint' => '255'
                ),
            'middle_name'=> array(
                'type' => 'VARCHAR', 
                'constraint' => '255'
                ),
            'surname'=> array(
                'type' => 'VARCHAR', 
                'constraint' => '255'
                ),
            'birthdate'=> array(
                'type' => 'DATE'
                ),
            'sex'=> array(
                'type' => 'SET', 
                'constraint' => array(
                    "men","women","not_set"
                ), 
                "default" => "not_set"
                ),
            'description'=> array(
                'type' => 'TEXT'
                )
        );
        $this->dbforge->add_column('user_profile', $fields);
	}

	public function down()
	{
		die("Nothing Downgrade!");
	}
}