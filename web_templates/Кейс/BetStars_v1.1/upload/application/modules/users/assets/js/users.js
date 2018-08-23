

	$("#login_form").validate({

      /* @validation states + elements 
      ------------------------------------------- */

      errorClass: "has-error",
      validClass: "has-success",
      errorElement: "span",

      /* @validation rules 
      ------------------------------------------ */

    rules: 
	{

		username: {
		required: true,
		},
		password: {
		required: true,
		minlength: 5
		},		
		
	},
	
	messages: 
	{
	
		username: {
        required: req_user,
        },
		password: {
        required: req_pass,
        },		
	},	
	
 });	
	


	
	
	$("#form_register").validate({

      /* @validation states + elements 
      ------------------------------------------- */

      errorClass: "has-error",
      validClass: "has-success",
      errorElement: "span",

      /* @validation rules 
      ------------------------------------------ */

    rules: 
	{

		email: {
		required: true,
		email: true
		},
		display_name: {
		required: true,
		minlength: 5,
		maxlength: 12
		},		
		username: {
		required: true,
		},
		password: {
		required: true,
		minlength: 5
		},
		pass_confirm: {
		required: true,
		minlength: 5,
		equalTo: '#password'
		},		
		country: {
		required: true,
		},		
	},
	messages: 
	{
	
		username: {
        required: req_user,
        },
		password: {
        required: req_pass,
        },		
	},	
	
 });	