<!-- pdf -->
<div class="box box-element" data-type="pdf">
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
		 <img class="svg" src="<?= $starter->MEDIA_PATH;?>interface/pdf1.png" alt="pdf">
		 <div class="element-desc">PDF</div>
	</div>
	<div class="view">
		<div class="iframe_container">
			<iframe class="responsive-iframe" src="<?php echo $starter->HTTP_ROOT . 'pdf_viewer/oney-poster.pdf';?>" frameborder="0" allowfullscreen data-url=""></iframe>
		</div>
	</div>
</div>