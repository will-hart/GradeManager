<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Migration_profile extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'autoincrement' => TRUE
			),
			'users_id' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'first_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
			),
			'last_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
			),
			'default_course' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'created_on' => array(
				'type' => 'DATETIME',
			),
			'modified_on' => array(
				'type' => 'DATETIME',
			),
		));

		$this->dbforge->add_key('id', TRUE);

		$this->dbforge->create_table('profile', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('course');
	}
}
