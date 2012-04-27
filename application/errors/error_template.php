
<!DOCTYPE HTML> 
<html>
	<head>
		<title>GradeKeep by William Hart</title>
		
		<meta charset="utf-8" />
		<meta name="author" content="William Hart" />
		<meta name="description" content="Grade Manager is a simple online tool that allows you to track your coursework and to share assessment structure with your students or other students" />
		<meta name="keywords" content="student, coursework, assignment, subject, university, school, grades, marks, scores, GradeKeep">

		<link rel="stylesheet" href="../assets/css/screen.css" type="text/css" media="screen, projection" />
		<link rel="stylesheet" href="../assets/css/print.css" type="text/css" media="print" />
		<!--[if IE]>
		<link rel="stylesheet" href="../assets/css/ie.css" type="text/css" media="screen, projection" />
		<![endif]-->
		<link rel="stylesheet" href="../assets/css/style.css" type="text/css" media="screen, projection" />
		<link rel="stylesheet" href="../assets/css/datepicker.css" type="text/css" media="screen, projection" />
		
	</head>
	<body>
		<div id="header"><img src="../assets/images/gm_header_logo.png" class="logo_image" alt=""/></div>
		<div id="nav">
			ERROR >> <?php echo $error_type; ?>
		</div>
		
		
		<div id="container" class="container">
			<?php echo $error_message; ?>
		</div>
		
		<div id="footer">		
			<p>GradeKeep 1.0 is open source software by William Hart.  You can find out more by visiting <a href="http://www.williamhart.info/software/gradekeep">http://www.williamhart.info/software/gradekeep</a>.</p>

			If you found GradeKeep useful, please consider supporting it!
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="92UZ5RC7NJUVS">
				<input type="image" src="https://www.paypalobjects.com/en_GB/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal — The safer, easier way to pay online.">
				<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
			</form>
		</div>
	
	</body>
</html>
