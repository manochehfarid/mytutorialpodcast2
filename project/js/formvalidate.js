/* 
 * This is going to be the rules to validate the registration form.
 */

$().ready(function() {
	// validate registration form on keyup and submit
	$("#regform").validate({
		rules: {
			cfirst: "required",
			clast: "required",
			cemail: {
				required: true,
				email: true
			},
			cpassword: {
				required: true,
				minlength: 3,
                                maxlength: 25
			},
			cpassword: {
				required: true,
				minlength: 3,
                                maxlength: 25,
                                equalTo:"#cpassword"
			}
		},
		messages: {
			cfirst: "Please enter your firstname",
			clast: "Please enter your lastname",
			cemail: "Please enter a valid email address",
			cpassword: {
				required: "Please provide a password",
				minlength: "Your password must be at least 3 characters long",
                                maxlength: "Your password cannont exceed 25 characters"
			},
			cpassword2: {
				required: "Please provide a password",
				minlength: "Your password must be at least 3 characters long",
				equalTo: "Please enter the same password as above",
                                maxlength: "Your password cannont exceed 25 characters",
                                equalTo:"Please enter the same password as the first one"
			},
			
			agree: "Please accept our policy"
		}
	});
})

