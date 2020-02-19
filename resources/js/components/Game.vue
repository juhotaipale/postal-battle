<template>
    <div class="game-container d-flex flex-column align-items-center" :class="{ 'activeTurn': myTurn }">
        <div class="status w-100 pt-4 align-self-baseline">
            <div class="container">
                <div class="row">
                    <div class="col-2">
                        <a href="/">
                            <img src="/img/postal_battle.svg" height="40px" />
                        </a>
                    </div>
                    <div v-if="game && !game.finished_at" ref="turn" class="col-6">
                        <h2 v-if="turn.id == user" class="text-uppercase mb-0 mt-1">It's your turn</h2>
                        <h2 v-else-if="turn" class="mb-0 mt-1">Waiting for {{ turn.name }}'s move...</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="distribution-centres d-flex flex-row align-items-end mb-5" style="height: 500px;">
            <placeholder v-for="card in distributionCentres" :key="card.id" class="mx-2" :cards="filterByDistributionCentre(card)"></placeholder>
        </div>
        <div class="hand mb-4" style="height: 350px;">
            <hand></hand>
        </div>
    </div>
</template>

<script>
    import { mapState, mapActions } from 'vuex';

    export default {
        name: "Game",
        props: ['uuid'],
        data() {
            return {
                loading: true,
            }
        },
        computed: {
            ...mapState(['game', 'cards', 'players', 'turn']),

            user: function () {
                return USER;
            },

            myTurn: function () {
                return this.game && this.turn.id == USER;
            },

            distributionCentres: function () {
                return _.filter(this.cards, function (o) {
                    return o.type === 'distributionCentre';
                });
            },
        },

        methods: {
            ...mapActions(['setGame', 'demo']),

            filterByDistributionCentre: function (distributionCentre) {
                let cards = _.filter(this.cards, function (o) {
                    return (o.data.code).substring(0, 2) === (distributionCentre.data.code).substring(0, 2);
                });

                return _.orderBy(cards, ['data.code'], ['desc']);
            },

            fetchGame: function () {
                axios.get('/api/game/' + this.uuid)
                    .then(response => {
                        this.setGame(response.data);
                        this.loading = false;
                    })
                    .catch(error => {
                        alert(error.message);
                    });
            }
        },

        created() {
            window.DEMO = (game) => {
                this.demo(game);
            };

            this.fetchGame();

            Echo.private('game.' + this.uuid)
                .listen('.updated', (e) => {
                    this.fetchGame();
                });
        }
    }
</script>

<style scoped>
    .game-container {
        height: 100%;
        border: 5px dashed transparent;
    }

    .activeTurn {
        border-color: orangered !important;
    }

    .blinker {
        animation: blink .1s step-end 5 alternate;
    }

    @keyframes blink {
        50% {
            color: red;
        }
    }
</style>