<?php

$basepath = "http://".str_replace('/index.php','', $_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']);
$error_type = "Database Error";
$error_message = <<<CODE

	<div class="span-16">
		<img src="$basepath/assets/images/knight_slip.png" alt="Error - Knight falling over" /></div>

		<div class="span-8 last">
			<h1>Oopsie!</h1>
			<p>
				It seemed there was a minor error accessing our library.
				Click back and try again and if all else fails report an issue on 
				the support forum linked in the footer.  
			</p>
			<p>
				To help out if you are posting on the forum, post a brief
				description of what you were doing before the error occured 
				and then add the "techy stuff" below in to your support post.
			</p>
			<p class="notice">
				The Techy stuff: <br> 
				<span class="fancy">
					A database error occurred - <br>
CODE;
$error_message .= str_replace("<p>", "", str_replace("</p>", "<br>", $message));
$error_message .= <<<CODE
				</span>
			</p>
		</div>
CODE;


include_once('error_template.php');
