<?php

$dbhost = 'localhost';
$dbuser = 'hap_user';
$dbpass = 't5fDg5d!';
$dbname = 'haproject'; 


// Connect to the database
$link = mysql_connect($dbhost, $dbuser, $dbpass);
mysql_select_db($dbname);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

?>
