<?php
	echo form_open('coursework/enter_score/'.$this->uri->segment(3));
?>

	<fieldset>
		<p>Enter a score for this assessment.  This should be a percentage from 0 to 100 in whole numbers.  Do not include the % sign.</p>
		<label for="score">Coursework Score</label><br/>
		<input type="text" name="score" id="score" value="<?php echo $score; ?>" /><br />
		<input type="submit" name="submit" value="submit" />
	</fieldset>
<?php echo form_close(); ?> 
