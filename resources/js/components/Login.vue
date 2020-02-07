<template>
        <div class="row m-0 main d-flex justify-content-center align-items-center">
            <div class="col-lg-4 col-md-6">
                <div class="row text-center">
                    <div class="col-12">
                        <img class="mb-4" src="/img/logo.svg" alt="DBgames" width="70%">
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-12">
                        <hr>
                        <h1 class="pt-4">
                            <b>POSTAL BATTLE</b>
                        </h1>
                        <p class="lead">
                            Fill in your nickname to enter the game
                        </p>
                        <form @submit.prevent="login">
                            <div class="input-group">
                                <input v-model="name" id="name" type="text" name="name" class="form-control form-control-lg"
                                       autocomplete="off" :disabled="loading" autofocus="true" />
                            </div>
                            <button type="submit" class="mt-3 btn btn-lg btn-block btn-primary" :disabled="loading">
                                <span v-if="loading">
                                    <font-awesome-icon icon="circle-notch" spin />
                                </span>
                                <span v-else>
                                    Let's begin!
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
    export default {
        name: "Login",
        data() {
            return {
                name: null,
                loading: false
            }
        },
        methods: {
            login() {
                this.loading = true;
            }
        }
    }
</script>

<style scoped>
    .main {
        height: 100%;
    }

    input {
        text-align: center;
    }

    input[type="text"], textarea {
        outline: none;
        box-shadow:none !important;
        border:1px solid #ccc !important;
    }
</style>