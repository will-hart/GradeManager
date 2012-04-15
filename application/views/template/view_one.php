
<div class="span-23 info last">
	<?php echo anchor('template','<< Back to Template List'); ?> |
	<?php echo anchor('template/install/'.$template->id,'INSTALL'); ?> | 
	<?php if ($user_id === $template->users_id) echo anchor('template/edit/'.$template->id,'EDIT'); ?> | 
	<?php echo anchor('template/delete/'.$template->id,'DELETE'); ?>
</div>

<div class="span-24 last">
	<?php if ($template->is_official) {
		$img['src'] = 'assets/images/official_seal.png';
		$img['alt'] = "Official Template";
		$img['style'] = 'float:right;';
		echo img($img);
	} ?>
	
	<h2 class="fancy"><?php echo $template->title; ?></h1>
	
	<p><em><?php echo $template->code; ?></em></p>
	<blockquote><?php echo $template->notes; ?></blockquote>
	<p><?php if ($template->is_course) {
		echo "Course Template";
	}
	else
	{
		echo "Subject Template";
	}?></p>
</div>

<div class="span-24 last">
	<h2 class="fancy">Template Contents</h2>
	<ul>
		<?php foreach($objects as $s) { ?>
		<li><?php echo '<strong>[' . $s['code'] . '] ' . $s['title'] . '</strong>'; ?>
			<ul>
				<?php foreach ($s['coursework'] as $c) { ?>
					<li><?php echo $c['title']; ?></li>
				<?php } ?>
			</ul>
		</li>	
		<?php } ?>
	</ul>
</div>
