CanvasJS.addColorSet("colors",
	[
		"#FF8384",
		"#B3C1E3",
		"#45465D"
	]
);

var chart_stackedBar = new CanvasJS.Chart("chartContainer_<?php echo $key;?>", {
	colorSet: "colors",
	title: {
		text: '<?php echo $renderstats->name;?>',
		fontSize: 30
	},
	animationEnabled: true,
	axisX: {
		labelFontFamily: "Arial",
		labelFontSize: 13,
		labelFontWeight: 400,
		tickLength: 20,
		tickThickness: 0,
	},
	axisY2: {
		gridColor: "#F0F2F7",
		gridThickness: 1,
		labelFontFamily: "Arial",
		labelFontSize: 13,
		labelFontWeight: 400,
		tickLength: 20,
		tickThickness: 0,
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
		<?php $i_incr = 1;
		foreach($renderstats->output as $output => $group){?>{
				type: "stackedBar",
				showInLegend: true,
				name: "<?php echo $group['name'];?>",
				axisYType: "secondary",
				<?php if($i_incr == count($renderstats->output)){?>
					indexLabel: "#total",
					indexLabelPlacement: "outside",                    
				<?php }?>
				dataPoints: [
					<?php foreach($group['stat'] as $stat => $page){?>{ 
						y: <?php echo $page['stats'];?>, label:"<?php echo $page['name'];?>" },
					<?php }?>
				]
			},
			<?php $i_incr++;
		}?>
	]
});

chart_stackedBar.render();
