<?php 

$basepath = "http://".str_replace('/index.php','', $_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']);
$error_type = "General Error";
$error_message = "<h1>$heading</h1> <p>$message</p>";

include_once('error_template.php');
