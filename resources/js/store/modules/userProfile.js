const state = {
    userProfile: {
        name: "",
        email: "",
        bio: "",
        age: "",
        image: "",
    },


}


const mutations = {

    setUserProfile(state, payload) {
        console.log(state, payload)
        Object.keys(payload).map(keys => state[keys] = payload[keys]);

    }

}



export default {
    namespaced: true,
    state,
    mutations
}
