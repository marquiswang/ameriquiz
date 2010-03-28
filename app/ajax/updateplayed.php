<?php

require "../lib/dbconnect.php";

//Add the recently played round to the database
$user_id = $_GET["user_id"];
$event_id = $_GET["event_id"];
$date_score = $_GET["date_score"];
$loc_score = $_GET["loc_score"];
$time_spent = $_GET["time_spent"];

if($user_id) {
    $query = "INSERT INTO played (user_id, timestamp, event_id, date_score, loc_score, time_spent) VALUES($user_id, NOW(), $event_id, $date_score, $loc_score, $time_spent)";
    echo mysql_query($query) ? "Success" : "Error";
}

?>
