<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://facebook.com/2008/fbml">
	<head>
		<link type="text/css" rel="stylesheet" href = "styles/global.css"/>
		<link type="text/css" rel="stylesheet" href = "styles/facebox/facebox.css"/>
		<link type="text/css" rel="stylesheet" href = "styles/index.css"/>

		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/facebox.js"></script>
		<script type="text/javascript" src="js/index.js"></script>
	</head>
	
	<body>
		<center>
		<h1>Welcome to <b>AmeriQuiz!</b></h1>
		
		<div id="container">
			<h2>{$fb_user}, your total score is:</h2> 
			<h3>{$user_score}</h3>

			<div id="main-nav" class="nav" {if $new_category}style="display: none"{/if}>
				<div id="play">
					<h4> Begin Playing </h4>
					<ul id="play-buttons">
						<li><a id='random-play' href='realmap.php?{$fb_params}'><b>Random Events</b></a></li>
						<li><a id='category-play' href='#'><b>Historical Periods</b></a></li>
					</ul>
				</div>

				<ul id="nav1">	
					<li><a href='rules.php?{$fb_params}'>About AmeriQuiz</a></li>
					<li><a href='scoreboard.php?{$fb_params}'>High Scores</a></li>
					<li><a href='badges.php?{$fb_params}'>Awards</a></li>
					<li><a id='invite' href='#'>Invite a Friend</a></li>
					<li><a id='review' rel="facebox" href='#review-info'>Review Our Game</a></li>
				</ul>
			</div>
		
			<div id="choose-category" class="nav" {if $new_category}style="display: inline"{/if}>		
				{foreach from=$categories item=category name=categories}
					<ul id="nav2">
						<li><a href='realmap.php?{$fb_params}&cat={$category.category_id}&catname={$category.name}'>{$category.name}</a>
						</li>
					</ul>
				{/foreach}

				<ul id="nav3">
					<li><a id='menu' href='#'><i>Back To Menu</i></a></li>
				</ul>
			</div>
			
		</div>
		</center>

		<div id="review-info" style="display: none">
			<p>
			This game is one of the semi-finalists for the <a href="http://www.facebook.com/haproject" onclick="window.top.location='http://www.facebook.com/haproject';return false;">Hidden Agenda</a> contest!
			</p>
			The goal of this contest is to create an educational Facebook game for high school students.
			</p>
			<p>
			They pick finalists based on reviews of the games, so help us out and tell them how much you like our game.
			</p>
		</div>


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
