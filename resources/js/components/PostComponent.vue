<template>
    <div>
        <button @click="toggleAddPostForm()"
                class="align-centre ml-5 bg-green-500 hover:bg-maroon-700 text-white font-bold py-2 px-4 border  rounded">
            ADD NEW POST
        </button>

        <add-post v-if="isAddNewPost" v-on:addPost="submitPost"></add-post>

        <div class="flex flex-col">
            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        <table class="min-w-full ">
                            <thead class="bg-white border-b">
                            <tr>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                    #
                                </th>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                    User Id
                                </th>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                    Title
                                </th>
                                <th scope="col" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ post.id }}
                                </td>
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                    {{ post.userId }}
                                </td>
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                    {{ post.title }}
                                </td>
                                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                                    {{ post.body }}
                                </td>
                                <td class="flex">
                                    <button
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                                        EDIT
                                    </button>
                                    <button
                                        class=" ml-5 bg-red-500 hover:bg-maroon-700 text-white font-bold py-2 px-4 border  rounded">
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
            isAddNewPost: true,
            form: {}
        }
    },
    methods: {
        getPosts() {
            axios.get('posts/getPosts')
                .then((response) => {
                    this.posts = response.data;
                    console.log(response.data);
                })
                .catch(function (error) {

                })
        },
        toggleAddPostForm() {
            this.isAddNewPost = !this.isAddNewPost;
        },
        submitPost() {

        }

    },
    mounted() {
        this.getPosts();
        console.log('Component mounted.')
    }
}
</script>

<style scoped>
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
