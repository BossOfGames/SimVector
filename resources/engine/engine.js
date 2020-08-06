/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

//const files = require.context('./', true, /\.vue$/i);
//files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

import svmap from './components/SVMap'
import svmapafv from './components/SVMapAFV'
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import SideInfoPanel from "./components/SideInfoPanel";
import vle from 'vue-echo-laravel'
//Vue.use(vle, window.Echo);
import L from 'leaflet'

/*
window.Echo.channel('laravel_database_flight-data').listen('VatsimUpdated', e => {
    console.log(e);
});
*/
import store from './store'
const app = new Vue({
    created() {
    },
    components: {
        SideInfoPanel
    },
    store,
    el: '#app',
});
