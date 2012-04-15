<p>
	The link you provided was not valid or there was an error somewhere behind the scenes. Please check your link and try again.
</p>
<p>
	<?php echo if (isset($is_pw_reset) { ?> 
	If you need a new password reset email, <?php echo anchor('manage/forgot_password','you can get one here'); ?>.
	<?php } else { ?>
	If you require a new activation link, then <?php echo anchor('manage/resend_activation','you can get one here'); ?>.
	<?php } ?>
</p>

<p>
Thanks,
<br>
The GradeKeep Team
</p>
