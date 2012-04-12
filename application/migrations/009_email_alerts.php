<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Migration_email_alerts extends CI_Migration {

	public function up()
	{
		// add a "alert_sent" tinyint column to DB
		$fields = array(
			'alert_sent' => array ('type' => 'INT', 'constraint' => 1, 'default' => '0' ),
		);
		$this->dbforge->add_column('coursework',$fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('coursework','alert_sent');
	}
}
