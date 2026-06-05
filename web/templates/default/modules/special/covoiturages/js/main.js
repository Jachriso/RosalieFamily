/**********************************/
/*               VARS             */
/**********************************/

$(document).ready(function() {
    
    $('.btnresa').on('click',function(){
        $('#adherent').val($(this).data('id'));
        $('#ref').val($(this).data('ref'));
        $('#covoiturage_type').val(2);
        $('#blocForm').attr('action', $(this).data('uri'));
        $('#blocForm').submit();
    });

    $('.covoitEnd').on('click',function(){
        $.ajax(
        {
            type:"POST",
            url: sDomain + sLang + '/ajax/confirmcovoit.html',
            data:{
                ref: $(this).data('value'),          
            },
            context: document.body
        }).done(function(data) 
        { 
            

        }); 
    });

    $('#covoiturage_adherent').on('change',function(){
        $.ajax(
        {
            type:"POST",
            url: sDomain + sLang + '/ajax/getassosbyuserusers.html',
            data:{
                adherent: $(this).val(),          
            },
            context: document.body
        }).done(function(data) 
        { 
            var response = eval('(' + data + ')');
            let option = '';
            for (const z in response.response_data) {
                option += '<option value="'+response.response_data[z].association_id+'_1">'+response.response_data[z].association_label+' : '+response.response_data[z].association_address+', '+response.response_data[z].association_zip+', '+response.response_data[z].association_city+'</option>';
                if(response.response_data[z].association_address2 != "")
                    option += '<option value="'+response.response_data[z].association_id+'_2">'+response.response_data[z].association_label+' : '+response.response_data[z].association_address2+', '+response.response_data[z].association_zip2+', '+response.response_data[z].association_city2+'</option>';
            }
            $('#covoiturage_add_end').append(option);
            $('#covoiturage_add_end').trigger('focus');

        }); 
    });
});