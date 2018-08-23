      $(function () {
        CKEDITOR.replace('review');
      });
	  
		$('#side').css('display', 'none');
			$('#full').css('display', 'none');
	    $('#banner_type').on('change', function() {
		if ($(this).val() == 0) {
            $('#side').css('display', 'none');
			$('#full').css('display', 'none');
        }
        if ($(this).val() == 1) {
            $('#side').css('display', 'block');
			$('#full').css('display', 'none');
        } else {
            $('#side').css('display', 'none');
        }
        if ($(this).val() == 2) {
            $('#full').css('display', 'block');
			$('#side').css('display', 'none');
        } else {
            $('#full').css('display', 'none');
        }		
    });