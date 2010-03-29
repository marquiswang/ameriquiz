<?php

require "../lib/dbconnect.php";

//Add the recently played round to the database
$user_id = $_GET["user_id"];
$event_id = $_GET["event_id"];
$date_score = $_GET["date_score"];
$loc_score = $_GET["loc_score"];
$time_spent = $_GET["time_spent"];
$cat_id = $_GET["cat_id"];

$new_score = 0;

//If no cat_id was passed in, determine the cat_id
if (!($cat_id))
{
    $query = "SELECT category_id FROM event_categories WHERE event_id = $event_id";
    $cat_id = mysql_result(mysql_query($query), 0);
}

//Update the played database
if($user_id) {
    $query = "INSERT INTO played (user_id, timestamp, event_id, date_score, loc_score, time_spent) VALUES($user_id, NOW(), $event_id, $date_score, $loc_score, $time_spent)";
	mysql_query($query);

	$query = "UPDATE highscores SET score = score + $date_score + $loc_score, timestamp = NOW() WHERE user_id = $user_id";
	mysql_query($query);

	$query = "SELECT score FROM highscores WHERE user_id = $user_id";
	$new_score = mysql_result(mysql_query($query), 0);
	
}
else {
	header("HTTP/1.0 500 Bad Data");
	echo "No such User ID";
	exit();
}


/*
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
*/
$awards_won = array();
//Checking for finishing a category
$query = "SELECT * FROM userawards WHERE user_id = $user_id AND award_id = 1";
$alreadywon = mysql_fetch_object(mysql_query($query)); //fetch_object works best because it returns false if there are no rows left, otherwise it just gives you whatever it is
if(!$alreadywon){
    $query = "SELECT (SELECT COUNT(DISTINCT played.event_id) FROM played LEFT JOIN event_categories ON event_categories.event_id = played.event_id WHERE user_id = $user_id AND event_categories.category_id = $cat_id) = (SELECT COUNT(event_id) FROM event_categories WHERE category_id = $cat_id)";
    $justwon = mysql_result(mysql_query($query), 0);
    if($justwon){
        $query = "INSERT INTO userawards (user_id, timestamp, award_id) VALUES($user_id, NOW(), 1)";
        mysql_query($query);
		array_push($awards_won, 1);
    }
}

//Checking for a perfect score on a question
$query = "SELECT * FROM userawards WHERE user_id = $user_id AND award_id = 2";
$alreadywon = mysql_fetch_object(mysql_query($query)); //fetch_object works best because it returns false if there are no rows left, otherwise it just gives you whatever it is
if(!$alreadywon){
    $justwon = (($loc_score + $date_score) == 200);
    if($justwon){
        $query = "INSERT INTO userawards (user_id, timestamp, award_id) VALUES($user_id, NOW(), 2)";
        mysql_query($query);
		array_push($awards_won, 2);
    }
}

//Checking for perfect location score
$query = "SELECT * FROM userawards WHERE user_id = $user_id AND award_id = 3";
$alreadywon = mysql_fetch_object(mysql_query($query)); //fetch_object works best because it returns false if there are no rows left, otherwise it just gives you whatever it is
if(!$alreadywon){
    $justwon = ($loc_score  == 100);
    if($justwon){
        $query = "INSERT INTO userawards (user_id, timestamp, award_id) VALUES($user_id, NOW(), 3)";
        mysql_query($query);
		array_push($awards_won, 3);
    }
}

//Checking for 3 locations in a row perfect
$query = "SELECT * FROM userawards WHERE user_id = $user_id AND award_id = 4";
$alreadywon = mysql_fetch_object(mysql_query($query)); //fetch_object works best because it returns false if there are no rows left, otherwise it just gives you whatever it is
if(!$alreadywon){
    $justwon = ($loc_score  == 100);
    if($justwon){
        $query = "SELECT loc_score FROM played ORDER BY timestamp DESC limit 3";
        $result = mysql_query($query);
        if($result && mysql_result($result, 0)==100 && mysql_result($result, 1)==100 && mysql_result($result, 2)==100)
        {
            $query = "INSERT INTO userawards (user_id, timestamp, award_id) VALUES($user_id, NOW(), 4)";
            mysql_query($query);
			array_push($awards_won, 4);
        }
    }
}

