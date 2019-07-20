import vue from 'vue'
import vuex from 'vuex'
import airportSelected from "./airportSelected";
import aircraft from './aircraft';
import firs from './fir_db';

vue.use(vuex);

export default new vuex.Store({
    modules: {
        airport: airportSelected,
        aircraft: aircraft,
        firs: firs
    }
});
