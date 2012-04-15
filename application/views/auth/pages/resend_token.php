
<?php 
	$img['src'] = 'assets/images/gm_large_logo.png';
	$img['alt'] = "Grade Boss Logo";
	$img['height'] = '332';
	$img['width'] = '335';
	$img['class'] = 'large_login_logo';
	echo img($img);
?>
	<div style="padding-top:30px;">
		<form method="POST">
			Email:<br />
			<input type="text" name="email" value="<?php echo set_value('email'); ?>" size="50" /><?php echo form_error('email', '<div class="error">','</div>'); ?><br /><br />
			<input type="submit" value="Resend" name="Resend" />
		</form>
	</div>
