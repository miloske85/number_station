/*
*	Calculates approximate password strength in bits of entropy
*/
$(document).ready(function(){
	$('#regPassword').keyup(function(){
		var password = $('#regPassword').val();

		var chBase = 0;

		if(password.match(/[a-z]/g)){
			chBase += 26;
		}
		if(password.match(/[A-Z]/g)){
			chBase += 26;
		}
		if(password.match(/[0-9]/g)){
			chBase += 10;
		}
		if(password.match(/[^a-zA-Z0-9]/g)){
			chBase += 32;
		}

		var entropy = Math.round(Math.log(Math.pow(chBase, password.length)) / Math.log(2));

		$("#passwordMeter").text(entropy);
	});
});

