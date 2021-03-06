<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Migration_templates extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'autoincrement' => TRUE,
			),
			'users_id' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'school_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
			),
			'course_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
			),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
			),
			'year_level' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'template' => array(
				'type' => 'TEXT',
			),
			'created_on' => array(
				'type' => 'DATETIME',
			),
			'modified_on' => array(
				'type' => 'DATETIME',
			),
		));

		$this->dbforge->add_key('id', TRUE);

		$this->dbforge->create_table('template', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('template');
	}
}
