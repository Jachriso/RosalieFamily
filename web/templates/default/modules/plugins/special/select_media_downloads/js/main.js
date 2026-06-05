							//init vars
							/*var bidouille = 0;
							function getDownloadItemSpecial (reboot){
								var aItem = new Array;
								if(oItemDownloads != '') aItem = oItemDownloads.split(',');
								$('.clickitem input[type=checkbox]').each(function(){
									if($(this).is(':checked') && !aItem.in_array($(this).val())) 
										oItemDownloads += ','+ $(this).val() ;

									else if(!$(this).is(':checked') && aItem.in_array($(this).val())){
										aItem.unset($(this).val());
										_oItemDownloads = oItemDownloads.split(',');
										_oItemDownloads.unset($(this).val());
										oItemDownloads = _oItemDownloads.join(',');
									}
								});

								if(aItem.length == 0) oItemDownloads = oItemDownloads.substr(1);
								console.log(oItemDownloads);
								if(oItemDownloads != '') {
									document.getElementById('data').value = ('{"downloadsId":['+oItemDownloads+']}');
									parent.SetField('tree_downloads','{"downloadsId":['+oItemDownloads+']}');
								}
								else {
									document.getElementById('data').value = '';
									parent.SetField('tree_downloads','');
								}
								if(reboot)
									parent.jQuery.fancybox.getInstance().close(); 

							}


							$(window).on('load',function() {
								$('#download_submit').click(function(){
									getDownloadItemSpecial('true');
								});
								
							});
							function pagination(uri){
								getDownloadItemSpecial(0);
								var s_search = document.getElementById('search_download').value;
								var _oItemDownloads = '';
								if(oItemDownloads != '')
								{
									_oItemDownloads = '{"downloadsId":['+oItemDownloads+']}';
									window.location.href = uri + '&search_download=' + s_search + '&data=' + _oItemDownloads;
								}else window.location.href = uri + '&search_download=' + s_search;
							}*/

function addDownload(elt){
	var counter = Number($( ".compteur" ).data( "info" ));
	elt.addClass('active');
	counter++;
	var download = elt.clone();
	$( ".fileListing" ).prepend(download);
	updateCounter(counter);
}
function deleteDownload(elt){
	var counter = Number($( ".compteur" ).data( "info" ));
	var eltTodel = elt.data('id');
	$('.listcontainer.'+ eltTodel ).removeClass('active');
	counter--;
	$( ".fileListing .listcontainer." + eltTodel).remove();
	updateCounter(counter);
}
function updateCounter(counter){	
	$( ".compteur" ).data( "info" , counter);
	$( ".compteur" ).html( counter ) ;
}
$(document).ready(function() {
	$('.closebtn').click(function(){
		console.log('close popin');
	});
	$('.fullListing').on('click', '.listcontainer', function(event) {
		if($(this).hasClass('active')){
			deleteDownload($(this));
		}
		else{
			addDownload($(this));
		}
	});
	$('.fileListing').on('click', '.deleteButton', function(event) {
		deleteDownload($(this).parent());
	});
});