
	
jQuery(document).ready(function() {	
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
		
		rating: {
		  required: true
		},		


	},
	
	messages: 
	{
	    rating: {
        required: rating_req
		},   
		
		description: {
        required: description_forgot,
        minWords: description_req
        },
	},	
	
 });
});
