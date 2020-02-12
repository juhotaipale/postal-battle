<template>
    <div class="d-flex flex-row mb-5">
        <card style="margin-left: -35px; margin-right: -35px;" v-for="(card, index) in cardsInHand" :key="card.id"
              :style="{ zIndex: (index > selected ? 100 - index : 100 + index) }" :class="{ selected: (index === selected) }"
              :card="card" @click.native="select(index)"></card>
    </div>
</template>

<script>
    import { mapActions } from 'vuex';

    export default {
        name: "Hand",
        props: ['cards'],
        data() {
            return {
                selected: 8,
            }
        },
        computed: {
            cardsInHand: function () {
                return _.filter(this.cards, function (o) {
                    return ! o.on_table;
                });
            }
        },
        methods: {
            ...mapActions(['placeCard']),

            select: function (index) {
                this.selected = index;
            },
            place: function (card) {
                let allowed = _.find(this.cards, function (o) {
                    return o.id === card.parent_id && o.on_table;
                });

                if (allowed || card.parent_id === null) this.placeCard(card);
                else alert('This card can\'t be placed.')
            },
        },
        mounted() {
            document.addEventListener('keyup', (e) => {
                if (e.code === "ArrowLeft") this.select(Math.max(1, this.selected - 1));
                else if (e.code === "ArrowRight") this.select(Math.min(14, this.selected + 1));
                else if (e.code === "Enter") this.place(this.cardsInHand[this.selected]);
            });
        }
    }
</script>

<style scoped>
    .selected {
        z-index: 1000 !important;
        margin-top: -10px;
    }
</style>