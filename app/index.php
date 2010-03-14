<?php

// Load Smarty templating engine
require 'smarty/Smarty.class.php';
require 'lib/dbconnect.php';

$smarty = new Smarty;
$smarty->compile_check = true;

// Required stuff to connect to Facebook API
require_once 'lib/facebook.php';

$appapikey = 'a56164bf95f2ebb8706961860ebb156f';
$appsecret = '0c4259ab098ed2446706172a23130c6d';
$facebook = new Facebook($appapikey, $appsecret);

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

// Call smarty template
$smarty->assign('fb_params', $fb_params);
$smarty->assign('user_score', $user_score);
$smarty->assign('fb_user', $fb_user);

// DO THIS LAST
$smarty->display('index.tpl');

