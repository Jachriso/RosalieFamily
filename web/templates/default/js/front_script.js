/*****************************/
/*         INIT VARS         */
/*****************************/
var bLoader  = false;

function posFotter(){
	if($('.wrapper').height() < ($( window ).height() - $( 'footer' ).height() - 40 ))
		$('footer').css('position','absolute').css('bottom','0');
	else
		$('footer').css('position','relative').css('bottom','initial');
}
function removeFileDrop(filename, url, dpzone, multiple, field, callback ){
    $.ajax(
    {
        type:"POST",
        url: url,
        data:{
            name: filename,
            request: 2                   
        },
        context: document.body
    }).done(function(data) 
    { 
        var response = eval('(' + data + ')');
        if(!multiple){
            $(field).val('');
            $(dpzone).removeClass('max-files-reached');
            $(dpzone).removeClass('dz-max-files-reached');
        }
    }); 
}	

function checkMandatory(){
	$('.bloc_on_error').removeClass('bloc_on_error');
	scroll = false;
	if($('#blocForm').find('.mandatoryfield:not(.nonmandatory)').length >0){
		scroll = true;
		$('#blocForm').find('.mandatoryfield:not(.nonmandatory)').each(function(){
			if(($(this).attr('type') == "hidden" || $(this).attr('type') == "text" || $(this).data('type') == "select" || $(this).data('type') == "textarea") && $(this).val() == ""){
																														if($(this).data('linked') != "" && $(this).data('linked') != undefined){
																											            	bvalidator = false;
																											      				$('input[name="'+$(this).data('linked')+'"]').each(function(){
																											            		if($(this).val() != "" || $(this).prop('checked') == true ){
																											            			bvalidator = true;
																											            		}
																											            	});
																											              if(!bvalidator){
																											              	$(this).parents('.blocMandatory').addClass('bloc_on_error');
																											              	$('input[name="'+$(this).data('linked')+'"]').addClass('bloc_on_error');
																											              }
				}else{
					$(this).parents('.blocMandatory').addClass('bloc_on_error');
				}
			}
			else if($(this).attr('type') == "password" && ($(this).val() == "" || ($('#zxcvbn').length > 0 && document.getElementById("zxcvbn").value <4))){
				$(this).parents('.blocMandatory').addClass('bloc_on_error');
			}
			else if($(this).data('type') == "textarea" && $(this).data('min') != "undefined"){   
				_tmp = strip_tags($(this).val());
				if(_tmp.length < $(this).data('min')){
					$(this).parents('.blocMandatory').addClass('bloc_on_error');
				}
			}
			else if($(this).attr('type') == "radio"){
				bvalidator = false;
																											            $('input[name="'+$(this).attr('name')+'"]').each(function(){
																											              if($(this).prop('checked') == true ){
																											              	bvalidator = true;
																											                $('input[name="'+$(this).attr('name')+'"]').parents('.blocMandatory').removeClass('bloc_on_error');
																											              }
																											              if(!bvalidator){
																											              	$(this).parents('.blocMandatory').addClass('bloc_on_error');
																											              }
																											            });
																											              
		    }else if($(this).attr('type') == "number" && $(this).val() == ""){
		        $(this).parents('.blocMandatory').addClass('bloc_on_error');
																											          }else if($(this).attr('type') == "dropzone" && ($(this).val() == "" || $(this).val() == "0")){
																											              $(this).parents('.blocMandatory').addClass('bloc_on_error');
																											          }
																											      });
																											  }
																											  
  if(scroll){
    //$('.nextslide').addClass('ctadisabled');
    var gotoBloc = $('.wrapper .bloc_on_error').eq(0);

    if($('.wrapper .bloc_on_error').length > 0)
    {
        var offset = gotoBloc.offset();
        var offsetDest = offset.top - 100;
        $(window).scrollTop(offsetDest);
        return false;
    }else
        return true;
  }else
        return true;
}
																											
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}

function sendResa()
{
	$(".adherent").hide();
	$("#sendResa").hide();
	
	$.ajax(
	{
		type:"POST",
		url: sDomain + sLang + '/covoiturages/resa_covoiturage.html',
		context: document.body,
		data:{
			ref: $("#ref").val(),
			adherent: $("#adherent").val()
		},
	}).done(function(data)
	{
		var response = eval('(' + data + ')');
		/*if(response.response_code != 0)
		{
			$(".adherent").show();
			$("#sendResa").show();
		}
		else{*/
			$('.form_result').html(response.response_message);
			setTimeout(hide_overlay,3000);
		//}
		setIFrameHeight();
		parent.setIFrameHeight();
		//setIFrameHeight();
	});
}

