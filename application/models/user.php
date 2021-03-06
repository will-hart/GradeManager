<?php namespace Model;

/* This basic model has been auto-generated by the Gas ORM */

use \Gas\Core;
use \Gas\ORM;

class User extends ORM {
	
	public $primary_key = 'id';
	public $table = 'users'; // users table to satisfy ag_auth
	
	const ADMINISTRATOR = 1;
	const USER = 100;
	
	function _init()
	{
		
		self::$relationships = array (
			'profile'		=>		ORM::has_one('\\Model\\Profile'),
			'course'		=>		ORM::has_many('\\Model\\Course'),
			'subject' 		=> 		ORM::has_many('\\Model\\Subject'),
			'coursework'	=>		ORM::has_many('\\Model\\Coursework'),
		);
		
		self::$fields = array(
			'id' 						=> 		ORM::field('auto[10]'),
			'username' 					=> 		ORM::field('char[255]'),
			'password' 					=> 		ORM::field('char[255]'),
			'group_id' 					=> 		ORM::field('int[11]'),
			'token' 					=> 		ORM::field('varchar[255]'),
			'registration_token'		=> 		ORM::field('varchar[64]'),
			'registration_token_date' 	=>		ORM::field('datetime'),
			'forgot_pass_token'			=>		ORM::field('varchar[64]'),
			'forgot_pass_token_date'	=>		ORM::field('datetime'),
			'identifier' 				=> 		ORM::field('varchar[255]'),
			'last_login'				=>		ORM::field('datetime'),
			'created_on'				=> 		ORM::field('datetime'),
		);
		
		$this->ts_fields = array('[created_on]');

	}
}
