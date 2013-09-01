/* 
 * These are the rules to validate the registration form
 */

$().ready(function() {
	// validate registration form on keyup and submit
	$("#registrationform").validate({
		rules: {
			firstname: "required",
			lastname: "required",
                        email: {
				required: true,
				email: true
			},
			password: {
				required: true,
				minlength: 6
			},
			passconfirm: {
				required: true,
				minlength: 6,
				equalTo: "#password"
			}
		},
		messages: {
			firstname: "Please enter your first name",
			lastname: "Please enter your last name",
                        email: "Please enter a valid email address",
			password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 6 characters long"
			},
			passconfirm: {
				required: "Please provide a password",
				minlength: "Your password must be at least 6 characters long",
				equalTo: "Please enter the same password as above"
			}
		}
        });
});