<!DOCTYPE HTML> 
<html>
	<head>
		<title>GradeKeep by William Hart</title>
		
		<meta charset="utf-8" />
		<meta name="author" content="William Hart" />
		<meta name="description" content="Grade Manager is a simple online tool that allows you to track your coursework and to share assessment structure with your students or other students" />
		<meta name="keywords" content="student, coursework, assignment, subject, university, school, grades, marks, scores, GradeKeep">

		<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/datepicker.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/flot/jquery.flot.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/flot/jquery.flot.pie.js"></script>
		
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/screen.css" type="text/css" media="screen, projection" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/print.css" type="text/css" media="print" />
		<!--[if IE]>
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ie.css" type="text/css" media="screen, projection" />
		<![endif]-->
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css" type="text/css" media="screen, projection" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker.css" type="text/css" media="screen, projection" />
		
	</head>
	<body>
		<div id="header"><?php 
			$img['src'] = 'assets/images/gm_header_logo.png';
			$img['class'] = 'logo_image';
			echo img($img);
		?></div>
		<div id="nav">
			
			<?php if ($this->session->userdata('logged_in')) : ?>
				<?php echo anchor('dashboard','Dashboard'); ?> | 
				<?php echo anchor('reports/outstanding', 'Reports'); ?> |
				<?php echo anchor('profile','Profile'); ?> | 
				<?php echo anchor('logout','Logout'); ?> 
				
			<?php else : ?>
				<?php echo anchor('login','Log In'); ?>
				<?php echo anchor('register','Register'); ?>
			<?php endif; ?>
		</div>
		
		
		<div id="container" class="container">
			<?php if($this->session->flashdata('error')) : ?>
			<div class="error span-24 last"><?php echo $this->session->flashdata('error'); ?></div>
			<?php endif; ?>
			<?php if($this->session->flashdata('notice')) : ?>
			<div class="notice span-24 last"><?php echo $this->session->flashdata('notice'); ?></div>
			<?php endif; ?>
			<?php if($this->session->flashdata('success')) : ?>
			<div class="success span-24 last"><?php echo $this->session->flashdata('success'); ?></div>
			<?php endif; ?>
			
			<?php echo $content; ?>
		</div>
		
		<div id="footer">
			<script type="text/javascript"><!-- 
				google_ad_client = "ca-pub-4364768720239253";
				/* Grades Footer */
				google_ad_slot = "1383645669";
				google_ad_width = 728;
				google_ad_height = 90;
			//--></script>
			<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
			</script>
		</div>
	
	</body>
</html>
