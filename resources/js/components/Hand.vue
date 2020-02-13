<template>
    <div class="d-flex flex-column align-items-center justify-content-center" style="width: 90vw; height: 100%;">
        <div class="pb-2">
            <h4 v-if="game && !game.finished_at && myTurn">
                <span v-if="! canPlaceCard" class="text-uppercase hover">
                    <span v-if="getCardLoading"><font-awesome-icon icon="circle-notch" spin /></span>
                    <span v-else @click="getCard">Get a card from previous player</span>
                </span>
                <span v-if="! canPlaceCard && turn.skip"> or </span>
                <span v-if="turn.skip" class="text-uppercase hover" @click="skipTurn">
                    Skip your turn
                </span>
            </h4>
        </div>

        <div class="d-flex flex-row flex-wrap mb-5 justify-content-center align-items-center">
            <h1 v-if="game && cardsInHand.length === 0" class="align-self-center text-uppercase">You won the game</h1>
            <h1 v-else-if="game && game.finished_at" class="align-self-center text-uppercase">Game over, you lost the game</h1>

            <card v-if="!game.finished_at" :ref="card.id" style="margin-left: -35px; margin-right: -35px;" v-for="(card, index) in cardsInHand" :key="card.id"
                  :style="{ zIndex: (index > selected ? 100 - index : 100 + index) }" class="my-2" :class="{ selected: (index === selected) }"
                  :card="card" @click.native="select(index)"></card>
        </div>

        <a v-if="game && (cardsInHand.length === 0 || game.finished_at)" href="/" class="text-dark">
            <h4 class="text-uppercase">Return to main screen</h4>
        </a>
    </div>
</template>

<script>
    import { mapState, mapActions } from 'vuex';

    export default {
        name: "Hand",
        data() {
            return {
                selected: null,
                getCardLoading: false,
            }
        },
        computed: {
            ...mapState(['game', 'cards', 'ownCards', 'turn']),

            cardsInHand: function () {
                return _.filter(this.ownCards, function (o) {
                    return ! o.table;
                });
            },

            myTurn: function () {
                return this.turn.id == USER;
            },

            canPlaceCard: function () {
                let can = false;

                _.each(this.cardsInHand, (card) => {
                    if (! card.parent_id) {
                        switch (card.data.code) {
                            case '00000':
                                can = true;
                                break;
                            case '33000':
                            case '40000':
                            case '53000':
                                can = _.filter(this.cards, function (o) {
                                    return o.table === true && o.data.code === '00000';
                                }).length === 1;
                                break;
                            default:
                                can = _.filter(this.cards, function (o) {
                                    return o.table === true && _.includes(['33000', '40000', '53000'], o.data.code);
                                }).length === 3;
                                break;
                        }
                    } else {
                        can = _.find(this.cards, function (o) {
                            return o.id === card.parent_id && o.table;
                        });
                    }

                    if (can) return false;
                });

                return can;
            },
        },
        methods: {
            ...mapActions(['placeCard', 'rotateTurn', 'appendCard']),

            select: function (index) {
                this.selected = index;
            },

            skipTurn: function () {
                this.rotateTurn();

                axios.post('/api/game/' + this.$parent.uuid + '/skip')
                    .catch(error => {
                        alert(error.message);
                    });
            },

            getCard: function () {
                this.getCardLoading = true;

                axios.post('/api/game/' + this.$parent.uuid + '/getCard')
                    .then(response => {
                        this.appendCard(response.data);
                        this.rotateTurn();
                    })
                    .catch(error => {
                        alert(error.message);
                    })
                    .finally(() => {
                        this.getCardLoading = false;
                    });
            },

            place: function (card) {
                if (this.turn.id == USER) {

                    let allowed = false;

                    if (!card.parent_id) {
                        switch (card.data.code) {
                            case '00000':
                                allowed = true;
                                break;
                            case '33000':
                            case '40000':
                            case '53000':
                                allowed = _.filter(this.cards, function (o) {
                                    return o.table === true && o.data.code === '00000';
                                }).length === 1;
                                break;
                            default:
                                allowed = _.filter(this.cards, function (o) {
                                    return o.table === true && _.includes(['33000', '40000', '53000'], o.data.code);
                                }).length === 3;
                                break;
                        }
                    } else {
                        allowed = _.find(this.cards, function (o) {
                            return o.id === card.parent_id && o.table;
                        });
                    }

                    if (allowed) {
                        this.placeCard(card);
                        if (card.data.code.substring(2) != '600') {
                            this.rotateTurn();
                        } else {
                            this.$store.state.turn.skip = true;
                        }

                        axios.post('/api/game/' + this.$parent.uuid + '/place/' + card.id)
                            .catch(error => {
                                alert(error.message);
                            });
                    } else {
                        this.blinkCard(card);
                    }
                } else {
                    this.blinkCard(card);
                    this.blinkTurn();
                }
            },

            blinkCard: function (card) {
                this.$refs[card.id][0].$el.classList.add('blinker');

                setTimeout(() => {
                    this.$refs[card.id][0].$el.classList.remove('blinker');
                }, 500);
            },

            blinkTurn: function () {
                this.$parent.$refs['turn'].classList.add('blinker');

                setTimeout(() => {
                    this.$parent.$refs['turn'].classList.remove('blinker');
                }, 500);
            },
        },
        mounted() {
            document.addEventListener('keyup', (e) => {
                if (e.code === "ArrowLeft") this.select(Math.max(0, this.selected - 1));
                else if (e.code === "ArrowRight") this.select(Math.min(this.cardsInHand.length - 1, this.selected + 1));
                else if (e.code === "Enter") this.place(this.cardsInHand[this.selected]);
            });
        }
    }
</script>

<style scoped>
    .selected {
        z-index: 1000 !important;
        margin-top: -10px !important;
    }
    
    .hover:hover {
        text-decoration: underline;
        cursor: pointer;
    }

    .blinker {
        animation: blink .1s step-end 5 alternate;
    }

    @keyframes blink {
        50% {
            background-color: #feb4b4;
        }
    }
</style>