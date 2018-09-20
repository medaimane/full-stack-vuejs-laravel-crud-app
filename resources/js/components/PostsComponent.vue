<template>
    <div class="container">
        <div class="row mb-2 p-1">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                        <a class="page-link" href="#" @click="fetchPosts(pagination.prev_page_url)">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>

                    <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                        <a class="page-link" href="#" @click="fetchPosts(pagination.next_page_url)">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="row">
            <div v-for="(post) in posts" v-bind:key="post.id" class="card card-body mb-2">
                <h2>{{post.title}}</h2>
                <p class="text-justify">{{post.description}}</p>
                <p><a class="float-right btn btn-sm btn-outline-secondary" href="/posts/" role="button">Details &raquo;</a></p>
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
        fetchPosts(page_url) {
            let vue = this;
            page_url = page_url || 'api/posts';
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    console.log(res);
                    this.posts = res.data;
                    vue.makePagination(res.meta, res.links);
                })
                .catch(err => console.error(err));
        },
        makePagination(meta, links) {
            console.log(meta, links);
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev
            }

            this.pagination = pagination;
        }
    }
}
</script>



