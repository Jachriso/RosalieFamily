//init vars
var iTimer
var sCart = 'telechargements';
if( sLang == "en") sCart = 'downloads';
/************************************/
/**************DEL CART**************/
/************************************/
function delDownloadForm(iRel, iID){
	$.ajax(
		{
			type:"POST",
			url: sDomain + sLang + '/' + sCart + '/telechargements_del.html',
			context: document.body,
			data:{ 
				cartDel: iID
			}		
		}).done(function(data)
		{ 
		
			var response = eval('(' + data + ')');
			
			if(response.response_code == 0)
			{
				$('#cart-menu a img').animate({marginTop: '-20px'},200, function(){
					$('#cart-menu a img').animate({marginTop: '0px'},{duration: 600, easing: 'easeOutBounce'});
				});
				$(".nb-download").children('span').html(''+response.response_quantity+'');
				var aItems = response.response_item;
				
				for(var i=0;i<aItems.length;i++){

					$("#download_" + aItems[i]['index']).attr('checked',false);
					$("#cart1_" +  aItems[i]['index']).css('display','none');
					$("#cart2_" +  aItems[i]['index']).css('display','');
					$("#cart2_" +  aItems[i]['index']).parents('li').removeClass('in-caddie');
					$(".list_elem_dl .cart_" +  aItems[i]['index']).remove();
					
				}
				if(response.response_quantity > 0)
					$('.recap').html("<span>" + response.response_labelquantity + " : <strong>" + response.response_quantity + "</strong></span><span>" + response.response_labelsize + " : <strong>" + response.response_size + "</strong></span>")	;
				else
					$('.recap').html("<span>" + response.response_labelquantity)	;

				if(response.response_quantity == 0)
					$('#alldl').remove();

			}
			setDownloadCartBehavior();
			setDownloadsBehavior();
										
		});	
}

/**********************************/
/*            DOWNLOAD            */
/**********************************/
function addDownload(oDownload)
{
	$('#file').val(oDownload) ;	
}

/***********************************/
/***********************************/
function reloadPage(){
	window.location.href = sDomain + sLang + '/' + sCart + '/';
}
function reloadCurrent(){
	window.location.reload();
}
function reloadCart(){
	window.location.href = sDomain + sLang + '/' + sCart + '/mes-telechargements.html'
}
/**********************************/
/*            ADD FORM            */
/**********************************/
function addDownloadFormComplexe(oCart)
{
	$.ajax(
	{
		type:"POST",
		url: sDomain + sLang + '/' + sCart + '/telechargements_add.html',
		context: document.body,
		data: {
			cartAdd: oCart		
		}	
	}).done(function(data) 
	{
		var response = eval('(' + data + ')');
		if(response.response_code == 0)
		{
			$('#cart-menu a img').animate({marginTop: '-20px'},200, function(){
				$('#cart-menu a img').animate({marginTop: '0px'},{duration: 600, easing: 'easeOutBounce'});
			});
			$(".nb-download").children('span').html(''+response.response_quantity+'');
			var aItems = response.response_item;
			
			for(var i=0;i<aItems.length;i++){

				$("#download_" + aItems[i]['index']).attr('checked',true);
				$("#cart1_" +  aItems[i]['index']).css('display','');
				$("#cart2_" +  aItems[i]['index']).css('display','none');
				$("#cart2_" +  aItems[i]['index']).parents('li').addClass('in-caddie');
			
				if($('.list_elem_dl').length < 1){
					
					$('.scroll-container').append('<ul class="list_elem_dl"></ul>');
				}
				$('.list_elem_dl').append('<li class="cart_'+aItems[i]['index']+'"><a id="cart_cart1_'+aItems[i]['index']+'" rel="'+aItems[i]['link']+'" href="javascript:void(0);" class="del_cart_caddie" style=" ">supprimer</a><img src="'+aItems[i]['thumb']+'" alt="Titre Test"><span class="name">'+aItems[i]['title']+'</span><br class="clear"></li>');
				$('.recap').html("<span>" + response.response_labelquantity + " : <strong>" + response.response_quantity + "</strong></span><span>" + response.response_labelsize + " : <strong>" + response.response_size + "</strong></span>")	;
				if($('#alldl').length ==0)
					$('.list_elem_dl').after(response.response_link);
				
			}
		}/*else{
			
		}*/
		setDownloadCartBehavior();
		setDownloadsBehavior();
	});	
}
/***********************************/
/***********************************/

/**********************************/
/*            ADD FORM            */
/**********************************/
function donwloadItem(srel)
{
	if($('#usage').val() != ''){
		var pattern = new RegExp('download_zip', 'i');
		if(pattern.test(srel)){
			var oDownload = '';
			window.parent.$('.list_elem_dl').find('li').each(function(){
				
					oDownload += ','+ $(this).attr('class').substr(5,4) ;
				
			});
			if(oDownload != '') 
			{
				oDownload = oDownload.substr(1);
				oDownload = '[{"index":['+oDownload+']}]';	
				$('#file').val(oDownload) ;
			}	
			window.parent.$.fancybox.close();
			$('#sendUsage').submit();
		}
		else{
			window.parent.$.fancybox.close();
			$('#sendUsage').submit();
		}
		$('#usage').removeClass('on_error');
	}
	else{
		$('#usage').addClass('on_error');
	}
}
/***********************************/
/***********************************/


/**********************************/
/*************BEHAVIOR*************/
/**********************************/
function setDownloadCartBehavior(){
	$('.add_cart').click(function(){
		$(this).parents('li').addClass('in-caddie');
		freezDownloadCartBehavior();
		freezDownloadsBehavior();
		var iDelId = $(this).attr('id');
		iDelId = iDelId.substring(6,iDelId.length);
		oCart = '[{"index":['+iDelId+']}]';
		addDownloadFormComplexe(oCart);	
	});
	$('.del_cart').click(function(){
		$(this).parents('li').removeClass('in-caddie');
		freezDownloadCartBehavior();
		freezDownloadsBehavior();
		var iDelId = $(this).attr('id');
		iDelId = iDelId.substring(6,iDelId.length);
		delDownloadForm($(this).attr('rel'),iDelId);
	});
	$('.del_cart_caddie').click(function(){
		freezDownloadCartBehavior();
		freezDownloadsBehavior();
		var iDelId = $(this).attr('id');
		iDelId = iDelId.substring(11,iDelId.length);
		$("ul.download_list li").eq((parseInt(iDelId)-1)).removeClass('in-caddie');
		delDownloadForm($(this).attr('rel'),iDelId);
	});

}
function freezDownloadCartBehavior(){
	$('.add_cart').unbind('click');
	$('.del_cart').unbind('click');
}


$(document).ready(function() {
	setDownloadCartBehavior();
});

$(window).load(function() {
});

