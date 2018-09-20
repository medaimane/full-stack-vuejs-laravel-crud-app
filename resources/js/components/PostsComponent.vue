<template>
    <div class="container">
        <div class="row">
            <h3 class="text-muted">Recent Posts</h3>
        </div>
        <!-- Example row of columns -->
        <div class="row">
            <div v-for="(post) in posts" v-bind:key="post.id" class="card card-body col-md-4">
                <h2>{{post.title}}</h2>
                <p>{{post.description}}</p>
                <p><a class="btn btn-secondary" href="/posts/" role="button">View details &raquo;</a></p>
            </div>
        </div>
        <hr>
    </div> <!-- /container -->
</template>

<script>
export default {
    data() {
        return {
            posts: [],
            post: {
                id: '',
                title: '',
                body: ''
            },
            post_id: '',
            pagination: {},
            edit: false
        }
    },
    created() {
        this.fetchPosts();
    },
    methods: {
        fetchPosts() {
            fetch('api/posts')
                .then(res => res.json())
                .then(res => {
                    console.log(res);
                    this.posts = res.data;
                })
                .catch(err => {
                    console.error(err);
                })
        }
    }
}
</script>



