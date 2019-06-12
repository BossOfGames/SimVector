<template>
    <div>
        <div class="panel-item" style="display: inline-flex; width: 100%; background: #323232">
            <div :class="flightRules" style="border-radius: 50%; height: 25px; width: 25px; margin: auto; border: 2px solid white;">
            </div>
            <div style="margin-left: 1rem; flex: 1">
                <div style="font-size: 24px; line-height: 1">{{ airport.gps_code }}</div>
                <div style="font-size: 11px; color: #aaa">Elevation: {{ airport.elevation_ft }}ft | {{ airport.municipality }}</div>
            </div>
        </div>
        <div class="panel-item" v-if="current_wx">
            {{ current_wx.sanitized }}
        </div>
        <div class="sp-nav" v-if="this.$store.state.airport.charts">
            <button class="sp-nav-item" v-if="apd" @click="openChart(apd[0].pdf_name)">
                <i class="material-icons">info</i>
                <div>
                    Diagram
                </div>
            </button>
            <button class="sp-nav-item" v-if="min" @click="openChart(min[0].pdf_name)">
                <i class="material-icons">flight_takeoff</i>
                <div>
                    TO Mins
                </div>
            </button>
            <button class="sp-nav-item" v-if="hot" @click="openChart(hot[0].pdf_name)">
                <i class="material-icons">whatshot</i>
                <div>
                    Hotspots
                </div>
            </button>
        </div>
        <div class="side-header"><span class="side-title">Departures/Arrivals</span></div>
        <div class="dep-arr-container">
            <a style="flex: 1">
                <div class="sp-widget" style="background: #34a422; width: 100%">
                    <div class="sp-widget-icon">
                        <i class="material-icons">flight_takeoff</i>
                    </div>
                    <div class="sp-widget-content">
                        <div style="font-size: 40px">{{ dep.length }}</div>
                    </div>
                </div>
            </a>
            <a style="flex: 1">
                <div class="sp-widget" style="background: #a42125; width: 100%">
                    <div class="sp-widget-icon">
                        <i class="material-icons">flight_land</i>
                    </div>
                    <div class="sp-widget-content">
                        <div style="font-size: 40px">{{ arr.length }}</div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AirportInfoTab",
        data() {
            return {
                dep: 0,
                arr: 0
            }
        },
        props: {
            airport: Object,
            current_wx: Object,
        },
        created() {
            setInterval(this.getDepArr(this.airport.gps_code), 60 * 1000);
        },
        methods: {
            openChart(chart) {
                window.open('https://aeronav.faa.gov/d-tpp/1906/'+chart, '_blank')
            },
            getDepArr(icao) {
                // Get the METAR
                axios.get('/api/flights/vatsim/'+icao, {
                }).then(res => {
                    this.dep = res.data.dep;
                    this.arr = res.data.arr;
                });
            }
        },
        computed: {
            flightRules() {
                if(this.current_wx) {
                    switch (this.current_wx.flight_rules) {
                        case 'VFR':
                            return {'vfr': true};
                        case 'MVFR':
                            return {'mvfr': true};
                        case 'IFR':
                            return {'ifr': true};
                        case 'LIFR':
                            return {'lifr': true};
                    }
                }
                else {
                    return null
                }
            },
            apd() {
                return this.$store.state.airport.charts.charts.filter(c =>  c.chart_code === "APD")
            },
            hot() {
                return this.$store.state.airport.charts.charts.filter(c =>  c.chart_code === "HOT")
            },
            min() {
                return this.$store.state.airport.charts.charts.filter(c =>  c.chart_code === "MIN")
            },

        }
    }
</script>

<style scoped>

</style>
