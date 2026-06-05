CanvasJS.addColorSet("colors",
	[
		"#FF8384",
		"#B3C1E3",
		"#45465D"
	]
);


var chart_line = new CanvasJS.Chart("chartContainer_<?php echo $key;?>", {
	colorSet: "colors",
	title: {
		text: '<?php echo $renderstats->name;?>',
		fontSize: 30
	},
	animationEnabled: true,
	axisX: {
		valueFormatString: "DD/MM/YYYY",
		gridThickness: 0,
		labelAngle: 0,
		labelFontFamily: "Arial",
		labelFontSize: 13,
		labelFontWeight: 400,
		tickLength: 20,
		tickThickness: 0,
		tickColor: "#F0F2F7",
	},
	axisY: {
		gridColor: "#F0F2F7",
		gridThickness: 1,
		labelFontFamily: "Arial",
		labelFontSize: 13,
		labelFontWeight: 400,
		tickLength: 20,
		tickThickness: 0,
		tickColor: "#F0F2F7",
	},
	toolTip: {
		shared: true,
		cornerRadius: 0,
		backgroundColor: "#45465D",
		borderColor: "#45465D",
		fontColor: "white",
		labelFontFamily: "Arial",
		labelFontSize: 13,
		borderThickness: 5,
	},
	theme: "theme2",
	
	legend: {
		verticalAlign: "center",
		horizontalAlign: "right"
	},
	data: [
		<?php foreach($renderstats->output as $output => $group){?>{
				markerSize: 2,
				type: "<?php echo $renderstats->type;?>",
				showInLegend: true,
				lineThickness: 2,
				name: "<?php echo $group['name'];?>",
				dataPoints: [
					<?php foreach($group['stat'] as $stat => $_date){?>{ 
						x: new Date(<?php echo substr($_date['date'],0,4);?>, <?php echo substr($_date['date'],5,2);?>, <?php echo substr($_date['date'],8,2);?>), y: <?php echo $_date['stats'];?> },
					<?php }?>
				]
			},
		<?php }?>                
	],
	legend: {
		cursor: "pointer",
		itemclick: function (e) {
			if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
				e.dataSeries.visible = false;
			}
			else {
				e.dataSeries.visible = true;
			}
			chart_line.render();
		}
	}
});
chart_line.render();
