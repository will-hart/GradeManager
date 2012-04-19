<div class="span-24 last">
	<table>
		<thead>
			<tr>
				<th>Title</th>
				<th>Subjects</th>
				<th>Operations</th>
			</tr>
		</thead>
		<tbody>
	<?php foreach($courses as $c) : ?>
			<tr>
				<td>
					<?php 
						if ($c->id === $this->session->userdata('default_course'))
						{
							echo anchor('dashboard',$c->title);
							echo ' (default)';
						}
						else
						{
							echo anchor('course/view/'.$c->id,$c->title);
						}
					?>
				</td>
				<td><?php echo count($c->subject()); ?></td>
				<td>
					<?php echo anchor('course/edit/'.$c->id,'EDIT'); ?> | 
					<?php echo anchor('course/delete/'.$c->id,'DELETE'); ?>  
					<?php 
						if ($c->id !== $this->session->userdata('default_course'))
						{
							echo ' | ' . anchor('course/set_default/'.$c->id, 'Set as default');
						}
						if ($this->session->userdata('default_course') !== FALSE) {
							echo ' | ' . anchor('template/share_course/'.$c->id, 'Share Template'); 
						}
					?>
				</td>
			</tr>
	<?php endforeach; ?>
		</tbody>
	</table>
</div>
