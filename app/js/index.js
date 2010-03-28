$(document).ready(function() {
	$('a#invite').click(function() {
		$('#container').hide();
		FB.Connect.requireSession(); 
		return false;
	});
	
	$("a#category-play").click(function(e){
		$("ul#nav1").hide();
		$("ul#nav2").show();
		$("ul#nav3").show();
		return false;
	});
	
	$("a#menu").click(function(e){
		$("ul#nav2").hide();
		$("ul#nav3").hide();
		$("ul#nav1").show();
		return false;
	});
	
	
	$('a#review').facebox({
		loadingImage : 'styles/facebox/loading.gif',
		closeButton   : 'REVIEW',
		cancelButton   : 'CANCEL',
		onClose      : function() {
			window.top.location='http://www.facebook.com/topic.php?uid=114956308585&topic=13387';
		}
	});
});
