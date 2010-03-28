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

// Add user info to our database
$result = mysql_query("SELECT * FROM users WHERE user_id = $user_id");

if (mysql_num_rows($result) == 0) {
	mysql_query("INSERT INTO users (user_id) VALUES ($user_id)");
	// Update user's highscore to begin at 0
	mysql_query("INSERT INTO highscores (user_id, score, timestamp) VALUES ($user_id, 0, NOW())");
}

$query = "SELECT score FROM highscores WHERE user_id = $user_id";
$result2 = mysql_query($query);
$result_assoc = mysql_fetch_assoc($result2); 
$user_score = $result_assoc['score'];

// Pull stuff from Facebook API
$user_details = $facebook->api_client->users_getInfo($user_id, 'first_name');
$fb_user = $user_details[0]['first_name'];

$fb_params = http_build_query($facebook->fb_params);

// Generate information for invite box
$fql = 'SELECT uid FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1='.$user_id.') AND is_app_user = 1';
$_friends = $facebook->api_client->fql_query($fql);

// Extract the user ID's returned in the FQL request into a new array.
$friends = array();
if (is_array($_friends) && count($_friends)) {
	foreach ($_friends as $friend) {
		$friends[] = $friend['uid'];
	}
}

// Convert the array of friends into a comma-delimited string.
$friends = implode(',', $friends);

$content = "<fb:name uid=\"".$user_id."\" firstnameonly=\"true\" shownetwork=\"false\"/> has started playing <a href=\"http://www.facebook.com/apps/application.php?id=316321686100\">AmeriQuiz</a> and thinks you should try it too!\n".
		"<fb:req-choice url=\"".$facebook->get_add_url()."\" label=\"Put ".$app_name." on your profile\"/>";

$content = htmlentities($content);


// Find the categories
$query3 = "SELECT category_id, name FROM categories";
$result3 = mysql_query($query3);
$categories = mysql_fetch_assoc($result3);




// Call smarty template
$smarty->assign('fb_params', $fb_params);
$smarty->assign('user_score', $user_score);
$smarty->assign('fb_user', $fb_user);
$smarty->assign('friends', $friends);
$smarty->assign('content', $content);
$smarty-assign('categories', $categories);
$smarty->display('index.tpl');

