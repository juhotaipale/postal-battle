import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const _ = require('lodash');

export default new Vuex.Store({
    state: {
        game: null,
        cards: [],
        players: [],
    },

    mutations: {
        setGame(state, payload) {
            state.game = payload.if;
            state.cards = payload.cards;
            state.players = payload.players;
        },
    },

    actions: {
        setGame(context, payload) {
            context.commit('setGame', payload);
        },
    }
});