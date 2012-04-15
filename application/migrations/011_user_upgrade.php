<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Migration_user_upgrade extends CI_Migration {

	public function up()
	{
		// add a "alert_sent" tinyint column to DB
		$fields = array(
			'registration_token' => array ('type' => 'CHAR', 'constraint' => 64 ),
			'forgot_pass_token' => array ('type' => 'CHAR', 'constraint' => 64 ),
		);
		$this->dbforge->add_column('users',$fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('users','registration_token');
		$this->dbforge->drop_column('users','forgot_pass_token');
	}
}
