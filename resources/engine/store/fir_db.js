export default {
    state: {
        firList: []
    },
    mutations: {
        SET_FIR(state, payload) {
            state.firList = payload;
        },
    },
    actions: {
        initFirData({commit, state}, p) {
            console.log('Init FIR Data');
            // check if the aircraft exists. If not, create a new aircraft.
            axios.get('/firs.json').then(res => {
                console.log(res);
                commit('SET_FIR', res.data.firs.features);
            })
        }
    },
    getters: {
        getFir: (state) => (icao) => {
            if (state.firList === undefined || state.firList.length == 0) {
                return undefined;
            }
            let out = state.firList.find(a => a.properties.prefix === icao);
            if (out) {
                return out;
            } else {
                let out2 = state.firList.find(a => a.properties.icao === icao);
                if (out2) {
                    return out2;
                } else {
                    return null;
                }
            }
        }
    }
}