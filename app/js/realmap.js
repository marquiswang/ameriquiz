var mapPosX = -300;
var mapPosY = -550;

var containerWidth = 700;
var containerHeight = 400;

var currentlyPlaying = false;
var disableMap = true;
var guessedMap = false;
var guessedDate = false;

var user_id;
var score = 0;
var user_score = 0;
var strikes = 0;
var events = {};
var currentEvent;

var eventsDone = 0;

var dateGuessTicks = 0;
var posGuessX = 0;
var posGuessY = 0;

var startButtonLoaded = true;
var eventsInSet = 20;

var locImage;
		
var message = 'I\'ve been playing this new American history game I found! Check it out!';
var attachment = {
	'name': 'I know my American history!'
};

function callPublish(msg, attachment, action_link) {
  FB.ensureInit(function () {
    FB.Connect.streamPublish(msg, attachment, action_link);
  });
}

function calcLocScore(distance) {
	if (distance < 60) return 100;
	if (distance < 120) return 90;
	if (distance < 180) return 80;
	if (distance < 240) return 70;
	if (distance < 300) return 60;
	if (distance < 375) return 50;
	if (distance < 450) return 40;
	if (distance < 525) return 30;
	if (distance < 600) return 20;
	if (distance < 750) return 10;
	return 0;
}

function calcDateScore(ticks) {
	if (ticks == 0) return 100;
	if (ticks < 6) return 90;
	if (ticks < 11) return 80;
	if (ticks < 16) return 70;
	if (ticks < 21) return 60;
	if (ticks < 26) return 50;
	if (ticks < 31) return 40;
	if (ticks < 36) return 30;
	if (ticks < 41) return 20;
	if (ticks < 51) return 10;
	return 0;
}

function begin() {
	$("a#start").fadeOut(200);
	$("a#share").fadeOut(200);
    setTimeout(loadNewEvent, 200);
}

function loadNextButton() {
	$("#next").fadeIn(250);
}

// Load quiz items
function loadQuiz(numEvents){
    $.ajax({
        url: 'ajax/quiz_events.php',
        data: {numEvents: numEvents},
        type: "GET",
        dataType: 'json',
        success: function(data) {
          events = data;
        }
    });
}

function markCorrectAnswers() {
	// Mark correct location
	locImage = $('img#loc-sol');
	xHeight = locImage.height();
	xWidth = locImage.width();
	locImage.css('left', currentEvent.xPos - xWidth/2 + mapPosX);
	locImage.css('top', currentEvent.yPos - xHeight/2 + mapPosY);

	// Tell them what that place is
	information = $('#location-tag');
	information.html(currentEvent.location);
	information.css('top', currentEvent.yPos - xHeight/2 + mapPosY + 10);
	information.css('left', currentEvent.xPos + mapPosX-50);

	// Mark correct date
	$('#selected-date').css('color', "#00F");
	$('#slider-sol-marker').css('left', currentEvent.dateSolution/120*100 + "%");
	if (currentEvent.month == 0) {
		$('#sol-date').html(currentEvent.date.toString('yyyy'));
	} else if (currentEvent.day == 0) {
		$('#sol-date').html(currentEvent.date.toString('MMM yyyy'));
	} else {
		$('#sol-date').html(currentEvent.date.toString('MMM d, yyyy'));
	}
	$('#sol-date').css('left', currentEvent.dateSolution/120*100 + "%");

	// Fade in images
	information.fadeIn(500);
	locImage.fadeIn(500);

	$('#slider-sol-marker').fadeIn(500);
	$('#sol-date').fadeIn(500);
	
}

// Called when a guess (either date or position) is made. Does nothing if one or other
// has not yet been made.
// Otherwise, marks correct location and date, calculates score, updates score, and
// loads the next button.
function guessMade() {
	if (guessedMap && guessedDate) {
		$('#submit').fadeIn(500);
	}
}

