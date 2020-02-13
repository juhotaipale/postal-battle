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

        async demo(state, payload) {
            let order = [0, 1, 2, 7, 3, 8, 14, 9, 10, 11, 4, 21, 5, 28,
                15, 16, 17, 29, 30, 31, 6, 12, 13, 35, 36, 37, 38, 22, 23,
                18, 24, 25, 26, 49, 50, 27, 32, 33, 39, 40, 34, 41, 51,
                52, 53, 54, 42, 43, 55, 19, 20, 44, 45, 46, 47, 48];

            for (let i = 0; i < order.length; i++) {
                axios.post('/api/game/' + payload + '/place/' + state.cards[order[i]].id);

                await new Promise(r => setTimeout(r, 1000));
            }
        }
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
        },

        demo(context, payload) {
            context.commit('demo', payload);
        },
    }
});