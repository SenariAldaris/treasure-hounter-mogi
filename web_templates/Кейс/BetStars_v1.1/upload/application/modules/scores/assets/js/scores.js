	$("#sport_form").submit(function (e) {
	var sport = $('#sport').val();
	
		if (sport == "football") 
		{
			e.preventDefault();
			window.location.href = site_url+"scores";
		}
		if (sport == "basketball") 
		{
			e.preventDefault();
			window.location.href = site_url+"scores/basketball";
		}
		if (sport == "handball") 
		{
			e.preventDefault();
			window.location.href = site_url+"scores/handball";
		}	
		if (sport == "hockey") 
		{
			e.preventDefault();
			window.location.href = site_url+"scores/hockey";
		}	


		
	});
	
		$("button.gobottom").on('click', function(e) {
			e.preventDefault();
			$("html, body").animate({ scrollTop: $(document).height() }, 1000);
		});	
		
	/////////////////////////////////////////////////////////////////////////////////	