//Checking for perfect date score
$query = "SELECT * FROM userawards WHERE user_id = $user_id AND award_id = 5";
$alreadywon = mysql_fetch_object(mysql_query($query)); //fetch_object works best because it returns false if there are no rows left, otherwise it just gives you whatever it is
if(!$alreadywon){
    $justwon = ($date_score  == 100);
    if($justwon){
        $query = "INSERT INTO userawards (user_id, timestamp, award_id) VALUES($user_id, NOW(), 5)";
        mysql_query($query);
		array_push($awards_won, 5);
    }
}

//Checking for 3 locations in a row perfect
$query = "SELECT * FROM userawards WHERE user_id = $user_id AND award_id = 6";
$alreadywon = mysql_fetch_object(mysql_query($query)); //fetch_object works best because it returns false if there are no rows left, otherwise it just gives you whatever it is
if(!$alreadywon){
    $justwon = ($date_score  == 100);
    if($justwon){
        $query = "SELECT date_score FROM played ORDER BY timestamp DESC limit 3";
        $result = mysql_query($query);
        if($result && mysql_result($result, 0)==100 && mysql_result($result, 1)==100 && mysql_result($result, 2)==100)
        {
            $query = "INSERT INTO userawards (user_id, timestamp, award_id) VALUES($user_id, NOW(), 6)";
            mysql_query($query);
			array_push($awards_won, 6);
        }
    }
}

//Checking for perfect location but 0 date or vice versa
$query = "SELECT * FROM userawards WHERE user_id = $user_id AND award_id = 7";
$alreadywon = mysql_fetch_object(mysql_query($query)); //fetch_object works best because it returns false if there are no rows left, otherwise it just gives you whatever it is
if(!$alreadywon){
    $justwon = (($date_score  == 100 && $loc_score == 0) || ($date_score == 0 && $loc_score == 100));
    if($justwon){
        $query = "INSERT INTO userawards (user_id, timestamp, award_id) VALUES($user_id, NOW(), 7)";
        mysql_query($query);
		array_push($awards_won, 7);
    }
}

//Checking for trying every question
$query = "SELECT * FROM userawards WHERE user_id = $user_id AND award_id = 8";
$alreadywon = mysql_fetch_object(mysql_query($query)); //fetch_object works best because it returns false if there are no rows left, otherwise it just gives you whatever it is
if(!$alreadywon){
    $query = "SELECT COUNT(DISTINCT event_id) = (SELECT COUNT(event_id) from events) FROM played WHERE user_id = $user_id";
    $justwon = mysql_result(mysql_query($query), 0);
    if($justwon){
        $query = "INSERT INTO userawards (user_id, timestamp, award_id) VALUES($user_id, NOW(), 8)";
        mysql_query($query);
		array_push($awards_won, 8);
    }
}

//Checking for 1000 points
$query = "SELECT * FROM userawards WHERE user_id = $user_id AND award_id = 9";
$alreadywon = mysql_fetch_object(mysql_query($query)); //fetch_object works best because it returns false if there are no rows left, otherwise it just gives you whatever it is
if(!$alreadywon){
    $query = "SELECT score FROM highscores WHERE user_id = $user_id";
    $justwon = mysql_result(mysql_query($query), 0) > 1000;
    if($justwon){
        $query = "INSERT INTO userawards (user_id, timestamp, award_id) VALUES($user_id, NOW(), 9)";
        mysql_query($query);
		array_push($awards_won, 9);
    }
}

//Checking for 2000 points
$query = "SELECT * FROM userawards WHERE user_id = $user_id AND award_id = 10";
$alreadywon = mysql_fetch_object(mysql_query($query)); //fetch_object works best because it returns false if there are no rows left, otherwise it just gives you whatever it is
if(!$alreadywon){
    $query = "SELECT score FROM highscores WHERE user_id = $user_id";
    $justwon = mysql_result(mysql_query($query), 0) > 2000;
    if($justwon){
        $query = "INSERT INTO userawards (user_id, timestamp, award_id) VALUES($user_id, NOW(), 10)";
        mysql_query($query);
		array_push($awards_won, 10);
    }
}

//Checking for 5000 points
$query = "SELECT * FROM userawards WHERE user_id = $user_id AND award_id = 11";
$alreadywon = mysql_fetch_object(mysql_query($query)); //fetch_object works best because it returns false if there are no rows left, otherwise it just gives you whatever it is
if(!$alreadywon){
    $query = "SELECT score FROM highscores WHERE user_id = $user_id";
    $justwon = mysql_result(mysql_query($query), 0) > 5000;
    if($justwon){
        $query = "INSERT INTO userawards (user_id, timestamp, award_id) VALUES($user_id, NOW(), 11)";
        mysql_query($query);
		array_push($awards_won, 11);
    }
}

