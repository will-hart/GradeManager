<div class="span-24 last">
	<?php if (!empty($courseworks) AND $courseworks != NULL) : ?>
	<table>
		<thead>
			<tr>
				<th>Title</th>
				<th>Due Date</th>
				<th>Status</th>
				<th>Score</th>
				<th>Weighting</th>
				<th>Operations</th>
			</tr>
		</thead>
		<tbody>
	<?php foreach($courseworks as $cw) : ?>
			<tr>
				<td><?php echo anchor('coursework/view/'.$cw->id,$cw->title); ?></td>
				<td><?php echo $cw->due_date; ?></td>
				<td><?php echo $cw->status()->title; ?></td>
				<td><?php echo $cw->score; ?>%</td>
				<td><?php echo $cw->weighting; ?>%</td>
				<td>
					<?php echo anchor('coursework/edit/'.$cw->id,'EDIT'); ?> | 
					<?php echo anchor('coursework/delete/'.$cw->id,'DELETE'); ?>
				</td>
			</tr>
	<?php endforeach; ?>
		</tbody>
	</table>
	
	<?php endif; ?>
</div>
