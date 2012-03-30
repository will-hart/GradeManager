<div class="span-24 last">
	<table>
		<thead>
			<tr>
				<th>Code</th>
				<th>Name</th>
			</tr>
		</thead>
		<tbody>
	<?php foreach($this->usr->subject() as $subj) : ?>

			<tr>
				<td><?php echo anchor('subject/view/'.$subj->id,$subj->code); ?></td>
				<td><?php echo anchor('subject/view/'.$subj->id,$subj->title); ?></td>
			</tr>
	<?php endforeach; ?>
		</tbody>
	</table>
</div>
