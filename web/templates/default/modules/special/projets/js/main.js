/**********************************/
/*               VARS             */
/**********************************/
let nbLots = 0;

function sendEmailDoc($this)
{
    displayLoadingOn();
    
    $.ajax(
    {
        type:"POST",
        url: $this.data('uri'),
        context: document.body,
        data:{},
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

$(document).ready(function() {
    $('.addlot').on('click',function(){
        if(currentStep == 1)
            currentStep++;
        else if(currentStep == 3)
            currentStep--;
        showStep(currentStep);
        let lot = $( ".template-lot" ).clone();
        let nbLots = $( ".template_lot" ).length - 1;
      
        tpl = lot.get(0).innerHTML;
        s_lot = tpl.replaceAll('{X}', nbLots);
        s_lot = s_lot.replaceAll('nonmandatory', '');
        s_lot = s_lot.replaceAll('hide', "");
        $( ".bLots" ).append(s_lot);
        nbLots++;
        $('#projet_lot').val(nbLots);
    });

    $("body").delegate('.cloneLot', "click",function(){
        ilot = $(this).parents('.template_lot').data('info');
        if(currentStep == 1)
            currentStep++;
        else if(currentStep == 3)
            currentStep--;
        showStep(currentStep);
        let lot = $( ".template-lot" ).clone();
        let nbLots = $( ".template_lot" ).length - 1;
      
        tpl = lot.get(0).innerHTML;
        s_lot = tpl.replaceAll('{X}', nbLots);
        s_lot = s_lot.replaceAll('nonmandatory', '');
        s_lot = s_lot.replaceAll('hide', "");
        $( ".bLots" ).append(s_lot);

        $('.template-lot_'+nbLots+" .template_lot_title").html($('.template-lot_'+ilot+" .template_lot_title").html() + " copie");
        $('.template-lot_'+nbLots+" #lot_title_"+nbLots).val($('.template-lot_'+ilot+" #lot_title_"+ilot).val() + " copie");
        $('.template-lot_'+nbLots+" #lot_number_"+nbLots).val($('.template-lot_'+ilot+" #lot_number_"+ilot).val());
        $('.template-lot_'+nbLots+" #lot_montant_"+nbLots).val($('.template-lot_'+ilot+" #lot_montant_"+ilot).val());
        $('.template-lot_'+nbLots+" #lot_desc_"+nbLots).val($('.template-lot_'+ilot+" #lot_desc_"+ilot).val());
        $('.template-lot_'+nbLots+" #lot_option_"+nbLots).val($('.template-lot_'+ilot+" #lot_option_"+ilot).val());
        $('.template-lot_'+nbLots+" #lot_mt_date_"+nbLots).val($('.template-lot_'+ilot+" #lot_mt_date_"+ilot).val());
        $('.template-lot_'+nbLots+" #lot_deb_"+nbLots).val($('.template-lot_'+ilot+" #lot_deb_"+ilot).val());
        $('.template-lot_'+nbLots+" #lot_end_"+nbLots).val($('.template-lot_'+ilot+" #lot_end_"+ilot).val());
        $('.template-lot_'+nbLots+" #lot_prorata_"+nbLots+"_1").prop("checked",$('.template-lot_'+ilot+" #lot_prorata_"+ilot+"_1").prop("checked") == true ? true : false  );
        $('.template-lot_'+nbLots+" #lot_prorata_"+nbLots+"_2").prop("checked",$('.template-lot_'+ilot+" #lot_prorata_"+ilot+"_2").prop("checked") == true ? true : false  );
        $('.template-lot_'+nbLots+" #lot_retenue_"+nbLots).val($('.template-lot_'+ilot+" #lot_retenue_"+ilot).val());
        $('.template-lot_'+nbLots+" #lot_presta_"+nbLots).val();

        nbLots++;
        $('#projet_lot').val(nbLots);
    });

    $("body").delegate('.template_lot_title', "click",function(){
        if($(this).parent().next(".template_lot_content").hasClass('active'))
            $(this).parent().next(".template_lot_content").removeClass('active');
        else
            $(this).parent().next(".template_lot_content").addClass('active');
    });

    $("body").delegate('.deleteLot', "click",function(){
        $(this).parents('.template_lot').remove();
    });

    $("body").delegate(".sendEmailDoc", "click",function(e){
        sendEmailDoc($(this));
    });



    $("body").delegate(".btnMT", "click",function(e){
        $('.blocLot').hide();
        $('.blocDocMT').show();
        
    });

    $("body").delegate(".btnlot", "click",function(e){
        if($('#'+$(this).data('index')).css('display') == "block")
            $('#'+$(this).data('index')).hide();
        else
            $('#'+$(this).data('index')).show();
    });
    $("body").delegate(".btndocg", "click",function(e){
        $('.blocLot').hide();
        $('.blocDocG').show();
        
    });
    $("body").delegate(".btndoc", "click",function(e){
        $('.blocLot').hide();
        $('.blocDoc').show();
        
    });
    $("body").delegate(".btnbon", "click",function(e){
        
    });
    $("body").delegate(".btnbp", "click",function(e){
        $('.blocLot').hide();
        $('.blocBP').show();
    });

    $("body").delegate(".bloclottitle", "click",function(e){
        $(this).parent().children('.template_lot_content').css('height','auto');
    });

});