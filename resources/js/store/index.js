import vue from 'vue'
import vuex from 'vuex'
import airportSelected from "./airportSelected";
import aircraft from './aircraft';
vue.use(vuex);

export default new vuex.Store({
    modules: {
        airport: airportSelected,
        aircraft: aircraft
    }
});
