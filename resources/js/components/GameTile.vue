<template>
    <div class="game-tile" :class="{ 'loading': loading, 'game': game }" @click="click">
        <div v-if="game" class="h-100 d-flex flex-column p-3">
            <div class="text-center">
                <h4 class="text-uppercase">GAME {{ number }}</h4>
            </div>
            <div class="flex-grow-1">
                <span v-for="(player, index) in game.players">
                    Player {{ index + 1 }}: {{ player.name }}<br />
                </span>
            </div>
            <div class="text-center">
                <h4>
                    <span class="text-uppercase action" @click="joinOrBegin">{{ inGame ? 'Begin' : 'Join this game' }}</span>
                    <span v-if="inGame"> or
                        <span class="text-uppercase action" @click="leave">Leave</span>
                    </span>
                </h4>
            </div>
        </div>
        <div v-else class="h-100 d-flex justify-content-center">
            <h3 class="text-uppercase align-self-center">CREATE NEW</h3>
        </div>
    </div>
</template>

<script>
    export default {
        name: "GameTile",
        props: {
            game: {
                type: Object,
                required: false,
                default: null
            },
            number: {
                type: Number,
                required: false,
                default: 0
            }
        },
        data() {
            return {
                loading: false,
            }
        },
        computed: {
            inGame: function () {
                let found = false;

                _.each(this.game.players, function (player) {
                    if (player.id == USER) found = true;
                });

                return found;
            }
        },
        methods: {
            click: function () {
                if (this.loading) return;

                if (this.game)  {
                    this.$emit('start', this.game);
                } else {
                    this.loading = true;

                    axios.get('/api/game/create')
                        .then(response => {
                            this.$parent.gameList = response.data;
                        })
                        .catch(error => {
                            alert(error.message);
                        })
                        .finally(() => {
                            this.loading = false;
                        });
                }
            },

            joinOrBegin: function () {
                if (this.loading) return;
                this.loading = true;

                if (this.inGame) {
                    if (this.game.started_at) {
                        window.location.href = '/game/' + this.game.id;
                    } else {
                        axios.post('/api/game/' + this.game.id + '/begin')
                            .then(response => {
                                window.location.href = '/game/' + this.game.id;
                            })
                            .catch(error => {
                                alert(error.message);
                            })
                            .finally(() => {
                                this.loading = false;
                            });
                    }
                } else {
                    axios.post('/api/game/' + this.game.id + '/join')
                        .then(response => {
                            this.$parent.gameList = response.data;
                        })
                        .catch(error => {
                            alert(error.message);
                        })
                        .finally(() => {
                            this.loading = false;
                        });
                }
            },

            leave: function () {
                if (this.loading) return;
                this.loading = true;

                axios.post('/api/game/' + this.game.id + '/leave')
                    .then(response => {
                        this.$parent.gameList = response.data;
                    })
                    .catch(error => {
                        alert(error.message);
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            }
        },

        created() {
            if (this.game) {
                Echo.private('game.' + this.game.id)
                    .listen('.begun', (e) => {
                        window.location.href = '/game/' + e.game;
                    });
            }
        }
    }
</script>

<style scoped>
    .game-tile {
        width: 250px;
        height: 220px;
        border: 2px dashed gray;
        border-radius: 0.5em;
    }

    .action:hover {
        cursor: pointer;
        text-decoration: underline;
    }

    .game {
        border-style: solid;
    }

    .loading {
        background-color: lightgray;
    }
</style>