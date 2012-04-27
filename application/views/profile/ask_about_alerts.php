<h1 class="fancy">Welcome to GradeKeep!</h1>

<p>
	There are a couple of things that you should do to get strated using GradeKeep.
	Firstly, GradeKeep is set up so that it sends you emails from time to time 
	to let you know when you have some coursework due.  
</p>
<p>
	Please click below if you would like to receive email alerts about coursework. 
	(You can always change your mind later in your profile - we'll send you there after you make your choice).
</p>

<p>
	<?php echo anchor('profile/enable_alerts/1','Yes, please alert me when coursework is due'); ?>
</p>
<p>
	<?php echo anchor('profile/enable_alerts','No, I don\'t want any email alerts from GradeKeep'); ?>
</p>
