<!DOCTYPE HTML> 
<html>
	<head>
		<title>Grade Manager by William Hart</title>
		
		
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
		<div id="header">Grade Manager</div>
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
		
		<!--<div id="footer">Grade Manager by William Hart</div>-->
	
	</body>
</html>
