<?php namespace Model;

/* This basic model has been auto-generated by the Gas ORM */

use \Gas\Core;
use \Gas\ORM;

class Subject extends ORM {
	
	public $primary_key = 'id';

	function _init()
	{
		
		self::$relationships = array (
			'user'			=> 		ORM::belongs_to('\\Model\\User'),
			'course'		=>		ORM::belongs_to('\\Model\\Course'),
			'coursework'	=>		ORM::has_many('\\Model\\Coursework'),
		);
		
		
		self::$fields = array(
			'id' 			=> 		ORM::field('auto[10]'),
			'users_id'		=> 		ORM::field('int[10]'),
			'course_id'		=>		ORM::field('int[10]'),
			'code' 			=> 		ORM::field('char[32]', array('trim','xss_clean','max_length[32]','required')),
			'title' 		=> 		ORM::field('char[255]', array('trim','xss_clean','max_length[255]','required')),
			'notes' 		=> 		ORM::field('string', array('trim','xss_clean')),
			'score'			=>		ORM::field('int[3]'),
			'complete'		=>		ORM::field('int[3]'),
			'deleted' 		=> 		ORM::field('numeric[1]'),
			'created_on' 	=> 		ORM::field('datetime'),
			'modified_on' 	=> 		ORM::field('datetime'),
		);
		
		
		$this->ts_fields = array('modified_on','[created_on');

	}
}
