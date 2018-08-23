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
		
	/////////////////////////////////////////////////////////////////////////////////	

