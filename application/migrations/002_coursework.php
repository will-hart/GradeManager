<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* This basic migration has been auto-generated by the Gas ORM */

class Migration_coursework extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 10,
			),
			'users_id' => array(
				'type' => 'INT',
				'constraint' => 10,
			),
			'subject_id' => array(
				'type' => 'INT',
				'constraint' => 10,
			),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
			),
			'due_date' => array(
				'type' => 'DATE',
			),
			'status_id' => array(
				'type' => 'INT',
				'constraint' => 10,
				'default' => 1,
			),
			'notes' => array(
				'type' => 'TEXT',
				'constraint' => 0,
			),
			'score' => array(
				'type' => 'INT',
				'constraint' => 3,
				'defaul' => 0,
			),
			'weighting' => array(
				'type' => 'INT',
				'constraint' => 3,
				'default' => 0,
			),
			'deleted' => array(
				'type' => 'TINYINT',
				'constraint' => 1,
			),
			'created_on' => array(
				'type' => 'DATETIME',
				'constraint' => 0,
			),
			'modified_on' => array(
				'type' => 'DATETIME',
				'constraint' => 0,
			),
		));

		$this->dbforge->add_key('id', TRUE);

		$this->dbforge->create_table('coursework', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('coursework');
	}
}
