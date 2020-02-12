import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const _ = require('lodash');

export default new Vuex.Store({
    state: {
        game: null,
        cards: [],
        players: [],
        ownCards: [],
    },

    mutations: {
        setGame(state, payload) {
            state.game = payload.id;
            state.players = payload.players;
            state.cards = _.orderBy(payload.cards, function (o) { return o.data.code; }, ['asc']);
            state.ownCards = _.orderBy(_.filter(payload.cards, function (o) { return o.player_id == USER }), function (o) {
                return o.data.code;
            }, ['asc']);
        },

        placeCard(state, payload) {
            state.cards[_.indexOf(state.cards, payload)].table = true;
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