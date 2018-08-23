$(function() {
	var dates = $( "#from, #to" ).datepicker({
		defaultDate: "+1w",
		changeMonth: false,
		showOtherMonths:true,
		numberOfMonths:3,
		format: 'yyyy-mm-dd',
		onSelect: function( selectedDate ) {
			var option = this.id == "from" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});

});
////////////////////////////////////////////////////////////////////
$("#search-rankings").hide();

$("#rankings-search").on('click', function (e){
     e.preventDefault();
       var from = $('#from').val();
	   var to = $('#to').val();
        var post_url = site_url+"/tipsters/get_rankings_by_date";
        $.ajax({
            type: "POST",
             url: post_url,
			data: {
			"from": from,
			"to": to,
			"ci_csrf_token": ci_csrf_token()
			},	
			}).done(function (data){
            $("#result").html(data);
			$("#search-rankings").show();

        });
    
});	


$("#date-clear").on('click', function (e){
    $("#search-rankings").hide();
});	