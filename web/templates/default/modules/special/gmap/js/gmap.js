styles = [ 
	{
		"featureType": "road.local",
		"stylers": [
			{ "visibility": "off" }
		]
	},
	{ 
		"featureType": "landscape", 
		"stylers": [ 
			{ "color": "#233140" } 
		] 
	},
	{ 
		"featureType": "administrative", 
		"stylers": [ 
			{ "visibility": "on" } 
		] 
	},
	{ 
		"featureType": "water",
		"stylers": [ 
			{ "color": "#a1a1a1" } 
		] 
	},
	{ 
		"featureType": "road.arterial", 
		"elementType": "labels.icon", 
		"stylers": [ 
			{ "visibility": "off" } 
		] 
	},
	{ 
		"featureType": "road", 
		"stylers": [ 
			{ "visibility": "off" } 
		]
	},
	{ 
		"featureType": "water", 
		"elementType": "labels.text", 
		"stylers": [ 
			{ "visibility": "off" }
		] 
	},
	{ 
		"featureType": "poi", 
		"stylers": [ 
			{ "visibility": "off" } 
		] 
	},
  {
    	"featureType": "road.arterial",
    	"stylers": [
      		{ "visibility": "off" }
    	]
  } 
];

var markers = [];
var markerFilter = [];
var iStatut = 0;	
var map;
function initialize() {
	
	geocoder = new google.maps.Geocoder();
	var center = new google.maps.LatLng(48.8589507,2.2775175);
   	var myOptions = {
    	mapTypeControlOptions: { mapTypeIds: [ ''] },
		scrollwheel: true,
		zoom: 5,
		minZoom: 2, 
     	disableDefaultUI: true,
		streetViewControl: false,
		center: center,
		mapTypeId: 'Styled'
   }
   
	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

	var pictos = {'picto_clim':'content/static/picto_clim.png'};

	var styledMapType = new google.maps.StyledMapType(styles, { name: 'Styled' });
	
	var boxText = document.createElement("div");
	
	var myOptions = {
		 content: boxText,
		 disableAutoPan: false,
		 maxWidth: 0,
		 pixelOffset: new google.maps.Size(20, -50),
		 zIndex: null,
		 boxStyle: { background: "url('tipbox.gif') no-repeat #fff",
			 width: "200px",
			 height:"120px",
		 },
		 closeBoxMargin: "2px",
		 closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif",
		 infoBoxClearance: new google.maps.Size(1, 1),
		 isHidden: false,
		 pane: "floatPane",
		 enableEventPropagation: false
	};
	var infoWindow = new InfoBox(myOptions);
	var dataGroup = new Array();
	for (var i = 0; i < data.client.length; i++) {
		dataGroup[i] = data.client[i];
		if(dataGroup[i].address != '') {	
			var latLng = new google.maps.LatLng(dataGroup[i].lat,dataGroup[i].lon);
			var marker = new google.maps.Marker({
				position: latLng,
				map : map,
				'title' : dataGroup[i].client_name,
				'type' : '' + dataGroup[i].picto,
				icon: pictos[dataGroup[i].picto],
				'picto': dataGroup[i].picto,
				'detail' : dataGroup[i].client_detail,
				'address' : dataGroup[i].address,
				'thumb' : dataGroup[i].client_thumb,
				'name' : dataGroup[i].client_name,
				'link' : dataGroup[i].client_link,
				'id' : dataGroup[i].client_id
			});
			
			google.maps.event.addListener(marker, 'click', function() 
			{						
				//change Temoignages
				for (var i = 0; i < markers.length; i++) {
					if(typeof markers[i] != 'undefined'){
						markers[i].setIcon(pictos[markers[i].picto]);
					}
				}
				this.setIcon(pictosBig[this.picto]);
				jQuery(".panel-pays:visible").hide().removeClass('active');
				var target = "panel"+this.id;
				jQuery('li[id='+target+']').show().addClass('active');
				jQuery('ul#lieux>li.active li.active').removeClass('active');
				jQuery('ul#lieux>li.active .slide0').addClass('active');
				jQuery('.controls .glyphicon').hide();
				jQuery('ul#lieux>li.active .bullets').hide();
				jQuery('.bullet.active').removeClass('active');						
			});
			markers[marker.id] = marker;
		}
	}
	map.mapTypes.set('Styled', styledMapType);
}



google.maps.event.addDomListener(window, 'load', initialize);

