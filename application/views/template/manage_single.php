<?php if (validation_errors()) : ?>
<div class="error"><?php echo validation_errors();?></div>
<?php endif; ?>

<?php
	$title = '';
	$school_name = '';
	$course_name = '';
	$year_level = '';
	
	if (isset($template) && !is_null($template)) 
	{
		$title = $template->title;
		$school_name = $template->school_name;
		$course_name = $template->course_name;
		$year_level = $template->year_level;
	}
	
	$submit_to = 'template/edit/'.$this->uri->segment(3);
?>

<div class="span-24 last">
	<h2 class="fancy">Edit Template</h2>	
	<?php echo form_open(site_url($submit_to)); ?>
		<fieldset>
				<div>
					<label for="title">Template Title</label>
					<br>
					<input type="text" id="title" name="title" value="<?php echo $title; ?>" />
				</div>
				<div>
					<label for="school_name">University/College Name</label>
					<br>
					<input type="text" id="school_name" name="school_name" value="<?php echo $school_name; ?>" />
				</div>
				<div>
					<label for="course_name">Course Name</label>
					<br>
					<input type="text" id="course_name" name="course_name" value="<?php echo $course_name; ?>" />
				</div>
				<div>
					<label for="year_level">Year Level</label>
					<br>
					<input type="text" id="year_level" name="year_level" value="<?php echo $year_level; ?>" />
				</div>
				<input type="submit" value="Save" name="submit" />
		</fieldset>
	<?php echo form_close(); ?>
</div>


