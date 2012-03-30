<?php if (validation_errors()) : ?>
<div class="error"><?php echo validation_errors();?></div>
<?php endif; ?>

<?php
	$title = '';
	$code = '';
	if (isset($subject) && !is_null($subject)) 
	{
		$title = $subject->title;
		$code = $subject->code;
	}
?>

<div class="span-24 last">
	<?php echo form_open(site_url('subject/create')); ?>
		<fieldset>
			<legend>Add New Subject</legend>
				Subject Code <input type="text" name="code" value="<?php echo $code; ?>" />
				Subject Title <input type="text" name="title" value="<?php echo $title; ?>" />
			
				<button type="submit" value="submit" name="submit">Add New</button>
		</fieldset>
	<?php echo form_close(); ?>
</div>


