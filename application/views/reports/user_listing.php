<h1 class="fancy">Registered Users</h1>

<table>
	<tr>
		<th>User ID</th>
		<th>User Name</th>
		<th>Date Registered</th>
		<th>Last Login</th>
	</tr>
	
	<?php foreach($users as $u) : ?>
	<tr>
		<td><?php echo $u->id; ?></td>
		<td><?php echo $u->username; ?></td>
		<td><?php echo $u->registration_token_date; ?></td>
		<td><?php echo "N/A"; ?></td>
	</tr>
	<?php endforeach; ?>

</table>
