<template>
    <div class="card d-flex">
        <div class="deco pt-2 px-2">
            <div class="type">ECONOMY</div>
            <div class="jjfi">JJFI 000000 00000000001</div>
        </div>

        <div class="address p-2 my-2 flex-grow-1 d-flex align-items-center">
            <div>
                <b>Essi Esimerkki</b><br />
                Yliopistonkatu 23<br />
                11100 Riihimäki
            </div>
        </div>
        <div class="postcode pb-2 align-self-center">
            11100
        </div>
    </div>
</template>

<script>
    export default {
        name: "Card"
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