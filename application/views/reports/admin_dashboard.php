<h1 class="fancy">Admin Dashboard Report</h1>

<h2 class="fancy">User Registrations</h2>
<div id="registrations_chart" style="width:600px;height:300px;">
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
$i = 1;
$max_y = 0;

foreach($users as $u)
{
	$ticks .= "\n[". $i .", '".$u->date_registered."'],";
	$points .= "\nusers.push([$i,".$u->users."]);";
	$max_y = ($max_y > $u->users ? $u->users : $max_y);
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
		var data = [{ data: users, label: "Registrations per Month", color: "#40C3DF" }];
		
		var pane = $("#registrations_chart");
		
		// plot the chart
		var plot = $.plot(pane, data, {
				xaxis: { 
					ticks: [ <?php echo $ticks; ?> ], 
					min: 0, 
					max: <?php echo $i; ?>, 
					color: "#000000", 
					tickColor: "#FFFFFF" },
				yaxis: { 
					min: 0
				},
			}
		);
	});
</script>


<p>Retrieved <?php echo strftime("%Y-%m-%d %H:%M"); ?></p>
