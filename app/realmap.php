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

// Pull stuff from Facebook API
$user_details = $facebook->api_client->users_getInfo($user_id, 'first_name');
$fb_user = $user_details[0]['first_name'];

$query = "SELECT map_id, filename, name FROM maps";
$result = mysql_query($query);
$map = mysql_fetch_assoc($result); 

$fb_params = http_build_query($facebook->fb_params);

// Find current high score
$query2 = "SELECT score FROM highscores WHERE user_id = $user_id";
$result2 = mysql_query($query2);
$result_assoc = mysql_fetch_assoc($result2); 
$user_score = $result_assoc['score'];

// Now update the current high score


// Call smarty template
$smarty->assign('fb_params', $fb_params);
$smarty->assign('fb_user', $fb_user);
$smarty->assign('map', $map);
$smarty->assign('user_score', $user_score);
$smarty->assign('user_id', $user_id);

$smarty->display('realmap.tpl');
