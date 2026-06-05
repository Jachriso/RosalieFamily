styles = [/* 
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
  } */
];
var markers = [];
var markerFilter = [];
var iStatut = 0;    
var map;
function initialize() {
    if(annonces != "" && annonces != undefined)
        annonces = annonces.split(',');     
    geocoder = new google.maps.Geocoder();
    var center = new google.maps.LatLng(48.8589507,2.2775175);
    var myOptions = {
        mapTypeControlOptions: { mapTypeIds: [ ''] },
        scrollwheel: true,
        zoom: 10,
        minZoom: 2, 
        disableDefaultUI: true,
        streetViewControl: false,
        center: center,
        mapTypeId: 'Styled'
   }
   
    map = new google.maps.Map(document.getElementById("gmap"), myOptions);

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
         },
         closeBoxMargin: "0px",
         closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif",
         infoBoxClearance: new google.maps.Size(1, 1),
         isHidden: false,
         pane: "floatPane",
         enableEventPropagation: false
    };
    var infoWindow = new InfoBox(myOptions);
    var dataGroup = new Array();
    for (var i = 0; i < data.annonce.length; i++) {
        dataGroup[i] = data.annonce[i];
        if(dataGroup[i].address != '' && (annonces == "" || annonces.in_array(dataGroup[i].id)) && (type == "" || type == dataGroup[i].annonce_type )) {    
            var latLng = new google.maps.LatLng(dataGroup[i].lat,dataGroup[i].lon);
            var marker = new google.maps.Marker({
                position: latLng,
                map : map,
                'address' : dataGroup[i].address,
                'title' : dataGroup[i].name,
                'name' : dataGroup[i].pseudo,
                'detail' : dataGroup[i].detail,
                'annonce_type' : dataGroup[i].annonce_type,
                'price' : dataGroup[i].budget,
                'link' : sLang + '/' + dataGroup[i].fiche,
                'special' : dataGroup[i].special,
                icon: pictos[dataGroup[i].picto],
            });
            
            google.maps.event.addListener(marker, 'click', function() 
            {
                var contentString = '';                
                for (var i = 0; i < markers.length; i++) {
                    if(typeof markers[i] != 'undefined'){
                        markers[i].setIcon(pictos[markers[i].picto]);
                    }
                }
                linked = '';
                //if(annonces.length > 1)
                    linked = '<div class="gmap_action"><a class="ftmstr ft14 ftblue underline" href="' + this.link + '">Voir cette annonce</a></div>';
                if(this.annonce_type == "property"){
                    if(this.special != "")
                        contentString = '<div class="ftmstr ft16 backblue ftwhite brad4">' + '<p class="pad10 margB0">' + this.special + '</p>' + '</div><div class="gmap_window row pad10"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-xxs-12"><div class="ftmstr ft16 ftblue">' + '<p>' + this.title + '</p>' + '</div><div>' + '<span class="ftmstr ft14 ftblue"><strong>' + this.detail + '</strong></span><br>' + '<span class="ftmstr ft14 ftblue"><strong>Prix des chambres : </strong>' + this.price + '</p>' + '<p class="ftmstr ft14 ftblue"><strong>Par : </strong>' + this.name + '</p>' + '</div>' + linked + '</div></div>';
                    else
                        contentString = '<div class="gmap_window row pad10"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-xxs-12"><div class="ftmstr ft16 ftblue">' + '<p>' + this.title + '</p>' + '</div><div>' + '<span class="ftmstr ft14 ftblue"><strong>' + this.detail + '</strong></span><br>' + '<span class="ftmstr ft14 ftblue"><strong>Prix des chambres : </strong>' + this.price + '</p>' + '<p class="ftmstr ft14 ftblue"><strong>Par : </strong>' + this.name + '</p>' + '</div>' + linked + '</div></div>';
                }else
                    contentString = '<div class="gmap_window row pad10"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-xxs-12"><div class="ftmstr ft16 ftblue">' + '<p>' + this.title + '</p>' + '</div><div>' + '<span class="ftmstr ft14 ftblue"><strong>Par : </strong>' + this.name + '</span><br>' + '<span class="ftmstr ft14 ftblue"><strong>Budget : </strong>' + this.price + '</p>' + '</div>' + linked + '</div></div>';

                infoWindow.setContent(contentString);
                            
                infoWindow.open(map,this);

                /*this.setIcon(pictosBig[this.picto]);
                jQuery(".panel-pays:visible").hide().removeClass('active');
                var target = "panel"+this.id;
                jQuery('li[id='+target+']').show().addClass('active');
                jQuery('ul#lieux>li.active li.active').removeClass('active');
                jQuery('ul#lieux>li.active .slide0').addClass('active');
                jQuery('.controls .glyphicon').hide();
                jQuery('ul#lieux>li.active .bullets').hide();
                jQuery('.bullet.active').removeClass('active');*/
            });
            google.maps.event.addListener(marker, 'mouseover', function() {
            });
            google.maps.event.addListener(infoWindow, 'domready', function () {
                $('.infoboxclose').on('click', function () {
                    infoWindow.close();                       
                })
            });
            markers[marker.id] = marker;
        }
    }
    map.mapTypes.set('Styled', styledMapType);
    window.map.panTo(latLng);
}
google.maps.event.addDomListener(window, 'load', initialize);	