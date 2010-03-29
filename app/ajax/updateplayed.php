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

}

//Checking for a perfect score on a question
$query = "SELECT * FROM userawards WHERE user_id = $user_id AND award_id = 2";
$alreadywon = mysql_fetch_object(mysql_query($query)); //fetch_object works best because it returns false if there are no rows left, otherwise it just gives you whatever it is
if(!$alreadywon){
    $justwon = (($loc_score + $date_score) == 200);
    if($justwon){
        $query = "INSERT INTO userawards (user_id, timestamp, award_id) VALUES($user_id, NOW(), 2)";
        mysql_query($query);
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
    }
}



?>


