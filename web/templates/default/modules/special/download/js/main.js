//init vars
var aCart = new Array();
var iTimer;
var minHeight = 80;
var iPas = 52;
var iCurrentPos = 52;

/**********************************/
/*          SEARCH FORM           */
/**********************************/
function processData(aData){
	var aDownload = aData.response_message.split(',');

	$('#download_list input[type=checkbox]').each(function(){
		if($.inArray($(this).val(), aDownload) != -1) $(this).parent().parent().parent().css('display','block');
		else $(this).parent().parent().parent().css('display','none');
	});
	
}
function searchDownloadForm(oEntiteSearch,oCatSearch,oCountrySearch,oCibleSearch, oCharteSearch)
{
	$('#searchCibleAdd').val(oCibleSearch);
	$('#searchCountryAdd').val(oCountrySearch);
	$('#searchEntiteAdd').val(oEntiteSearch);
	$('#searchCharteAdd').val(oCharteSearch);
	$('#searchCatAdd').val(oCatSearch);
	$('#download_cat_form').submit();
	
}



/***********************************/
/***********************************/

/**********************************/
/*            ADD SEARCH          */
/**********************************/
function addSearchDownloadsForm()
{
	var oCibleSearch = '';
	var oCatSearch = '';
	var oCountrySearch = '';
	var oEntiteSearch = '';
	var oCharteSearch = '';
	$('#download_cat_form').find('input[type=checkbox]').each(function(){
		var checkbox = document.getElementById($(this).attr('id'));
		if($(this).is(':checked'))
		{
			if($(this).hasClass('cible_type')) oCibleSearch = oCibleSearch.concat(','+ $(this).val()) ;
			if($(this).hasClass('cat_type')) {oCatSearch = oCatSearch.concat(','+ $(this).val()) ;}
			if($(this).hasClass('country_type')) {oCountrySearch = oCountrySearch.concat(','+ $(this).val()) ;}
			if($(this).hasClass('entite_type')) {oEntiteSearch = oEntiteSearch.concat(','+ $(this).val()) ;}
			if($(this).hasClass('charte_type')) {oCharteSearch = oCharteSearch.concat(','+ $(this).val()) ;}
		}
	});
	if(oCibleSearch != '') 
	{
		oCibleSearch = oCibleSearch.substr(1);
		oCibleSearch = '[{"index":['+oCibleSearch+']}]';		
	}
	if(oCountrySearch != '') 
	{
		oCountrySearch = oCountrySearch.substr(1);
		oCountrySearch = '[{"index":['+oCountrySearch+']}]';		
	}
	if(oEntiteSearch != '') 
	{
		oEntiteSearch = oEntiteSearch.substr(1);
		oEntiteSearch = '[{"index":['+oEntiteSearch+']}]';		
	}
	if(oCatSearch != '') 
	{
		oCatSearch = oCatSearch.substr(1);
		oCatSearch = '[{"index":['+oCatSearch+']}]';
	}
	if(oCharteSearch != '') 
	{
		oCharteSearch = oCharteSearch.substr(1);
		oCharteSearch = '[{"index":['+oCharteSearch+']}]';
	}
	
	searchDownloadForm(oEntiteSearch,oCatSearch,oCountrySearch,oCibleSearch,oCharteSearch);
}
/***********************************/
/***********************************/

/**********************************/
/*             DOWNLOAD           */
/**********************************/
function downloadAllForm(sType)
{
	var oDownload = '';
	window.parent.$('.list_elem_dl').find('li').each(function(){
		
			oDownload += ','+ $(this).attr('class').substr(5,4) ;
		
	});
	if(oDownload != '') 
	{
		oDownload = oDownload.substr(1);
		oDownload = '[{"index":['+oDownload+']}]';	
		addDownload(oDownload);	
	}	
}
/***********************************/
/***********************************/



/**********************************/
/*            ADD FORM            */
/**********************************/
function addDownloadForm()
{
	var oCart = '';
	$('#download_list input[type=checkbox]').each(function(){
		if($(this).is(':checked'))
		{
			oCart += ','+ $(this).val() ;
		}
	});
	if(oCart != '') 
	{
		oCart = oCart.substr(1);
		oCart = '[{"index":['+oCart+']}]';	
		addDownloadFormComplexe(oCart);
	}
	else
	{
		pContent = '<a href="javascript:hide_overlay();" class="close-desc ico ico-delete">' + sLexique['fermer'] + '</a><div id="overlay_content"><h1>' + sLexique['vide'] + '</h1>';
		
		$('#general-message').addClass('error');
		$('#general-message').html(pContent);
		
		clearTimeout(iTimer);
		iTimer = setTimeout(hide_overlay,3000);
		setDownloadCartBehavior();
		setDownloadsBehavior();
	}
}
/***********************************/
/***********************************/

