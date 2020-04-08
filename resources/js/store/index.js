import Vue from 'vue';
import Vuex from 'vuex';

/* Component */
import userProfileData from './modules/userProfile.js';

Vue.use(Vuex);

export default new Vuex.Store({
  /**
   *
   * @param {Object} loginUser・・・ログインユーザーの情報を管理
   *
   **/
  modules: {
    userProfileData,
  },
  state: {
    loginUser: '',
    tastes: [],
  },
  mutations: {
    setLoginUser(state, loginUser) {
      state.loginUser = loginUser;
    },
    setAllTastes(state, payload) {
      // this.$set(state.tastes, payload)
    },
  },
  actions: {
    getLoginUserData({ commit }) {
      axios.get('api/uid').then((res) => {
        commit('setLoginUser', res.data.uid);
      });
    },
    getTastes({ commit }, payload) {
      console.log(23, payload);
      axios.get('api/tastes/all').then((res) => {
        commit('setAllTastes', res.data.tastes);
      });
    },
  },
  getters: {
    loginUser: (state) => state.loginUser,
  },
});
