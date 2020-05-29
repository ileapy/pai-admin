import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    isLogin:false,
    userInfo:null,
    isWeChat:false,
    isAndroid:true,
    isIos:true,
    token:'',
  },
  mutations: {
  },
  actions: {
  },
  modules: {
  }
})
