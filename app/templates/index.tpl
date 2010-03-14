<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://facebook.com/2008/fbml">

<link type = "text/css" rel="stylesheet" href = "styles/index.css"/>
<script type = "text/javascript" src="js/jquery.js"></script>
<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php/en_US" type="text/javascript"></script>
<body>

<center><h1>Welcome to <b>AmeriQuiz!</b></h1>
</center>
<h2>{$fb_user}, your current score is {$user_score}!</h2>
<center>
<p>
<div id="container">
<h3>Select An Option</h3>

<p class="nav"><a href='realmap.php?{$fb_params}'>Play</a></p>
<p class="nav"><a href='rules.php?{$fb_params}'>About AmeriQuiz</a></p>
<p class="nav"><a href='scoreboard.php?{$fb_params}'>High Scores</a></p>

</div>

</center>

<script type="text/javascript">
    FB.init("a56164bf95f2ebb8706961860ebb156f", "xd_receiver.htm");
</script>
</body>

</html>
