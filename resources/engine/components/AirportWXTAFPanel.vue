<template>
    <div>
        <div class="panel-item" style="display: inline-flex; width: 100%; background: #323232">
            <div :class="flightRules" style="border-radius: 50%; height: 25px; width: 25px; margin: auto; border: 2px solid white;">
            </div>
            <div style="margin-left: 1rem; flex: 1">
                <div style="font-size: 24px; line-height: 1">{{ wx.type }} {{ wx.start_time.repr }}</div>
                <div style="font-size: 11px; color: #aaa">{{ wx.sanitized }}</div>
            </div>
        </div>
        <div class="panel-item" style="font-size: 14px;">
            <div class="wx-row" v-if="wx.wind_direction">
                <div class="wx-header">
                    <div>Wind:</div>
                </div>
                <div style="margin-left: .5rem;">
                    <div>{{ wx.wind_direction.repr }}@{{ wx.wind_speed.repr }}</div>
                </div>
            </div>
            <div class="wx-row" v-if="wx.clouds">
                <div class="wx-header">
                    <div>Sky Conditions:</div>
                </div>
                <div style="margin-left: .5rem;">
                    <div v-for="cond in wx.clouds">{{ cond.type }}@{{ cond.altitude }}</div>
                </div>
            </div>
            <div class="wx-row" v-if="wx.visibility">
                <div class="wx-header">
                    <div>Visibility:</div>
                </div>
                <div style="margin-left: .5rem;">
                    <div>{{ wx.visibility.repr }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AirportWXTAFPanel",
        props: {
            wx: Object
        },
        computed: {
            flightRules() {
                switch(this.wx.flight_rules) {
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
