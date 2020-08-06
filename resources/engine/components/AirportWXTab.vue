<template>
    <div v-if="metar && taf">
        <div class="side-header">
            Current Weather
        </div>
        <div class="panel-item" style="display: inline-flex; width: 100%; background: #323232">
            <div :class="flightRules" style="border-radius: 50%; height: 25px; width: 25px; margin: auto; border: 2px solid white;">
            </div>
            <div style="margin-left: 1rem; flex: 1">
                <div style="font-size: 24px; line-height: 1">{{ metar.time.repr }}</div>
                <div style="font-size: 11px; color: #aaa">{{ metar.raw }}</div>
            </div>
        </div>
        <div class="panel-item" style="font-size: 14px;">
            <div class="wx-row">
                <div class="wx-header">
                    <div>Wind:</div>
                </div>
                <div style="margin-left: .5rem;">
                    <div>{{ metar.wind_direction.repr }}@{{ metar.wind_speed.repr }}</div>
                </div>
            </div>
            <div class="wx-row">
                <div class="wx-header">
                    <div>Sky Conditions:</div>
                </div>
                <div style="margin-left: .5rem;">
                    <div v-for="cond in metar.clouds">{{ cond.repr }}</div>
                </div>
            </div>
            <div class="wx-row">
                <div class="wx-header">
                    <div>Temperature:</div>
                </div>
                <div style="margin-left: .5rem;">
                    <div>{{ metar.temperature.repr }}{{ metar.units.temperature }}</div>
                </div>
            </div>
            <div class="wx-row">
                <div class="wx-header">
                    <div>Dew Point:</div>
                </div>
                <div style="margin-left: .5rem;">
                    <div>{{ metar.dewpoint.repr }}{{ metar.units.temperature }}</div>
                </div>
            </div>
            <div class="wx-row">
                <div class="wx-header">
                    <div>Altimeter:</div>
                </div>
                <div style="margin-left: .5rem;">
                    <div>{{ metar.altimeter.value }}</div>
                </div>
            </div>
        </div>
        <div class="side-header">
            Terminal Area Forecast
        </div>
        <div v-for="c in taf.forecast">
            <airport-w-x-t-a-f-panel :wx="c"></airport-w-x-t-a-f-panel>
        </div>
    </div>
</template>

<script>
    import AirportWXTAFPanel from "./AirportWXTAFPanel";
    export default {
        name: "AirportWXTab",
        components: {AirportWXTAFPanel},
        props: {
            airport: Object,
            metar: Object,
            taf: Object
        },
        computed: {
            flightRules() {
                switch(this.metar.flight_rules) {
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
        }
    }
</script>

<style scoped>
    .wx-row {
        display: flex;
        justify-content: space-between;
    }
    .wx-header {
        text-align: right;
        font-weight: bold;
        margin-right: .5rem;
    }
</style>
