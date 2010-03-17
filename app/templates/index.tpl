<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://facebook.com/2008/fbml">
	<head>
		<link type="text/css" rel="stylesheet" href = "styles/global.css"/>
		<link type="text/css" rel="stylesheet" href = "styles/index.css"/>

		<script type="text/javascript" src="js/jquery.js"></script>
	</head>
	
	<body>
		<center>
		<h1>Welcome to <b>AmeriQuiz!</b></h1>
		
		<div id="container">
			<h2>{$fb_user}, your total score is:</h2> 
			<h3>{$user_score}</h3>

			<ul id="nav">	
				<li><a href='realmap.php?{$fb_params}'>Play</a></li>
				<li><a href='rules.php?{$fb_params}'>About AmeriQuiz</a></li>
				<li><a href='scoreboard.php?{$fb_params}'>High Scores</a></li>
			</ul>
		</div>
		</center>
	</body>
</html>
