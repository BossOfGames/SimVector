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
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-139927183-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-139927183-1');
    </script>
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
        .custom-controls {
            position: fixed;
            z-index: 5;
            right: .5rem;
            top: .5rem;
            width: 140px;
            height: 70px;
            display: flex;
            justify-content: space-between;
            background: #1a1a1a;
            color: white;
        }
        .filter-button {
            width: 100%;
            text-align: center;
            display: flex;
        }
        .filter-button:hover {
            background: #ffcc00;
            cursor: pointer;
            color:black;
        }
        .flex-justify {
            display: flex;
            justify-content: space-between;
        }
        .zoom-button {
            text-align: center;
            font-weight: 700;
            line-height: 35px;
            font-size: 25px;
            cursor: pointer;
            background: #333333;
            color:white;
        }
        .zoom-button:hover {
            background: #00F98E;
            color:black;
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
<div class="custom-controls">
    <div class="filter-button" onclick="showPanel()">
        <div style="margin: auto">
            <div style="font-size: 18px;"><span class="mdi mdi-cog"></span></div>
            <div style="font-weight: 700">Map Settings</div>
        </div>
    </div>
    <div style="background: blue; width: 50px; display: flex; justify-content: space-between; flex-direction: column">
        <div class="zoom-button" onclick="zoomIn()">+</div>
        <div class="zoom-button" onclick="zoomOut()">–</div>
    </div>
</div>
<div id="sidepanel">
    <side-info-panel/>
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

    function clickHandler(selection) {
        let event = new CustomEvent('airport', { detail: selection });
        window.dispatchEvent(event)
    }
    $(function() {
        if ( window.location === window.parent.location ) {
            // The page is in an iframe
        }
        clickHandler('KMSP')
    });
</script>
</body>