$(document).ready(function() {

	$('.covoiturage_type').on('change',function(){		
		$('#blocForm').submit();
	})

	$('#covoiturage_type').on('change',function(){	
		if($(this).val() == 1){
			$('.covoiturage_nb_places').show();
			$('.covoiturage_nb_places > div').addClass('blocMandatory');
			$('.covoiturage_nb_places > div').addClass('');
			$('#covoiturage_nb_places').addClass('mandatoryfield');

			$('.covoiturage_adherent').hide();
			$('.covoiturage_adherent .blocMandatory').removeClass('blocMandatory');
			$('.covoiturage_adherent .bloc_on_error').removeClass('bloc_on_error');
			$('#covoiturage_adherent').removeClass('mandatoryfield');

			$('.covoiturage_add_start').hide();
			$('.covoiturage_add_start .blocMandatory').removeClass('blocMandatory');
			$('.covoiturage_add_start .bloc_on_error').removeClass('bloc_on_error');
			$('#covoiturage_add_start').removeClass('mandatoryfield');
		}
		else{
			$('.covoiturage_nb_places').hide();
			$('.covoiturage_nb_places .blocMandatory').removeClass('blocMandatory');
			$('.covoiturage_nb_places .bloc_on_error').removeClass('bloc_on_error');
			$('#covoiturage_nb_places').removeClass('mandatoryfield');

			$('.covoiturage_adherent').show();
			$('.covoiturage_adherent > div').addClass('blocMandatory');
			$('.covoiturage_adherent > div').addClass('');
			$('#covoiturage_adherent').addClass('mandatoryfield');

			$('.covoiturage_add_start').show();
			$('.covoiturage_add_start > div').addClass('blocMandatory');
			$('.covoiturage_add_start > div').addClass('');
			$('#covoiturage_add_start').addClass('mandatoryfield');

		}
	})
	
	if($('#covoiturage_type').val() == 1){
		$('.covoiturage_nb_places').show();
		$('.covoiturage_nb_places > div').addClass('blocMandatory');
		$('.covoiturage_nb_places > div').addClass('');
		$('#covoiturage_nb_places').addClass('mandatoryfield');

		$('.covoiturage_adherent').hide();
		$('.covoiturage_adherent .blocMandatory').removeClass('blocMandatory');
		$('.covoiturage_adherent .bloc_on_error').removeClass('bloc_on_error');
		$('#covoiturage_adherent').removeClass('mandatoryfield');

		$('.covoiturage_add_start').hide();
		$('.covoiturage_add_start .blocMandatory').removeClass('blocMandatory');
		$('.covoiturage_add_start .bloc_on_error').removeClass('bloc_on_error');
		$('#covoiturage_add_start').removeClass('mandatoryfield');
	}
	else{
		$('.covoiturage_nb_places').hide();
			$('.covoiturage_nb_places .blocMandatory').removeClass('blocMandatory');
			$('.covoiturage_nb_places .bloc_on_error').removeClass('bloc_on_error');
			$('#covoiturage_nb_places').removeClass('mandatoryfield');

			$('.covoiturage_adherent').show();
			$('.covoiturage_adherent > div').addClass('blocMandatory');
			$('.covoiturage_adherent > div').addClass('');
			$('#covoiturage_adherent').addClass('mandatoryfield');

			$('.covoiturage_add_start').show();
			$('.covoiturage_add_start > div').addClass('blocMandatory');
			$('.covoiturage_add_start > div').addClass('');
			$('#covoiturage_add_start').addClass('mandatoryfield');
	}

	$('#sendResa').on('click',function(){	
		sendResa();
	})

/**********************************/
/*             CARTO              */
/**********************************/
	if($('#mapid_adresse').length > 0){
	  var formatResult = function (feature, el) {
	    var title = document.createElement("strong");
	    el.appendChild(title);
	    var detailsContainer = document.createElement("small");
	    el.appendChild(detailsContainer);
	    var details = [];
	    title.innerHTML = feature.properties.label || feature.properties.name;
	    var types = {
	      housenumber: "numéro",
	      street: "rue",
	      locality: "lieu-dit",
	      municipality: "commune",
	    };
	    if (types[feature.properties.type]) {
	      var spanType = document.createElement("span");
	      spanType.className = "type";
	      title.appendChild(spanType);
	      spanType.innerHTML = types[feature.properties.type];
	    }
	    if (
	      feature.properties.city &&
	      feature.properties.city !== feature.properties.name
	    ) {
	      details.push(feature.properties.city);
	    }
	    if (feature.properties.context) {
	      details.push(feature.properties.context);
	    }
	    detailsContainer.innerHTML = details.join(",");
	  };
		function myHandler(featureCollection) {
		    if(featureCollection.features.length == 0)
		      $('#mapid_adresse').find("input").val($('#mapid_adresse').find("input").val().substring(0, $('#mapid_adresse').find("input").val().length - 1));
		}
		function onSelected_adresse(feature) {
		    $("#mapid_adresse input").val(feature.properties.name);
		    $("#mapid_adresse input").addClass("fieldcomplited");
		    $("#mapid_adresse input").removeClass("error");
		    $('#_zip').val(feature.properties.postcode);
		    $('#_city').val(feature.properties.city);
		}

	  // URL for API
	  var API_URL = "//api-adresse.data.gouv.fr";
		var container_adresse_ = new Photon.Search({
		    resultsHandler: myHandler,
		    onSelected: onSelected_adresse,
		    placeholder: "",
		    formatResult: formatResult,
		    url: API_URL + "/search/?",
		    feedbackEmail: null,
		    limit:10,
		    minChar:5
		  });
		  $('#mapid_adresse').append(container_adresse_);

		  $('#mapid_adresse input').attr('id','mapid_adresse__photon');
		  $('#mapid_adresse input').addClass('fieldoutline');

		  $("body").delegate("#mapid_adresse input", "input",function(e){
		    if($(this).val() == '')
		      $('#tarification_ln_zip_step_autoC').val($(this).val());
		  });
		  $("body").delegate("#mapid_adresse input", "change",function(e){
		    if($(this).val() == '')
		      $('#tarification_ln_zip_step_autoC').val($(this).val());
		  });
	}
	$('#user_reseau').on('change',function(){
		$.ajax(
		{
	        type:"POST",
	        url: sDomain + sLang + '/ajax/getusers.html',
	        context: document.body,
			data: {
				"user_reseau" : $('#user_reseau').val(),
			},
	    }).done(function(data)
	    {
	        var response = eval('(' + data + ')');
	        if(response.response_code == 0)
	        {
	        	let elt = response.response_data;
	            $('#userlisting select').html('');
	            $('#userlisting select').prepend(elt);
	        }
      	});
	});
	$('#user_reseau').trigger('change');

	$("body").delegate('[data-type=select].mandatoryfield', "change",function(){
		$(this).parents('.blocMandatory').removeClass('bloc_on_error');
	});

																												   
	$('.btnsubmit').on('click', function(e) {
  		e.preventDefault();
      	if(typeof recaptchakey != 'undefined' && recaptchakey){
          	onClickRecaptcha();
      	}else if($(this).hasClass('checkmandatory')){
      		gonext = checkMandatory();
			if(gonext){
				$('#blocForm').submit();
			}else{
				console.log('error');}
      	}else{
        	$('#blocForm').submit();
      	}
  	});

	$('.inputdropzonebtn').on('click', function(){
		$('.inputdropzonebtn').parent().find('.dropzone').trigger('click');
	});
	let customfilename = "";
	if($('.dropzone').length > 0 ){    
		$('.dropzone').each(function(){
			let currentDrop = $(this);
		    Dropzone.autoDiscover = false;
		    var dropzoneOptions = {
		     	dictDefaultMessage: '',
				previewTemplate: document.querySelector('#template-container').innerHTML,
				url: sDomain + 'media_upload/' + currentDrop.data('type') + '?upload' + (currentDrop.data('file') != undefined && currentDrop.data('file') != "" ? '&filename=' + currentDrop.data('file') : '') + (currentDrop.data('date') == true ? '&date=true' : ''),
				method: "POST",
				acceptedFiles: currentDrop.data('files'),
				paramName: "file",
				maxFilesize: 50, // MB
				addRemoveLinks: false,
				maxFiles: currentDrop.data('maxfiles'),
				uploadMultiple: false,
				thumbnailHeight: 120,
  				thumbnailWidth: 120,
				"customvar": $(this).data('linked'),
				timeout: 180000,
				dictRemoveFileConfirmation: "Confirmez-vous la suppression de ce fichier ?", // ask before removing file
				// Language Strings
				dictFileTooBig: "Votre fichier est trop volumineux ({{filesize}}mb). La taille maximale autorisée est de {{maxFilesize}}mb",
				dictInvalidFileType: "Format de fichier invalide.",
				dictCancelUpload: "Annuler",
				dictRemoveFile: "Supprimer",
				dictResponseError: "Une erreur est survenue lors du chargement de votre fichier. Veuillez essayer à nouveau.",
				dictMaxFilesExceeded: "Un seul fichier est autorisé.",
				thumbnail: function(file, dataUrl) {
				    if (file.previewElement) {
				    	file.previewElement.classList.remove("dz-file-preview");
				    	var images = file.previewElement.querySelectorAll("[data-dz-thumbnail]");
				    	for (var i = 0; i < images.length; i++) {
				        	var thumbnailElement = images[i];
				        	thumbnailElement.alt = file.name;
				        	thumbnailElement.src = dataUrl;
				      	}
				      	setTimeout(function() {file.previewElement.classList.add("dz-image-preview");}, 1);
				    }
				},
				renameFile: function (file) {
				    return currentDrop.data('customfilename');
				},
				init: function () {
		        	this.on("success", function (file,data) {
		        		var response = eval('(' + data + ')');
			            $filename = response.response_message;
			            file.previewElement.id = $filename;
			            if($('#'+this.options.customvar).val() == "")
	                    	$('#'+this.options.customvar).val( $filename);
	                  	else
	                    	$('#'+this.options.customvar).val($('#'+this.options.customvar).val() + ','+ $filename);

                  		$('#dropzone_'+this.options.customvar).siblings('.dropmessage').html('');
	                    if(currentDrop.data('callback') != undefined && currentDrop.data('callback') != "" && currentDrop.data('callback') != false){
	                    	$.ajax(
    						{
						        type:"POST",
						        url: sDomain + sLang + '/ajax/' + currentDrop.data('callback') + ".html",
						        context: document.body,
								data: {
									"projet" : currentDrop.data('projet'),
									"value" : currentDrop.data('value'),
									"lot" : currentDrop.data('lot'),
									"doc" : currentDrop.data('doc'),
									"files" : $('#'+this.options.customvar).val(),
								},
						    }).done(function(data)
						    {
						        var response = eval('(' + data + ')');
						        if(response.response_code != 0)
						        {
						            console.log("error");
						        }
						        else{
						            window.location.reload();
						        }
						        displayLoading();
				          	});
	                    }else if(currentDrop.data('callback') != false)
						    window.location.reload();
			        });
			        this.on("error", function (file,data) {
			        	$('#dropzone_'+this.options.customvar).siblings('.dropmessage').html(data);
			        	this.removeFile(file);
			        });
		      	},
		      	removedfile: function(file) {
		        	var name = file.previewElement.id;
		        	if(name == "")
		          		name = file.name;

		        	removeFileDrop(name, sDomain + 'media_upload/' + currentDrop.data('type') + "?uploadremove", "#"+this.options.customvar, false, "", "" );
		        	var _ref;
		        	$('#dropzone_'+this.options.customvar).removeClass('max-files-reached');
		        	$('#dropzone_'+this.options.customvar).removeClass('dz-max-files-reached');
		        	let tmpval = $('#'+this.options.customvar).val();
					tmpval = tmpval.replace(name+",", "");
					tmpval =  tmpval.replace(","+name, "");
					tmpval =  tmpval.replace(name, "");
					$('#'+this.options.customvar).val(tmpval);
		        	return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
		      	}
		    };

		    let myDropzone = new Dropzone('#'+currentDrop.attr('id'), dropzoneOptions);
		});

	    $('.dropzone .defaultremoveDrop').on('click',function(){
	      if ( confirm( "Confirmez-vous la suppression de ce fichier ?" ) ) {
	      	let $this = $(this).parents('.dropzone');
	      	let name = $(this).data("value");
	        removeFileDrop(name, sDomain + 'media_upload/' + $this.data('type') + "?uploadremove", "#"+$this.data('linked'), false, "", $this.data('callback'));
	      	
	      	$this.removeClass('max-files-reached');
	        $this.removeClass('dz-max-files-reached');
	      	$(this).parents('.dz-preview').remove();
	      	let tmpval = name;
			tmpval = tmpval.replace(name+",", "");
			tmpval = tmpval.replace(","+name, "");
			tmpval = tmpval.replace(name, "");
			$('#'+$this.data('linked')).val(tmpval);

			if($this.data('callback') != undefined && $this.data('callback') != "" && $this.data('callback') != false){
	        	$.ajax(
				{
			        type:"POST",
			        url: sDomain + sLang + '/ajax/' + $this.data('callback') + ".html",
			        context: document.body,
					data: {
						"projet" : $this.data('projet'),
						"value" : $this.data('value'),
						"lot" : $this.data('lot'),
						"doc" : $this.data('doc'),
						"files" : tmpval,
					},
			    }).done(function(data)
			    {
			        var response = eval('(' + data + ')');
			        if(response.response_code != 0)
			        {
			            console.log("error");
			        }
			        else{
			            window.location.reload();
			        }
			        displayLoading();
	          	});
	        }
	      } else {
	          // Code à éxécuter si l'utilisateur clique sur "Annuler" 
	      }
	    });
	}
	$('.blocContent').on("click", function(){
		location.href = $(this).data('uri');
	})
	
});
$(window).on('load', function() {
	//$(window).trigger('resize');
});

$(window).on('resize', function() {
	//posFotter();
});