<?php

require "../lib/dbconnect.php";

// Add user score to our database
$new_score = $_GET["score"];
$user_id = $_GET["user_id"];

if($user_id) {
	$query = "UPDATE highscores SET score = $new_score, timestamp = NOW() WHERE user_id = $user_id";
	echo mysql_query($query);
}

?>
