$(document).ready(function() {
	$('a#invite').click(function() {
		$('#container').hide();
		FB.Connect.requireSession(); 
		return false;
	});

	$('a#review').facebox({
		loadingImage : 'styles/facebox/loading.gif',
		closeImage   : 'styles/facebox/closelabel.gif',
		onClose      : function() {
			window.top.location='http://www.facebook.com/topic.php?uid=114956308585&topic=13387';
		}
	});
});
