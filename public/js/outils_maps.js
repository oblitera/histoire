var map = false;
var marque = false;
var bounds = new google.maps.LatLngBounds();

function maps_pointer_position(init_lat, init_long)
{
    map = new GMaps({
        div: '#carte',
        lat: (init_lat) ? init_lat : 48.855680,
        lng: (init_long) ? init_long : 2.246704,
        zoom: 10,
        click: function(e)
        {
            if(marque)
            {
                marque.setMap(null);
            }

            marque = map.addMarker({
              lat: e.latLng.lat(),
              lng: e.latLng.lng(),
            });

            $("input[name='coordonnee_lat'").val(e.latLng.lat());
            $("input[name='coordonnee_long'").val(e.latLng.lng());
        },
        dragend: function(e)
        {
            console.log(e);
        }
    });

    if(init_lat !== false && init_long !== false)
    {
        marque = map.addMarker({
          lat: init_lat,
          lng: init_long,
        });                
    }   
}

function create_map_and_markers(init_lat, init_long, zoom, markers)
{
    map = new GMaps({
        div: '#carte',
        lat: (init_lat) ? init_lat : 48.855680,
        lng: (init_long) ? init_long : 2.246704,
        zoom: zoom
    });

    for(i in markers)
    {
        var tempoMarqueur = map.addMarker({
          lat: markers[i].coordonnee_lat,
          lng: markers[i].coordonnee_long
        }); 

        bounds.extend(tempoMarqueur.position);        
    }

    map.fitBounds(bounds);
}