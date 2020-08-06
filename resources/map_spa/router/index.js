
import Vue from 'vue'
import Router from 'vue-router'
import store from '../store'

import FlightListView from "../views/Flights/FlightListView";
import FlightDetailedView from "../views/Flights/FlightDetailedView";
import Login from "../views/Auth/Login";
import SettingsView from "../views/SettingsView";
import InterfaceSettingsAdminView from "../views/Admin/InterfaceSettingsAdminView";
import LiveMapView from "../views/LiveMapView";
import AirportsView from "../views/Airports/AirportsView";
import AirportsDetailedView from "../views/Airports/AirportsDetailedView";

Vue.use(Router);

function doAuth(to, from, next) {

}
export default new Router({
    routes: [
        { path: '/', name: 'dashboard', component: LiveMapView },
        { path: '/login', name: 'login', component: Login, meta: {layout: 'blank'}},
        { path: '/register', name: 'register', component: Login, meta: {layout: 'blank'}},
        // Flight Management and Browsing System
        { path: '/flights', name: 'flights', component: FlightListView},
        { path: '/flights/:id', name: 'flights_detailed', component: FlightDetailedView},
        // Controller View System
        { path: '/controllers', name: 'controllers', component: FlightListView},
        { path: '/firs', name: 'firs', component: FlightDetailedView},
        { path: '/firs/:id', name: 'firs_detailed', component: FlightDetailedView},
        // Airports Display
        { path: '/airports', name: 'airports', component: AirportsView},
        { path: '/airports/:icao', name: 'airports_detailed', component: AirportsDetailedView},
        // User Profiles
        { path: '/settings', name: 'settings', component: SettingsView},
        { path: '/settings/admin', name: 'settings_admin', component: InterfaceSettingsAdminView},
    ]
});
