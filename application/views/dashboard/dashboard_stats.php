<h2 class="fancy">Dashboard</h2>

<div class="span-24 border" style="border:2px solid #CCC; height:400px;">
	<p><em>Your dashboard stats (coming soon)</em></p>
	<div id="chart_pane" style="height:350px;">&nbsp;</div>
</div>


<script type="text/javascript">
	$(function () {
		// generate the dataset
		var mark = []; // the mark we have got out of 100 so far
		var complete = []; // the % of assessment (by weight) complete
		
		// add some sample data
		mark.push([0,50]); complete.push([0.4,50]);
		mark.push([1,30]); complete.push([1.4,75]);
		mark.push([2,25]); complete.push([2.4,100]);
		mark.push([3,37]); complete.push([3.4,10]);
		
		// build the data
		var data = [{ data: mark, label: "Your Mark", color: "#40C3DF" },
			{ data: complete, label: "Completed", color: "#8A1E1F" }
		];
		
		// set some background markings
		var markings = [
			{ color: '#EEF7EC', yaxis: { from: 80 } },
			//{ color: '#EDEDED', yaxis: { from: 0, to: 40 } }
		];
		
		var pane = $("#chart_pane");
		
		// plot the chart
		var plot = $.plot(pane, data, {
			bars: { show: true, barWidth: 0.35, fill: 0.7 },
			xaxis: { ticks: [
					[0.4, "Subject 1"],
					[1.4, "Subject 2"],
					[2.4, "Subject 3"],
					[3.4, "Subject 4"]
				], min: -0.1, max: 3.9, color: "#000000", tickColor: "#FFFFFF" },
			yaxis: { min: 0, max:100 },
			grid: { markings: markings, hoverable: true, clickable: false },
			legend: {show: false}
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
