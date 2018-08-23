	$("#sport_form").submit(function (e) {
	var sport_id = $('#sport_id').val();
	
		if (sport_id == "") 
		{
			e.preventDefault();
			window.location.href = site_url+"events";
		}
		else
		{
			e.preventDefault();
			window.location.href = site_url+"events/by_sport/"+sport_id;
		}	
	});
	
		$("button.gobottom").on('click', function(e) {
			e.preventDefault();
			$("html, body").animate({ scrollTop: $(document).height() }, 1000);
		});	
		
		
		
	/*	
	$("#bet").submit(function (e) {
	var match_id = $('#match_id').val();
	var bet_id = $('#bet_id').val();
	var choice_name = $('#choice_name').val();
	var odds = $('#odds').val();
	
	
		e.preventDefault();
		window.location.href = site_url+"tips/custom_bet/"+match_id+"/"+bet_id+"/"+choice_name+"/"+odds;
	});*/
	
			
		