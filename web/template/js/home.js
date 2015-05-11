 var pos;
(function($) {
    "use strict";
    var options = {
                        zoom : 15,
                        zoomControl: true,
                        mapTypeControl: true,
    panControl: true,
  panControlOptions: {
  position: google.maps.ControlPosition.LEFT_CENTER
},
    zoomControlOptions: {
        style: google.maps.ZoomControlStyle.LARGE,
        position: google.maps.ControlPosition.LEFT_CENTER
    },
    mapTypeControlOptions: {
        style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
        position: google.maps.ControlPosition.RIGHT_CENTER
    }
                        };

var markers = [];
var map;
setTimeout(function() {
$('body').removeClass('notransition');
 if ($('#home-map').length > 0) {

            map = new google.maps.Map(document.getElementById('home-map'), options);

            

            

            map.setZoom(15);



    

            

            if (navigator.geolocation) {

                    navigator.geolocation.getCurrentPosition(function (position) {

                         pos = new google.maps.LatLng(position.coords.latitude,

                                position.coords.longitude);
                              







                        var newMarker = new google.maps.Marker({

                            position: pos,

                            map: map,

                            icon: new google.maps.MarkerImage('http://www.optimus-beta.com/template/images/marker-position.png'),

                            draggable: false,

                            animation: google.maps.Animation.DROP

                        });



                        map.setCenter(pos);

                        

                    }, function () {

                        handleNoGeolocation(true);

                    });

                } else {

                    handleNoGeolocation(false);

                }

                

                var btn = (document.getElementById('btn-input'));

                google.maps.event.addDomListener(btn, 'click', function () {

                    map.setCenter(pos),

                    map.setZoom(15)



                });

                

                var input = (document.getElementById('pac-input2'));

                

                var searchBox = new google.maps.places.SearchBox((input));

                

                google.maps.event.addListener(searchBox, 'places_changed', function () {

                    var places = searchBox.getPlaces();



                    if (places.length == 0) {

                        return;

                    }

//                    for (var i = 0, marker; marker = markers[i]; i++) {

//                        marker.setMap(null);

//                    }



                    // For each place, get the icon, place name, and location.

                    markers = [];

                    var bounds = new google.maps.LatLngBounds();

                    for (var i = 0, place; place = places[i]; i++) {

                        var image = {

                            url: place.icon,

                            size: new google.maps.Size(71, 71),

                            origin: new google.maps.Point(0, 0),

                            anchor: new google.maps.Point(17, 34),

                            scaledSize: new google.maps.Size(25, 25)

                        };





                        bounds.extend(place.geometry.location);

                    }



                    map.fitBounds(bounds);

                    map.setZoom(15);

                    

                    

                });

              

                google.maps.event.addListener(map, 'bounds_changed', function () {

                    var bounds = map.getBounds();

                    searchBox.setBounds(bounds);

                });

                

        }

    }, 300);



    if(!(('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch)) {

        $('body').addClass('no-touch');

    }



     $('.dropdown-select li a').click(function() {

        if (!($(this).parent().hasClass('disabled'))) {

            $(this).prev().prop("checked", true);

            $(this).parent().siblings().removeClass('active');

            $(this).parent().addClass('active');

            $(this).parent().parent().siblings('.dropdown-toggle').children('.dropdown-label').html($(this).text());

        }

    });



    var cityOptions = {

        types : [ '(cities)' ]

    };

    var city = document.getElementById('city');

    var cityAuto = new google.maps.places.Autocomplete(city, cityOptions);



    $('#advanced').click(function() {

        $('.adv').toggleClass('hidden-xs');

    });



    $('.home-navHandler').click(function() {

        $('.home-nav').toggleClass('active');

        $(this).toggleClass('active');

    });



    //Enable swiping

    $(".carousel-inner").swipe( {

        swipeLeft:function(event, direction, distance, duration, fingerCount) {

            $(this).parent().carousel('next'); 

        },

        swipeRight: function() {

            $(this).parent().carousel('prev');

        }

    });



    $('.modal-su').click(function() {

        $('#signin').modal('hide');

        $('#signup').modal('show');

    });



    $('.modal-si').click(function() {

        $('#signup').modal('hide');

        $('#signin').modal('show');

    });



    $('input, textarea').placeholder();



})(jQuery);