/**********************************/
/*         DEL ALL FORM           */
/**********************************/
function delAllDownloadForm()
{
	var oCart = '';
	$('#download_list input[type=checkbox]').each(function(){
		if($(this).is(':checked'))
		{
			oCart += ','+ $(this).val() ;
		}
	});
	if(oCart != '')
	{
		oCart = oCart.substr(1);
		/*oCart = '[{"index":['+oCart+']}]';*/
		delDownloadForm('all',oCart);
	}
	else
	{
		pContent = '<a href="javascript:hide_overlay();" class="close-desc ico ico-delete">' + sLexique['fermer'] + '</a><div id="overlay_content"><h1>' + sLexique['no_file'] + '</h1>';
		
		$('#general-message').removeClass('success');
		$('#general-message').addClass('error');
		$('#general-message').html(pContent);
		
		clearTimeout(iTimer);
		iTimer = setTimeout(hide_overlay,3000);
		setDownloadsBehavior();
	}
}
/***********************************/
/***********************************/

/**********************************/
/*************BEHAVIOR*************/
/**********************************/
function setDownloadsBehavior(){
	clearTimeout(iTimer);
	$('#add_all').click(function(){
		freezDownloadCartBehavior();
		freezDownloadsBehavior();
		addDownloadForm();
	});
	$('#del_all').click(function(){
		freezDownloadsBehavior();
		freezDownloadCartBehavior();
		delAllDownloadForm();
	});
	
}
function freezDownloadsBehavior(){
	$('#add_all').unbind('click');
	
	$('#del_all').unbind('click');	
}



$(document).ready(function() {
	//minHeight += $('#left-content').height();
	//$('#container').css('min-height',minHeight);
	
	setDownloadsBehavior();
	
	$('#download_selected').click(function(){
		freezDownloadsBehavior();
		downloadAllForm('selected');
	});
	$('#download_select_all').click(function(){
		freezDownloadsBehavior();
		downloadAllForm('all');
	});
	$('#nbpage').change(function(){
		document.getElementById('viewnbpage').value = $('#nbpage').val();
		document.forms['download_cat_form'].submit();
	})


	$('#form_content h3').on('click',function(){
		
	if($(window).width()<768){
		if($(this).parent().hasClass('open')){
			$(this).parent().removeClass('open');
			$(this).siblings('div').slideUp();
		}
		else {
			$(this).parent().addClass('open');
			$(this).siblings('div').slideDown();
		}
	}
	});

	$('#form_content h4').on('click',function(){

	if($(window).width()<768){
		if($(this).parent().hasClass('open')){
			$(this).parent().removeClass('open');
			$(this).siblings('ul').slideUp();
		}
		else {
			$(this).parent().addClass('open');
			$(this).siblings('ul').slideDown();
		}
	}
	});

	
	/*if($('.bxslider').length>0){
		$('.bxslider').bxSlider({
			pagerCustom: '#bx-pager',
			auto: true
		});
	}*/

	$('div.seemore a').click(function(){
		$('ul#download_list li').each(function(){
			if($(this).index() < iPas + iCurrentPos)
				$(this).show();
		});
		iCurrentPos+=iPas;
		if(iCurrentPos>$('ul#download_list li').length)
			$('div.seemore').hide();
	});

	
});

