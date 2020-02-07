<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Pusher connection test</div>

                    <div class="card-body">
                        <ul>
                            <li v-for="message in messages">
                                {{ message }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                messages: []
            }
        },
        mounted() {
            Echo.channel('testing')
                .listen('.test-event', (e) => {
                    console.log(e);
                    this.messages.push(JSON.stringify(e));
                })
        }
    }
</script>
