import vuex from 'vuex'
import axios from 'axios'

export default {
    state: {
        info: null,
        charts: null,
        cycle: null,
        loading: false
    },
    mutations: {
        SET_AIRPORT(state, payload) {
            if (payload == null) {
                state.info = null;
                state.charts = null;
                state.cycle = null;
            } else {
                state.info = payload.airport;
                state.charts = payload.charts;
                state.cycle = payload.cycle;
            }
        },
        SET_LOADING(state, payload) {
            state.loading = payload;
        }
    },
    actions: {
        checkAndSetAirport({commit, state}, icao) {
            axios.get('/api/airports', {
                params: {
                    icao: icao
                }
            }).then(res => {
                commit('SET_LOADING', true);
                commit('SET_AIRPORT', res.data);
                commit('SET_LOADING', false);
            });
        }
    }
}
