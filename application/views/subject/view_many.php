<div class="span-24 last">

	<h2 class="fancy">Your Subjects</h2>

	<table>
		<thead>
			<tr>
				<th>Code</th>
				<th>Name</th>
				<th>Operations</th>
			</tr>
		</thead>
		<tbody>
	<?php foreach($subjects as $subj) : ?>

			<tr>
				<td><?php echo anchor('subject/view/'.$subj->id,$subj->code); ?></td>
				<td><?php echo anchor('subject/view/'.$subj->id,$subj->title); ?></td>
				<td>
					<?php echo anchor('subject/edit/'.$subj->id,'EDIT'); ?> | 
					<?php echo anchor('subject/delete/'.$subj->id,'DELETE'); ?>
				</td>
			</tr>
	<?php endforeach; ?>
		</tbody>
	</table>
</div>
