<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=1024" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<title>Welcome to Grade Manager by William Hart</title>
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
			<!--
			Each step of the presentation should be an element inside the `#impress` with a class name
			of `step`. These step elements are positioned, rotated and scaled by impress.js, and
			the 'camera' shows them on each step of the presentation. Positioning information is passed through data attributes.
			-->
			
			<div id="intro" class="step" data-x="0" data-y="0" data-z="-3000">
				<h1>G<span class="make_smaller">RADE</span> M<span class="make_smaller">ANAGER</span></h1>
				<p>is a <span class="green">free</span> online tool</p>
				<p>for students and teachers</p>
				<p class="small right">(use the arrow keys to find out more)</small>
			</div>
			
			<div id="track" class="step" data-x="0" data-y="600" data-z="0" data-rotate="180">
				<p>
					<img style="float: left; padding-right: 15px; margin-top: 10px;" src="<?php echo base_url(); ?>assets/images/graph_sample.png" />
					track your <br>assessments, <br>and your grades
				</p>
			</div>
			
			<div id="notify" class="step" data-x="-1000" data-y="0" data-z="3000" data-rotate-z="90">
				get notified when something is due
			</div>
			
			<div id="borrow" class="step" data-x="0" data-y="0" data-z="2700" data-rotate-y="-45" data-rotate-z="90">
				<p>make your own course, <br>or download a template</p>
			</div>
			
			<div id="web" class="step" data-x="1500" data-y="1500" data-z="4000" data-rotate-x="90" data-rotate-z="90">
				<img style="float:left; padding-right: 15px;" src="<?php echo base_url(); ?>assets/images/www_splash.png" />
				100% free, web based
			</div>
			
			<div id="join" class="step round_border" data-x="1000" data-y="5000" data-z="2000" data-rotate-x="90" data-rotate-z="90">
				<p><?php echo anchor('login','login'); ?> or <?php echo anchor('register','register'); ?> now!</p>
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