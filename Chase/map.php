

<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }

      #description {
       font-family: Roboto;
       font-size: 15px;
       font-weight: 300;
     }

     #infowindow-content .title {
       font-weight: bold;
     }

     #infowindow-content {
       display: none;
     }

     #map #infowindow-content {
       display: inline;
     }

     .pac-card {
       margin: 10px 10px 0 0;
       border-radius: 2px 0 0 2px;
       box-sizing: border-box;
       -moz-box-sizing: border-box;
       outline: none;
       box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
       background-color: #fff;
       font-family: Roboto;
     }

     #pac-container {
       padding-bottom: 12px;
       margin-right: 12px;
     }

     .pac-controls {
       display: inline-block;
       padding: 5px 11px;
     }

     .pac-controls label {
       font-family: Roboto;
       font-size: 13px;
       font-weight: 300;
     }

     #pac-input {
       background-color: #fff;
       font-family: Roboto;
       font-size: 18px;
       text-align:center;
       font-weight: 300;
       margin-left: 12px;
       padding: 0 11px 15px 13px;
       text-overflow: ellipsis;
       width: 400px;
     }

     #pac-input:focus {
       border-color: #4d90fe;
     }

     #title {
       color: #fff;
       background-color: #4d90fe;
       font-size: 25px;
       font-weight: 500;
       padding: 6px 12px;
     }
     #target {
       width: 345px;
     }
    </style>
  </head>
  <body>
     <input id="pac-input" class="controls" type="text" placeholder="Search for ATMs">
    <div id="map"></div>
    <script>
        // Note: This example requires that you consent to location sharing when
        // prompted by your browser. If you see the error "The Geolocation service
        // failed.", it means you probably did not give permission for the browser to
        // locate you.
        var map, infoWindow;
        function initMap() {
          map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -34.397, lng: 150.644},
            zoom: 15
          });
          infoWindow = new google.maps.InfoWindow;

          // Try HTML5 geolocation.
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
              var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
              };

              infoWindow.setPosition(pos);
              infoWindow.setContent('You are here');
              infoWindow.open(map);
              map.setCenter(pos);

              //----------------------------------------------

              var request = {
                location: pos,
                radius: '25000',
                query: 'chase atm'
              };
              var service = new google.maps.places.PlacesService(map);
              service.textSearch(request, callback);

              //-----------------------------------------------
              // Create the search box and link it to the UI element.
       var input = document.getElementById('pac-input');
       var searchBox = new google.maps.places.SearchBox(input);
       map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

       // Bias the SearchBox results towards current map's viewport.
       map.addListener('bounds_changed', function() {
         searchBox.setBounds(map.getBounds());
       });

       var markers = [];
       // Listen for the event fired when the user selects a prediction and retrieve
       // more details for that place.
       searchBox.addListener('places_changed', function() {
         var places = searchBox.getPlaces();

         if (places.length == 0) {
           return;
         }

         // Clear out the old markers.
         markers.forEach(function(marker) {
           marker.setMap(null);
         });
         markers = [];

         // For each place, get the icon, name and location.
         var bounds = new google.maps.LatLngBounds();
         places.forEach(function(place) {
           if (!place.geometry) {
             console.log("Returned place contains no geometry");
             return;
           }
           var icon = {
             url: place.icon,
             size: new google.maps.Size(71, 71),
             origin: new google.maps.Point(0, 0),
             anchor: new google.maps.Point(17, 34),
             scaledSize: new google.maps.Size(25, 25)
           };

           // Create a marker for each place.
           markers.push(new google.maps.Marker({
             map: map,
             icon: icon,
             title: place.name,
             position: place.geometry.location
           }));

           if (place.geometry.viewport) {
             // Only geocodes have viewport.
             bounds.union(place.geometry.viewport);
             var request = {
               location: place.geometry.location,
               radius: '25000',
               query: 'chase atm'
             };
             var service = new google.maps.places.PlacesService(map);
             service.textSearch(request, callback);
           } else {
             bounds.extend(place.geometry.location);
             console.log("extend");
           }
         });
         map.fitBounds(bounds);
         console.log("fitbounds");
       });

            }, function() {
              handleLocationError(true, infoWindow, map.getCenter());
            });
          } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, map.getCenter());
          }
        }

        function callback(results, status) {
          if (status == google.maps.places.PlacesServiceStatus.OK) {
            for (var i = 0; i < results.length; i++) {
              var place = results[i];
              addMarker(place.geometry.location);

            }
          }
        }

        function addMarker(coords){
          var marker = new google.maps.Marker({
            position:coords,
            map:map
            //icon:'';
          });
        }

        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
          infoWindow.setPosition(pos);
          infoWindow.setContent(browserHasGeolocation ?
                                'Error: The Geolocation service failed.' :
                                'Error: Your browser doesn\'t support geolocation.');
          infoWindow.open(map);
        }
      </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCH1HaPIDXOFpscE6E4RcO-ziGD7_Ht6e4&libraries=places&callback=initMap"
    async defer></script>
  </body>
</html>
