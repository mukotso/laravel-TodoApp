<template>
    <div>
<!--        <div v-if="loading">-->
<!--            <loader object="#ff9633" color1="#ffffff" color2="#17fd3d" size="5" speed="2" bg="#343a40"-->
<!--                    objectbg="#999793" opacity="80" name="circular"></loader>-->

<!--        </div>-->
        <button @click="toggleAddPostForm"
                class=" m-5 align-centre ml-5 bg-green-500 hover:bg-maroon-700 text-white font-bold py-2 px-4 border  rounded">
            ADD NEW POST
        </button>

        <div v-if="isAddNewPost" class="block  p-6 rounded-lg shadow-lg bg-white max-w-md">
            <form id="addPostForm">
<!--                <div class="form-group mb-6">-->
<!--                    <input type="number" class="form-control block-->
<!--        w-full-->
<!--        text-gray-700-->
<!--        bg-white bg-clip-padding-->
<!--        border border-solid border-gray-300-->
<!--        rounded-->
<!--        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"-->
<!--                           required v-model="form.userId" placeholder="User Id">-->
<!--                </div>-->
                <div class="form-group mb-6">
                    <input type="text" name="title" class="form-control block
        w-full
        text-gray-700
        bg-white bg-clip-padding
        border border-solid border-gray-300
        rounded
        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                           v-model="form.title" required placeholder="Title">
                </div>
                <div class="form-group mb-6">
      <textarea name="body"
                class="
        form-control
        block
        w-full
        px-3
        py-1.5
        text-gray-700
        bg-white bg-clip-padding
        border border-solid border-gray-300
        rounded
        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none
      "
                v-model="form.body"
                rows="5"
                placeholder="body" required
      ></textarea>
                </div>
                <button @click.prevent="isEdit ? updatePost() : submitPost()" class="
      w-full
      p-3
      bg-blue-600
      text-white
      leading-tight
      uppercase
      rounded">
                    {{ isEdit ? "UPDATE POST DETAILS" : "ADD POST" }}
                </button>
            </form>
        </div>


                <table class="table">
                    <thead>
                    <tr>
                        <th> Title</th>
                        <th>Body</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(post , index) in posts">
                        <td data-label="title">{{post.title}}</td>
                        <td data-label=" body">{{post.body}}</td>
                        <td class="flex">
                                                                <button
                                                                    @click="editPost(post)"
                                                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                                                    EDIT
                                                                </button>
                                                                <button
                                                                    @click="deletePost(post)"
                                                                    class="  ml-5 bg-red-500 hover:bg-maroon-700 text-white font-bold py-2 px-4 border  rounded">
                                                                    DELETE
                                                                </button>


                                                          </td>
                                        </tr>

                                        </tbody>
                                    </table>


    </div>


</template>

<script>
const axios = require('axios');
 const Swal =require('sweetalert2');
export default {
    data() {
        return {
            posts: null,
            isAddNewPost: false,
            form: {
                userId: 1,
                title: '',
                body: '',
            },
            loading: false,
            isEdit: false,
        }

    },
    beforeMount() {




        axios.get('/posts/getPosts')
            .then((response) => {

                this.posts = response.data.splice(0,15)
                console.log(response.data);
            })
            .catch(function (error) {
                console.log('error adding post');

            })

        console.log('Component mounted.')
    },
    methods: {


        submitPost() {
            axios.post('/post/store', this.form).then((response) => {
                this.posts.unshift(response.data)
                Swal.fire({
                    title: 'Success!',
                    text: 'Post added successfully',
                    icon: 'success',
                    confirmButtonText: 'Ok'
                })
                console.log(response.data);
                this.resetFormInputs();
            }).catch((error) => {

                console.log(error);
            })
        },

        deletePost(post) {

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.get(`/delete/post/${post.id}`).then((response) => {

                        if (response.status == 200) {
                            this.posts = this.posts.filter(response => response.id !== post.id)
                            Swal.fire('Deleted!', 'Your post has been deleted.', 'success')
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Something went wrong',
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            })
                        }
                    }).catch((error) => {
                        console.log('An error occured');
                    })
                }
            })

        },


        updatePost() {
            axios.post('/post/update/details', this.form).then((response) => {
                if (response.status == 200) {
                    return response.data
                    Swal.fire('Updated!', 'Your post has been Updated.', 'success')
                    this.resetFormInputs();
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    })
                }
            }).catch((error) => {
                console.log('An error occured');
            })

        },

        resetFormInputs() {
            this.form = {
                userId: null,
                title: '',
                body: '',
            }
        },
        editPost(post) {
            this.form = {
                title: post.title,
                userId: 1,
                body: post.body,
            },
                this.isEdit = true;
            this.toggleAddPostForm();
        },

        toggleAddPostForm() {
            this.isAddNewPost = !(this.isAddNewPost);
        },
    }
}




</script>

<style scoped>

input {
    padding: 14px;
}


table {
    border: 2px solid #ccc;
    margin: 40px;
    padding: 10px;
}

table caption {
    font-size: 1.5em;
    margin: .5em 0 .75em;
}

table tr {
    background-color: #f8f8f8;
    border: 1px solid #ddd;
    padding: .35em;
}

table th,
table td {
    padding: .625em;
    text-align: left;
}

table th {
    font-size: .85em;
    letter-spacing: .1em;
    text-transform: uppercase;
    background-color: rgb(46, 59, 115);
    color: white;
    padding: 20px;
}

@media screen and (max-width: 600px) {
    table {
        border: 0;
        margin: 10px;
        padding: 5px;
    }

    table caption {
        font-size: 1.3em;
    }

    table thead {
        border: none;
        clip: rect(0 0 0 0);
        height: 1px;
        margin: -1px;
        overflow: hidden;
        padding: 0;
        position: absolute;
        width: 1px;
    }

    table tr {
        border-bottom: 3px solid #ddd;
        display: block;
        margin-bottom: .625em;
    }

    table td {
        border-bottom: 1px solid #ddd;
        display: block;
        font-size: .8em;
        text-align: right;
    }

    table td::before {
        /*
        * aria-label has no advantage, it won't be read inside a table
        content: attr(aria-label);
        */
        content: attr(data-label);
        float: left;
        font-weight: bold;
        text-transform: uppercase;
    }

    table td:last-child {
        border-bottom: 0;
    }
}

/* general styling */
body {
    font-family: "Open Sans", sans-serif;
    line-height: 1.25;
}


</style>
















