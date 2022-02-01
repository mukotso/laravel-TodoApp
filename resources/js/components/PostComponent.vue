<template>
    <div>
        <div v-if="loading">
              <loader object="#ff9633" color1="#ffffff" color2="#17fd3d" size="5" speed="2" bg="#343a40" objectbg="#999793" opacity="80" name="circular"></loader>

        </div>
        <button  @click="toggleAddPostForm"
                class=" m-5 align-centre ml-5 bg-green-500 hover:bg-maroon-700 text-white font-bold py-2 px-4 border  rounded">
            ADD NEW POST
        </button>

        <div v-if="isAddNewPost" class="block  p-6 rounded-lg shadow-lg bg-white max-w-md">
            <form id="addPostForm">
                <div class="form-group mb-6">
                    <input type="number" class="form-control block
        w-full
        text-gray-700
        bg-white bg-clip-padding
        border border-solid border-gray-300
        rounded
        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                           required v-model="form.userId" placeholder="User Id">
                </div>
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
                <button   @click="isEdit ? updatePost : submitPost"   type="submit" class="
      w-full
      p-3
      bg-blue-600
      text-white
      leading-tight
      uppercase
      rounded">
                {{isEdit ? "UPDATE POST DETAILS" : "ADD POST"}}
                </button>
            </form>
        </div>


        <div class="flex flex-col m-30">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 inline-block msm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        <table class=" ">
                            <thead class="bg-blue-300 text-bold border-b">
                            <tr>
                                <th scope="col" class="text-lg font-medium text-gray-900 px-6 py-4 text-left">
                                    #
                                </th>
                                <th scope="col" class="text-lg font-medium text-gray-900 px-6 py-4 text-left">
                                    User Id
                                </th>
                                <th scope="col" class="text-lg font-medium text-gray-900 px-6 py-4 text-left">
                                    Title
                                </th>
                                <th scope="col" class="text-lg font-medium text-gray-900 px-6 py-4 text-left">
                                    Body
                                </th>
                                <th>
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(post,index) in posts " :key="index"
                                class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100">
                                <td class="px-6 py-4 whitespace-nowrap text-md font-medium text-gray-900">
                                    {{ post.id }}
                                </td>
                                <td class="text-md text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                    {{ post.userId }}
                                </td>
                                <td class="text-md text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                    {{ post.title }}
                                </td>
                                <td class="text-md text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                    {{ post.body }}
                                </td>
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
                </div>
            </div>
        </div>


    </div>


</template>

<script>
const axios = require('axios');
export default {
    data() {
        return {
            posts: null,
            isAddNewPost: false,
            form: {
                userId: null,
                title: '',
                body: '',
            },
            loading:false,
            isEdit:false,
        }

    },
    mounted() {
        this.loading = true;

        //Waste 2 seconds
        setTimeout(() => {
            this.loading = false;
        }, 2000)
        this.getPosts();
        console.log('Component mounted.')
    },
    methods: {
        getPosts() {
            axios.get('/posts/getPosts')
                .then((response) => {
                    this.posts = response.data;
                    this.$swal('Basic', 'This is Basic', 'OK');
                })
                .catch(function (error) {
                    console.log('Post added successfully');

                })
        },

        submitPost() {
            axios.post('/post/store', this.form).then((response) => {
                this.posts.unshift(response.data)
                 this.$swal('Basic', 'This is Basic', 'OK');
                // console.log('Post added successfully');
                this.resetFormInputs();
            }).catch((error) => {

                // console.log('error');
            })
        },

        deletePost(post) {
            axios.get(`/delete/post/${post.id}`).then((response) => {
                this.posts = this.posts.filter(response => response.id !== post.id)
                console.log('Your Post has been  deleted successfully');
            }).catch((error) => {
                console.log('An error occured');
            })
        },
        updatePost() {
            axios.post('/post/update-details', this.form).then((response) => {
                this.posts = this.posts.map((post) => {
                    if (post.id === this.form.id) {
                        return response.data;
                    }
                    return post;
                });
                console.log('Post Details updated')
                this.resetFormInputs();
            }).catch((error) => {
                console.log('an error occured');
            })
        },
        resetFormInputs() {
            this.form = {
                userId: null,
                title: '',
                body: '',
            }
        },
        editPost(post){
            this.form={
                title:post.title,
                userId:post.userId,
                body:post.body,
            },
                this.isEdit=true;
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

html,
body {
    height: 100%;
}

@media (min-width: 640px) {
    table {
        display: inline-table !important;
    }

    thead tr:not(:first-child) {
        display: none;
    }
}

td:not(:last-child) {
    border-bottom: 0;
}

th:not(:last-child) {
    border-bottom: 2px solid rgba(0, 0, 0, .1);
}
</style>
