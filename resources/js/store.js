import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    category : []  
  },
  mutations: {
    setCategory (state , data) {
      state.category = data
    }
  }
})
export default store