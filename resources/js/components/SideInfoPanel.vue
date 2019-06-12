<template>
    <div class="side-panel" v-if="airport" style="z-index: 100">
        <div class="side-header" style="background: #2eb5ff; z-index: 40; display: flex; justify-content: space-between; position: sticky; top: 0;">
            <div style="font-size: 18px; font-weight: bold; margin: auto 0;">{{airport.name}}</div>
            <div>
                <i class="material-icons panel-close" @click="closePanel">close</i>
            </div>
        </div>
        <SidePanelTabs :tabs="tabs" :initialTab="initialTab">

            <template slot="tab-body-main">
                <AirportInfoTab :airport="airport" :current_wx="metar"></AirportInfoTab>
            </template>

            <template slot="tab-body-freq">
                <div>
                    <div class="side-header" style="background: #fc2200">Airport Frequencies Not Verified</div>
                    <div class="panel-item" v-for="freq in airport.freqs">
                        <div style="font-size: 18px; font-weight: bold">{{ freq.description }}</div>
                        <div>{{ freq.frequency }}</div>
                    </div>
                </div>
            </template>

            <template slot="tab-body-wx">
                <AirportWXTab :airport="airport" :metar="metar" :taf="taf"></AirportWXTab>
            </template>

            <template slot="tab-body-charts">
                <AirportChartsTab></AirportChartsTab>
            </template>


            <template slot="tab-nav-main">
                <div>
                    <i class="material-icons">info</i>
                    <div>
                        Info
                    </div>
                </div>
            </template>
            <template slot="tab-nav-freq">
                <div>
                    <i class="material-icons">headset_mic</i>
                    <div>
                        Freq
                    </div>
                </div>
            </template>
            <template slot="tab-nav-wx">
                <div>
                    <i class="material-icons">cloud</i>
                    <div>
                        WX
                    </div>
                </div>
            </template>
            <template slot="tab-nav-charts">
                <div>
                    <i class="material-icons">map</i>
                    <div>
                        Charts
                    </div>
                </div>
            </template>
        </SidePanelTabs>
    </div>
</template>

<script>
    import SidePanelTabs from "./SidePanelTabs";
    import axios from 'axios';
    import AirportInfoTab from "./AirportInfoTab";
    import AirportWXTab from "./AirportWXTab";
    import AirportChartsTab from "./AirportChartsTab";
    export default {
        name: "SideInfoPanel",
        components: {AirportChartsTab, AirportWXTab, AirportInfoTab, SidePanelTabs},
        data() {
            return {
                showing: false,
                initialTab: 'main',
                tabs: ['main', 'freq', 'wx', 'charts'],
                metar: null,
                taf: null
            }
        },
        created() {
            this.getWX(this.airport.gps_code);
            setInterval(this.getWX(this.airport.gps_code), 300 * 1000)
        },
        methods: {
            getWX(icao) {
                // Get the METAR
                axios.get('/api/wx/all/'+icao, {
                    params: {
                        format: 'json',
                        onfail: 'cache'
                    }
                }).then(res => {
                    this.metar = res.data.metar;
                    this.taf = res.data.taf;
                });
            },
            closePanel() {
                this.$store.commit('SET_AIRPORT', null);
            }
        },
        watch: {
            airport(n) {
                // Get the wx
                this.getWX(n.gps_code)
            }
        },
        computed: {
            airport() {
                return this.$store.state.airport.info;
            }
        }
    }
</script>

<style>
    @media (min-width: 576px) {
        .side-panel {
            position: fixed;
            left: 0;
            top: 0;
            width: 350px !important;
            bottom: 0;
        }
    }
    .side-panel {
        position: fixed;
        left: 0;
        top: 0;
        bottom: 0;
        width: 100%;
        background: #1a1a1a;
        z-index: 30;
        overflow-x: hidden;
        overflow-y: auto;
    }
    .panel-close {
        cursor: pointer;
        line-height: inherit;
        transition: .2s;
    }
    .panel-close:hover {
        color: #ffcc00;
        transition: .2s;
    }
    .panel-item {
        padding: 1rem;
        background: #111;
    }
    .side-title {
        font-size: 16px;
    }
    .sp-widget {
        padding: 0 1rem;
        display: inline-flex;
        justify-content: center;
    }
    .dep-arr-container > div
    {
        flex: 1;
    }
    .dep-arr-container {
        display: flex;
        flex-direction: row;
        align-items: stretch;
        width: 100%;
    }
    .sp-widget-icon {
    }
    .sp-widget-icon > .material-icons {
        font-size: 2.5rem;
        line-height: inherit;
    }
    .sp-widget-content {
        position: relative; margin-top: auto; margin-bottom: auto; margin-right: 0;
        padding-left: .5rem;
    }
    .side-header {
        padding: .5rem 1rem;
        background: #2a2a2a;
        position: relative;
        z-index: 10;
        box-shadow: rgba(0,0,0,.72) 0 0 10px;
    }
    .side-image {
        height: 200px;
        background: #2eb5ff center no-repeat;
        background-size: cover;
    }
    .sp-nav {
        width: 100%;
        display: flex;
        flex-direction: row;
        align-items: stretch;
        background: #333;
    }
    .sp-nav-item {
        flex: 1;
        text-align: center;
        line-height: 1;
        padding: .25rem 1rem;
        padding-bottom: .5rem;
        color: white;
        border: none;
        background: transparent;
        text-decoration: none;
        text-underline: none;
        transition: .2s;
    }
    .vfr {
        background: rgba(39, 193, 84, 1);
    }
    .mvfr {
        background: #298dde;
    }
    .ifr {
        background: #da1319;
    }
    .lifr {
        background: #e81ce9;
    }
    .footer-nav > .active {
        color: #2eb5ff;
    }
    .sp-nav-item:hover {
        background: #ffcc00;
        transition: .2s;
        color: white;
        border: none;
        text-decoration: none;
        text-underline: none;
    }
</style>
