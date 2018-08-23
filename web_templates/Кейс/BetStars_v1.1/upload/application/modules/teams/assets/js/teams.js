	 
$('.championship :input').prop('disabled',true);
$('#sport_id').change(function(){

    var sport_id = $('#sport_id').val();
    if (sport_id != "")
	{
        var post_url = site_url+"/tips/get_championships_by_sport_id/" + sport_id;
        $.ajax({
            type: "POST",
             url: post_url,
			data: {
			"ci_csrf_token": ci_csrf_token()
			},				 
             success: function(championships) //we're calling the response json array 'championships'
              {
                $('#championship_id').empty();
				 var opt = $('<option />'); // here we're creating a new select option for each group
                      opt.val('');
                      opt.text('Select Country');
                      $('#championship_id').append(opt); 
					  $('.championship :input').removeAttr('disabled');
                      $.each(championships,function(id,championships) 
                   {
                    var opt = $('<option />'); // here we're creating a new select option for each group
                      opt.val(id);
                      opt.text(championships);
                      $('#championship_id').append(opt); 
                });
               } //end success
         }); //end AJAX
    } else {
        $('#championship_id').empty();
        $('.championship :input').prop('disabled',true);
    }//end if
}); //end change 


////////////////////////////
//League Select
///////////////////////////

$('.league :input').prop('disabled',true);

$('#sport_id').change(function(){
	$('#league').empty();
	$('.league :input').prop('disabled',true);
});

$('#championship_id').change(function(){
	$('#league_id').empty();
	$('.league :input').prop('disabled',true);
});
	
$('#championship_id').change(function(){
    var championship_id = $('#championship_id').val();
    if (championship_id != "")
	{
        var post_url = site_url+"/tips/get_leagues_by_championship_id/" + championship_id;
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
                      opt.val('');
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