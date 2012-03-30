<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Migration_yearlevel extends CI_Migration {

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
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
			),
			'created_on' => array(
				'type' => 'DATETIME',
			),
			'modified_on' => array(
				'type' => 'DATETIME',
			),
		));

		$this->dbforge->add_key('id', TRUE);

		$this->dbforge->create_table('yearlevel', TRUE);
		
		
		// we also need to add 'yearlevel_id' to the subject table
		$fields = array(
			'yearlevel_id' => array ('type' => 'INT', 'constraint' => 11, ),
		);
		$this->dbforge->add_column('subject',$fields);
		
	}

	public function down()
	{
		$this->dbforge->drop_table('yearlevel');
		$this->dbforge->drop_column('subject','yearlevel_id');
	}
}
