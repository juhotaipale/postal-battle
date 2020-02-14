<template>
    <div class="row container-fluid h-100">
        <div class="col-md-3 px-5 pt-5 h-100" style="border-right: 1px dashed gray;">
            <div class="status">
                <img src="/img/postal_battle.svg" height="70px" />
            </div>
            <h4 class="pt-4">Game history</h4>
            <p class="small">Click the game to see the stacks.</p>

            <ul class="pt-2 small">
                <li v-for="game in history">
                    <a :href="'/game/'+ game.id">{{ game.finished_at }}<br />Winner: {{ game.winner.name }}</a>
                </li>
                <li v-if="history.length < 1">Start a new game and make history!</li>
            </ul>
        </div>
        <div class="col-md-9 h-100">
            <div class="h-100 d-flex flex-column align-items-center justify-content-center">

                <div class="d-flex flex-grow-1 align-items-center mb-5 pb-5">
                    <div class="d-flex flex-wrap justify-content-center">
                        <game-tile v-for="(game, index) in gameList" :key="game.id" :game="game" :number="index+1" class="m-2"></game-tile>
                        <game-tile class="m-2" style="cursor: pointer;"></game-tile>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "SelectGame",
        props: ['games', 'history'],
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

</style>