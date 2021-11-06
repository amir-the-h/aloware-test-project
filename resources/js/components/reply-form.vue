<template>
  <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" id="my-modal">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
      <div class="mt-3 text-center">
        <h3 class="text-lg leading-6 font-medium text-gray-900" v-text="replyTitle"></h3>

        <!-- validation errors at need -->
        <div v-if="errors.length > 0" class="mt-2 px-7 py-3" id="alertbox">
          <div class="container bg-red-500 flex items-center text-white text-sm font-bold px-4 py-3 relative" role="alert">
            <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
              <path
                d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z" />
            </svg>
            <ul>
              <li v-for="error in errors" :key="error">
                <span v-text="error"></span>
              </li>
            </ul>

            <span class="absolute top-0 bottom-0 right-0 px-4 py-3 closealertbutton" @click="errors = []">
              <svg class="fill-current h-6 w-6 text-white" role="button" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20">
                <title>Close</title>
                <path
                  d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
              </svg>
            </span>
          </div>
        </div>
        <!-- commenter name -->
        <div class="mt-2 px-7 py-3">
          <input v-model="reply.name" class="p-5 mb-5 bg-white border border-gray-200 rounded shadow-sm w-full text-xl" placeholder="Enter your name"/>
        </div>
        <!-- comment content -->
        <div class="mt-2 px-7 py-3">
          <textarea v-model="reply.body" class="p-5 mb-5 bg-white border border-gray-200 rounded shadow-sm h-36 w-full text-lg" placeholder="leave your comment ..."/>
        </div>
        <div class="flex justify-between space-x2 px-4 py-3">
          <button
            id="ok-btn"
            class="p-1 bg-green-500 disabled:opacity-50 text-white text-base font-medium rounded-md w-1/3 shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300"
            :disabled="!this.canReply"
            @click="sendReply"
          >
            <span v-if="canReply">
              <font-awesome-icon :icon="faReply"/> Reply
            </span>
            <span v-else>
              <font-awesome-icon :icon="faSpinner" spin/> Sending...
            </span>
          </button>
          <button
            id="cancel-btn"
            class="p-1 bg-red-500 text-white text-base font-medium rounded-md w-1/3 shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300"
            @click="$emit('close-reply-form')"
          >
            <font-awesome-icon :icon="faTimes"/> Cancel
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {faTimes, faReply, faSpinner} from '@fortawesome/free-solid-svg-icons'

export default {
  name: 'ReplyForm',
  props: {
    replyTo: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      faTimes,
      faReply,
      faSpinner,
      errors: [],
      canReply: true,
      reply: this.refreshReply(),
      visible: false,
    };
  },
  computed: {
    replyTitle() {
      // determine it's a first depth comment or a reply
      return this.replyTo !== null ? 'Reply to ' + this.replyTo.name : 'Comment';
    },
    replyParentId() {
      // set the parent id of the reply according to the replyTo prop
      return this.replyTo !== null ? this.replyTo.id : null;
    }
  },
  methods: {
    refreshReply() {
      return {
        name: '',
        body: '',
        parent_id: null
      };
    },
    sendReply() {
      // disable the reply button
      this.canReply = false;
      // set the parent id
      this.reply.parent_id = this.replyParentId;
      // send the reply
      this.$store.dispatch('addComment', this.reply)
        .then(() => {
          // refresh the form and close it
          this.reply = this.refreshReply();
          this.canReply = true;
          this.errors = [];
          this.$emit('close-reply-form');
        })
        .catch(error => {
          // enable the reply button and print the errors
          this.canReply = true;
          if (error.status === 422 && error.data.errors) {
            this.errors = [];
            for (const key in error.data.errors) {
              if (error.data.errors.hasOwnProperty(key)) {
                for (const error of error.data.errors[key]) {
                  this.errors.push(error);
                }
              }
            }
          }
        });
    },
  },
}
</script>
