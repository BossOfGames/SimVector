<!doctype html>
<head>
    <title>SimVector Map Engine</title>
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.1.45/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="/css/map_controls.css"/>
    <script src="{{ mix('js/engine.js') }}" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@200;400;700&display=swap" rel="stylesheet">
    <style>
        body {
            height: 100%;
            margin: 0;
            font-family: 'Titillium Web', sans-serif;
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

        /* The switch - the box around the slider */
        .switch {
            position: relative;
            display: inline-block;
            width: 30px;
            height: 20px;
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 10px;
            width: 10px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(10px);
            -ms-transform: translateX(10px);
            transform: translateX(10px);
        }
    </style>
</head>
<body>
<div id="filters" class="side-panel" style="color: white;">
    <div class="side-header" style="background: #2eb5ff; z-index: 40; display: flex; justify-content: space-between; position: sticky; top: 0;">
        <div style="font-size: 18px; font-weight: bold; margin: auto 0;">Map Settings</div>
        <div>
            <i class="material-icons panel-close" onclick="closePanel()">close</i>
        </div>
    </div>
    <div class="side-header">Layers</div>
    <div class="panel-item flex-justify">
        <div>FIR/UIR Boundaries</div>
        <label class="switch">
            <input id="layer_firs" type="checkbox" checked>
            <span class="slider"></span>
        </label>
    </div>
    <div class="panel-item flex-justify">
        <div>Aircraft</div>
        <label class="switch">
            <input id="layer_aircraft" type="checkbox" checked>
            <span class="slider"></span>
        </label>
    </div>
    <div style="padding: 1rem;">
    </div>
</div>
<div id="app">
    <main>
        <div>
            <SVMap></SVMap>
        </div>
    </main>
</div>
<!-- leaflet -->
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"></script>
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="/lib/leaflet-hash.js"></script>
<!-- Main tangram library -->
<script src="https://unpkg.com/tangram/dist/tangram.debug.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
</script>

<script>
    let map = L.map('map', {zoomControl: false});
    let tangramLayer = Tangram.leafletLayer({
        scene: 'vfr_map.yaml',
        attribution: 'openAIP | &copy; OSM contributors | <b style="color: red">FOR SIM USE ONLY</b>',
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
        axios.get('/vatsimflights.json').then(response => {
            console.log(response.data);

                tangramLayer.scene.setDataSource('aircraft', {type: 'GeoJSON', data: response.data});

            console.log('Aircraft Data Loaded');
        });
    }
    function clickHandler(selection) {
        console.log(selection);
        if (selection.feature !== undefined) {
            if (selection.feature.source_layer === "airports") {
                let event = new CustomEvent('airport', { detail: selection.feature.properties.icao });
                window.dispatchEvent(event)
            }
        }
    }
    // Interface Control Functions
    function zoomIn() {
        map.zoomIn(.5)
    }
    function zoomOut() {
        map.zoomOut(.5)
    }
    function showPanel() {
        $('#filters').show()
    }
    function closePanel() {
        $('#filters').hide()
    }
    $(function() {
        if ( window.location === window.parent.location ) {
            // The page is in an iframe
        }
        $('#layer_firs').change(() => {
            tangramLayer.scene.config.layers.firs.visible = $('#layer_firs').is(":checked");
            tangramLayer.scene.rebuild()
        });
        $('#layer_aircraft').change(() => {
            tangramLayer.scene.config.layers.aircraft.visible = $('#layer_aircraft').is(":checked");
            tangramLayer.scene.rebuild()
        });
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
