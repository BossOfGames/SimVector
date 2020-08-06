<template>
    <div>
        <v-img :aspect-ratio="16/5" src="https://i.imgur.com/Fj4dbUx.png" gradient="rgba(100,115,201,.33), rgba(25,32,72,.7)"></v-img>
        <v-container fluid>
            <v-layout row wrap>
                <v-flex md6 v-for="flight in flights" :key="flight.id">
                    <FlightCard :info="flight"></FlightCard>
                </v-flex>
            </v-layout>
        </v-container>
    </div>
</template>

<script>
    import FlightCard from "../../components/FlightCard";
    export default {
        name: "FlightListView",
        components: {FlightCard},
        data() {
            return {
                flights: [
                    {
                        "id": 130,
                        "user_id": 2,
                        "fo_id": null,
                        "airline_id": 1,
                        "flightnum": "2160",
                        "depapt_id": 3772,
                        "arrapt_id": 3384,
                        "altapt_id": null,
                        "aircraft_id": 137,
                        "route": null,
                        "cruise": null,
                        "route_data": "{\"cruise\":null}",
                        "landingrate": -91,
                        "load": "0",
                        "deptime": null,
                        "arrtime": null,
                        "out": null,
                        "off": null,
                        "on": null,
                        "in": null,
                        "created_at": "2019-01-15 04:01:37",
                        "updated_at": "2019-01-15 18:26:08",
                        "acars_client": "smartCARS",
                        "fuel_used": "18389",
                        "wcBidID": null,
                        "status": 1,
                        "network": null,
                        "lat": 33.6399149194919,
                        "lon": -84.4419902825482,
                        "gs": 0,
                        "altitude": 1034,
                        "distance": null,
                        "type": null,
                        "state": 2,
                        "flighttime": "02.55",
                        "sc_log": "smartCARS version 2.1.31.1, 2019/1/15 UTC*[14:56:16] Preflight started, flying offline*[14:56:16] Flying PMDG 737-942NGX Spark Airlines*[15:10:59] Pushing back with 36835 lb of fuel*[15:12:21] Engine 2 is on*[15:13:57] Engine 1 is on*[15:14:38] Flaps set to position 1*[15:14:45] Flaps set to position 2*[15:14:49] Flaps set to position 3*[15:14:53] Flaps set to position 4*[15:14:56] Flaps set to position 5*[15:15:17] Taxiing to runway*[15:22:40] Taking off*[15:23:09] Climbing, pitch: 9, roll: level, 161 kts*[15:23:12] Gear lever raised at 77 ft at 169 kts*[15:23:18] Flaps set to position 4 at 335 ft at 168 kts*[15:23:45] Flaps set to position 3 at 1577 ft at 174 kts*[15:24:21] Flaps set to position 2 at 2395 ft at 218 kts*[15:24:24] Flaps set to position 1 at 2464 ft at 222 kts*[15:24:31] Flaps set to position 0 at 2664 ft at 231 kts*[15:26:02] Exceeded 250 KIAS below 10,000 feet MSL*[15:26:43] Speed corrected at 9954 ft after a max speed of 274 kts*[15:44:48] Cruising at 35000ft, pitch: 3, 505 kts*[17:55:06] Sim paused*[17:55:08] Sim unpaused*[17:56:16] Descending*[18:08:53] Approaching*[18:12:38] Flaps set to position 1 at 4947 ft at 209 kts*[18:12:46] Flaps set to position 2 at 4910 ft at 202 kts*[18:12:50] Flaps set to position 3 at 4871 ft at 199 kts*[18:14:06] Flaps set to position 4 at 3389 ft at 175 kts*[18:14:26] Final approach, 171 kts*[18:15:03] Gear lever lowered at 2410 ft at 169 kts*[18:15:26] Flaps set to position 5 at 2059 ft at 163 kts*[18:15:35] Flaps set to position 6 at 1955 ft at 160 kts*[18:15:38] Flaps set to position 7 at 1933 ft at 159 kts*[18:17:57] Touched down at -91 fpm, gear lever: down, pitch: 1, roll: level, 143 kts*[18:18:34] Flaps set to position 6*[18:18:37] Flaps set to position 5*[18:18:40] Landed in 4829 ft, fuel: 18613 lb, weight: 143691 lb*[18:18:40] Taxiing to gate*[18:18:40] Flaps set to position 4*[18:18:43] Flaps set to position 3*[18:18:47] Flaps set to position 2*[18:18:51] Flaps set to position 1*[18:18:59] Flaps set to position 0*[18:22:07] The flight may now be ended*[18:22:07] Arrived, flight duration: 02:55*[18:24:33] Engine 2 is off*[18:24:33] Engine 1 is off",
                        "rules": null,
                        "callsign": "SPK2160",
                        "heading": 97,
                        "pacx_url": null,
                        "airline": {},
                        "depapt": {},
                        "arrapt": {},
                        "aircraft": {}
                    }
                ]
            }
        },
        computed: {
            /*
            flights() {
                return this.$store.state.user.flights;
            },
             */
            fch() {
                switch (this.$vuetify.breakpoint.name) {
                    case 'xs': return '200px';
                    case 'sm': return '200px';
                    case 'md': return '200px';
                    case 'lg': return '200px';
                    case 'xl': return '200px';
                }
            }
        }
    }
</script>

<style scoped>

</style>
