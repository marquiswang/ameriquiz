// Helper code for map stuff
var maxLatAng = 5.0/4*Math.log(Math.tan(Math.PI/4 + 2.0/5 * 86.5 * Math.PI/180));
// Constants that depend on the map we're using
function sinh(arg) {
    return (Math.exp(arg) - Math.exp(-arg))/2;
}

Map = {
	longitudeMin : -169.8,
	height : 2252,
	width : 3000,

	lngToXPos : function (lng) {
		return Math.floor((lng - Map.longitudeMin) * Map.width / 360);
	},

	latToYPos : function (lat) {
        return Math.floor(Map.height*.5*(1-(1.0/maxLatAng * 5.0/4 * Math.log(Math.tan(Math.PI/4+(2.0/5 * lat/180*Math.PI))))))
	},

	xPosToLng : function (x) {
		return (x / Map.width * 360 + Map.longitudeMin + 180) % 360 - 180;
	},

	yPosToLat : function (y) {
		return 180.0/Math.PI *5.0/4* Math.atan(sinh((Map.height/2 - y)/Map.height*2 * maxLatAng * 4.0/5 ));
	},

	distance: function (lat1, lon1, lat2, lon2) {
		if (lat1 == lat2 && lon1 == lon2) return 0;
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
}

