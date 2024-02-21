import {createApp} from 'vue'
import router from './routes.js';
import store from './store.js';
import App from './App.vue'



const app = createApp({});
app.component('App', App);

const token = localStorage.getItem('token');

if (token) {
  // Set the token in Vuex store on page load
  store.commit('setToken', token);
}

app.use(store);
app.use(router);
app.mount('#app');