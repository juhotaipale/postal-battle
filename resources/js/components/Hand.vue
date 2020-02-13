<template>
    <div>
        <div class="d-flex flex-row flex-wrap mb-5 justify-content-center align-items-center" style="width: 90vw; height: 100%;">
            <h1 v-if="cardsInHand.length === 0 && selected !== null" class="align-self-center text-uppercase">You won the game</h1>
            <h1 v-else-if="game && game.finished_at" class="align-self-center text-uppercase">Game over, {{ turn.name }} won the game</h1>

            <card :ref="card.id" style="margin-left: -35px; margin-right: -35px;" v-for="(card, index) in cardsInHand" :key="card.id"
                  :style="{ zIndex: (index > selected ? 100 - index : 100 + index) }" class="my-2" :class="{ selected: (index === selected) }"
                  :card="card" @click.native="select(index)"></card>
        </div>
    </div>
</template>

<script>
    import { mapState, mapActions } from 'vuex';

    export default {
        name: "Hand",
        data() {
            return {
                selected: null,
            }
        },
        computed: {
            ...mapState(['game', 'cards', 'ownCards', 'turn']),

            cardsInHand: function () {
                return _.filter(this.ownCards, function (o) {
                    return ! o.table;
                });
            }
        },
        methods: {
            ...mapActions(['placeCard', 'rotateTurn']),

            select: function (index) {
                this.selected = index;
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
                        this.rotateTurn();

                        axios.post('/api/game/' + this.$parent.uuid + '/place/' + card.id)
                            .catch(error => {
                                alert(error.message);
                            });
                    } else {
                        this.$refs[card.id][0].$el.classList.add('blinker');

                        setTimeout(() => {
                            this.$refs[card.id][0].$el.classList.remove('blinker');
                        }, 500);
                    }
                } else {
                    this.$parent.$refs['turn'].classList.add('blinker');

                    setTimeout(() => {
                        this.$parent.$refs['turn'].classList.remove('blinker');
                    }, 500);
                }
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

    .blinker {
        animation: blink .1s step-end 5 alternate;
    }

    @keyframes blink {
        50% {
            background-color: #feb4b4;
        }
    }
</style>