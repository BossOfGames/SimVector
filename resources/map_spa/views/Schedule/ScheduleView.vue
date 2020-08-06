<template>
    <div>
        <div>
            <v-container class="flex">
                <v-layout grid row style="max-width: 400px; margin: 0 auto;">
                    <v-flex md6 sm12>
                        <ApiPullAutoComplete v-model="filter_options.depapt" label="Origin" url="https://fsvaos.net/api/data/airports/search"/>
                        <ApiPullAutoComplete v-model="filter_options.arrapt" label="Destination" url="https://fsvaos.net/api/data/airports/search"/>
                    </v-flex>
                    <v-flex md6 sm12>
                        <ApiPullAutoComplete v-model="filter_options.aircraft" label="Origin" url="https://fsvaos.net/api/data/aircraft/search"/>
                        <ApiPullAutoComplete v-model="filter_options.aviation_group" label="Destination" url="https://fsvaos.net/api/data/airports/search"/>
                    </v-flex>
                </v-layout>
            </v-container>
            <v-img :aspect-ratio="16/5" src="https://i.imgur.com/Fj4dbUx.png" gradient="rgba(100,115,201,.33), rgba(25,32,72,.7)"></v-img>
        </div>
        <div>
            <v-container grid-list-lg>
                <v-layout grid row>
                    <v-flex lg4 md6 sm12 v-for="flight in schedule_list" :key="flight.id">
                        <v-card class="mx-auto mb-4">
                            <v-img class="white--text align-end" height="150px" src="https://upload.wikimedia.org/wikipedia/commons/2/2c/SLC_airport%2C_2010.jpg"></v-img>
                            <v-card-title>{{flight.callsign}}</v-card-title>
                            <v-card-subtitle class="pb-0">{{flight.depapt}}-{{flight.arrapt}}</v-card-subtitle>
                            <v-card-actions>
                                <v-btn text color="primary">View Details</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </div>
    </div>
</template>

<script>
    import ApiPullAutoComplete from "../../components/ApiPullAutoComplete";
    export default {
        name: "ScheduleView",
        components: {ApiPullAutoComplete},
        data() {
            return {
                schedule_list: [],
                filter_options: {
                    depapt: '',
                    arrapt: '',
                    aircraft: '',
                    deptime: '',
                    arrtime: '',
                    aviation_group: ''
                }
            }
        },
        created() {
            this.$http.get('/api/materialcrewredux/schedule').then(res => {
                this.schedule_list = res.data
            })
        },
        computed: {
            filtered_list() {
                this.schedule_list.filter(flight => {
                    for (let key in this.filter_options) {
                        if (key === '') {
                            continue;
                        }
                        if (flight[key] === undefined || flight[key] !== this.filter_options[key])
                            return false;
                    }
                    return true;
                })
            }
        }
    }
</script>

<style scoped>

</style>
