<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://facebook.com/2008/fbml">
	<head>
		<link type="text/css" rel="stylesheet" href="styles/global.css" />
		<link type="text/css" rel="stylesheet" href="styles/realmap.css" />
		<link type="text/css" rel="stylesheet" href="styles/redmond/jquery-ui.redmond.css" />
		<link type="text/css" rel="stylesheet" href="styles/facebox/facebox.css" />
		
		
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/ui.core.js"></script>
		<script type="text/javascript" src="js/ui.slider.js"></script>
		<script type="text/javascript" src="js/jquery.backgroundPosition.js"></script>
		<script type="text/javascript" src="js/jquery.countDown.js"></script>
		<script type="text/javascript" src="js/date.js"></script>
		<script type="text/javascript" src="js/facebox.js"></script>

		<script type="text/javascript" src="js/maplib.js"></script>
		<script type="text/javascript" src="js/realmap.js"></script>
	</head>
	
	<body>
		<div id="map_container">
			<div id="user_id" class="hidden">{$user_id}</div>
			<div id="category_id" class="hidden">{$category_id}</div>	
			<div id="map_header">
				<h2 id="desc">When and Where?</h2>
				<div class="score">
					<p>Current Score: <span id="score">0</span></p>
					<p>Total Score: <span id="total_score">{$user_score}</span></p>
				</div>

				<div id="header2">	
					<div id="event"></div> 

					<div id="points">Where: <span id="where-points">0</span> Points <br /> When: <span id="when-points">0</span> Points</div>
					<div id="time-out">Out of time!</div>
				</div>
			</div>
	
			<div id='map'>
				<div id="counter">#<span id='index'></span>/<span id='total'></span></div>
				<img id="loc-guess" src="images/icons/blue-dot.gif" class="map_marker">
				<img id="loc-sol" src="images/icons/red-dot.gif" class="map_marker">
				<div id="location-tag", class="guessed map_marker"></div>
				<div id="countdown"></div>
				<span id="status"></span>
				<div class='button action-button'>
					<a id="share" class="continue" href="#">Share</a>
					<a id="next" class="guessed" href="#">Next</a>
					<a id="next-awards" class="guessed" href="#awards" rel="facebox">Next</a>
					<a id="continue" class="continue" href="#">Continue Playing</a>
					<a id="new-category" class ="newCat" href="index.php?{$fb_params}&new-category">New Category</a>
					<a id="submit" class="guessed" href="#">Submit</a>
				</div>

				<div id="start-button" class="button">
					<a id="start" href="#info" rel="facebox">Click to Start</a>
				</div>
			
			</div>
	
			<div id='slider-container'>
				<div id='selected-date'></div>
				<div id='sol-date' class='guessedDate'></div>
				<div id='slider-sol-marker' class='ui-slider ui-slider-horizontal ui-widget guessedDate'><a href='#' class='ui-slider-handle ui-state-active ui-corner-all'></a></div>
				<div id='slider'></div>
				<div id='slider-beg'></div> <div id='slider-end'></div>
			</div>
			
			
			<center>
			<div id="return-button">
					<a href='index.php?{$fb_params}'>BACK TO MENU</a>
			</div>
			</center>
	
			<div id="info" style="display: none">
				<ul>
					<li>Drag the date bar at the bottom to <b>when</b> the event took place.</li>
					<li>Click on the map <b>where</b> the event took place.</li>
				</ul>
			</div>

<div style="top: 150px; left: 192.5px; display: none;" id="fake-facebox">
	<div class="popup">
         <table>
           <tbody>
             <tr>
				<td class="tl"></td>
				<td class="b"></td><td class="tr"></td>
             </tr>
             <tr>
               <td class="b"></td>
               <td class="body">
                 <div class="content" style="display: block;"><div style="" id="awards">
				You've won an award!
				<div id="award-info">
				</div>
			</div></div>
                 <div class="footer" style="display: block;">
                   <a class="close" href="#">OKAY</a>
                 </div>
               </td>
               <td class="b"></td>
             </tr>
             <tr>
               <td class="bl"></td><td class="b"></td><td class="br"></td>
             </tr>
           </tbody>
         </table>
       </div>
     </div>

		</div>
	
		<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script> 
		<script src="js/load_fb_api.js" type="text/javascript"></script>
	</body>
</html>
