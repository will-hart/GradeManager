<div class="info_box">
<h1 class="fancy">Now hold up just a minute!</h1>

<p class='notice'>
	You have asked to delete a <?php echo $type_name; ?>.<br /><br/>
	If you go ahead this will also delete any linked items (if you delete
	a subject you will also delete all the coursework associated with it!)<br /><br>  
	This action cannot be undone, are you sure you wish to proceed?</p>

<?php echo form_open(site_url($type_url.'/delete/'.$this->uri->segment(3))); ?>
	<input type="submit" class="negative" name="delete" value="Yes" />, or 
	<?php echo anchor('dashboard','Go back to your dashboard'); ?>
<?php echo form_close();?>
</div>