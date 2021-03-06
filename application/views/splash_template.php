<!DOCTYPE HTML> 
<html>
	<head>
		<title>GradeKeep by William Hart</title>
		
		<meta charset="utf-8" />
		<meta name="author" content="William Hart" />
		<meta name="description" content="Grade Manager is a simple online tool that allows you to track your coursework and to share assessment structure with your students or other students" />
		<meta name="keywords" content="student, coursework, assignment, subject, university, school, grades, marks, scores, GradeKeep">

		
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>		
		
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/admin.css" type="text/css" media="screen, projection" />
		
	</head>
	<body>
		
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
	
	</body>
</html>
