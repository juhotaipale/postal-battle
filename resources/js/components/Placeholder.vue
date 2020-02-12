<template>
    <div>
        <div v-if="cardsOnStack.length > 0" class="d-flex flex-column">
            <card v-if="card.on_table" v-for="(card, index) in cards" :key="index" :class="{firstMargin: index < cards.length - 1, lastMargin: index === cards.length - 1 }"
                  :style="{ zIndex: 100 - index }" :card="card"></card>
        </div>
        <div v-else class="lastMargin placeholder"></div>
    </div>
</template>

<script>
    export default {
        name: "Placeholder",
        props: ['cards'],
        computed: {
            cardsOnStack: function () {
                return _.filter(this.cards, function (o) {
                    return o.on_table;
                });
            },
        }
    }
</script>

<style scoped>
    .firstMargin {
        margin-top: -70px;
        margin-bottom: -70px;
    }

    .lastMargin {
        margin-top: -15px !important;
        margin-bottom: -15px !important;
    }

    .placeholder {
        width: 120px;
        height: 170px;
        border: 2px dashed gray;
        border-radius: 0.5em;
    }
</style>