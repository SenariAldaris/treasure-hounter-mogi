$(document).ready(function(){


	$('#allow_remember').on('change', function(){
		if ('checked' == $(this).attr('checked')) {
			$('#remember-length').css('display', 'block');
		} else {
			$('#remember-length').css('display', 'none');
		}
	});
	
	
    $('#status').on('change', function() {
        if (0 == $(this).val()) {
            $('#offline_reason').parents('.form-group').css('display', 'block');
        } else {
            $('#offline_reason').parents('.form-group').css('display', 'none');
        }
    });
	
      $(function () {
        CKEDITOR.replace('tips_rules');
      });
		
		
});