$(window).load(function() {
	
	
	$('.grid').masonry({
	  // options
		columnWidth: '.grid-item',
		itemSelector: '.grid-item',
		percentPosition: true
	});
	
	minHeight += $('#left-content').height();
	$('#container').css('min-height',minHeight);
	$('.add-delete a').css('pointer-events','initial');
	
	$('#download_list').find('input[type=checkbox]').each(function(){
		var checkbox = document.getElementById($(this).attr('id'));
		var blnEtat = (checkbox.getAttribute('checked') || checkbox.checked ? true : false );
		if(blnEtat) $(this).parent().children('label').css('background','url(/content/interface/login_checkbox-on.png) left 2px no-repeat');
		else $(this).parent().children('label').css('background','url(/content/interface/login_checkbox.png) left 2px no-repeat');
	});
	$("#download_cat_form [type=checkbox]").removeAttr('disabled');
	$("#download_cat_form [type=checkbox]").click(function(){
		addSearchDownloadsForm();
	});
	$( "#download_list [type=checkbox]" ).click(function(){
		var checkbox = document.getElementById($(this).attr('id'));

		if($(this).is(':checked')) {
            checkbox.setAttribute('checked', 'checked');
		}
		else 
		{
			checkbox.removeAttribute('checked');
		}
	});

	$('#download_all').on('click', function() {
		$('#download_list').find('input[type=checkbox]').each(function(){
			var checkbox = document.getElementById($(this).attr('id'));
			var checkboxs = document.getElementById('download_all');
			
			/*if(checkboxs.getAttribute('checked') || checkboxs.checked ) {
				checkbox.setAttribute('checked', 'checked');
			}
			else 
			{
				checkbox.removeAttribute('checked');
			}*/
			var blnEtat = (checkboxs.getAttribute('checked') || checkboxs.checked ? true : false );
			document.getElementById(checkbox.getAttribute("id")).checked=blnEtat;
		});			
	});
	$('.toolbar > div').click(function(){

		var checkbox = document.getElementById($(this).children('input').attr('id'));
		var blnEtat = (checkbox.getAttribute('checked') || checkbox.checked ? false : true );

		document.getElementById(checkbox.getAttribute("id")).checked = blnEtat;
		if(blnEtat) $(this).children('label').css('background','url(/content/interface/login_checkbox-on.png) left 2px no-repeat');
		else $(this).children('label').css('background','url(/content/interface/login_checkbox.png) left 2px no-repeat');
		
		$('#download_list').find('input[type=checkbox]').each(function(){
			var checkbox = document.getElementById($(this).attr('id'));
			//var checkboxs = document.getElementById('download_all');
			
			/*if(checkboxs.getAttribute('checked') || checkboxs.checked ) {
				checkbox.setAttribute('checked', 'checked');
			}
			else 
			{
				checkbox.removeAttribute('checked');
			}*/
			//var blnEtat = (checkboxs.getAttribute('checked') || checkboxs.checked ? true : false );
			document.getElementById(checkbox.getAttribute("id")).checked = blnEtat;
			if(blnEtat) $(this).parent().children('label').css('background','url(/content/interface/login_checkbox-on.png) left 2px no-repeat');
			else $(this).parent().children('label').css('background','url(/content/interface/login_checkbox.png) left 2px no-repeat');
		});			
	});
	
	
	$(' div#form_content > ul > li > div').click(function(){
		var checkbox = document.getElementById($(this).children('input').attr('id'));
		var _blnEtat = (checkbox.getAttribute('checked') || checkbox.checked ? false : true );
		document.getElementById(checkbox.getAttribute("id")).checked = _blnEtat;
		//if(_blnEtat) $(this).children('label').css('background','url(/content/interface/login_checkbox-on.png) left 2px no-repeat');
		//else $(this).children('label').css('background','url(/content/interface/login_checkbox.png) left 2px no-repeat');
		addSearchDownloadsForm();
	});
	
	$('.download_checkbox').click(function(){
		var checkbox = document.getElementById($(this).children('input').attr('id'));
		var _blnEtat = (checkbox.getAttribute('checked') || checkbox.checked ? false : true );
		document.getElementById(checkbox.getAttribute("id")).checked = _blnEtat;
		if(_blnEtat) $(this).children('label').css('background','url(/content/interface/login_checkbox-on.png) left 2px no-repeat');
		else $(this).children('label').css('background','url(/content/interface/login_checkbox.png) left 2px no-repeat');
	});
	$('.input-check').click(function(){
		var checkbox = document.getElementById($(this).children('input').attr('id'));
		var _blnEtat = (checkbox.getAttribute('checked') || checkbox.checked ? false : true );
		document.getElementById(checkbox.getAttribute("id")).checked = _blnEtat;
		if(_blnEtat) $(this).children('label').css('background','url(/content/interface/login_checkbox-on.png) left 2px no-repeat');
		else $(this).children('label').css('background','url(/content/interface/login_checkbox.png) left 2px no-repeat');
	});
	
	
	
});