
<div class="span-24 last">
	<h2 class="fancy"><?php echo $coursework->title; ?></h1>
	<p><em><?php echo $coursework->due_date; ?></em></p>
	<blockquote><?php echo $coursework->notes; ?></blockquote>
</div>

<div class="span-24 notice last">
	<?php echo anchor('subject/view/'.$coursework->subject()->id,'<< Back to Subject');?> | 
	<?php echo anchor('coursework/edit/'.$coursework->id,'EDIT'); ?> | 
	<?php echo anchor('coursework/delete/'.$coursework->id,'DELETE'); ?>
</div>

<div class="span-7 colborder">
	<?php echo $coursework->score; ?>
</div>
<div class="span-7 colborder">
	<?php echo $coursework->weighting; ?>
</div>
<div class="span-7 last">
	<?php echo $coursework->status; ?>
</div>

