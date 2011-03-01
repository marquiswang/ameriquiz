<?php

$dbhost = '';
$dbuser = '';
$dbpass = '!';
$dbname = ''; 


// Connect to the database
$link = mysql_connect($dbhost, $dbuser, $dbpass);
mysql_select_db($dbname);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

?>
