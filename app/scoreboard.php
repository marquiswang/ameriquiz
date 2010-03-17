<?php
// Load Smarty templating engine
require 'smarty/Smarty.class.php';
require 'lib/dbconnect.php';

$smarty = new Smarty;
$smarty->compile_check = true;

// Required stuff to connect to Facebook API
require_once 'lib/facebook.php';
require_once 'lib/facebook_include.php';

$facebook->require_frame();
$user_id = $facebook->require_login();

// Pull stuff from Facebook API
$query = "SELECT user_id, score, timestamp FROM highscores ORDER BY score DESC LIMIT 10";
$global_result = mysql_query($query);

// Make Global Scoreboard here
$global_scores = array();
while ($score = mysql_fetch_assoc($global_result)) {
	$highscore_user_id = $score['user_id'];
	$user_details = $facebook->api_client->users_getInfo($highscore_user_id, 'first_name, last_name');

	// Skip if this user_id doesn't exist.
	if (is_array($user_details) == 0) continue;
	$score['first_name'] = $user_details[0]['first_name'];
	$score['last_name'] = $user_details[0]['last_name'];
	
	array_push($global_scores, $score);
}

// GETTING READY TO MAKE LOCAL SCOREBOARD!
$user_query = "SELECT user_id, score, timestamp FROM highscores WHERE user_id = $user_id";
$user_result = mysql_query($user_query);
$user_assoc = mysql_fetch_assoc($user_result);
$user_database_id = $user_assoc['user_id'];
$user_score = $user_assoc['score'];
$current_user_details = $facebook->api_client->users_getInfo($user_database_id, 'first_name, last_name');
$user_assoc['first_name'] = $current_user_details[0]['first_name'];
$user_assoc['last_name'] = $current_user_details[0]['last_name'];

$query= "SELECT COUNT(*) FROM highscores WHERE score > $user_score";
$local_result = mysql_query($query);
$user_rank_array=mysql_fetch_row($local_result);
$user_rank = $user_rank_array[0]+1;
$user_assoc['rank'] = $user_rank;

// Find the 4 users above
$query = "SELECT user_id, score, timestamp FROM highscores WHERE score > $user_score ORDER BY score LIMIT 4";
$local_result = mysql_query($query);

// Add these users to local scoreboard
$local_scores = array();
$offset = 1;
while ($score = mysql_fetch_assoc($local_result)) {
	$local_user_id = $score['user_id'];
	$user_details = $facebook->api_client->users_getInfo($local_user_id, 'first_name, last_name');
	
	// Skip if this user_id doesn't exist.
	if (is_array($user_details) == 0) continue;
	$score['first_name'] = $user_details[0]['first_name'];
	$score['last_name'] = $user_details[0]['last_name'];
    $score['rank'] = $user_rank-$offset;
    $offset = $offset + 1;
	
	array_push($local_scores, $score);
}

$local_scores = array_reverse($local_scores);

// Now add user to local scoreboard
array_push($local_scores, $user_assoc);

// Find the 5 users below
$query = "SELECT user_id, score, timestamp FROM highscores WHERE score < $user_score ORDER BY score DESC LIMIT 5";
$local_result = mysql_query($query);

// add these users to local scoreboard
$offset = 1;
while ($score = mysql_fetch_assoc($local_result)) {
	$local_user_id = $score['user_id'];
	$user_details = $facebook->api_client->users_getInfo($local_user_id, 'first_name, last_name');
	
	// Skip if this user_id doesn't exist.
	if (is_array($user_details) == 0) continue;
	$score['first_name'] = $user_details[0]['first_name'];
	$score['last_name'] = $user_details[0]['last_name'];
	$score['rank'] = $user_rank+$offset;
    $offset = $offset + 1;

	array_push($local_scores, $score);
}

// GETTING READY TO MAKE FRIENDS SCOREBOARD!!!
$friends = $facebook->api_client->friends_getAppUsers();
array_push($friends, $user_id);
$friends_comma = implode(',', $friends);
$query = "SELECT user_id, score, timestamp FROM highscores WHERE user_id IN ($friends_comma) ORDER BY score DESC LIMIT 14";
$friend_result = mysql_query($query);

// add friends to friend scoreboard
$friend_scores = array();
while ($score = mysql_fetch_assoc($friend_result)) {
	$friend_user_id = $score['user_id'];
	$user_details = $facebook->api_client->users_getInfo($friend_user_id, 'first_name, last_name');
	
	// Skip if this user_id doesn't exist.
	if (is_array($user_details) == 0) continue;
	$score['first_name'] = $user_details[0]['first_name'];
	$score['last_name'] = $user_details[0]['last_name'];
	
	array_push($friend_scores, $score);
}

$smarty->assign('global_scores', $global_scores);
$smarty->assign('local_scores', $local_scores);
$smarty->assign('friend_scores', $friend_scores);
$smarty->assign('user_rank',$user_rank);

$smarty->display('scoreboard.tpl');