function guessSubmit() {
	$('#slider').slider('disable');
	disableMap = true;
    // Stop the countdown
    $('#countdown').stop(true);
	$('#countdown').html("");

	// Calculate change in score
	var guessLng = Map.xPosToLng(posGuessX);
	var guessLat = Map.yPosToLat(posGuessY);;
	var offByMiles = Map.distance(guessLat, guessLng, currentEvent.latitude, currentEvent.longitude);

	locationPoints = calcLocScore(offByMiles);
	score += locationPoints
	user_score += locationPoints

	datePoints = calcDateScore(Math.abs(dateGuessTicks - currentEvent.dateSolution));
	score += datePoints
	user_score += datePoints

	markCorrectAnswers();

	$('span#total_score').html(user_score);
	$('span#where-points').html(locationPoints);
	$('span#when-points').html(datePoints);
	$('span#score').html(score);

	$('div#time-out').hide();
	$('div#points').fadeIn(500);

	// Post updated score to database
	$.ajax({
		url: 'ajax/updatescore.php',
		data: {user_id : user_id, score: user_score},
		type: "GET",
		success: function() {
		}
	});

	setTimeout(loadNextButton, 1000);
}

function loadNewEvent() {
	// Shift off first event off events array
    $('#countdown').stop(true);
	$('#countdown').html("");

	currentEvent = events.shift();

	// Clear previous events and guesses
	$('.map_marker').hide();
	guessedMap = false;

	$('#selected-date').css('color', "#000");
	$('#slider-sol-marker').hide();
	$('#sol-date').hide();
	$('#points').hide();
	$('#time-out').hide();
	guessedDate = false;

	if (!currentEvent) {
        loadQuiz(eventsInSet);
        currentEvent=events.shift();
        $('#event').html('You\'ve just finished an entire set of '+eventsInSet+' events! Congratulations! Did you like it? Tell a friend if you did!');
		$('div.guess').hide();
	    $("a.continue").show();
        loadNextButton();
		return;
    }

	// Print this event's name
	$('#event').html(currentEvent.name);
	
	$("a#share").fadeOut(200);
	// Find event's actual position on map
	currentEvent.xPos = Map.lngToXPos(currentEvent.longitude);
	currentEvent.yPos = Map.latToYPos(currentEvent.latitude);
	
	// Center the map on this event (roughly)
	mapPosX = containerWidth/2 - currentEvent.xPos + (Math.random() - .5)*containerWidth*.5;
	mapPosY = containerHeight/2 - currentEvent.yPos + (Math.random() - .5)*containerHeight*.5;
	$('div#map').animate({"background-position": mapPosX+"px "+ mapPosY + "px"}, 500);

	// Create date object for this object
	if (currentEvent.month == 0) {
		currentEvent.date = new Date(currentEvent.year, 0, 1);
	}
	else if (currentEvent.day == 0) {
			currentEvent.date = new Date(currentEvent.year, currentEvent.month - 1, 0);
	}
	else {
		currentEvent.date = new Date(currentEvent.year, currentEvent.month - 1, currentEvent.day);
	}

	currentEvent.dateSolution = 60 + Math.floor(80 * (Math.random() -.5));

	// Mark the slider ends correctly
	sliderBegDate = new Date(currentEvent.date);
	sliderEndDate = new Date(currentEvent.date);
	if (currentEvent.increment == 'day') {
		sliderBegDate.addDays(-currentEvent.dateSolution);
		sliderEndDate.addDays(120-currentEvent.dateSolution);
		
		$('#slider-beg').html(sliderBegDate.toString('MMM d, yyyy'));
		$('#slider-end').html(sliderEndDate.toString('MMM d, yyyy'));
	}
	else if (currentEvent.increment == 'month') {
		sliderBegDate.addMonths(-currentEvent.dateSolution);
		sliderEndDate.addMonths(120-currentEvent.dateSolution);

		$('#slider-beg').html(sliderBegDate.toString('MMM yyyy'));
		$('#slider-end').html(sliderEndDate.toString('MMM yyyy'));
	}
	else if (currentEvent.increment == 'year') {
		sliderBegDate.addYears(-currentEvent.dateSolution);
		sliderEndDate.addYears(120-currentEvent.dateSolution);

		$('#slider-beg').html(sliderBegDate.toString('yyyy'));
		$('#slider-end').html(sliderEndDate.toString('yyyy'));
	}
	else if (currentEvent.increment == 'decade') {
		sliderBegDate.addYears(-currentEvent.dateSolution*10);
		sliderEndDate.addYears(120-currentEvent.dateSolution*10);

		$('#slider-beg').html(sliderBegDate.toString('yyyy'));
		$('#slider-end').html(sliderEndDate.toString('yyyy'));
	}

	$('#slider').slider('enable');
	$('#slider').slider('value', 60);
	updateSliderDate(null);
	disableMap = false;

	// Start countdown
	$('#countdown').show();
	$('#countdown').countDown({
		startNumber: 30,
		callBack: function(me) {
			$('#countdown').hide();
			timeOut()
       		loadNextButton()
        } 
	});
}

