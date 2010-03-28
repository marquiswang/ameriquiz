<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://facebook.com/2008/fbml">
	<head>
		<link type="text/css" rel="stylesheet" href = "styles/global.css"/>
		<link type="text/css" rel="stylesheet" href = "styles/index.css"/>

		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/index.js"></script>
	</head>
	
	<body>
		<center>
		<h1>Welcome to <b>AmeriQuiz!</b></h1>
		
		<div id="container">
			<h2>{$fb_user}, your total score is:</h2> 
			<h3>{$user_score}</h3>


			<ul id="nav1">	
				<li><a id ='random-play' href='realmap.php?{$fb_params}'>Random Play</a></li>
				 <li><a id='category-play' href='#'>Category Play</a></li>
				<li><a href='rules.php?{$fb_params}'>About AmeriQuiz</a></li>
				<li><a href='scoreboard.php?{$fb_params}'>High Scores</a></li>
				<li><a id='invite' href='#'>Invite a Friend</a></li>
			</ul>
		
		
			{foreach from=$categories item=category_id name=name}
					<ul id="nav2">
						<li><a href='realmap.php?{$fb_params}&cat={$categories.category_id}'>{$categories.name}</a>
						</li>
					</ul>
			{/foreach}
			
		</div>
		</center>

		<fb:serverFbml style="width: 755px;">
			<script type="text/fbml">
				<fb:fbml> 
					<fb:request-form action="http://daedalus.marquiswang.com/haproject/index.php" method="POST" invite="true" type="AmeriQuiz" content="{$content}">
					<fb:multi-friend-selector actiontext="Invite your friends to use AmeriQuiz." exclude_ids="{$friends}"> </fb:multi-friend-selector>
					</fb:request-form>
				</fb:fbml> 
			</script>
		</fb:serverFbml>

		<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>
		<script src="js/load_fb_api.js" type="text/javascript"></script>
	</body>
</html>
