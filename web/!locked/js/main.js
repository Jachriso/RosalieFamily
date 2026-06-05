///**********************************/
/*          INIT VARS             */
/**********************************/
Array.prototype.in_array = function(p_val) {
    var l = this.length;
    for(var i = 0; i < l; i++) {
        if(this[i] == p_val) {
            return true;
        }
    }
    return false;
}

if (!Array.prototype.indexOf)
{
  Array.prototype.indexOf = function(elt /*, from*/)
  {
    var len = this.length;

    var from = Number(arguments[1]) || 0;
    from = (from < 0)
         ? Math.ceil(from)
         : Math.floor(from);
    if (from < 0)
      from += len;

    for (; from < len; from++)
    {
      if (from in this &&
          this[from] === elt)
        return from;
    }
    return -1;
  };
}
Array.prototype.unset = function(val){
	var index = this.indexOf(val)
	if(index > -1){
		this.splice(index,1)
	}
}

function sendSenderForm()
{
	$("#send-block").css({'display':'none'});
	$("#submit_img").css({'display':'block'});
	$.ajax(
	{
		type:"POST",
		url: sDomain + sLang + '/send_to_friend/',
		data:{ 
		
			form_uri: $("#form_uri").val(),
			form_email_sender: $("#form_email_sender").val(),
			form_email_receiver: $("#form_email_receiver").val(),
			form_comment: $("#form_comment").val()
		
		},
		context: document.body
	
	}).done(function(data) 
	{ 
	
		var response = eval('(' + data + ')');
		
		$("#submit_img").css({'display':'none'});
		//$("#email_sender").removeClass('on_error');
		//$("#email_receiver").removeClass('on_error');
		
		if(response.response_code != 0) 
		{
			for(var z in response.response_errors)
			{
				$("#" + z).addClass('on_error');
				$("#" + z).val(response.response_errors[z]);
				$("#" + z).prev('label').addClass('on_error');
			}
			
			$("#send-block").css({'display':'block'});
		}
		else 
		{
			$('#form_result').html(response.response_message);
			setTimeout(hide_overlay,3000);
		}
				
	});	
}
/*******************************/

/*******************************************/
/*       SEND FORGOT PASSWORD FORM         */
/*******************************************/
function sendForgotPassWordForm()
{
	$("#sendForgotPassWord").css({'visibility':'hidden'});
	$("#user_email").css({'visibility':'hidden'});
	$("#submit_img").css({'visibility':'visible'});
	$("#user_email").removeClass('on_error');
	$('#form_result').html('');
	$.ajax(
	{
		type:"POST",
		url: sDomain + sLang + '/forgot_password.html',
		context: document.body,
		data:{user_email: $("#user_email").val()},
	}).done(function(data)
	{
		var response = eval('(' + data + ')');
		$("#submit_img").css({'visibility':'hidden'});
		if(response.response_code != 0)
		{
			for(var z in response.response_errors)
			{
				$("#" + z).addClass('on_error');
			}

			if(response.cta_label != undefined){
				$('.txtcontent').html(response.response_message);
				$('#sendForgotPassWord').html(response.cta_label);
				$('#sendForgotPassWord').data('info',response.cta_link);
				$('#sendForgotPassWord').data('value',response.cta_data);
			  setIFrameHeight();
			  parent.setIFrameHeight();
			}else{
				$("#user_email").css({'visibility':'visible'});
				$('#form_result').html(response.response_message);
			}
			$("#sendForgotPassWord").css({'visibility':'visible'});
		}
		else{
			$('#form_result').html(response.response_message);
			setTimeout(hide_overlay,3000);
		}
		
		//setIFrameHeight();
	});
}

