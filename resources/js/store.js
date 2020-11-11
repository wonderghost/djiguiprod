import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    category : [],
    _token : document.querySelector("meta[name='csrf-token']").content
  },
  mutations: {
    setCategory (state , data) {
      state.category = data
    }
  }
})
export default store