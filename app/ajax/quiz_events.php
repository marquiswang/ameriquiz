<?php

require "../lib/dbconnect.php";

$num_events = $_GET["numEvents"];
$category_id = $_GET["category_id"];
if (is_null($category_id))
	$query = "SELECT * FROM events ORDER BY RAND() LIMIT $num_events";
else
	$query = "SELECT categories.name, events.name FROM event_categories LEFT JOIN events ON event_categories.event_id = events.event_id LEFT JOIN categories ON categories.category_id = event_categories.category_id WHERE event_categories.category_id = $category_id";

$result = mysql_query($query);

$events = array();

while ($event = mysql_fetch_assoc($result)) {
	array_push($events, $event);
}

echo json_encode($events);

?>




