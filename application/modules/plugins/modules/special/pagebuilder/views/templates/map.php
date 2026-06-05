<!-- map -->
<div class="box box-element" data-type="map">
	<div class="actions">
		<a href="#close" class="remove">
			<img class="picto" src="<?= $starter->MEDIA_PATH;?>interface/delete.svg" alt="">
		</a>
		<a class="drag">
			<img class="picto" src="<?= $starter->MEDIA_PATH;?>interface/move.svg" alt="">
		</a> 
		<a class="configuration settings" >
			<img class="picto" src="<?= $starter->MEDIA_PATH;?>interface/config.svg" alt="">
		</a>
	</div>

	<div class="preview">
		 <img class="svg" src="<?= $starter->MEDIA_PATH;?>interface/map.svg" alt="map">
		 <div class="element-desc">Map</div>
	</div>
	<div class="view">
		 <iframe class="img-responsive" src="http://maps.google.com/maps?q=12.927923,77.627108&z=15&output=embed"  frameborder="0" allowfullscreen data-url=""></iframe>
	</div>
</div>