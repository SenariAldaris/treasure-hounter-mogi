


    if (match_id != "")
	{
        var post_url = site_url+"/tips/get_bets_by_match_id/" + match_id;
        $.ajax({
            type: "POST",
             url: post_url,
			data: {
			"ci_csrf_token": ci_csrf_token()
			},				 
             success: function(bet_names) //we're calling the response json array 'bet_names'
            {
				$('#bet_id').empty();
				 var opt = $('<option />'); // here we're creating a new select option for each group
					   opt.val('');
					  opt.text('Select Bet Type');
					  $('#bet_id').append(opt); 
				      $('.bet_id :input').removeAttr('disabled');
				   $.each(bet_names,function(id,bet_names) 
				   {
					var opt = $('<option />'); // here we're creating a new select option for each group
					  opt.val(id);
					  opt.text(bet_names);
					  $('#bet_id').append(opt); 
				});
            } //end success
			
         }); //end AJAX
    } else {
        $('#bet_id').empty();
        $('.bet_id :input').prop('disabled',true);
		
    }//end if	


////////////////////////////
//Bet Type Select
///////////////////////////

$('.choice_id :input').prop('disabled',true);

$('#sport_id').change(function(){
	$('#choice_id').empty();
	$('.choice_id :input').prop('disabled',true);
});	

$('#league_id').change(function(){
	$('#choice_id').empty();
	$('.choice_id :input').prop('disabled',true);
});	

$('#match_id').change(function(){
	$('#choice_id').empty();
	$('.choice_id :input').prop('disabled',true);
});	

$('#bet_id').change(function(){
	$('#choice_id').empty();
	$('.choice_id :input').prop('disabled',true);
});	

$('#bet_id').change(function(){
	var match_id = $('#match_id').val();
    var bet_id = $('#bet_id').val();
    if (bet_id != "")
	{
        var post_url = site_url+"/tips/get_bet_choice_by_bet_id/" +bet_id+"/"+match_id;
        $.ajax({
            type: "POST",
             url: post_url,
			data: {
			"ci_csrf_token": ci_csrf_token()
			},				 
             success: function(bet_choices) //we're calling the response json array 'bet_choices'
              {
                $('#choice_id').empty();
				 var opt = $('<option />'); // here we're creating a new select option for each group
                    opt.val('');
                    opt.text('Select Bet');
                    $('#choice_id').append(opt); 
                    $('.choice_id :input').removeAttr('disabled');
                    $.each(bet_choices,function(id,bet_choices) 
                   {
                    var opt = $('<option />'); // here we're creating a new select option for each group
                      opt.val(id);
                      opt.text(bet_choices);
                      $('#choice_id').append(opt); 
                });
               } //end success
         }); //end AJAX
    } else {
        $('#choice_id').empty();
        $('.choice_id :input').prop('disabled',true);
		
    }//end if	
}); //end change 



////////////////////////////
// odds
///////////////////////////

//////////////////////////////////////////////////////
$('#choice_id').change(function(){
	var match_id = $('#match_id').val();
	var choice_id = $('#choice_id').val();
	var bet_id = $('#bet_id').val();
	
	var post_url = site_url+"/tips/get_match_odds/"+bet_id+"/"+choice_id+"/"+match_id
        $.ajax({
            type: "POST",
             url: post_url,
			data: {
			"ci_csrf_token": ci_csrf_token()
			},				 
             success: function(response) //we're calling the response json array 'bets'
              {
                $.each(response,function(response) 
                {
                    $('#odds').val(response); 
                });
            } //end success
        }); //end AJAX
}); //end change 


////////////////////////////
// Stake
///////////////////////////

$('.stake :input').prop('disabled',true);

$('#sport_id').change(function(){
	$('.stake :input').prop('disabled',true);
});	

$('#league_id').change(function(){
	$('.stake :input').prop('disabled',true);
});	

$('#match_id').change(function(){
	$('.stake :input').prop('disabled',true);
});	

$('#bet_id').change(function(){
	$('.stake :input').prop('disabled',true);
});	

$('#choice_id').change(function(){
	$('.stake :input').prop('disabled',true);
});	

$('#choice_id').change(function(){
    var choice_id = $('#choice_id').val();
    if (choice_id != "")
	{
        $('.stake :input').removeAttr('disabled');

    } else {
        $('.stake :input').prop('disabled',true);
		
    }//end if	
}); //end change 


	$("#form").validate({

      /* @validation states + elements 
      ------------------------------------------- */

      errorClass: "has-error",
      validClass: "has-success",
      errorElement: "span",

      /* @validation rules 
      ------------------------------------------ */

    rules: 
	{

		description: {
		required: true,
		 minWords: 30
		},
		bet_id: {
		required: true,
		},
		choice_id: {
		required: true,
		},	
		stake: {
		required: true,
		},			
	},
	
	messages: 
	{
	
		description: {
        required: description_forgot,
        minWords: description_req
        },
	},	
	
 });	
	
	
