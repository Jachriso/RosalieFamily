var bLoader  = false;

function zxcvbn(e) {
    var t = new RegExp("^(?=.{12,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g"),
        o = new RegExp("^(?=.{8,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g"),
        n = new RegExp("(?=.{6,}).*", "g"),
        a = new Object;
    return a.score = 0, 0 == e.length ? a.score = 0 : 0 == n.test(e) ? a.score = 1 : t.test(e) ? a.score = 4 : o.test(e) ? a.score = 3 : a.score = 2, a
}

function meter() {
    var e = document.getElementById("password"),
        t = document.getElementById("password-strength-meter");
    e && t && e.addEventListener("input", function() {
        var o = zxcvbn(e.value);
        document.getElementById("zxcvbn").value = o.score, t.setAttribute("data-strength", o.score)
    })
}
function strip_tags(str) {
    str = str.toString();
    return str.replace(/<\/?[^>]+>/gi, '');
}
$(document).ready(function() {
	if($('.autopopin').length > 0){
        $(".autopopin").trigger("click");
    }

    if($('.isAutocomplete').length > 0){
        let autoCompleteUrl = $('.isAutocomplete').data('url');
        $( ".isAutocomplete" ).autocomplete({
            minLength: 0,//search after two characters
            delay:100,
            appendTo: ".blocAutoComplete",
            source: function( request, response ) {
                $.ajax({
                    url: sDomain + sLang + '/ajax/' + autoCompleteUrl +  '.html',
                    context: document.body,
                    type: 'post',
                    dataType: "json",
                    data: $('#blocForm').serialize(),
                    success: function( data ) {
                        response( data.response_data );
                    }
                });
            },
            select: function(event, ui){
                $('#autocompleteField').val(ui.item.user_id);
            }
        }).focus(function(){
            $(this).data("uiAutocomplete").search($(this).val());
        });
    }

    $('form').on('focus', 'input[type=number]', function (e) {
        $(this).on('wheel.disableScroll', function (e) {
          e.preventDefault()
        })
    })

    $('form').on('blur', 'input[type=number]', function (e) {
        $(this).off('wheel.disableScroll')
    })

    $('.btn[data-type="iframe"]').on('click', function (e) {
        e.preventDefault();
        var modal = $($(this).attr('data-bs-target')).find('.modal-body'); // NOM DE LA MODAL
        var modalLink = $(this).attr('data-link');
        modal.html('<iframe name="Mymodal" class="auto-height fullW" vspace="0" hspace="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" scrolling="auto" src="' + modalLink + '" frameborder="0"></iframe>');
    });

    /***************************************************/
    /************       DARK MODE       ****************/
    /***************************************************/
    const body = document.querySelector('body');
    let getMode = localStorage.getItem("mode");
    if(getMode && getMode ==="dark"){
        $('body').addClass("dark");
    }
    let getStatus = localStorage.getItem("status");
    if(getStatus && getStatus ==="close"){
        $('body').addClass("close");
    }

    $('.mode-toggle').on("click", function(){
        if($('body').hasClass("dark")){
            $('body').addClass("close");
            $('body').removeClass("dark");
            localStorage.setItem("mode","light");
        }else {
        $('body').addClass("dark");
            $('body').removeClass("close");
            localStorage.setItem("mode", "dark");
        }
    });  
    $('.reset').on("click", function(){
        document.getElementById("blocForm").reset();
    });
});