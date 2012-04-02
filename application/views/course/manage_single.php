<?php if (validation_errors()) : ?>
<div class="error"><?php echo validation_errors();?></div>
<?php endif; ?>

<?php
	$title = '';
	if (isset($course) && !is_null($course)) 
	{
		$title = $course->title;
	}
	
	$submit_to = 'course/edit/'.$this->uri->segment(3);
?>

<div class="span-24 last">
	<h2 class="fancy">Edit Subject</h2>	
	<?php echo form_open(site_url($submit_to)); ?>
		<fieldset>
				<div>
					<label for="title">Course Title</label>
					<br>
					<input type="text" id="title" name="title" value="<?php echo $title; ?>" />
				</div>
				<input type="submit" value="Save" name="submit" />
		</fieldset>
	<?php echo form_close(); ?>
</div>


