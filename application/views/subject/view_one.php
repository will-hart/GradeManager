
<div class="span-24 last">
	<h2><?php echo $subject->title; ?></h1>
	<p><em><?php echo $subject->code; ?></em></p>
	<blockquote><?php echo $subject->notes; ?></blockquote>
</div>

<div class="span-24 last">
	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>Title</th>
				<th>Due Date</th>
				<th>Status</th>
				<th>Score</th>
				<th>Weighting</th>
				<th>Operations</th>
			</tr>
		</thead>
		<tbody>
	<?php foreach($subject->coursework() as $cw) : ?>
			<tr>
				<td><?php echo anchor('coursework/view/'.$cw->id,$cw->id); ?></td>
				<td><?php echo anchor('coursework/view/'.$cw->id,$cw->title); ?></td>
				<td><?php echo $cw->due_date; ?></td>
				<td><?php echo $cw->status; ?></td>
				<td><?php echo $cw->score; ?></td>
				<td><?php echo $cw->weighting; ?></td>
				<td>
					<?php echo anchor('coursework/edit/'.$cw->id,'EDIT'); ?> | 
					<?php echo anchor('coursework/delete/'.$cw->id,'DELETE'); ?>
				</td>
			</tr>
	<?php endforeach; ?>
		</tbody>
	</table>
</div>
