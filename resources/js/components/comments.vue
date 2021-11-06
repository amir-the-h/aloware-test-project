<template>
  <div class="antialiased mx-auto max-w-screen-md pt-5">
    <div class="relative mb-8 h-5">
      <h3 class=" text-lg font-semibold text-gray-900">Comments</h3>
      <!-- leaving a comment is storing a first depth comment in backend-process -->
      <button 
        class="absolute top-0 right-0 p-1 text-green-500 text-lg rounded border-green-400 border" 
        @click="reply(null)">
        <font-awesome-icon :icon="faComment"/> Leave comment
      </button>
    </div>

    <div class="space-y-4">
      <!-- List first depth comments only  -->
      <comment v-for="comment of firstDepthComments" :key="comment.id" :comment="comment" @reply="reply" />
    </div>
  </div>
</template>

<script>
import { faComment } from '@fortawesome/free-solid-svg-icons'
import { mapGetters } from 'vuex'
import Comment from './comment'

export default {
  name: 'comments',
  components: {
    Comment
  },
  data () {
    return {
      faComment,
    }
  },
  computed: {
    firstDepthComments () {
      // filter out all comments in first depth
      return this.$store.getters.comments.filter(comment => comment.depth === 1)
    },
    ...mapGetters([
      'comments',
    ]),
  },
  methods: {
    // proxy it up to the parent component
    reply (comment) {
      this.$emit('reply', comment)
    },
  },
  mounted () {
    // fetch all comments and store them in the store
    this.$store.dispatch('fetchComments')
  },
}
</script>