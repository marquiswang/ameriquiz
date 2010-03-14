<?php
// Load Smarty templating engine
require 'smarty/Smarty.class.php';
require 'lib/dbconnect.php';

$smarty = new Smarty;
$smarty->compile_check = true;

// Required stuff to connect to Facebook API
//require_once 'lib/facebook.php';

//$appapikey = 'a56164bf95f2ebb8706961860ebb156f';
//$appsecret = '0c4259ab098ed2446706172a23130c6d';
//$facebook = new Facebook($appapikey, $appsecret);
//$facebook->require_frame();
//$user_id = $facebook->require_login();
//$fb_params = http_build_query($facebook->fb_params);

// Call smarty template


$smarty->assign('fb_params', $fb_params);
$smarty->display('rules.tpl');
