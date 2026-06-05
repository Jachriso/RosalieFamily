Array.prototype.in_array = function(p_val) {
    var l = this.length;
    for(var i = 0; i < l; i++) {
        if(this[i] == p_val) {
            return true;
        }
    }
    return false;
}
	function updateSave(){
		var post ;
		var rules_chartesId = new Array();
		var rules_groupId = new Array();
		var rules_treeId = new Array();
		var rules_backId = new Object();
		var _rules_backId = new Array();

		$('#auth_charte').find('input[type=checkbox]').each(function(){
			var checkboxs = document.getElementById($(this).attr('id'));
			blnEtat = (checkboxs.getAttribute('checked') || checkboxs.checked || document.getElementById(checkboxs.getAttribute("id")).checked ? true : false );
			if( blnEtat )
				rules_chartesId.push($(this).val());
		});

		$('#auth_group').find('input[type=checkbox]').each(function(){
			var checkboxs = document.getElementById($(this).attr('id'));
			blnEtat = (checkboxs.getAttribute('checked') || checkboxs.checked || document.getElementById(checkboxs.getAttribute("id")).checked ? true : false );
			if( blnEtat )
				rules_groupId.push($(this).val());
		});

		$('#auth_tree').find('input[type=checkbox]').each(function(){
			var checkboxs = document.getElementById($(this).attr('id'));
			blnEtat = (checkboxs.getAttribute('checked') || checkboxs.checked || document.getElementById(checkboxs.getAttribute("id")).checked ? true : false );
			if( blnEtat )
				rules_treeId.push($(this).val());
		});

		$('#auth_backoffice').find('input[type=checkbox]').each(function(){
			var checkboxs = document.getElementById($(this).attr('id'));
			blnEtat = (checkboxs.getAttribute('checked') || checkboxs.checked || document.getElementById(checkboxs.getAttribute("id")).checked ? true : false );
			if( blnEtat )
			{
				if(!_rules_backId.in_array($(this).attr('data-module') + '_' + $(this).attr('data-config')))
				{
					_rules_backId.push($(this).attr('data-module') + '_' + $(this).attr('data-config'));
					if(!_rules_backId.in_array($(this).attr('data-module')))
					{
						_rules_backId.push($(this).attr('data-module'));
						rules_backId[$(this).attr('data-module')] = new Array();
					}
					rules_backId[$(this).attr('data-module')][$(this).attr('data-config')] = new Array();
				}
				rules_backId[$(this).attr('data-module')][$(this).attr('data-config')].push($(this).val());
			}
			
					
		});
		
		post = '{\\"rules_chartesId\\":' + JSON.stringify(rules_chartesId) + ',\\"rules_groupId\\":' + JSON.stringify(rules_groupId) + ',\\"rules_treeId\\":' + JSON.stringify(rules_treeId) + ',\\"rules_backId\\":' + JSON.stringify(rules_backId) + '}';
		
		//var jsonToSend = JSON.stringify(post);
		parent.setField('map', post); 
	}

$(document).ready(function() {	
	
	$('.back_group h1').click(function(){
		if($(this).parent().children('ul').height() != 0) 
			$(this).parent().children('ul').css('height',0);
		else  
			$(this).parent().children('ul').css('height','auto');
	});
	

	$('input[type=checkbox]').click(function(){
		updateSave();
	});

	$('#auth_tree').find('input[type=checkbox]').each(function(){
		$(this).on('click', function() {
			var checkboxs = document.getElementById($(this).attr('id'));
			blnEtat = (checkboxs.getAttribute('checked') || checkboxs.checked || document.getElementById(checkboxs.getAttribute("id")).checked ? true : false );
			
			$(this).parent().parent().find('input[type=checkbox]').each(function(){
				var checkbox = document.getElementById($(this).attr('id'));
				document.getElementById(checkbox.getAttribute("id")).checked=blnEtat;
			});
			
			if(blnEtat)
			{
				if($(this).parent().parent().parent().parent().children('div').children('input').length>0)
				{
					var checkbox = document.getElementById($(this).parent().parent().parent().parent().children('div').children('input').attr('id'));
					document.getElementById(checkbox).checked=blnEtat;
				}
				
				if($(this).parent().parent().parent().parent().parent().parent().children('div').children('input').length>0)
				{
					var checkbox = document.getElementById($(this).parent().parent().parent().parent().parent().parent().children('div').children('input').attr('id'));
					document.getElementById(checkbox).checked=blnEtat;
				}
				
				if($(this).parent().parent().parent().parent().parent().parent().parent().parent().children('div').children('input').length>0)
				{
					var checkbox = document.getElementById($(this).parent().parent().parent().parent().parent().parent().parent().parent().children('div').children('input').attr('id'));
					document.getElementById(checkbox).checked=blnEtat;
				}
				
				if($(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().children('div').children('input').length>0)
				{
					var checkbox = document.getElementById($(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().children('div').children('input').attr('id'));
					document.getElementById(checkbox).checked=blnEtat;
				}
				if($(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().children('div').children('input').length>0)
				{
					var checkbox = document.getElementById($(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().parent().children('div').children('input').attr('id'));
					document.getElementById(checkbox).checked=blnEtat;
				}
			}
		});
	});	
	$('.open-close').click(function(){
		var sHeight = $(this).parent().parent().children('ul').css('height');
		if(sHeight == '0px') {
			$(this).parent().parent().children('ul').css('height','auto');
			$(this).addClass('open');
		}
		else {
			$(this).parent().parent().children('ul').css('height',0);
			$(this).removeClass('open');
		}
	});
});