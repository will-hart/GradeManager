<h3 class="fancy">Template Installation</h3>


<p class="notice">
<?php if(isset($course_id)) : ?>
	You successfully installed a new course!
	Do you want to <?php echo anchor('course/set_default/'.$course_id, 'set it as your default course'); ?>, or 
<?php endif; ?>
	<?php echo anchor('dashboard','Continue to dashboard'); ?>
</p>

<h2 class="fancy">Installation Log</h2>
<div class="info_box"><?php echo $install_log; ?></div>

