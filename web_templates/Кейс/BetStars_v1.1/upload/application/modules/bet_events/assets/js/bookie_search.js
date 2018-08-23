	$("#bookie_form").submit(function (e) {
	var bookmaker_id = $('#bookmaker').val();

		e.preventDefault();
		window.location.href = site_url+"events/bookmaker/"+bookmaker_id;
	});
	
		$("button.gobottom").on('click', function(e) {
			e.preventDefault();
			$("html, body").animate({ scrollTop: $(document).height() }, 1000);
		});	