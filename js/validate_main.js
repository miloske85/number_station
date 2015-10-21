/*
*	Validates posting of a message
*/
$(document).ready(function(){

	$('#mainForm').validate({
		rules:{
			name: {
				required: true,
				minlength: 2
			},
			captcha: {
				required: true
			},
			message: {
				required: true,
				minlength: 2
			}
		},
		messages: {
			name: {
				required: "You must enter a name",
				minlength: "Username too short"
			},
			captcha: "You must fill in captcha code"
			},
			message: {
				required: "You must enter a message",
				minlength: "Message must be longer than 2 characters"
			}
	});

});