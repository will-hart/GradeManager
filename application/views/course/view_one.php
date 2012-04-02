
<div class="span-23 info last">
	<?php echo anchor('dashboard','<< Back to Dashboard'); ?> |
	<?php echo anchor('profile','<< Back to Your Profile'); ?> |
	<?php echo anchor('template/share_course/'.$course->id,'Share Course Template'); ?> | 
	<?php echo anchor('course/edit/'.$course->id,'EDIT'); ?> | 
	<?php echo anchor('course/delete/'.$course->id,'DELETE'); ?>
</div>

<div class="span-24 last">
	<h2 class="fancy"><?php echo $course->title; ?></h1>
	<?php echo anchor('course/set_default/'.$course->id,'Set as Default Course'); ?>
</div>
