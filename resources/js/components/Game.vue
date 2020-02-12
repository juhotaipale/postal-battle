<template>
    <div class="game-container d-flex flex-column align-items-center justify-content-center">
        <div class="status py-4">
            <h2>POSTAL BATTLE</h2>
        </div>
        <div class="distribution-centres d-flex flex-row flex-grow-1 align-items-end mb-5 pb-5">
            <placeholder v-for="card in distributionCentres" :key="card.id" class="mx-2" :cards="filterByDistributionCentre(card)"></placeholder>
        </div>
        <div class="hand py-4">
            <hand :cards="cards"></hand>
        </div>
    </div>
</template>

<script>
    import { mapState, mapActions } from 'vuex';

    export default {
        name: "Game",
        props: ['uuid'],
        data() {
            return {
                loading: true,
            }
        },
        computed: {
            ...mapState(['game', 'cards', 'players']),

            distributionCentres: function () {
                return _.filter(this.cards, function (o) {
                    return o.type === 'distributionCentre';
                });
            }
        },

        methods: {
            ...mapActions(['setGame']),

            filterByDistributionCentre: function (distributionCentre) {
                if (distributionCentre.data.code === '00000') return false;

                let cards = _.filter(this.cards, function (o) {
                    return (o.data.code).substring(0, 2) === (distributionCentre.data.code).substring(0, 2);
                });

                return _.orderBy(cards, ['data.code'], ['desc']);
            }
        },

        created() {
            axios.get('/api/game/' + this.uuid)
                .then(response => {
                    this.setGame(response.data);
                    this.loading = false;
                })
                .catch(error => {
                    alert(error.message);
                });
        }
    }
</script>

<style scoped>
    .game-container {
        height: 100%;
    }
</style>