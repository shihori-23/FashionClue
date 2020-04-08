const state = {
  userProfile: {
    name: '',
    email: '',
    bio: '',
    age: '',
    image: '',
  },
  selectedTastes: [],
};

const mutations = {
  setUserProfile(state, payload) {
    Object.keys(payload).map((keys) => (state[keys] = payload[keys]));
    console.log(3, state);
  },

  setUsetTaste(state, payload) {},
};

const actions = {
  setUserProfile({ commit }, data) {
    console.log(data);
    commit('setUserProfile', data);
  },
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
};
