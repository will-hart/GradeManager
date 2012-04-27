<?php

$basepath = "http://".str_replace('/index.php','', $_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']);
$error_type = "Page not found";
$error_message = <<<CODE

	<div class="span-16">
		<img src="$basepath/assets/images/GradeKeepShieldKnight" alt=""/></div>

		<div class="span-8 last">
			<h1>None Shall Pass!!</h1>
			<p>
				You have attempted to click on a link that doesn't exist!
			</p>
			<p>
				Click back and try again and if all else fails report an issue on 
				the support forum linked in the footer.  To help out, paste in a
				brief description of what you were doing before the error occured 
				and then add the "techy stuff" in your support post.
			</p>
			<p class="notice">
				The Techy stuff: <br> 
				<span class="fancy">
					A 404 error occurred trying to access <br>
CODE;
$error_message .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $_SERVER['REQUEST_URI'];
$error_message .= <<<CODE
				</span>
			</p>
		</div>
CODE;

include_once('error_template.php');
