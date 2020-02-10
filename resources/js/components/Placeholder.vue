<template>
    <div>
        <div class="d-flex flex-column">
            <card style="margin-top: -80px; margin-bottom: -80px;" v-for="index in 4" :key="index" :style="{ zIndex: 100 - index }"></card>
        </div>
        <div v-if="false" class="placeholder"></div>
    </div>
</template>

<script>
    export default {
        name: "Placeholder"
    }
</script>

<style scoped>

    .placeholder {
        width: 150px;
        height: 200px;
        border: 2px dashed gray;
        border-radius: 0.5em;
    }
</style>