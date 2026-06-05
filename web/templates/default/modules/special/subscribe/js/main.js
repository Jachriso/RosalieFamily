/**********************************/
/*               VARS             */
/**********************************/
var zxcvbn_minlength = 12,
    zxcvbn_specialchar = !0,
    zxcvbn_uppercase = !0,
    zxcvbn_strength = 0;
var bLoader  = false;

function zxcvbn(e) {
    var t = new RegExp("^(?=.{12,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g"),
        o = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g"),
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
$(document).ready(function() {
	meter();
    
    if($('.autopopin').length > 0){
        $(".autopopin").trigger("click");
    }
});