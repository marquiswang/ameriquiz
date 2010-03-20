$(document).ready(function() {
	$('a#invite').click(function() {
		$('#container').hide();
		FB.Connect.requireSession(); 
		return false;
	});
});
