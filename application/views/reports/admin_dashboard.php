<h1 class="fancy"></h1>
<div id="registrations_chart">
	<table>
		<tr>
			<th>Week</th>
			<th>User Registrations</th>
		</tr>
		
		<?php foreach($users as $u) : ?>
		<tr>
			<td><?php echo $u->date_registered; ?></td>
			<td><?php echo $u->users; ?></td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>


<?php 
// build the chart data
$points = '';
$ticks = '';
$i = 0;
$bar_width = 0.35;
$bar_center = 0.4;

foreach($users as $u)
{
	$ticks .= "\n[".($i+$bar_center).", '".$u->date_registered."'],";
	$points .= "\nusers.push([$i,".$u->users."]);";
	$i++;
}
?>
<script type="text/javascript">
	$(function () {
		// generate the dataset
		var users = []; // the mark we have got out of 100 so far
		
		// add some sample data
		<?php echo $points; ?>
		
		// build the data
		var data = [{ data: users, label: "Grades Earned", color: "#40C3DF" }];
		
		var pane = $("#registrations_chart");
		
		// plot the chart
		var plot = $.plot(pane, data);
	});
</script>
