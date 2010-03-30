<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://facebook.com/2008/fbml">
	<head>
		<link type="text/css" rel="stylesheet" href = "styles/global.css"/>
		<link type="text/css" rel="stylesheet" href = "styles/badges.css"/>
		<script type="text/javascript" src="js/jquery.js"></script>
	</head>

	<body>
	<center><h1>Awards!</h1></center>
	
	<p>
	<h5>
	Players of AmeriQuiz! are automatically awarded badges for reaching certain achievements in the game, the number of which are kept track here.  Acheivements can be based on number of questions answered, categories completed, total score, accuracy, and any number of fun things.  Some badges are more difficult to attain than others, so they are differentiated by color: <span style="color:black">white</span> being the easiest, <span style="color:red">red</span> being of moderate difficulty, and <span style="color:blue">blue</span> being the most challenging.
			</h5>
		</p>
	
	<center>
	<table>
	<tr>
	<td scope="check"> </td>
	<td scope="image"> </td>
	<td scope="number" width=75px> </td>
	<td scope="description"> </td>
	</tr>
	{foreach from=$badges item=badge_info name=badges}
		<tr>
			<td scope="check">{if $badge_info.received}<img src="images/checkmark.jpg" width="25" height="25">{/if}</td>
			<td scope="image"><img src="images/badges/{$badge_info.image}" width="150" height="40"></td>
			<td scope="number">x {$badge_info.count}</td>
			<td scope="description">{$badge_info.description}</td>
		</tr>
	{/foreach}
	</table>
	</center>


		<center>	
		<div id="return-button">
			<a href='index.php?{$fb_params}'>BACK TO MENU</a>
		</div>
		</center>

		<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>
		<script src="js/load_fb_api.js" type="text/javascript"></script>
</body>
</html>