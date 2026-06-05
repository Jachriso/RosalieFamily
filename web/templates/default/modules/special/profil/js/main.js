/**********************************/
/*               VARS             */
/**********************************/
var zxcvbn_minlength = 12,
    zxcvbn_specialchar = !0,
    zxcvbn_uppercase = !0,
    zxcvbn_strength = 0;
var bLoader  = false;
var API_URL = "//api-adresse.data.gouv.fr";

$(document).ready(function() {
	meter();
    $('.btnType').on('click', function(){
        $('#covoiturage_type').val($(this).data('value'));
        $('#blocForm').submit();
    })
});

$(window).on('load', function() {
	
});
