<div class="span-23 info last">
	<?php echo anchor('subject/view/'.$coursework->subject()->id,'<< Back to Subject');?> |
	<?php if ($coursework->status_id < Model\Status::HANDED_IN) echo anchor('coursework/hand_in/'.$coursework->id,'Hand In') . " | "; ?>  
	<?php if ($coursework->status_id == Model\Status::HANDED_IN) echo anchor('coursework/enter_score/'.$coursework->id,'Enter Score') . " | "; ?> 
	<?php if ($coursework->status_id == Model\Status::RETURNED) echo anchor('coursework/close/'.$coursework->id,'Close Coursework') . " | "; ?> 
	<?php echo anchor('coursework/edit/'.$coursework->id,'EDIT'); ?> | 
	<?php echo anchor('coursework/delete/'.$coursework->id,'DELETE'); ?>
</div>

<div class="span-24 last">
	<h2 class="fancy"><?php echo $coursework->title; ?></h1>
	<p><em><?php echo $coursework->due_date; ?></em></p>
	<blockquote><?php echo $coursework->notes; ?></blockquote>
</div>

<div class="span-1">&nbsp;</div>
<div class="span-5 info_box">
	<h2 class="center caps">Score</h2>
	<p class="center large"><?php echo $coursework->score; ?>%</p>
</div>
<div class="span-3">&nbsp;</div>
<div class="span-5 info_box">
	<h2 class="center caps">Weighting</h2>
	<p class="center large"><?php echo $coursework->weighting; ?>%</p>
</div>
<div class="span-3">&nbsp;</div>
<div class="span-5 info_box last">
	<h2 class="center caps">Status</h2>
	<p class="center large"><?php echo $coursework->status()->title; ?></p>
</div>

<p>&nbsp;</p>

