<h1>Available Reports</h1>

<p>
	Use the following reports to keep track of your progress on your course:
</p>

<ul>
	<li><?php echo anchor('reports/outstanding', 'Outstanding Coursework'); ?>  - coursework that hasn't been handed in yet</li>
	<li><?php echo anchor('reports/not_returned', 'Unmarked Coursework') ; ?> - coursework that has been handed in but not marked and returned</li>
</ul>


<?php 

	// check if the user can view admin reports
	if ($group_id == Model\User::ADMINISTRATOR	) {
?>
<h1>Administrative Reports</h1>

<p>
	Some basic administrative reports to track the application's health
</p>
<ul>
	<li><?php echo anchor('manage/send_alerts','Send email alerts'); ?> - alert users about upcoming coursework</li>
	<li><?php echo anchor('reports/registered_users', 'Registered Users'); ?> - a list of registered users with some key stats</li>
	<li><?php echo anchor('reports/admin_dashboard', 'Admin Dashboard'); ?> - some headline administrative stats</li>
</ul>

<?php } ?> 
