
////////////////////////////
//League Select
///////////////////////////

$('.league :input').prop('disabled',true);

$('#sport_id').change(function(){
	$('#league_id').empty();
	$('.league :input').prop('disabled',true);
});
	
$('#sport_id').change(function(){
    var sport_id = $('#sport_id').val();
    if (sport_id != "")
	{
        var post_url = site_url+"/tips/get_all_leagues_by_sport_id/" + sport_id;
        $.ajax({
            type: "POST",
             url: post_url,
			 data: {
			"ci_csrf_token": ci_csrf_token()
			},		
             success: function(leagues) //we're calling the response json array 'leagues'
              {
                $('#league_id').empty();
				 var opt = $('<option />'); // here we're creating a new select option for each group
                      opt.val('0');
                      opt.text('Select League');
                      $('#league_id').append(opt); 
					  $('.league :input').removeAttr('disabled');
                      $.each(leagues,function(id,leagues) 
                   {
                    var opt = $('<option />'); // here we're creating a new select option for each group
                      opt.val(id);
                      opt.text(leagues);
                      $('#league_id').append(opt); 
                });
               } //end success
         }); //end AJAX
    } else {
        $('#league_id').empty();
        $('.league :input').prop('disabled',true);
		
    }//end if	
}); //end change 


$( "#start_date" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths:1,
format: 'yyyy-mm-dd',

});
$( "#end_date" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
format: 'yyyy-mm-dd',

});


  //SLIMSCROLL 
  $('.scroll').slimScroll({
		height: '380px',
		size: '3px',
		color: '#609cec'
  });