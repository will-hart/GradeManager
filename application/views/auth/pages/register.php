<div id="login">
	<?php 
		$img['src'] = 'assets/images/gm_large_logo.png';
		$img['alt'] = "Grade Boss Logo";
		$img['height'] = '332';
		$img['width'] = '335';
		$img['class'] = 'large_login_logo';
		echo img($img);
	?>

	<form method="post" style="float:right;">
	<?php if(empty($username)) { ?>
	Username:<br />
	<input type="text" name="username" size="50" class="form" value="<?php echo set_value('username'); ?>" /><br /><?php echo form_error('username', '<div class="error">','</div>'); ?><br />
	Password:<br />
	<input type="password" name="password" size="50" class="form" value="<?php echo set_value('password'); ?>" /><?php echo form_error('password', '<div class="error">','</div>'); ?><br /><br />
	Password confirmation:<br />
	<input type="password" name="password_conf" size="50" class="form" value="<?php echo set_value('conf_password'); ?>" /><?php echo form_error('conf_password', '<div class="error">','</div>'); ?><br /><br />
	<?php } ?>
	Email:<br />
	<?php if(empty($username)){ ?>
		<input type="text" name="email" size="50" class="form" value="<?php echo set_value('email'); ?>" /><?php echo form_error('email', '<div class="error">','</div>'); ?><br /><br />
	<?php }else{ ?>
	<input type="text" name="email" size="50" class="form" value="<?php echo set_value('email', $email); ?>" /><?php echo form_error('email', '<div class="error">','</div>'); ?><br /><br />
	
	<?php } if(empty($username)) { ?>
	<input type="submit" value="Register" name="register" />
	<?php } else { ?>
	<input type="submit" value="Update" name="register" />
	<?php } ?>
	</form>
</div>
