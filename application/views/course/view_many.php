<div class="span-24 last">
	<?php if(empty($courses) OR $courses == NULL) : ?>
	
	<h2 class="fancy">No courses were found! You may want to add one from your <?php echo anchor('profile','Profile');?></h2>
	
	<?php else : ?>
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
	
	<?php endif; ?>
</div>
