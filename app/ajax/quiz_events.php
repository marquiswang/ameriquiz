<?php

require "../lib/dbconnect.php";

$num_events = $_GET["numEvents"];

//$query = "SELECT * FROM events where event_id ORDER BY event_id"; //RAND() LIMIT $num_events";
$query = "SELECT * FROM events ORDER BY RAND() LIMIT $num_events";
$result = mysql_query($query);

$events = array();

while ($event = mysql_fetch_assoc($result)) {
	array_push($events, $event);
}

echo json_encode($events);

?>




