<!doctype html>
<head>
    <title>{{ $data->name }} Embedded Map</title>
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" />
    <style>
        body {
            height: 100%;
            margin: 0;
        }
        #map {
            position: fixed;
            width: 100%;
            height: 100%;
        }
        .markerText {
            background: rgba(25,25,25,.50);
            color: white;
        }
    </style>
</head>
<body>
<div id="map"></div>
<!-- leaflet -->
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"></script>
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="/lib/leaflet-hash.js"></script>
<!-- Main tangram library -->
<script src="https://unpkg.com/tangram/dist/tangram.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    window.map_settings = <?php echo json_encode([
        'scene' => $data->style_url,
        'aircraft_source' => $data->aircraft_source,
        'input_schema' => $data->input_schema ? $data->input_schema : null,
        'colors' => [
            'primary' => '#71ccff'
        ]
    ])?>
</script>

<script>
    let map = L.map('map');
    let tangramLayer = Tangram.leafletLayer({
        scene: window.map_settings.scene,
        attribution: 'openAIP | &copy; OSM contributors',
        events: {
            click: clickHandler,
        },
        selectionRadius: 10
    });
    function looseJsonParse(obj, val) {
        window.value_pass = val;
        return Function(`'use strict';let val = window.value_pass;return ${obj};`)();
    }
    tangramLayer.addTo(map);
    let url_hash = window.location.hash.slice(1, window.location.hash.length).split('/');
    let map_start_location = [37.487, -98.981, 5]; // NYC
    let hash = new L.Hash(map);
    let load_data = true;
    let loading = false;
    let phpVMS_Schema = '{type: "Feature", geometry: {type: "Point",coordinates: [val.lng, val.lat]},properties: {callsign: val.flightnum,heading: val.heading}}';
    tangramLayer.scene.subscribe({
        update: ()=> {
            console.log('Loading');
            loading = true;
        },
        view_complete: () => {
            loading = false;
            if (load_data) {
                getVatsimData();
                load_data = false;
            }
        }
    })
    let active_selection = {};
    if (url_hash.length === 3) {
        map_start_location = [url_hash[1],url_hash[2], url_hash[0]];
        // convert from strings
        map_start_location = map_start_location.map(Number);
    }
    map.setView(map_start_location.slice(0, 3), map_start_location[2]);
    let vatsimTarget = L.icon({
        iconUrl: "/img/aircraftTarget.svg",
        iconSize: [32,32],
        iconAnchor: [16,16],
        popupAnchor: [-20, 20],
    });
    let vatsimAircraft = L.layerGroup().addTo(map);
    // get vatsim data
    function getVatsimData() {
        axios.get(window.map_settings.aircraft_source).then(response => {
            console.log(response.data);
            if (window.map_settings.input_schema === 'phpVMS') {
                let out = { aircraft: {
                        type: "FeatureCollection",
                        features:[]
                    }};
                response.data.forEach((d) => {
                    out.aircraft.features.push(looseJsonParse(phpVMS_Schema, d))
                });
                tangramLayer.scene.setDataSource('aircraft', {type: 'GeoJSON', data: out});
            } else {
                tangramLayer.scene.setDataSource('aircraft', {type: 'GeoJSON', data: response.data});
            }
            console.log('Aircraft Data Loaded');
        });
    }
    function clickHandler(selection) {
        console.log(selection)
    }
    $(function() {
        if ( window.location === window.parent.location ) {
            // The page is in an iframe
        }
        setInterval(() => {
            if (!tangramLayer.scene.view_complete) {
                console.log('Waiting for Map Load');
                load_data = true;
            } else {
                getVatsimData();
            }
        }, 60 * 1000);
    });
</script>
</body>
