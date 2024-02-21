import { createStore } from 'vuex';

const store = createStore({
    state: {
      user: null,
      token: null, // Add a token state
    },
    mutations: {
      setUser(state, user) {
        state.user = user;
      },
      setToken(state, token) {
        state.token = token; // Define a setToken mutation
      },
    },
    getters: {
      isLoggedIn: (state) => {
        return state.token !== null;
      },
    },
  });
export default store;