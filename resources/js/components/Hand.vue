<template>
    <div class="d-flex flex-row">
        <card style="margin-left: -35px; margin-right: -35px;" v-for="index in 14" :key="index" @click.native="select(index)"
              :style="{ zIndex: (index > selected ? 100 - index : 100 + index) }" :class="{ selected: (index === selected) }"></card>
    </div>
</template>

<script>
    export default {
        name: "Hand",
        data() {
            return {
                selected: 8
            }
        },
        methods: {
            select: function (index) {
                this.selected = index;
            }
        },
        mounted() {
            document.addEventListener('keyup', (e) => {
                if (e.code === "ArrowLeft") this.select(Math.max(1, this.selected - 1));
                else if (e.code === "ArrowRight") this.select(Math.min(14, this.selected + 1));
            });
        }
    }
</script>

<style scoped>
    .selected {
        z-index: 1000 !important;
        margin-top: -10px;
    }
</style>