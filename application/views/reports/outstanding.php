<?php 	// this report lists all outstanding assignments grouped by month and year
if(is_null($courseworks) or empty($courseworks)) {
?>
<div class="notice">There is no more coursework to finish!</div>
<?php 
} else { 
	$current_year = 0;
	$last_year = 0;
	$current_month = '';
	$last_month = '';
?>
<h1 class="fancy">Outstanding Coursework Report</h1>
<p>
	This report shows upcoming coursework that you haven't yet submitte
</p>
<table>
	<tr>
		<th>Due Date</th>
		<th>Name</th>
		<th>Subject</th>
		<th>Weighting</th>
		<th>Status</th>
	</tr>
<?php 
	foreach($courseworks as $cw): 
		$current_month = date('F', mktime(0,0,0,substr($cw->due_date,5,2)));
		$current_year = substr($cw->due_date,0,4);
		
		if ($current_year != $last_year || $current_month != $last_month)
		{
?>
	<tr class="subheading">
		<td colspan="5"><?php echo date('F',mktime(0,0,0,substr($cw->due_date,5,2))) . ", " . substr($cw->due_date,0,4); ?></td>
	</tr>
<?php } ?>
	<tr>
		<td><?php echo $cw->due_date; ?></td>
		<td><?php echo anchor('coursework/view/'.$cw->id, $cw->title); ?></td>
		<td><?php echo anchor('subject/view/'.$cw->subject()->id, $cw->subject()->code . " - " . $cw->subject()->title); ?></td>
		<td><?php echo $cw->weighting; ?>%</td>
		<td><?php echo $cw->status()->title; ?></td>
	</tr>
	
<?php
		$last_month = $current_month;
		$last_year = $current_year;

	endforeach;
?>
</table>

<p>Retrieved <?php echo strftime("%Y-%m-%d %H:%M"); ?></p>

<?php } ?>
