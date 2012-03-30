<html lang="EN">
	<head>
		<title>Grade Manager by William Hart</title>
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/screen.css" type="text/css" media="screen, projection" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/print.css" type="text/css" media="print" />
		<!--[if IE]>
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ie.css" type="text/css" media="screen, projection" />
		<![endif]-->
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css" type="text/css" media="screen, projection" />
		
	</head>
	<body>
		<div id="nav">Grade Manager</div>
		<div id="subnav">By William Hart</div>
		
		<?php if($this->session->flashdata('error') != "") : ?>
		<div class="error"><?php echo $this->session->flashdata('error'); ?></div>
		<?php endif; ?>
		<?php if($this->session->flashdata('notice') != "") : ?>
		<div class="notice"><?php echo $this->session->flashdata('notice'); ?></div>
		<?php endif; ?>
		<?php if($this->session->flashdata('success') != "") : ?>
		<div class="success"><?php echo $this->session->flashdata('success'); ?></div>
		<?php endif; ?>
		
		
		<div id="container">
			
			<div id="content">
				<?php echo $content; ?>
			</div>
		</div>
	
	</body>
</html>
