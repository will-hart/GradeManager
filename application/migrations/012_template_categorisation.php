<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Migration_template_categorisation extends CI_Migration {

	public function up()
	{
		// add a "alert_sent" tinyint column to DB
		$fields = array(
			'is_official' => array ('type' => 'INT', 'constraint' => 1, 'default' => '0' ),
			'is_course' => array ('type' => 'INT', 'constraint' => 1, 'default' => '0'),
			
		);
		$this->dbforge->add_column('template',$fields);
	}

	public function down()
	{
		$this->dbforge->drop_column('template','is_official');
		$this->dbforge->drop_column('template','is_course');
	}
}
