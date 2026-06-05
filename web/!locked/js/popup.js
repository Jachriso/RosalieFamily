/**
 ** POPUP by Stratis BAKAS
 */

var overlay = $('.overlay');
var modal;
var close = $('.close');

// fonction qui enleve la class .show de la popup et la fait disparaitre
function removeModal() {
	$('body').removeClass('nooverflow');
	modal.removeClass('show');
	modal.removeClass('fullH');
	modal.removeClass('fullW');
}

// evenement qui appelle la fonction removeModal()
function removeModalHandler() {
	removeModal(); 
}
$("body").delegate(".popup-button", "click",function()
{
	modal = $('#' + $(this).attr('data-modal')); // NOM DE LA MODAL
	var modalLink = $(this).attr('data-link'); // APPEL URL EXTERNE : URL DE L'IFRAME APPELLEE
	var modalContent = $(this).attr('data-info'); // APPEL D'UN CONTENU DANS LA PAGE COURANTE
	var modalHtml = $(this).attr('data-html');
	var modalMod = $(this).attr('data-mod'); // CLASS SPECIFIQUE POUR L'OVERLAY
	var modalClass = $(this).attr('data-class'); // CLASS SPECIFIQUE POUR LA MODAL
	var modalIframeClass = $(this).attr('data-iframeclass'); // CLASS SPECIFIQUE POUR L'IFRAME
	var modalValue = $(this).attr('data-value'); // PARAMETRE A PASSER A LA MODAL
	var modalValue1 = $(this).attr('data-value1'); // PARAMETRE A PASSER A LA MODAL
	var modalValue2 = $(this).attr('data-value2'); // PARAMETRE A PASSER A LA MODAL
	var modalAction = $(this).attr('data-action'); // PARAMETRE A PASSER A LA MODAL
	var modalAction1 = $(this).attr('data-action1'); // PARAMETRE A PASSER A LA MODAL
	var modalAction2 = $(this).attr('data-action2'); // PARAMETRE A PASSER A LA MODAL
	var isoverflow = $(this).attr('data-overflow'); // PARAMETRE A PASSER A LA MODAL
	if(modalClass == undefined)
		modalClass = "auto-width";
	if(modalIframeClass == undefined)
		modalIframeClass = "fullW";
	if(modalValue == undefined)
		modalValue = "";
	if(modalValue1 == undefined)
		modalValue1 = "";
	if(modalValue2 == undefined)
		modalValue2 = "";
	if(modalAction == undefined)
		modalAction = "";
	if(modalAction1 == undefined)
		modalAction1 = "";
	if(modalAction2 == undefined)
		modalAction2 = "";
	if(isoverflow == undefined)
		isoverflow = false;

	//modal.addClass('show');
	
	if(isoverflow)
		$('body').addClass('nooverflow');
	modal.addClass(modalClass);				
	overlay.unbind("click");
	
	if(modalAction != ""){
		$("body").find('div[data-ref="data-action"]').each(function(){
			$(this).hide();
			if($(this).data('action') == modalAction){   
	        	$(this).show();
	        };
        });
	}

	if(modalAction1 != ""){
		$("body").find('div[data-ref="data-action1"]').each(function(){   
			$(this).hide();
			if($(this).data('action1') == modalAction1){
	        	$(this).show();
	        };
        });
	}

	if(modalAction2 != ""){
		$("body").find('div[data-ref="data-action2"]').each(function(){   
			$(this).hide();
			if($(this).data('action2') == modalAction2){
	        	$(this).show();
	        };
        });
	}

	if(modalLink != '' && modalLink != undefined)
		modal.html('<div class="close"></div><iframe name="Mymodal" class="auto-height ' + modalIframeClass + '" vspace="0" hspace="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" scrolling="auto" src="' + modalLink + '" frameborder="0"></iframe>');
	else{
		modal.html('<div class="close"></div>'+$('#' + modalContent).html());
		if(modalValue != ""){
			tpl = modal.get(0).innerHTML;
			tpl = tpl.replaceAll('{DATAVALUE}', modalValue);
			modal.html(tpl);
		}
		if(modalValue1 != ""){
			tpl = modal.get(0).innerHTML;
			tpl = tpl.replaceAll('{DATAVALUE1}', modalValue1);
			modal.html(tpl);
		}
		if(modalValue2 != ""){
			tpl = modal.get(0).innerHTML;
			tpl = tpl.replaceAll('{DATAVALUE2}', modalValue2);
			modal.html(tpl);
		}
	}
	var close1 = $('.closer');
	close1.click(function(event)
	{
		//overlay.removeClass(modalMod);
		event.stopPropagation();
		removeModalHandler();
	});

	// on ajoute sur l'overlay la fonction qui permet de fermer la popup
	overlay.bind("click", removeModalHandler);
	jQuery('.close').click(function(event)
	{
		event.stopPropagation();
		removeModalHandler();
	});
	//setIFrameHeight();
	setTimeout(parent.setIFrameHeight,500);
	setTimeout(parent.showmodal,1000);
});

// en cliquant sur le bouton close on ferme tout et on arrête les fonctions
close.click(function(event)
{
	event.stopPropagation();
	removeModalHandler();
});

// en cliquant sur le bouton close on ferme tout et on arrête les fonctions
$("body").delegate(".close", "click",function()
{
	event.stopPropagation();
	removeModalHandler();
});
