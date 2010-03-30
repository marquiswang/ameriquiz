<?php
// Load Smarty templating engine
require 'smarty/Smarty.class.php';
require 'lib/dbconnect.php';

$smarty = new Smarty;
$smarty->compile_check = true;

// Get badge information
$query = "SELECT award_id, name, count(user_id) AS count, description, image FROM awards NATURAL LEFT JOIN userawards WHERE active=1 GROUP BY award_id ORDER BY name";
$result = mysql_query($query);

$badges = array();
while ($badge_array = mysql_fetch_assoc($result)) {
	array_push($badges, $badge_array);
}

$smarty->assign('badges', $badges);
$smarty->assign('fb_params', $fb_params);
$smarty->display('badges.tpl');

