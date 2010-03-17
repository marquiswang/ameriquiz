<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://facebook.com/2008/fbml">
	<head>
		<link type="text/css" rel="stylesheet" href="styles/global.css" />
		<link type="text/css" rel="stylesheet" href="styles/realmap.css" />
		<link type="text/css" rel="stylesheet" href="styles/redmond/jquery-ui.redmond.css" />
		<link type="text/css" rel="stylesheet" href="styles/facebox/facebox.css" />
		
		
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/ui.core.js"></script>
		<script type="text/javascript" src="js/ui.slider.js"></script>
		<script type="text/javascript" src="js/jquery.backgroundPosition.js"></script>
		<script type="text/javascript" src="js/jquery.countDown.js"></script>
		<script type="text/javascript" src="js/date.js"></script>
		<script type="text/javascript" src="js/facebox.js"></script>

		<script type="text/javascript" src="js/maplib.js"></script>
		<script type="text/javascript" src="js/realmap.js"></script>
	</head>
	
	<body>
		<div id="map_container">
			<div id="user_id" style="display: none">{$user_id}</div>
	
			<div id="map_header">
				<h2 id="desc">When and Where?</h2>
				<div class="score">
					<p>Current Score: <span id="score">0</span></p>
					<p>Total Score: <span id="total_score">{$user_score}</span></p>
				</div>
			</div>
	
			<div id='map'>
				<span id="event"></span> 
				<div id="countdown"></div>
				<span id="status"></span>
	
				<div id='points' class='guessed'></div>
					<div id='button'>
						<a id="start" href="#info" rel="facebox">Click to Start</a>
						<a id="share" class="continue" href="#">Share</a>
						<a id="next" class="guessed" href="#">Next</a>
				</div>
			
			</div>
	
			<div id='slider-container'>
				<div id='selected-date'></div>
				<div id='sol-date' class='guessedDate'></div>
				<div id='slider-sol-marker' class="ui-slider ui-slider-horizontal ui-widget guessedDate"><a href="#" class="ui-slider-handle ui-state-active ui-corner-all"></a></div>
				<div id='slider'></div>
				<div id='slider-beg'></div> <div id='slider-end'></div>
			</div>
			
			<center>
			<div id="return-button">
					<a href='index.php?{$fb_params}'>BACK TO MENU</a>
			</div>
			</center>
	
			<div id="info" style="display: none">
				<ul>
					<li>Drag the date bar at the bottom to <b>when</b> the event took place.</li>
					<li>Click on the map <b>where</b> the event took place.</li>
				</ul>
			</div>
		</div>
	
		<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script> 
		<script type="text/javascript">
			{literal}
			FB_RequireFeatures(["CanvasUtil"], function(){
				FB.XdComm.Server.init("xd_receiver.htm"); 
				FB.CanvasClient.startTimerToSizeToContent(); 
			});
			{/literal}
		</script>
	</body>
</html>
