$(document).ready(function() {
	$( "#date_start" ).datepicker({
			dateFormat : "dd-mm-yy",
			changeMonth: true,
			changeYear : true
		});
	$( "#date_start" ).datepicker( $.datepicker.regional[ sLang ] );

	$( "#date_end" ).datepicker({
			dateFormat : "dd-mm-yy",
			changeMonth: true,
			changeYear : true
		});
	$( "#date_end" ).datepicker( $.datepicker.regional[ sLang ] );
	
	
});