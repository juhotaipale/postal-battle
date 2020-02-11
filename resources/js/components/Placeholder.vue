<template>
    <div>
        <div v-if="cards.length > 0" class="d-flex flex-column">
            <card v-for="(card, index) in cards" :key="index" :class="{firstMargin: index < cards.length - 1, lastMargin: index === cards.length - 1}"
                  :style="{ zIndex: 100 - index }" :card="card"></card>
        </div>
        <div v-else class="lastMargin placeholder"></div>
    </div>
</template>

<script>
    export default {
        name: "Placeholder",
        props: ['cards'],
    }
</script>

<style scoped>
    .firstMargin {
        margin-top: -70px;
        margin-bottom: -70px;
    }

    .lastMargin {
        margin-top: -15px;
        margin-bottom: -15px;
    }

    .placeholder {
        width: 120px;
        height: 170px;
        border: 2px dashed gray;
        border-radius: 0.5em;
    }
</style>