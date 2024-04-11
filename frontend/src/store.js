
import { createStore } from 'vuex';

export default createStore({
  state: {
    userData: JSON.parse(localStorage.getItem('userData')) || null,
  },
  mutations: {
    setUserData(state, data) {
      state.userData = data;
      if (data !== null) {
        localStorage.setItem('userData', JSON.stringify(data));
      } else {
        localStorage.removeItem('userData');
      }
    },
  },
  actions: {
    authenticateUser({ commit }, userData) {
      commit('setUserData', userData);
    },
    logout({ commit }) {
      commit('setUserData', null);
    },
  },
  getters: {
    getUserData: (state) => state.userData,
  },
});
