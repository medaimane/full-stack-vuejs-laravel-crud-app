<template>
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
        <div class="container">
        <h1 class="display-3">Hello, world!</h1>
        <p>This is a simple crud application for posts. created using Laravel and Vue.js.</p>
        <p><a class="btn btn-primary btn-lg" href="#" @click="sayHelloWorld()" role="button">Say Hello World &raquo;</a></p>
        </div>
    </div>   
</template>

<script>
export default {
    data() {
        return {};
    },
    created() {

    },
    methods: {
        sayHelloWorld() {
            swal({
                title: "Good job!",
                text: "You are here!",
                icon: "success",
                button: "Go through the app, and make fun!",
                className: 'text-center'
            });
        }
    }
}
</script>
