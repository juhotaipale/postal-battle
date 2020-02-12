<template>
    <div class="game-container d-flex flex-column align-items-center justify-content-center">
        <div class="status py-4">
            <h2>POSTAL BATTLE</h2>
        </div>
        <div class="d-flex flex-grow-1 align-items-center mb-5 pb-5">
            <div class="d-flex flex-wrap justify-content-center">
                <game-tile v-for="(game, index) in gameList" :key="game.id" :game="game" :number="index+1" class="m-2"></game-tile>
                <game-tile class="m-2" style="cursor: pointer;"></game-tile>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SelectGame",
        props: ['games'],
        data() {
            return {
                gameList: []
            }
        },
        methods: {
            //
        },
        created() {
            this.gameList = this.games;

            Echo.channel('games')
                .listen('.updated', (e) => {
                    this.gameList = e.games;
                });
        }
    }
</script>

<style scoped>
    .game-container {
        height: 100%;
    }
</style>