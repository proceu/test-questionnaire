const state = () => ({
  users: [],
});
const actions = {
  downloadUsers({commit}) {
    return new Promise(((resolve, reject) => {
      this.$axios.get('users')
        .then(res => {
          commit("UPDATE_USERS", res.data);
          resolve(res.data)
        })
        .catch(errors => {
          reject(errors.response.data)
        })
    }))
  },
};

const mutations = {
  UPDATE_USERS (state, users) {
    state.users = users
  },
};

export default {
  namespaced: true,
  state,
  actions,
  mutations
}
