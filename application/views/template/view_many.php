<div class="span-24 last">

	<h2 class="fancy">Available Templates</h2>

	<table>
		<thead>
			<tr>
				<th>School</th>
				<th>Course</th>
				<th>Year</th>
				<th>Title</th>
				<th>Operations</th>
			</tr>
		</thead>
		<tbody>
	<?php foreach($templates as $t) : ?>

			<tr>
				<td><?php echo $t->school_name; ?></td>
				<td><?php echo $t->course_name; ?></td>
				<td><?php echo anchor('template/view/'.$t->id,$t->title); ?></td>
				<td><?php echo $t->year_level; ?></td>
				<td><?php echo anchor('template/install/'.$t->id,'Install'); ?></td>
			</tr>
	<?php endforeach; ?>
		</tbody>
	</table>
</div>

