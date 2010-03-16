<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://facebook.com/2008/fbml">
	<head>
		<link type="text/css" rel="stylesheet" href = "styles/global.css"/>
		<link type="text/css" rel="stylesheet" href = "styles/index.css"/>

		<script type="text/javascript" src="js/jquery.js"></script>
	</head>
	
	<body>
		<center>
		<h1>Welcome to <b>AmeriQuiz!</b></h1>
		
		<h2>{$fb_user}, your current score is {$user_score}!</h2>
		
		<div id="container">
		<h3>Select An Option</h3>
		
		<p class="nav"><a href='realmap.php?{$fb_params}'>Play</a></p>
		<p class="nav"><a href='rules.php?{$fb_params}'>About AmeriQuiz</a></p>
		<p class="nav"><a href='scoreboard.php?{$fb_params}'>High Scores</a></p>
		</div>
		</center>
	</body>
</html>
