<template>
    <div class="game-container d-flex flex-column align-items-center justify-content-center">
        <div class="status py-4">
            <h2>POSTAL BATTLE</h2>
        </div>
        <div class="distribution-centres d-flex flex-row flex-grow-1 align-items-center">
            <placeholder v-for="card in distributionCentres" :key="card.id" class="mx-2" :cards="filteredCards"></placeholder>
        </div>
        <div class="hand py-4">
            <hand :cards="data.cards"></hand>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Game",
        props: ['data'],
        computed: {
            distributionCentres: function () {
                return _.filter(this.data.cards, function (o) {
                    return o.type === 'distributionCentre';
                });
            },

            filteredCards: function () {
                let cards = _.filter(this.data.cards, function (o) {
                    return (o.data.code).substring(0, 2) === ('00000').substring(0, 2);
                });

                return _.orderBy(cards, ['data.code'], ['desc'])
            },
        }
    }
</script>

<style scoped>
    .game-container {
        height: 100%;
    }
</style>