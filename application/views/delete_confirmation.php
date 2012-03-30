<h1>Now hold up just a minute!</h1>

<p>You have asked to delete a <?php echo $type_name; ?>.  This action cannot be undone, are you sure you wish to go ahead?</p>

<?php echo form_open(site_url($type_url.'/delete/'.$this->uri->segment(3))); ?>
	<input type="submit" name="delete" value="Yes" />, or 
	<?php echo anchor('dashboard','Go back to the dashboard'); ?>
<?php echo form_close();
