<template>
  <div class="flex mt-2">
    <div class="flex-shrink-0 mr-3">
      <img 
        class="mt-2 rounded-full w-8 h-8 sm:w-10 sm:h-10" 
        :src="'https://eu.ui-avatars.com/api/?background=random&name=' + comment.name" 
        alt="avatar">
    </div>
    <div class="flex-1 border rounded-lg px-2 py-2 md:px-3 lg:px-4 sm:py-4 leading-relaxed relative" :class="bgClass">
      <button v-if="comment.depth < commentsMaxDepthLevel" class="absolute top-0 right-0 text-green-500 text-lg rounded-lg border-green-400 border-l border-b px-1 md:px-2 lg:px-2 xl:px-2"
        @click="reply(comment)">
        <font-awesome-icon :icon="faReply"/>
      </button>
      <!-- commenter name -->
      <strong>{{ comment.name }}</strong>
      <!-- comment content -->
      <p class="text-sm">
        {{ comment.body }}
      </p>
      <!-- comment date -->
      <span class="text-xs text-gray-400 flex justify-end -mt-1">{{ comment.created_at | formatDate }}</span>

      <h4 v-if="comment.replies && comment.replies.length > 0" class="uppercase tracking-wide text-gray-400 font-bold text-xs">Replies</h4>

      <!-- replies -->
      <div class="space-y-4">
        <comment v-for="commentReply of commentReplies(comment)" :key="commentReply.id" :comment="commentReply" @reply="reply" />
      </div>
    </div>
  </div>
</template>

<script>
import { faReply, faComment } from '@fortawesome/free-solid-svg-icons'
import {mapGetters} from 'vuex'
import moment from 'moment'

export default ({
  name: 'Comment',
  props: {
    comment: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      faReply,
      faComment,
    }
  },
  computed: {
    bgClass() {
      return this.comment.depth % 2 == 1 ? 'bg-grey-300' : 'bg-grey-500'
    },
    ...mapGetters([
      'comments',
      'commentsMaxDepthLevel',
    ]),
  },
  methods: {
    reply (comment) {
      this.$emit('reply', comment)
    },
    commentReplies(comment) {
      return this.comments.filter((c) => {
        return c.parent_id == comment.id
      })
    },
  },
  filters: {
    formatDate (value) {
      return moment(value).format('MMMM Do YY, hh:mm')
    }
  }
})
</script>