//Checking for 10000 points
$query = "SELECT * FROM userawards WHERE user_id = $user_id AND award_id = 12";
$alreadywon = mysql_fetch_object(mysql_query($query)); //fetch_object works best because it returns false if there are no rows left, otherwise it just gives you whatever it is
if(!$alreadywon){
    $query = "SELECT score FROM highscores WHERE user_id = $user_id";
    $justwon = mysql_result(mysql_query($query), 0) > 10000;
    if($justwon){
        $query = "INSERT INTO userawards (user_id, timestamp, award_id) VALUES($user_id, NOW(), 12)";
        mysql_query($query);
		array_push($awards_won, 12);
    }
}

//Checking for 25000 points
$query = "SELECT * FROM userawards WHERE user_id = $user_id AND award_id = 13";
$alreadywon = mysql_fetch_object(mysql_query($query)); //fetch_object works best because it returns false if there are no rows left, otherwise it just gives you whatever it is
if(!$alreadywon){
    $query = "SELECT score FROM highscores WHERE user_id = $user_id";
    $justwon = mysql_result(mysql_query($query), 0) > 25000;
    if($justwon){
        $query = "INSERT INTO userawards (user_id, timestamp, award_id) VALUES($user_id, NOW(), 13)";
        mysql_query($query);
		array_push($awards_won, 13);
    }
}

//Checking for 50000 points
$query = "SELECT * FROM userawards WHERE user_id = $user_id AND award_id = 14";
$alreadywon = mysql_fetch_object(mysql_query($query)); //fetch_object works best because it returns false if there are no rows left, otherwise it just gives you whatever it is
if(!$alreadywon){
    $query = "SELECT score FROM highscores WHERE user_id = $user_id";
    $justwon = mysql_result(mysql_query($query), 0) > 50000;
    if($justwon){
        $query = "INSERT INTO userawards (user_id, timestamp, award_id) VALUES($user_id, NOW(), 14)";
        mysql_query($query);
		array_push($awards_won, 14);
    }
}

//Checking for 75000 points
$query = "SELECT * FROM userawards WHERE user_id = $user_id AND award_id = 15";
$alreadywon = mysql_fetch_object(mysql_query($query)); //fetch_object works best because it returns false if there are no rows left, otherwise it just gives you whatever it is
if(!$alreadywon){
    $query = "SELECT score FROM highscores WHERE user_id = $user_id";
    $justwon = mysql_result(mysql_query($query), 0) > 75000;
    if($justwon){
        $query = "INSERT INTO userawards (user_id, timestamp, award_id) VALUES($user_id, NOW(), 15)";
        mysql_query($query);
		array_push($awards_won, 15);
    }
}

//Checking for 100000 points
$query = "SELECT * FROM userawards WHERE user_id = $user_id AND award_id = 16";
$alreadywon = mysql_fetch_object(mysql_query($query)); //fetch_object works best because it returns false if there are no rows left, otherwise it just gives you whatever it is
if(!$alreadywon){
    $query = "SELECT score FROM highscores WHERE user_id = $user_id";
    $justwon = mysql_result(mysql_query($query), 0) > 100000;
    if($justwon){
        $query = "INSERT INTO userawards (user_id, timestamp, award_id) VALUES($user_id, NOW(), 16)";
        mysql_query($query);
		array_push($awards_won, 16);
    }
}

//Checking if ever score leader
$query = "SELECT * FROM userawards WHERE user_id = $user_id AND award_id = 17";
$alreadywon = mysql_fetch_object(mysql_query($query)); //fetch_object works best because it returns false if there are no rows left, otherwise it just gives you whatever it is
if(!$alreadywon){
    $query = "SELECT (SELECT user_id FROM highscores ORDER BY score DESC LIMIT 1) = $user_id";
    $justwon = mysql_result(mysql_query($query), 0);
    if($justwon){
        $query = "INSERT INTO userawards (user_id, timestamp, award_id) VALUES($user_id, NOW(), 17)";
        mysql_query($query);
		array_push($awards_won, 17);
    }
}

//Checking if played the last 3 days in a row
$query = "SELECT * FROM userawards WHERE user_id = $user_id AND award_id = 21";
$alreadywon = mysql_fetch_object(mysql_query($query)); //fetch_object works best because it returns false if there are no rows left, otherwise it just gives you whatever it is
if(!$alreadywon){
    $query = "SELECT (SELECT DISTINCT DATE(timestamp) AS DATE FROM played WHERE user_id = $user_id ORDER BY DATE DESC LIMIT 2,1) = (SELECT DATE_SUB(DATE(NOW()), INTERVAL 2 DAY))";
    $justwon = mysql_result(mysql_query($query), 0);
    if($justwon){
        $query = "INSERT INTO userawards (user_id, timestamp, award_id) VALUES($user_id, NOW(), 21)";
        mysql_query($query);
		array_push($awards_won, 21);
    }
}

