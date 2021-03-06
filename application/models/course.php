<?php namespace Model;

/* This basic model has been auto-generated by the Gas ORM */

use \Gas\Core;
use \Gas\ORM;

class Course extends ORM {
	
	public $primary_key = 'id';

	function _init()
	{
		
		self::$relationships = array (
			'user'			=> 		ORM::belongs_to('\\Model\\User'), 
			'subject'		=>		ORM::has_many('\\Model\\Subject'),
		);
		
		
		self::$fields = array(
			'id' 			=> 		ORM::field('auto[10]'),
			'users_id'		=> 		ORM::field('int[10]'),
			'title'			=> 		ORM::field('char[255]', array('trim','xss_clean','max_length[255]','required')),
			'created_on' 	=> 		ORM::field('datetime'),
			'modified_on' 	=> 		ORM::field('datetime'),
		);
		
		$this->ts_fields = array('modified_on','[created_on]');

	}
}
