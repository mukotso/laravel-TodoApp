<template>
    <div>
        <div class="block p-6 rounded-lg shadow-lg bg-white max-w-md">
            <form>
                <div class="form-group mb-6">
                    <input type="text" class="form-control block
        w-full
        text-gray-700
        bg-white bg-clip-padding
        border border-solid border-gray-300
        rounded
        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                           required v-model="form" placeholder="User Id">
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
                rows="3"
                placeholder="body" required
      ></textarea>
                </div>
                <button @click="addPost" type="submit" class="
      w-full
      p-3
      bg-blue-600
      text-white
      leading-tight
      uppercase
      rounded">Send
                </button>
            </form>
        </div>

    </div>
</template>

<script>
export default {
    name: "addPostComponent",
    data() {
        return {}
    },
    methods: {
        addPost: function () {
            this.$emit('addPost');
        }
    },
}
</script>

<style scoped>

</style>
