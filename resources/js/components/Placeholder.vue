<template>
    <div>
        <div v-if="cards.length > 0" class="d-flex flex-column">
            <card :class="{firstMargin: index < cards.length - 1, lastMargin: index === cards.length - 1}" v-for="(card, index) in cards" :key="index" :style="{ firstMargin, zIndex: 100 - index }" :card="card"></card>
        </div>
        <div v-else class="placeholder"></div>
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
        margin-top: -80px;
        margin-bottom: -80px;
    }

    .lastMargin {
        margin-top: -20px;
        margin-bottom: -20px;
    }

    .placeholder {
        width: 150px;
        height: 200px;
        border: 2px dashed gray;
        border-radius: 0.5em;
    }
</style>