<p>
	Welcome to GradeKeep!
</p>
<p>
	You recently registered at gradekeep.com. To finalise your registration we just need to confirm your email address.
	You probably know the drill, but to do this just click on the link below or copy/paste it into your browser address bar.
</p>
<p>
	Once you have done this you will be all good to go! 
</p>
<p>
	Here is the link: <br>
	<?php echo anchor('manage/activate_account/'.$token,'ACTIVATE BY CLICKING HERE'); ?>
	<br>
	<?php echo site_url('manage/activate_account/'.$token); ?>
</p>
