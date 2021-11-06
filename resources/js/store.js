import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import _ from 'lodash'

Vue.use(Vuex)
// set up axios to use the api url
axios.defaults.baseURL = window.apiBaseUrl

// create the store and export it
export const store = new Vuex.Store({
  state: {
    comments: [],
    commentsMaxDepthLevel: window.commentsMaxDepthLevel,
  },
  getters: {
    comments: state => state.comments,
    commentsMaxDepthLevel: state => state.commentsMaxDepthLevel,
  },
  mutations: {
    addComment(state, comment) {
      // add the comment to the beginning of the comments array
      state.comments = [comment].concat(state.comments)
    },
    fetchComments(state, comments) {
      state.comments = comments
    },
  },
  actions: {
    fetchComments(context) {
      axios.get('/comments')
        .then(response => {
          context.commit('fetchComments', response.data)
        })
        .catch(error => {
          console.log(error)
        })
    },
    addComment(context, comment) {
      return new Promise((resolve, reject) => {
        axios.post('/comments', comment)
        .then(response => {
          context.commit('addComment', response.data)
          resolve(response)
        })
        .catch(error => {
          reject(error.response)
        })
      });
    },
  }
})