<template>
    <div>
        <button @click="toggleAddPostForm" style="margin-left: 30%;margin-top:10px; margin-bottom: 10px"
                class=" bg-green-500 hover:bg-maroon-700 text-white font-bold py-2 px-4 border  rounded">
            ADD NEW POST
        </button>


        <!--        <div class="form-wrapper addPostForm" v-if="isAddNewPost">-->
        <!--            <form id="addPostForm">-->
        <!--              -->
        <!--                <div class="row">-->
        <!--                    <div class="col-25">-->
        <!--                        <label for="title">Title</label>-->
        <!--                    </div>-->
        <!--                    <div class="col-75">-->
        <!--                        <input type="text" id="title" name="title" v-model="form.title" placeholder="Post Title">-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--              -->
        <!--                <div class="row">-->
        <!--                    <div class="col-25">-->
        <!--                        <label for="subject">Body</label>-->
        <!--                    </div>-->
        <!--                    <div class="col-75">-->
        <!--                        <textarea id="body" name="body" v-model="form.body" placeholder="post body" style="height:200px"></textarea>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--                <div class="row">-->
        <!--                   -->

        <!-- <button >-->
        <!--                     -->
        <!--               </button>-->

        <!--                </div>-->
        <!--            </form>-->
        <!--        </div>-->


        <main class="sm:container sm:mx-auto sm:max-w-lg sm:mt-10  form-wrapper addPostForm" v-if="isAddNewPost">
            <div class="flex">
                <div class="w-full">
                    <section
                        class="flex flex-col break-words bg-white sm:border-1 sm:rounded-md sm:shadow-sm sm:shadow-lg">

                        <header
                            class="font-semibold bg-gray-200 text-gray-700 py-5 px-6 sm:py-6 sm:px-8 sm:rounded-t-md">
                            POST
                        </header>

                        <form class="w-full px-6 space-y-6 sm:px-10 sm:space-y-8" id="addPostForm">


                            <div class="flex flex-wrap">

                                <div class="row hidden">
                                    <div class="col-25">
                                        <label for="userId">User Id</label>
                                    </div>
                                    <div class="col-75">
                                        <input type="number" id="userId" name="userId" v-model="form.userId"
                                               placeholder="UserId">
                                    </div>

                                </div>
                                </div>
                            <div class="flex flex-wrap">
                                <input id="search" type="text"
                                       class="form-input w-full" name="search" placeholder="title"
                                       required  autofocus  v-model="form.title"> <br>
                            </div>
                            <div class="flex flex-wrap">
                                <textarea id="todo" type="text"
                                          class="form-input w-full" name="todo"
                                          rows="5" required autofocus  v-model="form.body" >
                                </textarea>

                            </div>




                            <div class="flex flex-wrap">
                                <button @click.prevent="isEdit ? updatePost() : submitPost()"
                                    class=" addFormButton w-full mb-5 select-none font-bold whitespace-no-wrap p-3 rounded-lg text-base leading-normal no-underline text-gray-100 bg-blue-500 hover:bg-blue-700 sm:py-4">

                                    {{ isEdit ? "UPDATE POST DETAILS" : "ADD POST" }}
                                </button>
                            </div>
                        </form>

                    </section>
                </div>
            </div>
        </main>


        <div style="overflow-x:auto;">
            <table>
                <tr>
                    <th>Title</th>
                    <th>Body</th>
                    <th>Action</th>
                </tr>

                <tr v-for="(post) in posts" :key="post.id">
                    <th>{{ post.title }}</th>
                    <th>{{ post.body }}</th>
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

            </table>
        </div>

    </div>


</template>

<script>
const axios = require('axios');
const Swal = require('sweetalert2');
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

                this.posts = response.data.splice(0, 15)
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
                this.form.userId = 1;
                if (response.status === 200) {
                    this.posts = this.posts.map((post) => {
                        if (post.id == this.form.userId) {
                            return this.form;
                        }
                        return post;
                    });
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

<style>


table {
    border-collapse: collapse;
    border-spacing: 0;
    max-width: 100%;
    border: 1px solid #ddd;
    padding: 30px;
}

th, td {
    text-align: left;
    padding: 8px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    font-weight: lighter;
}

tr:nth-child(even) {
    background-color: #f2f2f2
}


* {
    box-sizing: border-box;
}

input[type=text], select, textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    resize: vertical;
}

label {
    padding-left: 10%;
    display: inline-block;
}

.addFormButton {
    background-color: #04AA6D;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    float: right;
}

input[type=submit]:hover {
    background-color: #45a049;
}

.form-wrapper {
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;


@media screen and (min-width: 780px) {
    margin-left:

20%;
}

}

.col-25 {
    float: left;
    width: 25%;
    margin-top: 6px;
}

.col-75 {
    float: left;
    width: 75%;
    margin-top: 6px;
}

/* Clear floats after the columns */
.row:after {
    content: "";
    display: table;
    clear: both;
}

/* Responsive layout - when the screen is less than 780px wide, make the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 780px) {
    .col-25, .col-75, input[type=submit] {
        width: 100%;
        margin-top: 0;
    }
}


input {
    padding: 14px;
}


/*table {*/
/*    border: 2px solid #ccc;*/
/*    margin-right: 45px;*/
/*    padding: 10px;*/
/*    margin-left: 45px;*/
/*}*/

/*table caption {*/
/*    font-size: 1.5em;*/
/*    margin: .5em 0 .75em;*/
/*}*/

/*table tr {*/
/*    background-color: #f8f8f8;*/
/*    border: 1px solid #ddd;*/
/*    padding: .35em;*/
/*}*/


/*table th {*/
/*    font-size: .85em;*/
/*    letter-spacing: .1em;*/
/*    text-transform: uppercase;*/
/*    background-color: rgb(46, 59, 115);*/
/*    color: white;*/
/*    padding: 20px;*/
/*}*/

/*@media screen and (max-width: 780px) {*/
/*    table {*/
/*        border: 0;*/
/*        margin: 10px;*/
/*        padding: 5px;*/
/*    }*/

/*    table caption {*/
/*        font-size: 1.3em;*/
/*    }*/

/*    table thead {*/
/*        border: none;*/
/*        clip: rect(0 0 0 0);*/
/*        height: 1px;*/
/*        margin: -1px;*/
/*        overflow: hidden;*/
/*        padding: 0;*/
/*        position: absolute;*/
/*        width: 1px;*/
/*    }*/

/*    table tr {*/
/*        border-bottom: 3px solid #ddd;*/
/*        display: block;*/
/*        margin-bottom: .625em;*/
/*    }*/

/*    table td {*/
/*        border-bottom: 1px solid #ddd;*/
/*        display: block;*/
/*        font-size: .8em;*/
/*        text-align: right;*/
/*    }*/

/*    table td::before {*/
/*        !**/
/*        * aria-label has no advantage, it won't be read inside a table*/
/*        content: attr(aria-label);*/
/*        *!*/
/*        content: attr(data-label);*/
/*        float: left;*/
/*        font-weight: bold;*/
/*        text-transform: uppercase;*/
/*    }*/

/*    table td:last-child {*/
/*        border-bottom: 0;*/
/*    }*/
/*}*/

/* general styling */
/*body {*/
/*    font-family: "Open Sans", sans-serif;*/
/*    line-height: 1.25;*/
/*}*/


</style>
















