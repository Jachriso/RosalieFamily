
        <!-- loader -->
        <div id="loader">
        
            <div id="loader-bg"></div>
            
            <div id="loader-content">
            
                <img src="<?php echo $starter->utils->load_file('interface/ajax-loader.gif', $starter->MEDIA_PATH);?>" alt="<?php echo $starter->_get_lexique('loader',1); ?>" title="<?php echo $starter->_get_lexique('loader',1); ?>" />
                
            </div>
            
        </div>
        <!-- END loader -->
		
        <div class="modal blur-effect" id="popinModule"></div>
        <div class="overlay"></div>

        <!-- wrapper -->
        <div id="wrapper">
        

    <?php  
if(isset($_SESSION['WARNING'])){?>
    <div id="infoLogin" class="hide">
        <div class="popinModal padV20 padH20 popin<?php echo $_SESSION['WARNING']['type'];?>" >
            <h1 class="ftdbb ft32"><?php echo $starter->_get_lexique("Votre enregistrement");?></h1>
            <div class="leftcontent">
            <?php
    if($_SESSION['WARNING']['type'] == 'error'){?>
                <svg class="inline-svg" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;">
                    <path style="fill: black" d="M13.645,4.365c0.283,-0.478 0.797,-0.772 1.353,-0.771c0.556,0 1.07,0.295 1.352,0.774c3.801,6.479 7.478,12.927 11.019,19.34c0.266,0.482 0.259,1.069 -0.018,1.546c-0.277,0.476 -0.783,0.773 -1.335,0.78c-7.346,0.097 -14.69,0.099 -22.032,0.001c-0.551,-0.008 -1.058,-0.304 -1.335,-0.781c-0.277,-0.476 -0.284,-1.063 -0.017,-1.546c3.63,-6.577 7.293,-13.028 11.013,-19.343Zm1.281,15.026c1.017,0 1.842,0.825 1.842,1.842c0,1.016 -0.825,1.842 -1.842,1.842c-1.016,0 -1.841,-0.826 -1.841,-1.842c0,-1.017 0.825,-1.842 1.841,-1.842Zm0.804,-9.388c0.122,0.012 0.239,0.035 0.353,0.078c0.322,0.122 0.585,0.378 0.715,0.697c0.053,0.132 0.08,0.269 0.09,0.411c-0.252,2.238 -0.439,3.304 -0.587,5.379c-0.022,0.315 -0.099,0.448 -0.194,0.629c-0.229,0.436 -0.707,0.701 -1.198,0.666c-0.12,-0.009 -0.239,-0.035 -0.352,-0.078c-0.132,-0.05 -0.255,-0.123 -0.363,-0.214c-0.123,-0.103 -0.226,-0.231 -0.301,-0.374c-0.085,-0.163 -0.126,-0.338 -0.142,-0.521c-0.231,-2.764 -0.58,-5.426 -0.58,-5.426c0,0 0.024,-0.281 0.071,-0.415c0.121,-0.345 0.394,-0.625 0.736,-0.754c0.133,-0.051 0.271,-0.074 0.413,-0.081c0.061,0 1.279,0 1.339,0.003Z" />
                </svg>
<?php }?>
                <div class="message">
                    <p><?php echo implode('.<br /> ',$_SESSION['WARNING']['content']);?></p>
                </div>
            </div>
        </div>
    </div>
    <button data-modal="popinModule" data-info="infoLogin" class="popup-button autopopin" data-mod="<?php echo $_SESSION['WARNING']['type'];?>" style=""></button>
<?php 
}?>
