<div class="span-12">
	<h5 class="fancy">Score Distribution</h5>
</div>
<div class="span-12 last">
	<h5 class="fancy">Coursework Weighting</h5>
</div>

<div id="plot_left" class="span-12" style="height:200px;">&nbsp;</div>
<div id="plot_right" class="span-12 last" style="height:200px;">&nbsp;</div>

<div id="plot_left_value" class="span-12">&nbsp;</div>
<div id="plot_right_value" class="span-12 last">&nbsp;</div>

<script>
	
	var scores = [];
	var weights = [];
	
	<?php $i = 0; ?>
	<?php foreach($courseworks as $cw) : ?>	
	scores[<?php echo $i; ?>] = { label: '<?php echo anchor('coursework/view/'.$cw->id,substr($cw->title,0,10)); ?>', data: <?php echo $cw->score; ?> }
	weights[<?php echo $i; ?>] = { label: 'WEIGHT: <?php echo anchor('coursework/view/'.$cw->id,substr($cw->title,0,10)); ?>', data: <?php echo $cw->weighting; ?> }
		<?php $i++; ?>
	<?php endforeach; ?>
		
	$.plot($("#plot_left"), scores,
	{
		series: {
			pie: { show: true }
		},
		grid: { hoverable: true }
	});
	$("#plot_left").bind("plothover", pieHover);
	
	$.plot($("#plot_right"), weights,
	{
		series: {
			pie: { show: true }
		},
		grid: { hoverable: true }
	});
	$("#plot_right").bind("plothover", pieHover);
	
	function pieHover(event, pos, obj) 
	{
		if (!obj) return;
		percent = parseFloat(obj.series.percent).toFixed(2);
		$('#'+$(this).attr('id')+"_value").html('<span style="font-weight: bold; color: '+obj.series.color+'">'+obj.series.label+' ('+percent+'%)</span>');
	}
</script>
