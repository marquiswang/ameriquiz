$(document).ready(function() {
	$('a#invite').click(function() {
		$('#container').hide();
		FB.Connect.requireSession(); 
		return false;
	});
	
	$("ul#nav1").click(function(e){
		$("ul#nav1").hide();
		$("ul#nav2").show();
	});
	
});
