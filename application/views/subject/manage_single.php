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
		$notes = $subject->notes;
	}
	
	$submit_to = '';
	if ($action == 'create' || $action == 'dashboard') $submit_to = 'subject/create';
	if ($action == 'edit') $submit_to = 'subject/edit/'.$this->uri->segment(3);
?>

<div class="span-24 last">
	<h2 class="fancy"><?php echo $action == 'edit' ? 'Edit' : 'Add New'; ?> Subject</h2>	
	<?php echo form_open(site_url($submit_to)); ?>
		<fieldset>
				<div>
					<label for="code">Subject Code</label> 
					<br>
					<input type="text" id="code" name="code" value="<?php echo $code; ?>" />
				</div>
				<div>
					<label for="title">Subject Title</label>
					<br>
					<input type="text" id="title" name="title" value="<?php echo $title; ?>" />
				</div>
				
				<?php if ($action == 'edit'): ?>
				<div>
					<label for="notes">Notes</label>
					<br>
					<textarea id="notes" name="notes" rows="5" cols="30"><?php echo $notes; ?></textarea>
				</div>
				<?php endif; ?>
			
				<input type="submit" value="Save" name="submit" />
		</fieldset>
	<?php echo form_close(); ?>
</div>


