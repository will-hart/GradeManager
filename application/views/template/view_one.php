
<div class="span-23 info last">
	<?php echo anchor('template','<< Back to Template List'); ?> |
	<?php echo anchor('template/install/'.$template->id,'INSTALL'); ?> | 
	<?php echo anchor('template/edit/'.$template->id,'EDIT'); ?> | 
	<?php echo anchor('template/delete/'.$template->id,'DELETE'); ?>
</div>

<div class="span-24 last">
	<h2 class="fancy"><?php echo $template->title; ?></h1>
	<p><em><?php echo $template->code; ?></em></p>
	<blockquote><?php echo $template->notes; ?></blockquote>
</div>

<div class="span-24 last">
	<h2 class="fancy">Template Objects</h2>
	<ul>
		<?php foreach($objects as $s) { ?>
		<li><?php echo '[' . $s['code'] . '] ' . $s['title']; ?>
			<ul>
				<?php foreach ($s['coursework'] as $c) { ?>
					<li><?php echo $c['title']; ?></li>
				<?php } ?>
			</ul>
		</li>	
		<?php } ?>
	</ul>
</div>
