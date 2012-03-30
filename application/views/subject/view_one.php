
<div class="span-24 last">
	<h2 class="fancy"><?php echo $subject->title; ?></h1>
	<p><em><?php echo $subject->code; ?></em></p>
	<blockquote><?php echo $subject->notes; ?></blockquote>
</div>

<div class="span-23 notice last">
	<?php echo anchor('dashboard','<< Back to Dashboard'); ?> |
	<?php echo anchor('subject/edit/'.$subject->id,'EDIT'); ?> | 
	<?php echo anchor('subject/delete/'.$subject->id,'DELETE'); ?>
</div>

<?php echo $coursework_list; ?>
