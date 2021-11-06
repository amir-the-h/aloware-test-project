<template>
  <div id="app" class="container">
    <div class="mt-6 bg-gray-50">
      <div class=" px-5 py-6 mx-auto">
        <!-- simple blog template -->
        <a href="#"
          class="mt-2 sm:text-3xl md:text-3xl lg:text-3xl text-4xl font-bold text-purple-500 hover:underline">Lorem Ipsum?</a>
        <div class="max-w-6xl py-6 mx-auto bg-gray-50">
          <div class="max-w-4xl sm:px-4 mx-auto text-2xl sm:text-lg text-gray-700 mt-4 rounded bg-gray-100">
            <div>
              <p class="mt-2 p-8 text-md">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
            </div>
          </div>
        </div>
        <!-- list all comments -->
        <comments @reply="reply"></comments>
      </div>
    </div>
    <reply-form :reply-to=replyTo @close-reply-form="cancelReply" v-show="replyFormVisibility"></reply-form>
  </div>
</template>


<script>
import Comments from './components/comments.vue'
import ReplyForm from './components/reply-form'

export default {
  name: 'App',
  data() {
    return {
      replyTo: null,
      replyFormVisibility: false,
    }
  },
  components: {
    Comments,
    ReplyForm,
  },
  methods: {
    reply(replyTo) {
      this.replyTo = replyTo
      this.replyFormVisibility = true
    },
    cancelReply() {
      this.replyTo = null
      this.replyFormVisibility = false
    }
  },
}
</script>