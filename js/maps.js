function initMap() {
    var map_div = document.getElementById('id_map');
    var pos = {
        lat: 51.5371756,
        lng: -0.1290173
    };

    var map = new google.maps.Map(map_div, {
        zoom: 15,
        center: pos
    });

    var marker = new google.maps.Marker({
        position: pos,
        map: map,
        title: 'Meta Reality Labs'
    });
}
