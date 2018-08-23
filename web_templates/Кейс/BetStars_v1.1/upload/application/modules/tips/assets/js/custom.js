
////////////////////////////
// Stake
///////////////////////////

    if (match_id != "")
	{
        $('.stake :input').removeAttr('disabled');

    } else {
        $('.stake :input').prop('disabled',true);
		
    }//end if	





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
	
	
$(function() {
    var action;
    $(".number-spinner button").mousedown(function () {
        btn = $(this);
        input = btn.closest('.number-spinner').find('input');
        btn.closest('.number-spinner').find('button').prop("disabled", false);

    	if (btn.attr('data-dir') == 'up') {
            action = setInterval(function(){
                if ( input.attr('max') == undefined || parseInt(input.val()) < parseInt(input.attr('max')) ) {
                    input.val(parseInt(input.val())+1);
                }else{
                    btn.prop("disabled", true);
                    clearInterval(action);
                }
            }, 50);
    	} else {
            action = setInterval(function(){
                if ( input.attr('min') == undefined || parseInt(input.val()) > parseInt(input.attr('min')) ) {
                    input.val(parseInt(input.val())-1);
                }else{
                    btn.prop("disabled", true);
                    clearInterval(action);
                }
            }, 50);
    	}
    }).mouseup(function(){
        clearInterval(action);
    });
});	