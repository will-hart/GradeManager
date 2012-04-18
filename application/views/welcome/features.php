<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=1024" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<title>Welcome to GradeKeep by William Hart</title>
		<meta name="description" content="Grade Manager is a simple online tool that allows you to track your coursework and to share assessment structure with your students or other students" />
		<meta name="author" content="William Hart" />
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:regular,semibold,italic,italicsemibold|PT+Sans:400,700,400italic,700italic|PT+Serif:400,700,400italic,700italic" rel="stylesheet" />
		<link href="<?php echo base_url(); ?>assets/css/intro.css" rel="stylesheet" />
	</head>

	<body class="impress-not-supported">
		<!-- this fallback message is only visible when there is `impress-not-supported` class on body.	-->
		<div class="fallback-message">
			<p>
				Your browser <b>doesn't support the features required</b> by impress.js, so you are presented with a simplified version of this presentation.
			</p>
			<p>
				For the best experience please use the latest <b>Chrome</b>, <b>Safari</b> or <b>Firefox</b> browser.
			</p>
		</div>
		
		<div id="impress">			
			<div id="intro" class="step">
				<h1 class="app-title">
					G<span class="make_smaller">RADE</span>K<span class="make_smaller">EEP</span>
				</h1>
				<p>is a <span class="green">free</span> grade tracking app made for students and teachers</p>
				<p class="small">(use the arrow keys to find out more, or <?php echo anchor('login','log in now'); ?>)</p>
			</div>
			
			<div id="track" class="step" data-x="2000">
				<p class="app-title">
					K<span class="make_smaller">EEP</span> S<span class="make_smaller">CORE</span>
				</p>
				<p class="app-detail">
					<img style="float:left; padding-right: 15px;" src="<?php echo base_url(); ?>assets/images/graph_sample.png" />
					Record and view your progress so you know exactly how you are going
				</p>
			</div>
			
			<div id="notify" class="step" data-x="4000">
				<p class="app-title">
					G<span class="make_smaller">ET</span> N<span class="make_smaller">OTIFIED</span>
				</p>
				<p class="app-detail">
					<img style="float:left; padding-right: 15px;" src="<?php echo base_url(); ?>assets/images/email_alert.png" />
					Get an email when deadlines are near, or use built in reports to see what is coming up
				</p>
			</div>
			
			<div id="borrow" class="step" data-x="6000">
				<p class="app-title">
					G<span class="make_smaller">ET</span> G<span class="make_smaller">OING</span>
				</p>
				<p class="app-detail">
					Get started fast by installing a ready made course template or make and share your own
				</p>
			</div>
			
			<div id="join" class="step round_border" data-x="8000">
				<p>
					<img style="float:left; padding-right: 15px;" src="<?php echo base_url(); ?>assets/images/gm_large_logo.png" />
					<br>
					<?php echo anchor('login','LOGIN'); ?> <br>
					<img src="<?php echo base_url(); ?>assets/images/splash_separator.png" /><br>
					 <?php echo anchor('register','REGISTER'); ?>
				</p>
			</div>

			<div class="hint">
					Use a spacebar or arrow keys to navigate
			</div>
			<script>
				if("ontouchstart" in document.documentElement) {
					document.querySelector(".hint").innerHTML = "<p>Tap on the left or right to navigate</p>";
				}
			</script>
			
			
			<script src="<?php echo base_url(); ?>assets/js/impress.js"></script>
			<script>
				impress().init();
			</script>
	</body>
</html>
