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
            state.cards = _.orderBy(payload.cards, function (o) { return o.data.code; }, ['asc']);
            state.players = payload.players;
        },

        placeCard(state, payload) {
            state.cards[_.indexOf(state.cards, payload)].on_table = true;
        },
    },

    actions: {
        setGame(context, payload) {
            context.commit('setGame', payload);
        },

        placeCard(context, payload) {
            context.commit('placeCard', payload);
        }
    }
});