<?php 
$error_title = "A PHP Error was Encountered";
$error_message = "Severity: $severity<br>";
$error_message .= "Message: $message<br>";
$error_message .= "Filename: $filepath <br>";
$error_message .= "Line Number: $line <br>";

include_once('error_template.php');
