
<div class="span-23 info last">
	<?php echo anchor('dashboard','<< Back to Dashboard'); ?> |
	<?php echo anchor('template/share_subject/'.$subject->id,'Share Template'); ?> | 
	<?php echo anchor('subject/edit/'.$subject->id,'EDIT'); ?> | 
	<?php echo anchor('subject/delete/'.$subject->id,'DELETE'); ?>
</div>

<div class="span-24 last">
	<h2 class="fancy"><?php echo $subject->title; ?></h1>
	<p><em><?php echo $subject->code; ?></em></p>
	<blockquote><?php echo $subject->notes; ?></blockquote>
</div>

<?php echo $subject_dashboard; ?>

<?php echo $coursework_list; ?>
