<!-- Youtube -->
<div class="box box-element" data-type="sound">
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
		 <img class="svg" src="<?= $starter->MEDIA_PATH;?>interface/sound.png" alt="sound">
		 <div class="element-desc">Sound</div>
	</div>
	<div class="view">
		<figure>
			<figcaption></figcaption>
			<audio class="blocsound" controls src="">
			</audio>
		</figure>
	</div>
</div>