<?php

require "../lib/dbconnect.php";

//Add the recently played round to the database
$user_id = $_GET["user_id"];
$event_id = $_GET["event_id"];
$date_score = $_GET["date_score"];
$loc_score = $_GET["loc_score"];
$time_spent = $_GET["time_spent"];
$cat_id = $_GET["cat_id"];

//If no cat_id was passed in, determine the cat_id
if (!($cat_id))
{
    $query = "SELECT category_id FROM event_categories WHERE event_id = $event_id";
    $cat_id = mysql_result(mysql_query($query), 0);
    echo "cat_id was not sent, cat_id was pulled from database and was: ",$cat_id," ";
}

//Update the played database
if($user_id) {
    $query = "INSERT INTO played (user_id, timestamp, event_id, date_score, loc_score, time_spent) VALUES($user_id, NOW(), $event_id, $date_score, $loc_score, $time_spent)";
    echo mysql_query($query) ? "Success" : "Error";
}

$preCheck = array(0);
$awardCheck = array(0);

//To note, because we do not have a separate array for the award_ids, you must put these into the array in order.
//preCheck and awardCheck for award 1
$preCheck[] =  "SELECT * FROM userawards WHERE user_id = $user_id AND award_id = 1";
$awardCheck[] = "SELECT (SELECT COUNT(DISTINCT played.event_id) FROM played LEFT JOIN event_categories ON event_categories.event_id = played.event_id WHERE user_id = $user_id AND event_categories.category_id = $cat_id) = (SELECT COUNT(event_id) FROM event_categories WHERE category_id = $cat_id)";
foreach (array_keys($preCheck) as $n){
    if ($n == 0){continue;}
    $query = $preCheck[$n];
    $alreadywon = mysql_fetch_object(mysql_query($query)); //fetch_object works best because it returns false if there are no rows left, otherwise it just gives you whatever it is
    if(!$alreadywon){
        $query = $awardCheck[$n];
        $justwon = mysql_result(mysql_query($query),0);
        if($justwon){
            $query = "INSERT INTO userawards (user_id, timestamp, award_id) VALUES($user_id, NOW(), $n)";
            $result = mysql_query($query);
            echo "Just won award ",$n,"\n";
        }
    }else{
        echo "Already won award ", $n,"\n";
    }
}
/*
//Checking for finishing a category
$query = "SELECT * FROM userawards WHERE user_id = $user_id AND award_id = 1";
$alreadywon = mysql_fetch_object(mysql_query($query)); //fetch_object works best because it returns false if there are no rows left, otherwise it just gives you whatever it is
if(!$alreadywon){
    $query = "SELECT (SELECT COUNT(DISTINCT played.event_id) FROM played LEFT JOIN event_categories ON event_categories.event_id = played.event_id WHERE user_id = $user_id AND event_categories.category_id = $cat_id) = (SELECT COUNT(event_id) FROM event_categories WHERE category_id = $cat_id)";
    $justwon = mysql_result(mysql_query($query), 0);
    if($justwon){
        $query = "INSERT INTO userawards (user_id, timestamp, award_id) VALUES($user_id, NOW(), 1)";
        mysql_query($query);
    }

}else{
}
*/
?>
