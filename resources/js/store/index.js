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
        turn: null,
    },

    mutations: {
        setGame(state, payload) {
            state.game = payload.id;
            state.players = payload.players;
            state.turn = _.find(payload.players, function (o) { return o.turn === true; });
            state.cards = _.orderBy(payload.cards, function (o) { return o.data.code; }, ['asc']);
            state.ownCards = _.orderBy(_.filter(payload.cards, function (o) { return o.player_id == USER }), function (o) {
                return o.data.code;
            }, ['asc']);
        },

        placeCard(state, payload) {
            state.cards[_.indexOf(state.cards, payload)].table = true;
        },

        rotateTurn(state) {
            let next = _.indexOf(state.players, state.turn) + 1;
            next = (next >= state.players.length ? 0 : next);
            state.turn = state.players[next];
        },
    },

    actions: {
        setGame(context, payload) {
            context.commit('setGame', payload);
        },

        placeCard(context, payload) {
            context.commit('placeCard', payload);
        },

        rotateTurn(context, payload) {
            context.commit('rotateTurn', payload);
        }
    }
});