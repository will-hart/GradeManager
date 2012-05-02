<?php 

class MY_CI_Validation extends CI_Validation {

	// call the parent constructor
	public function __construct() {
		$parent::__construct();
	} 


	// check that a date is valid - must be in the format 
	function validdate($str)
	{
	     if ( ereg("([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})", $str) ) {
	        $arr = split("-",$str);     // splitting the array
	        $yy = $arr[0];            // first element of the array is year
	        $mm = $arr[1];            // second element is month
	        $dd = $arr[2];            // third element is days
	        return ( checkdate($mm, $dd, $yy) ); 
	     } else {
	        return FALSE;
	     }
	}
}