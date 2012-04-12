<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Migration_profile_unsubscribe extends CI_Migration {

	public function up()
	{
		// add a "alert_sent" tinyint column to DB
		$fields = array(
			'emails_allowed' => array ('type' => 'INT', 'constraint' => 1, 'default' => '0' ),
			'unsubscribe_code' => array ('type' => 'CHAR', 'constraint' => 23),
		);
		$this->dbforge->add_column('profile',$fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('profile','emails_allowed');
		$this->dbforge->drop_column('profile','unsubscribe_code');
	}
}
