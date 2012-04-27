<div class="info_box">
<h1 class="fancy">There may be fine print!</h1>

<p>
	<br>
	<strong>You have chosen to share a <?php echo $type_name; ?> with the masses.</strong>
</p>
<p>
	If you go ahead the <?php echo $type_name; ?> you have created will be accessible by
	everybody who is registered for GradeKeep.  They will be able to see:
</p>
<ul>
	<li>Your username</li>
	<li>The course / subject / coursework titles</li>
	<li>Coursework weightings</li>
	<li>The year level and school you assign to the template</li>
</ul>
<p>
	They will not be able to see:
</p>
<ul>
	<li>Your email address</li>
	<li>Your scores</li>
</ul>

<p>
	Are you sure you wish to proceed
</p>

<?php echo form_open(site_url("template/share_$type_name/".$this->uri->segment(3))); ?>
	<input type="submit" class="positive" name="share" value="Yes" />, or 
	<?php echo anchor("$type_name/view/".$this->uri->segment(3),'Cancel'); ?>
<?php echo form_close();?>
</div>
