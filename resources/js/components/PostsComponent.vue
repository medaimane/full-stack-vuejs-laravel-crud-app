<template>
    <div class="container">
        <div class="mb-2 p-2">
            <div>
                <h4>New post</h4>
            </div>
            <div>
                <form @submit.prevent="storePost()" class="form">
                    <input v-model="post.title" id="title" type="text" placeholder="Title" class="form-control" required>
                    <input v-model="post.description" id="description" type="text" placeholder="Description" class="form-control" required>
                    <textarea v-model="post.content" placeholder="Content" class="form-control" required></textarea>
                    <button class="btn btn-block btn-outline-success mt-2" type="submit" >Save</button>
                </form>
            </div>
        </div>
        <div class="mb-2 p-2">
            <div>
                <h4>List of posts</h4>
            </div>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
                        <a class="page-link" href="#" v-on:click="fetchPosts(pagination.prev_page_url)">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    
                    <li class="page-item active">
                        <span class="page-link disabled">Page {{pagination.current_page}} of {{pagination.last_page}}</span>
                    </li>

                    <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
                        <a class="page-link" href="#" @click="fetchPosts(pagination.next_page_url)">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="mb-2 p-1">
            <div v-for="(post, index) in posts" v-bind:key="post.id" class="card card-body mb-2">
                <h2>{{post.title}}</h2>
                <p class="text-justif">{{post.description}}</p>
                <p class="text-muted">Written on {{post.created_at}} by user has id {{post.user_id}}</p>
                <div>
                    <a class="btn btn-sm btn-outline-secondary" href="#" @click="editPost(post)">Edit</a>
                    <a class="btn btn-sm btn-outline-danger" href="#" @click="deletePost(post.id, index)">Delete</a>
                </div>
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
            // post: { // define data structure for a post
            //     id: '',
            //     user_id: '',
            //     title: '',
            //     description: '',
            //     body: ''
            // },
            post: {}, // use just an object
            // post_id: '', // used to pass id with posts update request
            pagination: {},
            edit: false
        }
    },
    created() {
        this.fetchPosts();
    },
    methods: {

        /**
         * Fetch method used to get posts from server/database with pagination features
         *  HTTP method 'GET'
        */
        fetchPosts(page_url = 'api/posts') { // input with default value
            // let vue = this;
            // page_url = page_url || 'api/posts'; // replaced by default input
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    console.log(res);
                    this.posts = res.data;
                    this.makePagination(res.meta, res.links);
                })
                .catch(err => {
                    swal("Oops!", "Something went wrong!", "error"); // SweetAlert error message
                    console.error(err);
                });
        },

        /**
         * Simple pagination setup
        */
        makePagination(meta, links) {
            // console.log(meta, links);
            
            // let pagination = { // create object contain pagination props
            //     current_page: meta.current_page,
            //     last_page: meta.last_page,
            //     next_page_url: links.next,
            //     prev_page_url: links.prev
            // }
            // this.pagination = pagination;

            // Just set new props to pagination object directly.
            this.pagination.current_page = meta.current_page;
            this.pagination.last_page = meta.last_page;
            this.pagination.next_page_url = links.next;
            this.pagination.prev_page_url = links.prev;
        },

        /**
         * Delete method used to remove post from database
         *  HTTP method 'DELETE'
        */
        deletePost(id, index) {
            // let vue = this;
            // if(confirm('Are you sure!')) {
            //     fetch(`api/posts/${id}`, {
            //         method: 'delete'
            //     })
            //     .then(res => {
            //         console.log(res);
            //         console.log('Post removed with success');
            //     })
            //     .then( _ => {
            //         this.fetchPosts(); // fetch the posts again
            //         // this.posts.splice(index, 1); // just remove post from posts array
            //     })
            //     .catch(err => console.error(err));
            // }


            // Use SweetAlert library for alert
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this post content!",
                icon: "warning",
                buttons: true,  // or {buttonsOptions}
                dangerMode: true,
                // className: "bg-dark",
                // closeOnClickOutside: false,
                // closeOnEsc: false,
                // timer: 3000,
            })
            .then((willDelete) => {
                if (willDelete) {
                    fetch(`api/posts/${id}`, {
                        method: 'delete'
                    })
                    .then(res => {
                        console.log(res);
                        this.fetchPosts(); // fetch the posts again
                        // this.posts.splice(index, 1); // just remove post from posts array
                        swal("Poof! Your post has been deleted!", {
                            icon: "success",
                            timer: 3000,
                        }); // SweetAlert with options
                    })
                    .catch(err => {
                        swal("Oops!", "Something went wrong!", {
                            icon:"error",
                            timer: 3000,
                        }); // SweetAlert error message
                        console.error(err);
                    });
                } else {
                    swal("It Ok!","Your post is safe!", {
                        timer: 3000,
                        // className: "bg-primary",
                        buttons: false, // without button, alert close automaticly 
                    }); // SweetAlert
                }
            });
        },
        
        /**
         * Store method used to add and update post
         *  HTTP method 'POST' and 'PUT'
        */
        storePost() {

            if (!this.edit) {
                // add post
                fetch('api/posts', {
                    method: 'post',
                    body: JSON.stringify(this.post),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(res => {
                    console.log(res); 
                    swal("Good job!", "You added new post!", {
                        icon: "success",
                        timer: 3000
                    }); // SweetAlert
                    this.fetchPosts();
                })
                .then(() => { 
                    this.post = {};
                    this.edit = false;
                })
                .catch(err => {
                    swal("Oops!", "Something went wrong!", {
                        icon: "error",
                        timer: 3000
                    }); // SweetAlert error message
                    console.error(err);
                });
            } else {
                // update post
                fetch(`api/posts/${this.post.id}`, {
                    method: 'put',
                    body: JSON.stringify(this.post),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(res => {
                    console.log(res);
                    swal("Good job!", "You updated the post!", {
                        icon: "success",
                        timer: 3000
                    }); // SweetAlert
                })
                .then(() => { 
                    this.post = {};
                    this.edit = false;
                })
                .catch(err => {
                    swal("Oops!", "Something went wrong!", {
                        icon: "error",
                        timer: 3000
                    }); // SweetAlert error message
                    console.error(err);
                });
            }
        },

        /**
         * Edit method used to set data into 
         * post prop and form inputs
        */
        editPost(post) {
            this.edit = true;
            this.post = post;
        }
    }
}
</script>

<style>
/*
 * SweetAlert Theming
*/
/* .swal-overlay {
    background-image: url('/storage/background.jpg');
    background-repeat: no-repeat;
    background-size: 100% 100%;
} */

/**
 * Form style
 *
*/
.form {
  width: 100%;
  max-width: 100%;
  padding: 15px;
  margin: auto;
}
.form .form-control {
  position: relative;
  box-sizing: border-box;
  height: auto;
  padding: 10px;
  font-size: 16px;
}
.form .form-control:focus {
  z-index: 2;
}
.form input[id="title"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form input[id="description"] {
  margin-bottom: -1px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form textarea {
  margin-bottom: -1px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form button {
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}
</style>


