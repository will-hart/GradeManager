<table style="align:center; width: 600px;" >
<?php foreach($this->usr->subject() as $subj) : ?>
	<tr>
		<th>Code</th>
		<th>Name</th>
	</tr>
	<tr style="height: 50px;">
		<td><?php echo anchor('subject/view/'.$subj->id,$subj->code); ?></td>
		<td><?php echo anchor('subject/view/'.$subj->id,$subj->title); ?></td>
	</tr>
<?php endforeach; ?>
</table>
