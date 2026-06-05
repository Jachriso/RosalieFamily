/**********************************/
/*               VARS             */
/**********************************/
let nbAdherents = 0;
let nbTotalAdherents = 0;

$(document).ready(function() {
    nbAdherents = $( ".template_container" ).length - 1;
    nbTotalAdherents = nbAdherents;
    $('#addTpl').on('click',function(){

        let adherent = $( ".template-container" ).clone();
        nbAdherents ++;
        let blocbtnAd = '';
        blocbtnAd = '<button type="button" class="CTA3 CTAOrange margR10 margB10 btnX" data-value="'+nbAdherents+'" id="btn_'+nbAdherents+'">'+nbAdherents+'</button>';
        nbTotalAdherents = nbAdherents;

        $( ".btnX" ).addClass('CTAOrangeOutline').removeClass('CTAOrange');
        $( ".listbtnAdherent" ).append(blocbtnAd);
        
        tpl = adherent.get(0).innerHTML;
        s_adherent = tpl.replaceAll('{X}', nbAdherents);
        s_adherent = s_adherent.replaceAll('nonmandatory', '');
        s_adherent = s_adherent.replaceAll('hide', "");
        $( "#bAdherents" ).append(s_adherent);
        $('#adherents').val(nbAdherents);

        $('.template_container').not( ".template-container_" + nbAdherents).hide();
        $('.template-container_'+nbAdherents).show();
    });

    $("body").delegate('.btnX', "click",function(){
        $('.template_container').not( ".template-container_" + $(this).data('value')).hide();
        $('.template-container_'+$(this).data('value')).show();
        $( ".btnX" ).not('.CTAOrangeOutline').removeClass('CTAOrange').addClass('CTAOrangeOutline');
        $( this ).addClass('CTAOrange').removeClass('CTAOrangeOutline');
    });

    $("body").delegate('.deleteAdherent', "click",function(){
        removeAdherent($(this));
    });

    function removeAdherent($this){
        let current = $this.data('index');
        $("#btn_"+current).remove();
        $this.parents('.template_container').remove();
        $(".btnX:first-child").trigger('click');

        let iCompt = 1;
        $(".btnX").each(function(){
            let currentbtn = $(this).data('value');
            $(this).html(iCompt);
            //$(this).attr('data-value', iCompt);
            //$(".template-container_"+currentbtn).addClass('template-container_'+iCompt).removeClass("template-container_"+currentbtn);
            iCompt++;
        });
        $('#adherents').val((iCompt-1));
    }
});