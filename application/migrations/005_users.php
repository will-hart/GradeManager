<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* This basic migration has been auto-generated by the Gas ORM */

class Migration_users extends CI_Migration {

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'username' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
			),
			'password' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
			),
			'group_id' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'token' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
			),
			'identifier' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
			),
		));

		$this->dbforge->add_key('id', TRUE);

		$this->dbforge->create_table('users', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('users');
	}
}