function updateSliderDate(val) {
	if (val == null) {
		$('#selected-date').hide();
		return;
	}
	else {
		$('#selected-date').show();
	}

	dateGuessTicks = val;
	if (currentEvent.increment == 'day') {
		dateGuess = new Date(sliderBegDate);
		dateGuess.addDays(val);
		$('#selected-date').html(dateGuess.toString('MMM d, yyyy'));
	}
	else if (currentEvent.increment == 'month') {
		dateGuess = new Date(sliderBegDate);
		dateGuess.addMonths(val);
		$('#selected-date').html(dateGuess.toString('MMM yyyy'));
	}
	else if (currentEvent.increment == 'year') {
		dateGuess = new Date(sliderBegDate);
		dateGuess.addYears(val);
		$('#selected-date').html(dateGuess.toString('yyyy'));
	}
	else if (currentEvent.increment == 'decade') {
		dateGuess = new Date(sliderBegDate);
		dateGuess.addYears(val*10);
		$('#selected-date').html(dateGuess.toString('yyyy'));
	}

	$('#selected-date').css('left', (val/120)*100 + "%");
}

function timeOut()  {
	if (guessedMap && guessedDate) {
		guessSubmit();
		return;
	}

	markCorrectAnswers();

    $('div#points').hide();
	$('#submit').hide();
	$('div#time-out').show();
}

// Takes two points, returns miles between them.
function distance(lat1, lon1, lat2, lon2) {
	var radlat1 = Math.PI * lat1/180
	var radlat2 = Math.PI * lat2/180
	var radlon1 = Math.PI * lon1/180
	var radlon2 = Math.PI * lon2/180
	var theta = lon1 - lon2
	var radtheta = Math.PI * theta/180
	var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
	dist = Math.acos(dist)
	dist = dist * 180/Math.PI
	dist = dist * 60 * 1.1515
	return dist
}

$(document).ready(function(){
	user_score = parseInt($("span#total_score").html());
	user_id = $('div#user_id').html();

	loadQuiz(eventsInSet);

	// Set map offset
	$('div#map').css("background-position", mapPosX + "px " + mapPosY + "px");
	
	
	
	// Slider
	$("#slider").slider({
		min: 0, 
		max: 120, 
		step: 1, 
		value: 60,
		slide: function(event, ui) {
			updateSliderDate(ui.value);
		},
		stop: function(event, ui) { 
			if (!guessedDate) {
				guessedDate = true;
				guessMade();
			}
		}
	});

	// Display Rules before game begins
	$('a[rel*=facebox]').facebox({
		loadingImage : 'styles/facebox/loading.gif',
		closeButton   : 'PLAY',
		onClose      : function() { 
			currentlyPlaying = true;
			begin();
			return false;
		}
	}) 

	///////////////////////////////////////////////////////////////////////////
	// Register event handlers
	$("a#share").click(function(e){
		FB.Connect.requireSession();
		attachment.description = "I scored " + score + " points in AmeriQuiz!"
		callPublish(message, attachment, null);
	});

	$("a#submit").click(function(e){
		guessSubmit();
		$(this).fadeOut(500);
		return false;
	});

	$("a#next").click(function(e){
		$(".guessed").fadeOut(250);
		loadNewEvent();
		return false;
	});

	$("div#map").click(function(e){
		if (disableMap) {
			return false;
		}

		posGuessX= e.pageX - $(this).offset().left - mapPosX;
		posGuessY = e.pageY - $(this).offset().top - mapPosY;

		if (!currentEvent) {
			return false;
		}

		if (!guessedMap) {
			// A guess has been made!
			guessedMap = true;
		}
            
		// Mark the click
		clickImage = $('img#loc-guess');
		xHeight = clickImage.height();
		xWidth = clickImage.width();
		clickImage.css('left', posGuessX-xWidth/2 + mapPosX);
		clickImage.css('top', posGuessY-xHeight/2 + mapPosY);
		clickImage.show();

		guessMade();

		return false;
    });
})

