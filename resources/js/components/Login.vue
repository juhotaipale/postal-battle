<template>
        <div class="row m-0 main d-flex justify-content-center align-items-center">
            <div class="col-4">
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
                        <div class="input-group">
                            <input id="name" type="text" name="name" class="form-control form-control-lg" />
                        </div>
                        <button class="mt-3 btn btn-lg btn-block btn-primary">
                            Let's begin!
                        </button>
                    </div>
                </div>
            </div>
        </div>
</template>

<script>
    export default {
        name: "Login"
    }
</script>

<style scoped>
    .main {
        height: 100%;
    }

    input {
        text-align: center;
    }
</style>