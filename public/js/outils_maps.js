var map = false;
var marque = false;
var marques = [];
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
    var bound_actif = (markers.length > 1) ? true : false;

    map = new GMaps({
        div: '#carte',
        lat: (init_lat) ? init_lat : 48.855680,
        lng: (init_long) ? init_long : 2.246704,
        zoom: zoom
    });

    for(i in markers)
    {
        var descriptMarqueur = "";
        descriptMarqueur+="<div style='width:300px'>";
            descriptMarqueur+="<div>";
                descriptMarqueur+="<a href='"+markers[i].lien+"' style='color:black;text-decoration:none;'>";
                    descriptMarqueur+="<b>"+markers[i].titre+"</b>";
                    descriptMarqueur+="<br><br>";
                descriptMarqueur+="</a>"; 
            descriptMarqueur+="</div>";
            descriptMarqueur+="<div style='width:150px;float:left'>";
                descriptMarqueur+="<a href='"+markers[i].lien+"' style='color:black;text-decoration:none;'>";       
                    descriptMarqueur+="<span>"+markers[i].contenu+"</span>";
                descriptMarqueur+="</a>"; 
            descriptMarqueur+="</div>";
            descriptMarqueur+="<div style='width:150px;float:left'>";
                descriptMarqueur+="<a href='"+markers[i].lien+"' style='color:black;text-decoration:none;'>";
                    descriptMarqueur+="<img width='100%' src='http://histoire.dev/histoire/public/img/122903-122903.jpg'>";
                descriptMarqueur+="</a>";
            descriptMarqueur+="</div>";
            descriptMarqueur+="<div style='clear:both;'></div>";
        descriptMarqueur+="</div>";

        var tempoMarqueur = map.addMarker({
          lat: markers[i].coordonnee_lat,
          lng: markers[i].coordonnee_long,
          id: markers[i].id,
          infoWindow: {
              content: descriptMarqueur 
            }
        }); 

        if(bound_actif)
        {
            bounds.extend(tempoMarqueur.position); 
        }  

        marques.push(tempoMarqueur);             
    }

    if(bound_actif)
    {
        map.fitBounds(bounds);
    }    
}

function get_marqer_by_id(id)
{
    for(i in marques)
    {
        if(marques[i].id == id)
        {
            return marques[i];
        }
    }

    return false;
}

function centrer_sur_marquer(cible)
{
    map.setZoom(15);
    map.setCenter({lat: cible.getPosition().lat(), lng: cible.getPosition().lng()});
}