//Checking if played the last 7 days in a row
$query = "SELECT * FROM userawards WHERE user_id = $user_id AND award_id = 22";
$alreadywon = mysql_fetch_object(mysql_query($query)); //fetch_object works best because it returns false if there are no rows left, otherwise it just gives you whatever it is
if(!$alreadywon){
    $query = "SELECT (SELECT DISTINCT DATE(timestamp) AS DATE FROM played WHERE user_id = $user_id ORDER BY DATE DESC LIMIT 6,1) = (SELECT DATE_SUB(DATE(NOW()), INTERVAL 6 DAY))";
    $justwon = mysql_result(mysql_query($query), 0);
    if($justwon){
        $query = "INSERT INTO userawards (user_id, timestamp, award_id) VALUES($user_id, NOW(), 22)";
        mysql_query($query);
		array_push($awards_won, 22);
    }
}

//Checking if played over 20 rounds
$query = "SELECT * FROM userawards WHERE user_id = $user_id AND award_id = 25";
$alreadywon = mysql_fetch_object(mysql_query($query)); //fetch_object works best because it returns false if there are no rows left, otherwise it just gives you whatever it is
if(!$alreadywon){
    $query = "SELECT (SELECT COUNT(*) FROM played WHERE user_id = $user_id) = (20)";
    $justwon = mysql_result(mysql_query($query), 0);
    if($justwon){
        $query = "INSERT INTO userawards (user_id, timestamp, award_id) VALUES($user_id, NOW(), 25)";
        mysql_query($query);
        array_push($awards_won, 25);
    }
}

//Checking if played over 100 rounds
$query = "SELECT * FROM userawards WHERE user_id = $user_id AND award_id = 26";
$alreadywon = mysql_fetch_object(mysql_query($query)); //fetch_object works best because it returns false if there are no rows left, otherwise it just gives you whatever it is
if(!$alreadywon){
    $query = "SELECT (SELECT COUNT(*) FROM played WHERE user_id = $user_id) = (100)";
    $justwon = mysql_result(mysql_query($query), 0);
    if($justwon){
        $query = "INSERT INTO userawards (user_id, timestamp, award_id) VALUES($user_id, NOW(), 26)";
        mysql_query($query);
        array_push($awards_won, 26);
    }
}

//Checking if played over 200 rounds
$query = "SELECT * FROM userawards WHERE user_id = $user_id AND award_id = 26";
$alreadywon = mysql_fetch_object(mysql_query($query)); //fetch_object works best because it returns false if there are no rows left, otherwise it just gives you whatever it is
if(!$alreadywon){
    $query = "SELECT (SELECT COUNT(*) FROM played WHERE user_id = $user_id) = (200)";
    $justwon = mysql_result(mysql_query($query), 0);
    if($justwon){
        $query = "INSERT INTO userawards (user_id, timestamp, award_id) VALUES($user_id, NOW(), 26)";
        mysql_query($query);
        array_push($awards_won, 26);
    }
}

//Checking if played over 500 rounds
$query = "SELECT * FROM userawards WHERE user_id = $user_id AND award_id = 39";
$alreadywon = mysql_fetch_object(mysql_query($query)); //fetch_object works best because it returns false if there are no rows left, otherwise it just gives you whatever it is
if(!$alreadywon){
    $query = "SELECT (SELECT COUNT(*) FROM played WHERE user_id = $user_id) = (500)";
    $justwon = mysql_result(mysql_query($query), 0);
    if($justwon){
        $query = "INSERT INTO userawards (user_id, timestamp, award_id) VALUES($user_id, NOW(), 39)";
        mysql_query($query);
        array_push($awards_won, 39);
    }
}

//Checking if they ran out of time

$awards_str = implode($awards_won, ',');
$awards = array();
if (count($awards_won)) {
	$query = "SELECT award_id, name, description, image FROM awards WHERE award_id IN ($awards_str)";
	$result = mysql_query($query);

	while ($award = mysql_fetch_assoc($result)) {
		array_push($awards, $award);
	}
}


echo json_encode(array('new_score' => $new_score, 'awards_won' => $awards_won, 'awards' => $awards));

?>


