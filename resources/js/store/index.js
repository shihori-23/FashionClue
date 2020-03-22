import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

export default new Vuex.Store({
/**
  *
  * @param {Object} loginUser・・・ログインユーザーの情報を管理
  *
  **/
    state: {
        loginUser:"",
    },
    mutations: {
        setLoginUser(state, loginUser){
            state.loginUser = loginUser
        },
    },
    actions: {
        getLoginUserData({ commit }){
            axios.get('api/uid').then(res =>{
                commit('setLoginUser', res.data.uid)
            })
        },
    },
    getters:{
        loginUser: state => state.loginUser
    },
});