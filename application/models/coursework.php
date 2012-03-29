<?php namespace Model;

use \Gas\Core;
use \Gas\ORM;

class Coursework extends ORM {

	function init() 
	{
		// relationship definitions
		self::$relationships = array (
			'subject'		=>		ORM::belongs_to('\\Model\\Subject'),
		);
		
		// field definitions
		self::$fields = array(
			'id'			=>		ORM::field('auto[10]'),
			'user_id'		=>		ORM::field('int[10]'),
			'subject_id'	=>		ORM::field('int[10]'),
			'title'			=>		ORM::field('char[255]'),
			'notes'			=>		ORM::field('string'),
			'score'			=>		ORM::field('int[3]'),
			'weight'		=>		ORM::field('int[3]'),
			'deleted'		=>		ORM::field('int[1]'),
			'created_on'	=>		ORM::field('datetime'),
			'modified_on'	=> 		ORM::field('datetime'),
		);
		
		// set up the timestamps
		$this->_ts_fields('modified_on','[created_on]');
	}
	
}
