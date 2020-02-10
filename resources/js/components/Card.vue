<template>
    <!-- Package -->
    <div v-if="card.type === 'package'" class="card d-flex">
        <div class="deco pt-2 px-2">
            <div class="type text-uppercase" :class="{ 'text-danger': (card.data.type === 'priority') }">
                {{ card.data.type }}
            </div>
            <div class="jjfi">{{ card.data.jjfi }}</div>
        </div>

        <div class="address p-2 my-2 flex-grow-1 d-flex align-items-center">
            <span v-html="card.data.address"></span>
        </div>
        <div class="postcode pb-2 align-self-center">
            {{ card.data.code }}
        </div>
    </div>

    <!-- Distribution centre -->
    <div v-else class="card d-flex" style="background-color: #fed8b1;">
        <div class="flex-grow-1 d-flex justify-content-center align-items-end text-uppercase">
            <b>{{ card.data.name }}</b>
        </div>
        <div class="postcode py-2 align-self-center">
            <h2>{{ card.data.code }}</h2>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Card",
        props: ['card']
    }
</script>

<style scoped>
    .card {
        width: 150px;
        height: 200px;
        border: 1px solid gray;
        border-radius: 0.5em;
        -webkit-box-shadow: 0px 5px 5px -2px rgba(50, 50, 50, 0.2);
        -moz-box-shadow: 0px 5px 5px -2px rgba(50, 50, 50, 0.2);
        box-shadow: 0px 5px 5px -2px rgba(50, 50, 50, 0.2);
    }

    .address {
        font-size: 85%;
        border-top: 1px dotted gray;
        border-bottom: 1px dotted gray;
    }

    .type {
        font-weight: bold;
    }

    .jjfi {
        font-size: 60%;
    }

    .postcode {
        font-size: 100%;
    }
</style>