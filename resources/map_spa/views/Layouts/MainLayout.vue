<template>
    <div>
        <v-navigation-drawer dark app width="300px" v-model="drawer">
            <div style="display:flex; flex-direction: column; justify-content: space-between;">
                <v-list flat>
                    <v-list-item link to="/">
                        <v-list-item-icon>
                            <v-icon>mdi-map</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Map</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item link to="/flights">
                        <v-list-item-icon>
                            <v-icon>mdi-airplane</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Flights</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item link to="/controllers">
                        <v-list-item-icon>
                            <v-icon>mdi-wifi-on</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Controllers</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </div>
        </v-navigation-drawer>
        <v-app-bar app>
            <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>SimVector</v-toolbar-title>
        </v-app-bar>
        <v-content style="min-height: 100vh;">
            <slot></slot>
        </v-content>
        <v-footer app>
            SimVector AIS. Copyright 2020 Cardinal Horizon, Inc.
        </v-footer>
    </div>
</template>

<script>
    import SideNavMenu from "../../components/SideNavMenu";
    export default {
        name: "MainLayout",
        components: {SideNavMenu},
        created() {
            console.log(this.$vuetify.breakpoint.lgAndUp);
            // this.drawer = !!this.$vuetify.breakpoint.lgAndUp;
            this.drawer = false;
            var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
            var eventer = window[eventMethod];
            var messageEvent = eventMethod === "attachEvent" ? "onmessage" : "message";
        },
        data() {
            return {
                drawer: false,
                items: [
                    {
                        icon: "dashboard",
                        title: "Dashboard"
                    },
                    {
                        icon: "person",
                        title: "Profile"
                    },
                    {
                        icon: "settings",
                        title: "Settings"
                    }
                ]
            }
        }
    }
</script>

<style scoped>

</style>
