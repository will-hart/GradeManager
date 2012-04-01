<?php if (validation_errors()) : ?>
<div class="error"><?php echo validation_errors();?></div>
<?php endif; ?>

<?php
	$first_name = '';
	$last_name = '';
	$default_course = -1;

	if (isset($profile) && !is_null($profile)) 
	{
		$first_name = $profile->first_name;
		$last_name = $profile->last_name;
		$default_course = ($this->session->userdata('default_course') == false) ? -1 : $this->session->userdata('default_course');
	}
	
	// build the status option list
	if (isset($course_list))
	{
		$course_options = array();
		foreach($course_list as $cl)
		{
			$course_options[$cl->id] = $cl->title;
		}
	}
	
	$submit_to = 'profile';
?>

<div class="span-24 last">
	<h2 class="fancy">Manage Profile</h2>
	<?php echo form_open(site_url($submit_to)); ?>
		<fieldset>
				<div>
					<label for="first_name">First Name</label>
					<br>
					<input type="text" id="first_name" name="first_name" value="<?php echo $first_name; ?>" />
				</div>
			
				<div>
					<label for="last_name">Last Name</label>
					<br>
					<input type="text" id="last_name" name="last_name" value="<?php echo $last_name; ?>" />
				</div>
			
				<?php if (!empty($coursework_options)) : ?>
				<div>
					<label for="default_course">Default Course</label>
					<br>
					<?php echo form_dropdown('default_course',$course_options, $default_course); ?>
				</div>
				<?php else : ?>
				<input type="hidden" name="default_course" id="default_course" value="0" />
				<div class="notice">
					You haven't created any courses yet. Do you want to 
					<?php echo anchor('course/create','add one'); ?>?
				</div>
				<?php endif; ?>
			
				<input type="submit" value="Save" name="submit" /> or 
				<?php echo anchor('dashboard', 'Go to dashboard'); ?>
		</fieldset>
	<?php echo form_close(); ?>
</div>

<div class="span-24 last info_box">
	<h2 class="fancy">Danger Zone</h2>
	<p>If you want to close your account and delete all your personal information all you need to do is click the link below.</p>

	<div class="error">
		<p><strong>Warning</strong>, if you do this then all of your data will be deleted and <strong>can not be recovered</strong>.  Please be certain before you proceed.</p>
		<a class="button negative" href="profile/delete/<?php echo $user_id; ?>">Delete your profile</a>
		<p>&nbsp;</p>
	</div>
</div>



