<?php namespace Model;

use \Gas\Core;
use \Gas\ORM;

class Subject extends ORM {

	function init() 
	{
		// relationship definitions
		self::$relationships = array (
			'user'		=>		ORM::belongs_to('\\Model\\User'),
			'coursework'=>		ORM::has_many('\\Model\\Coursework'),
		);
		
		// field definitions
		self::$fields = array(
			'id'			=>		ORM::field('auto[10]'),
			'user_id'		=>		ORM::field('int[10]'),
			'code'			=>		ORM::field('char[32]'),
			'title'			=>		ORM::field('char[255]'),
			'notes'			=>		ORM::field('string'),
			'deleted'		=>		ORM::field('int[1]'),
			'created_on'	=>		ORM::field('datetime'),
			'modified_on'	=> 		ORM::field('datetime'),
		);
		
		// set up the timestamps
		$this->_ts_fields('modified_on','[created_on]');
	}
	
}
