<?php namespace Model;

/* This basic model has been auto-generated by the Gas ORM */

use \Gas\Core;
use \Gas\ORM;

class User extends ORM {
	
	public $primary_key = 'id';
	public $table = 'users'; // users table to satisfy ag_auth
	
	function _init()
	{
		
		self::$relationships = array (
			'profile'		=>		ORM::has_one('\\Model\\Profile'),
			'course'		=>		ORM::has_many('\\Model\\Course'),
			'subject' 		=> 		ORM::has_many('\\Model\\Subject'),
			'coursework'	=>		ORM::has_many('\\Model\\Coursework'),
		);
		
		self::$fields = array(
			'id' 			=> 		ORM::field('auto[10]'),
			'username' 		=> 		ORM::field('char[255]'),
			'password' 		=> 		ORM::field('char[255]'),
			'group_id' 		=> 		ORM::field('int[11]'),
			'token' 		=> 		ORM::field('varchar[255]'),
			'identifier' 	=> 		ORM::field('varchar[255]'),
		);

	}
}
