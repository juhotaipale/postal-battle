<template>
    <div class="game-container d-flex flex-column align-items-center justify-content-center">
        <div class="status py-4">
            <h2>POSTAL BATTLE</h2>
        </div>
        <div class="distribution-centres d-flex flex-row flex-grow-1 align-items-center">
            <placeholder v-for="index in 8" :key="index" class="mx-2"></placeholder>
        </div>
        <div class="hand py-4">
            <hand></hand>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Game"
    }
</script>

<style scoped>
    .game-container {
        height: 100%;
    }
</style>