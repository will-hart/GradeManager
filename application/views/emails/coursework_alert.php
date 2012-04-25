<p>
	This is just a friendly reminder from GradeKeep, letting you know 
	that you have some coursework due in the next five days.
</p>
<p>
	The coursework that is due soon is for <?php echo $coursework->subject()->title; ?>,
	and is called:
	<blockquote><?php echo $coursework->title ?></blockquote>
</p>
<p>
	You can <?php echo anchor('coursework/view/'.$coursework->id,'click here'); ?>
	to view the coursework at gradekeep.com.
</p>
