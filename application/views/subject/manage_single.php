<div class="span-24 last">
	<?php echo form_open(site_url('subject/add')); ?>
		<fieldset>
			<legend>Add New Subject</legend>
				Subject Code <input type="text" name="code" value="" />
				Subject Title <input type="text" name="title" value="" />
			
				<button type="submit" value="submit" name="submit">Add New</button>
		</fieldset>
	<?php echo form_close(); ?>
</div>


