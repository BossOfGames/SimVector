<template>
    <div>
        <side-nav-bar></side-nav-bar>
        <div style="display: flex; position: fixed;top:0; left: 60px; bottom: 0; right: 0;">
            <SideInfoPanel></SideInfoPanel>
            <div id="map" style="z-index: -100">
            </div>
        </div>
    </div>
</template>

<script>
    function nmToMeters(nm) {
        return nm * 1852;
    }
    // @ is an alias to /src
    import L from 'leaflet';
    import Tangram from 'tangram';
    import axios from 'axios';
    // eslint-disable-next-line no-unused-vars
    import lrm from 'leaflet-rotatedmarker';
    // eslint-disable-next-line no-unused-vars
    import cmarker from 'leaflet-canvas-marker';
    import SideInfoPanel from "./SideInfoPanel";
    import SideNavBar from "./SideNavBar";

    let vatsimTarget = L.icon({
        iconUrl: "/img/aircraftTarget.svg",
        iconSize: [32,32],
        iconAnchor: [16,16],
        popupAnchor: [-20, 20],
    });

    let depTarget = L.icon({
        iconUrl: "/img/map/depTarget.svg",
        iconSize: [24,24],
        iconAnchor: [12,12]
    });
    let arrTarget = L.icon({
        iconUrl: "/img/map/arrTarget.svg",
        iconSize: [24,24],
        iconAnchor: [12,12]
    });
    let atc_del = L.icon({
        iconUrl: "/img/ATC_DEL.svg",
        iconSize: [16,16],
        iconAnchor: [8,8],
        popupAnchor: [-20, 20],
    });
    let atc_gnd = L.icon({
        iconUrl: "/img/ATC_GND.svg",
        iconSize: [16,16],
        iconAnchor: [8,8],
        popupAnchor: [-20, 20],
    });
    let atc_twr = L.icon({
        iconUrl: "/img/ATC_TWR.svg",
        iconSize: [16,16],
        iconAnchor: [8,8],
        popupAnchor: [-20, 20],
    });
    let atc_app = L.icon({
        iconUrl: "/img/ATC_APP.svg",
        iconSize: [16,16],
        iconAnchor: [8,8],
        popupAnchor: [-20, 20],
    });
    let atc_ctr = L.icon({
        iconUrl: "/img/ATC_CTR.svg",
        iconSize: [16,16],
        iconAnchor: [8,8],
        popupAnchor: [-20, 20],
    });
    // get vatsim data
    export default {
        name: 'Map',
        components: {SideNavBar, SideInfoPanel},
        data() {
            return {
                lmap: null,
                tangramLayer: null,
                vatsimLayer: null,
                vatsimAircraft: [],
                acf_markers: [],
                ground_targets: [],
                vatsimATCLayer: null,
                vatsimATC: []
            }
        },
        mounted() {
            var map_start_location = [37.487, -98.981, 5]; // Full United States
            this.lmap = L.map(document.getElementById('map'));
            this.lmap.zoomControl.setPosition('topright');
            this.tangramLayer = Tangram.leafletLayer({
                scene: 'classic_map.yaml',
                attribution: 'openAIP | &copy; OSM contributors | <b style="color: red">NOT FOR REAL WORLD NAVIGATION</b>',
                selectionRadius: 10,
                events: {
                    click: this.clickHandler
                }
            });
            this.tangramLayer.addTo(this.lmap);
            this.lmap.setView(map_start_location.slice(0, 3), map_start_location[2]);
            this.vatsimLayer = L.layerGroup().addTo(this.lmap);
            this.vatsimATCLayer = L.layerGroup().addTo(this.lmap);
            this.getVatsimData();
            setInterval(() => {
                this.getVatsimData();
            }, 60 * 1000);
        },
        updated() {
            console.log('Updated');
            this.tangramLayer.scene.updateConfig();
        },
        methods: {
            getVatsimData() {
                axios.get('/api/flights/vatsim').then(response => {
                    this.vatsimLayer.clearLayers();
                    response.data.forEach(e => {
                        let marker = L.marker([e.location.coordinates[1], e.location.coordinates[0]], {icon: vatsimTarget, rotationAngle: e.heading}).addTo(this.vatsimLayer);
                        marker.bindTooltip(e.callsign, {offset: [0, 0], className: 'markerText'});
                    })
                });
                console.log('VATSIM Aircraft Updated');
                axios.get('/api/vatsim/atc').then(res => {
                    this.vatsimATCLayer.clearLayers();
                    // Ok, now let's check if we got coordinate data
                    res.data.forEach(e => {
                        let cs_split = e.callsign.split('_');
                        let marker = null;
                        let circle = null;
                        switch (cs_split[cs_split.length-1]) {
                            case "DEL":
                                marker = L.marker([e.location.coordinates[1], e.location.coordinates[0]], {icon: atc_del}).addTo(this.vatsimATCLayer);
                                marker.bindTooltip(e.callsign + ' | ' + e.frequency + '<br>' + e.full_name);
                                circle = L.circle([e.location.coordinates[1], e.location.coordinates[0]], {radius: nmToMeters(e.visual_range), fill: false, color: '#f96f23'}).addTo(this.vatsimATCLayer);
                                break;
                            case "GND":
                                marker = L.marker([e.location.coordinates[1], e.location.coordinates[0]], {icon: atc_gnd}).addTo(this.vatsimATCLayer);
                                marker.bindTooltip(e.callsign + ' | ' + e.frequency + '<br>' + e.full_name);
                                circle = L.circle([e.location.coordinates[1], e.location.coordinates[0]], {radius: nmToMeters(e.visual_range), fill: false, color: '#2ef923'}).addTo(this.vatsimATCLayer);
                                break;
                            case "TWR":
                                marker = L.marker([e.location.coordinates[1], e.location.coordinates[0]], {icon: atc_twr}).addTo(this.vatsimATCLayer);
                                marker.bindTooltip(e.callsign + ' | ' + e.frequency + '<br>' + e.full_name);
                                circle = L.circle([e.location.coordinates[1], e.location.coordinates[0]], {radius: nmToMeters(e.visual_range), fill: false, color: '#17c2c6'}).addTo(this.vatsimATCLayer);
                                break;
                            case "APP":
                            case "DEP":
                                marker = L.marker([e.location.coordinates[1], e.location.coordinates[0]], {icon: atc_app}).addTo(this.vatsimATCLayer);
                                marker.bindTooltip(e.callsign + ' | ' + e.frequency + '<br>' + e.full_name);
                                circle = L.circle([e.location.coordinates[1], e.location.coordinates[0]], {radius: nmToMeters(e.visual_range), fill: false, color: '#fcee21'}).addTo(this.vatsimATCLayer);
                                break;
                            case "CTR":
                            case "FSS":
                                marker = L.marker([e.location.coordinates[1], e.location.coordinates[0]], {icon: atc_ctr}).addTo(this.vatsimATCLayer);
                                marker.bindTooltip(e.callsign + ' | ' + e.frequency + '<br>' + e.full_name);
                                circle = L.circle([e.location.coordinates[1], e.location.coordinates[0]], {radius: nmToMeters(e.visual_range), fill: false, color: '#e51515'}).addTo(this.vatsimATCLayer);
                                break;
                        }
                    })
                })
            },
            clickHandler(selection) {
                // Update the airport currently selected.
                console.log(selection);
                if (selection.feature !== undefined) {
                    this.$store.commit('SET_AIRPORT', null);
                    axios.get('/api/airport/'+ selection.feature.properties.icao).then(res => {
                        this.$store.commit('SET_AIRPORT', res.data)
                    })
                }
            },
            addAircraft(aircraft) {

            }
        },
        watch: {
            activeAircraft(n, o) {
                n.forEach(a => {
                    // Check to see if they're aircraft on the ground.
                    let i = this.acf_markers.findIndex(e => e._id === a._id);
                    if (i !== -1) {
                        // found the aircraft, we need to update.
                        this.acf_markers[i].marker.slideTo([a.location.coordinates[1], a.location.coordinates[0]]);
                        this.acf_markers[i].marker.setRotationAngle(a.heading);
                    } else {
                        this.acf_markers.push(a);
                        let b = this.acf_markers.findIndex(e => e._id === a._id);
                        this.acf_markers[b].marker.addTo(this.vatsimLayer);
                    }
                })
            }
        },
        computed: {
            activeAircraft() {
                return this.$store.state.aircraft.aircraftList;
            }
        }
    }
</script>
<style scoped>
    #map {
        width: 100%;
        height: 100%;
    }
</style>
