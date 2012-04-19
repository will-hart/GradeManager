<?php namespace Model;

/* This basic model has been auto-generated by the Gas ORM */

use \Gas\Core;
use \Gas\ORM;

class Template extends ORM {
	
	public $primary_key = 'id';

	function _init()
	{
		
		self::$relationships = array (
			'user'			=> 		ORM::belongs_to('\\Model\\User'), 
		);
		
		
		self::$fields = array(
			'id' 			=> 		ORM::field('auto[10]'),
			'users_id'		=> 		ORM::field('int[10]'),
			'school_name'	=> 		ORM::field('char[255]', array('trim','xss_clean','max_length[255]','required','strip_tags')),
			'course_name'	=> 		ORM::field('char[255]', array('trim','xss_clean','max_length[255]','required','strip_tags')),
			'title'			=> 		ORM::field('char[255]', array('trim','xss_clean','max_length[255]','required','strip_tags')),
			'year_level' 	=> 		ORM::field('int[11]', array('xss_clean','max_length[11]','required','integer')),
			'is_official'	=>		ORM::field('int[1]'),
			'is_course'		=>		ORM::field('int[1]'),
			'template'		=>		ORM::field('string'),
			'created_on' 	=> 		ORM::field('datetime'),
			'modified_on' 	=> 		ORM::Field('datetime'),
		);
		
		
		$this->ts_fields = array('modified_on','[created_on');

	}
}
