<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://facebook.com/2008/fbml">

<head>
<link type="text/css" rel="stylesheet" href="styles/realmap.css" />
<link type="text/css" rel="stylesheet" href="styles/redmond/jquery-ui.redmond.css" />

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/ui.core.js"></script>
<script type="text/javascript" src="js/ui.slider.js"></script>
<script type="text/javascript" src="js/maplib.js"></script>
<script type="text/javascript" src="js/jquery.backgroundPosition.js"></script>
<script type="text/javascript" src="js/jquery.countDown.js"></script>
<script type="text/javascript" src="js/realmap.js"></script>
<script type="text/javascript" src="js/date.js"></script>
</head>

<body>
	<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php/en_US" type="text/javascript"></script>
	<div id="user_id" style="display: none">{$user_id}</div>
	<div id="map_header">
		<h2 id="desc">When and Where?</h2>
		<div class="score">
			<p>Current Score: <span id="score">0</span></p>
			<p>Total Score: <span id="total_score">{$user_score}</span></p>
		</div>
	</div>
	<div id='map'>
		<span id="event"></span> <div id="countdown"></div> <span id="status"></span>
	<div id='points' class='guessed'></div>
		<div id='button'>
			<a id="start" href="#">Click to Start</a>
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

	<div id="return-button">
			<a href='index.php?{$fb_params}'>BACK TO MENU</a>
	</div>
	<script type="text/javascript">FB.init("a56164bf95f2ebb8706961860ebb156f", "xd_receiver.htm");</script>
</p>

