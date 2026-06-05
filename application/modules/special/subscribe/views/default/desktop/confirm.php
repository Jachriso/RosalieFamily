<div class="">
	<div class="">
		<form action="<?php echo $starter->HTTP_DOMAIN . ($_SERVER['REDIRECT_URL']); ?>" id="form_authenticate" name="form_authenticate" method="post" class="">
			<div>
				<a href="<?php echo $starter->HTTP_ROOT;?>">
					<img src="<?= $starter->MEDIA_PATH;?>static/logo-fdj.png" alt="" class=""></a>
				<br style="clear:both" />
			</div>
			
			<fieldset>
				<?php  if(isset($_SESSION['WARNING']['type']) == 'error'){?>
					<h2 class=""><?php echo $starter->_get_lexique("Validation de votre compte.");?></h2>
					<div class="">
						<h4 class="">
						<img src="<?= $starter->MEDIA_PATH;?>interface/warning.svg" alt="" class="">
						<?php echo implode(', ',$_SESSION['WARNING']['content']);?></h4>
					</div>
				<?php 
				} 
				else{?>
					<h2 class=""><?php echo $starter->_get_lexique("Votre compte est confirmé.");?></h2>

					<div >
					<a id="send" class="" href="<?php echo $starter->HTTP_ROOT;?>">
						<?php echo $starter->_get_lexique("Connexion");?>
						<svg width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;" id="null" class="icon inline-svg fill-white">
							<rect id="arrow" x="0" y="0" width="30" height="30" style="fill:none;"></rect>
							<path style="fill: black;" d="M17.944,21.805c0.143,0.797 -0.369,1.563 -1.16,1.736c-1.087,0.238 -2.578,0.564 -3.645,0.798c-0.303,0.066 -0.62,-0.021 -0.846,-0.233c-0.226,-0.212 -0.334,-0.522 -0.287,-0.829c0.389,-2.558 1.194,-7.845 1.194,-7.845c0,0 -2.371,0 -3.911,0c-0.248,0 -0.476,-0.139 -0.59,-0.36c-0.113,-0.221 -0.094,-0.487 0.05,-0.69c1.353,-1.893 4.185,-5.858 5.522,-7.73c0.168,-0.235 0.44,-0.375 0.729,-0.375c0.289,0 0.561,0.14 0.729,0.375c1.269,1.777 3.885,5.439 5.304,7.426c0.186,0.261 0.211,0.604 0.065,0.889c-0.147,0.285 -0.441,0.465 -0.762,0.465c-1.521,0 -3.536,0 -3.536,0c0,0 0.74,4.123 1.144,6.373Z"></path>
						</svg>
					</a>
				</div>
				<?php
				}?>
			</fieldset>
		</form>
	</div>
</div>