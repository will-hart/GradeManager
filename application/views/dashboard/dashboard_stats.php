<h2 class="fancy">Dashboard</h2>

<div  class="span-15 suffix-1">
	<h5 class="fancy">Current Status</h5>
	<div id="chart_pane" style="height:350px;">&nbsp;
	</div>
</div>
<div class="span-8 last">
	<?php if (isset($next_5) && !empty($next_5)) : ?>
	<h5 class="fancy">Next 5 courseworks:</h5>
	<ol>
		<?php foreach($next_5 as $cw) : ?>
		<li>
			<?php echo anchor('coursework/view/'.$cw->id,$cw->title) . "(".
				$cw->due_date . ")"; ?>
		</li>
		<?php endforeach; ?>
	</ol>
	<?php endif; ?>
	<?php echo anchor('reports/outstanding','See All Outstanding'); ?>
</div>

<?php 
// build the chart data
$points = '';
$ticks = '';
$i = 0;
$bar_width = 0.35;
$bar_center = 0.4;

foreach($subjects as $s)
{
	$ticks .= "\n[".($i+$bar_center).", '".anchor('subject/view/'.$s->id,$s->code)."'],";
	$points .= "\nmark.push([$i,".$s->score."]); complete.push([".($i+$bar_center).",".$s->complete."]);";
	$i++;
}
?>
<script type="text/javascript">
	$(function () {
		// generate the dataset
		var mark = []; // the mark we have got out of 100 so far
		var complete = []; // the % of assessment (by weight) complete
		
		// add some sample data
		<?php echo $points; ?>
		
		// build the data
		var data = [{ data: mark, label: "Your Mark", color: "#40C3DF" },
			{ data: complete, label: "Completed", color: "#8A1E1F" }
		];
		
		// set some background markings
		var markings = [
			{ color: '#EEF7EC', yaxis: { from: 70 } },
			{ color: '#FBFAE3', yaxis: { from: 40, to: 70 } },
			{ color: '#FBE4E3', yaxis: { from: 0, to: 40 } },
		];
		
		var pane = $("#chart_pane");
		
		// plot the chart
		var plot = $.plot(pane, data, {
			bars: { show: true, barWidth: <?php echo $bar_width; ?>, fill: 0.7 },
			xaxis: { ticks: [ <?php echo $ticks; ?>
				], min: -0.1, max: <?php echo ($i - 0.1); ?>, color: "#000000", tickColor: "#FFFFFF" },
			yaxis: { min: 0, max:100 },
			grid: { markings: markings, hoverable: true, clickable: false },
		});
		
		function showTooltip(x, y, contents) {
			$('<div id="tooltip">' + contents + '</div>').css( {
				position: 'absolute',
				display: 'none',
				top: y + 5,
				left: x + 5,
				border: '1px solid #fdd',
				padding: '2px',
				'background-color': '#fee',
				opacity: 0.80
			}).appendTo("body").fadeIn(200);
		}

		var previousPoint = null;
		$("#chart_pane").bind("plothover", function (event, pos, item) {
			$("#x").text(pos.x.toFixed(2));
			$("#y").text(pos.y.toFixed(2));

		   if (item) {
				if (previousPoint != item.dataIndex) {
					previousPoint = item.dataIndex;
					
					$("#tooltip").remove();
					var x = item.datapoint[0].toFixed(2),
						y = item.datapoint[1].toFixed(2);
					
					showTooltip(item.pageX, item.pageY,
								item.series.label + " - " + y + "%");
				}
			}
			else {
				$("#tooltip").remove();
				previousPoint = null;            
			}
		});
	});
</script>
