/*
*	Validates data from register page
*/
$(document).ready(function(){
	$('#registerForm').validate({
		rules: {
			username: {
				required: true,
				minlength: 2
			},
			email: {
				required: true,
				email: true
			},
			password: {
				required: true,
				minlength: 6
			},
			password2: {
				required: true,
				equalTo: "#regPassword"
			},
			captcha: {
				required: true
			}
		},
		messages: {
			username: {
				required: "You must fill in the username field",
				minlength: "Username must be at least 2 characters long"
			},
			email: {
				required: "You must fill in the email field",
				email: "You must enter valid email"
			},
			password: {
				required: "You must enter password",
				minlength: "Password must be at least 6 characters long"
			},
			password2: {
				required: "You must confirm your password",
				equalTo: "Passwords don't match"
			},
			captcha: "You must enter the captcha code"
		}
	});
});
