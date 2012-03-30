<?php if (validation_errors()) : ?>
<div class="error"><?php echo validation_errors();?></div>
<?php endif; ?>

<?php
	$title = '';
	$due_date = date('Y-m-d');
	$status = '';
	$notes = '';
	$score = '';
	$weighting = '';
	if (isset($coursework) && !is_null($coursework)) 
	{
		$title = $coursework->title;
		$due_date = $coursework->due_date;
		$status = $coursework->status;
		$notes = $coursework->notes;
		$score = $coursework->score;
		$weighting = $coursework->weighting;
	}
	
	$submit_to = '';
	if ($action == 'create' || $action == 'dashboard' || $action == 'view') $submit_to = 'coursework/create/'.$this->uri->segment(3);
	if ($action == 'edit') $submit_to = 'coursework/edit/'.$this->uri->segment(3);
?>

<script>
	$(document).ready( function() {
		$('#due_date').DatePicker({
			format 			: 	'Y-m-d',
			calendars		:	1,
			starts			: 	1,
			positiion		: 	'r',
			date			: 	$('#due_date').val(),
			current			:	$('#due_date').val(),
			onBeforeShow	: 	function(){
									$('#due_date').DatePickerSetDate($('#due_date').val(), true);
								},
			onChange		: 	function(formated, dates){
									$('#due_date').val(formated);
									$('#due_date').DatePickerHide();
								}
		});
	});
</script>

<div class="span-24 last">
	<?php echo form_open(site_url($submit_to)); ?>
		<fieldset>
			<legend><?php echo $action == 'edit' ? 'Edit' : 'Add New'; ?> Coursework</legend>
				<div>
					<label for="title">Coursework Title</label>
					<br>
					<input type="text" id="title" name="title" value="<?php echo $title; ?>" />
				</div>
				
				<?php if ($action == 'edit'): ?>
				<div>
					<label for="title">Due Date (yyyy-mm-dd)</label>
					<br>
					<input type="text" id="due_date" name="due_date" value="<?php echo $due_date; ?>" />
				</div>
				
				<div>
					<label for="title">Status</label>
					<br>
					<input type="text" id="status" name="status" value="<?php echo $status; ?>" />
				</div>
				
				<div>
					<label for="notes">Notes</label>
					<br>
					<textarea id="notes" name="notes" rows="5" cols="30"><?php echo $notes; ?></textarea>
				</div>
				
				<div>
					<label for="title">Your Score</label>
					<br>
					<input type="text" id="score" name="score" value="<?php echo $score; ?>" />
				</div>
				
				<div>
					<label for="title">Coursework Weighting</label>
					<br>
					<input type="text" id="weighting" name="weighting" value="<?php echo $weighting; ?>" />
				</div>
				<?php endif; ?>
			
				<input type="submit" value="Save" name="submit" /> or 
				<?php if ($action == 'edit') echo anchor('coursework/view/'.$this->uri->segment(3), 'Cancel'); ?>
		</fieldset>
	<?php echo form_close(); ?>
</div>


