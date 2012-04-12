<!DOCTYPE HTML> 
<html>
	<head>
		<title>Grade Manager by William Hart</title>
		
		
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>		
		
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/intro.css" type="text/css" media="screen, projection" />
		
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
