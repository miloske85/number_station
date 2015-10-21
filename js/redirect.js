/*
*	Timed redirect
*/
$(document).ready(function(){

	var redirectTo = ($('#redirectTarget')).text();

	function redir(){
		window.location.replace(redirectTo);
	}

	window.setTimeout(redir, 3000);
	
});
