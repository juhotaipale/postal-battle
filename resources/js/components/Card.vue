<template>
    <!-- Package -->
    <div v-if="card.type === 'package'" class="card d-flex" :class="{ 'allowed': canBePlaced }">
        <div class="deco pt-2 px-2">
            <div class="type text-uppercase" :class="{ 'text-danger': (card.data.type === 'priority') }">
                {{ card.data.type }}
            </div>
            <div class="jjfi">{{ card.data.jjfi }}</div>
        </div>

        <div class="address p-2 my-2 flex-grow-1 d-flex align-items-center">
            <span v-html="card.data.address"></span>
        </div>
        <div class="postcode pb-2 align-self-center">
            {{ card.data.code }}
        </div>
    </div>

    <!-- Distribution centre -->
    <div v-else class="card d-flex" :class="{ 'allowed': canBePlaced }" :style="{ backgroundColor: getColor(card.data.code) }">
        <div class="distributionCentre flex-grow-1 d-flex justify-content-center align-items-end text-uppercase">
            <b>{{ card.data.name }}</b>
        </div>
        <div class="postcode py-2 align-self-center">
            <h2>{{ card.data.code }}</h2>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex';

    export default {
        name: "Card",
        props: ['card'],
        data() {
            return {
                color: {
                    orange: '#fed8b1',
                    blue: '#b4d9fe',
                    green: '#c6feb4',
                }
            }
        },
        computed: {
            ...mapState(['cards']),

            canBePlaced: function () {
                let allowed = false;

                if (! this.card.parent_id) {
                    switch (this.card.data.code) {
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
                    allowed = _.find(this.cards, (o) => {
                        return o.id === this.card.parent_id && o.table;
                    });
                }

                return (this.card.table === false && allowed);
            }
        },
        methods: {
            getColor(postalCode) {
                switch (postalCode) {
                    case '00000':
                        return this.color.orange;
                    case '33000':
                    case '40000':
                    case '53000':
                        return this.color.blue;
                    default:
                        return this.color.green;
                }
            }
        }
    }
</script>

<style scoped>
    .card {
        width: 120px;
        height: 170px;
        border: 1px solid gray;
        border-radius: 0.5em;
        -webkit-box-shadow: 0px 5px 5px -2px rgba(50, 50, 50, 0.2);
        -moz-box-shadow: 0px 5px 5px -2px rgba(50, 50, 50, 0.2);
        box-shadow: 0px 5px 5px -2px rgba(50, 50, 50, 0.2);
    }

    .allowed {
        border-color: blue;
        border-width: 2px;
    }

    .address {
        font-size: 70%;
        border-top: 1px dotted gray;
        border-bottom: 1px dotted gray;
    }

    .type {
        font-weight: bold;
    }

    .jjfi {
        font-size: 60%;
    }

    .distributionCentre {
        font-size: 90%;
    }

    .postcode {
        font-size: 100%;
    }

    .postcode > h2 {
        font-size: 120%;
    }
</style>