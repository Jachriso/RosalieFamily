CanvasJS.addColorSet("colors",
    [
        "#FF8384",
        "#B3C1E3",
        "#45465D"
    ]
);
            var chart_bar = new CanvasJS.Chart("chartContainer_<?php echo $key;?>", {
                title: {
                    text: '<?php echo $renderstats->name;?>',
                    fontSize: 30
                },
                animationEnabled: true,
                data: [
<?php foreach($renderstats->output as $output => $group){?>                
                {
                    type: "<?php echo $renderstats->type;?>",
                    dataPoints: [
<?php foreach($group['stat'] as $stat => $_date){?>
                    { x: 10, y: <?php echo $_date['stats'];?>, label:"<?php echo $group['name'];?>" },
<?php }?>          
                    ]
                },
<?php }?>                
                ],
            });

            chart_bar.render();