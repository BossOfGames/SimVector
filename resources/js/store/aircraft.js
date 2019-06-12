import L from 'leaflet'
let vatsimTarget = L.icon({
    iconUrl: "/img/aircraftTarget.svg",
    iconSize: [32,32],
    iconAnchor: [16,16],
    popupAnchor: [-20, 20],
});
export default {
    state: {
        aircraftList: [],
        selectedAircraft: null
    },
    mutations: {
        SET_INDV_ACF(state, payload) {
            let i = state.aircraftList.findIndex(obj => obj._id = payload._id);
            state.aircraftList[i] = payload;
        },
        ADD_INDV_ACF(state, payload) {
            state.aircraftList.push(payload)
        }
    },
    actions: {
        editAircraft({commit, state}, p) {
            // check if the aircraft exists. If not, create a new aircraft.
            let obj = state.aircraftList.findIndex(obj => obj._id = p._id);
            if (obj === -1) {
                commit('ADD_INDV_ACF', p);
            } else {
                p.marker = L.marker([p.location.coordinates[1], p.location.coordinates[0]], {icon: vatsimTarget, rotationAngle: e.heading});
                p.marker.bindTooltip(e.callsign, {offset: [0, 0], className: 'markerText'});
                p.on_ground = p.groundspeed <= 30;
                commit('SET_INDV_ACF', p);
            }
        }
    }
}
