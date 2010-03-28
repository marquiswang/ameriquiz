$(document).ready(function() {
	$('a#invite').click(function() {
		$('#container').hide();
		FB.Connect.requireSession(); 
		return false;
	});
	
	$("a#category-play").click(function(e){
		$("ul#nav1").hide();
		$("ul#nav2").show();
		return false;
	});
	
});
