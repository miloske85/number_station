/*
*	Checks the availability of username
*/
$(document).ready(function(){
	$('#regUsername').blur(function(e){

		var postData = $('#regUsername').val();

		var url = "ajax/register";

		if(postData.length > 2){
			$.get(url+ '/' + postData, function(data){
				$('#ajaxRegUsernameNotice').html(data);

			});
		}
		e.preventDefault();
	});
});

