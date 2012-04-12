<?php
	// returns the number of days between two php dates
	function dateDiff($start, $end) {
		$start_ts = strtotime($start);
		$end_ts = strtotime($end);
		$diff = $end_ts - $start_ts;
		return round($diff / 86400);
	}
	
	// gets the date N days after the given date
	function addDays($num_days, $from_date)
	{
		return strtotime("+$num_days days", $from_date);
	}
?>
