$(document).ready(function() {
    $(".activnav").on('click', function (e) {
    	if($(this).hasClass('activ')){
    		$(this).removeClass('activ');
    		$("#subnav").removeClass('activ');
    	}else{
    		$(this).addClass('activ');
    		$("#subnav").addClass('activ');
    	}
    })

    $("#burgerNav").on('click', function (e) {
        if($(this).hasClass('activ')){
            $(this).removeClass('activ');
        }else{
            $(this).addClass('activ');
        }
    })
    
  })