function hide_overlay()
{
	$('#popinModule').removeClass('show');
}
function hideOverlay()
{
	$('.overlay').removeClass('show');
	$(".modal.show").modal('hide');
}
function showOverlay()
{
	$('.overlay').addClass('show');
}
$(document).ready(function() {
	svgInline();

    $("body").delegate(".loaderOn", "click",function(e){
        displayLoadingOn();
    });
    $("body").delegate("#btnforgotpassword", "click",function(e){
        sendForgotPassWordForm();
    });
	
	if($('.autopopin').length > 0){
		$(".autopopin").trigger("click");
	}

	$('#sendForgotPassWord').on('click',function(){
		if($(this).data('info') != ''){
			$("#sendForgotPassWord").css({'visibility':'hidden'});
			$("#submit_img").css({'visibility':'visible'});
			$("#user_email").css({'visibility':'hidden'});
			$.ajax(
			{
				type:"POST",
				url: $(this).data('info'),
				context: document.body,
				data:{user_email: $(this).data('value')},
			}).done(function(data)
			{
				var response = eval('(' + data + ')');
				$("#submit_img").css({'visibility':'hidden'});
				if(response.response_code != 0)
				{
					for(var z in response.response_errors)
					{
						$("#" + z).addClass('on_error');
					}
					$("#sendForgotPassWord").css({'visibility':'visible'});
				}	
				setTimeout(hide_overlay,6000);
				
				$('#form_result').html(response.response_message);
				//setIFrameHeight();
			});
		}else
			sendForgotPassWordForm();
	});

  $("body").delegate("#sendActiv", "click",function(){
		$("#submit_img").css({'visibility':'visible'});
		$("#user_email").css({'visibility':'hidden'});
		$("#sendActiv").css({'visibility':'hidden'});
		$.ajax(
		{
			type:"POST",
			url: $(this).data('info'),
			context: document.body,
			data:{user_email: $(this).data('value')},
		}).done(function(data)
		{
			var response = eval('(' + data + ')');
			$("#submit_img").css({'visibility':'hidden'});
			if(response.response_code != 0)
			{
				for(var z in response.response_errors)
				{
					$("#" + z).addClass('on_error');
				}
			}	
			$("#sendActiv").css({'visibility':'visible'});
			$("#user_email").css({'visibility':'visible'});
			setTimeout(hide_overlay,6000);
			
			$('#form_result').html(response.response_message);
			//setIFrameHeight();
		});
	});
	
});
function svgInline(){
	console.log('svgInline');
	$('img.picto[src$=".svg"]').each(function () {
		var $img = $(this);
		var imgURL = $img.attr('src');
		var attributes = $img.prop("attributes");
		$.get(imgURL, function (data) {
			// Get the SVG tag, ignore the rest
			var $svg = $(data).find('svg');
			// Remove any invalid XML tags
			$svg = $svg.removeAttr('xmlns:a');
			// Loop through IMG attributes and apply on SVG
			$.each(attributes, function () {
				$svg.attr(this.name, this.value);
			});
			// Replace IMG with SVG
			$img.replaceWith($svg);
		}, 'xml');
	});
}
function displayLoading()
{
	setTimeout(function ()
	{

		$("#loader").fadeOut(500);

	}, 500);
}
function displayLoadingOn()
{
	setTimeout(function ()
	{

		$("#loader").fadeIn(500);
    $('.overlayslide').removeClass('active');

	}, 500);
}
function setIFrameHeight(){
	if($('iframe.auto-height').length>0)
	$('iframe.auto-height').each(function(){
		$(this).height(0);
		$(this).height($(this).contents().outerHeight());
	});
	$('iframe.auto-width').each(function(){
		$(this).width(0);
		$(this).width($(this).contents().outerWidth());
	});
	console.log('setIFrameHeight');
}
function showmodal(){
	console.log('showmodal');
		$('.modal').addClass('show');
}

$(window).on('resize', function() {
	setIFrameHeight();
});

$(window).on('load', function() {
	if( bLoader ) 
		displayLoading();
	$('iframe').contents().find('html').addClass('loaded');
	svgInline();
	setTimeout(setIFrameHeight,1000);
	setTimeout(parent.setIFrameHeight,1000);
	
	$('iframe').contents().find('.embedded.fileupload').bind("DOMSubtreeModified",function(){
		setTimeout(function(){
			if($('iframe').contents().find('.slide').length > 0){
				$('iframe').contents().find('#fileupload').hide();
			}
			else $('iframe').contents().find('#fileupload').show();
			//setIFrameHeight();
		}, 50);
	});
});
