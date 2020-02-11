import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const _ = require('lodash');

export default new Vuex.Store({
    state: {
        game: null,
        players: [],
    },

    mutations: {
        setDestination(state, payload) {
            state.selectedDestination = payload;
        },
    },

    actions: {
        setData(context, payload) {
            context.commit('setData', payload);
        },
    }
});