/*
 *  Document   : base_comp_maps_full.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Google Maps Full Page
 */

var BaseCompMapsFull = function() {
    // Gmaps.js, for more examples you can check out https://hpneo.github.io/gmaps/
var map;
    // Init Full Map
    var initMapFull = function(){
        var $mainCon    = jQuery('#main-container');
        var $mlat       = -17.790900000;
        var $mlong      = 31.063100000;
        var $rTimeout;
          var myLatLng = {lat: $mlat, lng: $mlong};

        // Set #main-container position to be relative
        $mainCon.css('position', 'relative');

        // Adjust map container position
        jQuery('#js-map-full').css({
            'position': 'absolute',
            'top': $mainCon.css('padding-top'),
            'right': '0',
            'bottom': '0',
            'left': '0'
        });

        // Init map itself
         map = new GMaps({
            div: '#js-map-full',
            lat: $mlat,
            lng: $mlong,
            zoom: 15,
            zoomControl: true,
          zoomControlOptions: {
              position: google.maps.ControlPosition.LEFT_CENTER
          }
            
        });
        

        // Set map type
        map.setMapTypeId(google.maps.MapTypeId.ROADMAP  );
        
        var marker = new google.maps.Marker({
    position: myLatLng,
    map: map,
    title: 'Hello World!'
  });
  
  marker.setMap(map);
  
        // Resize and center the map on browser window resize
        jQuery(window).on('resize orientationchange', function(){
            clearTimeout($rTimeout);

            $rTimeout = setTimeout(function(){
                map.refresh();
                map.setCenter($mlat, $mlong);
            }, 150);
        });
    };

    return {
        init: function () {
            // Init Full Map
            initMapFull();
        }
    };
}();

// Initialize when page loads
jQuery(function(){ BaseCompMapsFull.init(); });