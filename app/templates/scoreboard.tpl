<link type = "text/css" rel="stylesheet" href = "styles/scoreboard.css" />
<link type = "text/css" rel="stylesheet" href = "styles/redmond/jquery-ui.redmond.css" />

<script type = "text/javascript" src="js/jquery.js"></script>
<script type = "text/javascript" src="js/ui.core.js"></script>
<script type = "text/javascript" src="js/ui.tabs.js"></script>
<script type = "text/javascript" src="js/scoreboard.js"></script>

<center>
<h1> World Leaders! </h1>
<p>

<div class="scores">
<div id="tabs">

	<ul>
			<li><a href="#tabs-0">Global Scoreboard</a></li>
			<li><a href="#tabs-1">Relative Scoreboard</a></li>
			<li><a href="#tabs-2">Friends Scoreboard</a></li>
	</ul>
	<div id="tabs-0">
		<table class="pretty-table" summary="high scores">
			<tr>
			    <th scope="col"> </th>
		  	 	<th scope="col2">Name</th>
		 	 	<th scope="col3">Score</th>
			</tr>
		{foreach from=$global_scores item=user_score name=scores}
			<tr>
				<th scope="row">{$smarty.foreach.scores.iteration}</th>
				<th scope="row2">{$user_score.first_name} {$user_score.last_name}</th>
				<td>{$user_score.score}</td>
			</tr>
		{/foreach}
		</table>
	</div>
	
	<div id="tabs-1">
		<table class="pretty-table" summary="high scores">
			<tr>
			    <th scope="col"> </th>
		  	 	<th scope="col2">Name</th>
		 	 	<th scope="col3">Score</th>
			</tr>
		{foreach from=$local_scores item=user_score name=scores}
			<tr>
				<th scope="row">{$user_score.rank}</th>
				<th scope="row2">{$user_score.first_name} {$user_score.last_name}</th>
				<td>{$user_score.score}</td>
			</tr>
		{/foreach}
		</table>
	</div>
	
	<div id="tabs-2">
		<table class="pretty-table" summary="high scores">
			<tr>
			    <th scope="col"> </th>
		  	 	<th scope="col2">Name</th>
		 	 	<th scope="col3">Score</th>
			</tr>
		{foreach from=$friend_scores item=user_score name=scores}
			<tr>
				<th scope="row">{$smarty.foreach.scores.iteration}</th>
				<th scope="row2">{$user_score.first_name} {$user_score.last_name}</th>
				<td>{$user_score.score}</td>
			</tr>
		{/foreach}
		</table>
	</div>
	
</div>
</div>
<br>
<center>
<a id="return" href='index.php?{$fb_params}'>BACK TO MENU</a>
</center>	
	
	
	
			
</center>
