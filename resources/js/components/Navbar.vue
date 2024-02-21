<template>
  <nav class="navbar" id="nav">

    <div class="navbar-menu">
      <div class="navbar-end">
        <div v-if="loggedIn">
          <router-link class="navbar-item" to="/dashboard">Dashboard</router-link>
          <router-link class="navbar-item" to="/blogs">Blogs</router-link>
          <router-link class="navbar-item" to="/my/blogs">My Blogs</router-link>
          <button @click="logout" class="btn btn-danger float-right">Logout</button>
        </div>
        <div v-else>
          <router-link to="/login" class="navbar-item">Login</router-link>
          <router-link to="/register" class="navbar-item">Register</router-link>
        </div>
      </div>
    </div>
  </nav>
</template>
  
<script>
import ApiService from '../services/ApiService';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';
export default {
  setup(){
    const router = useRouter();
    const store = useStore();
    const logout = async () => {
      try {
        await ApiService.post('/api/auth/logout', {},);

        store.commit('setUser', null);
        store.commit('setToken', null);

        localStorage.removeItem('token');

        router.push({ name: 'login' });
      } catch (error) {
        // Handle logout error here
        console.error('Logout failed', error);
      }
    };
    return{
      logout
    }
  },
  props: {
    loggedIn: Boolean,
  },

};
</script>
  
<style scoped>
/* Add your CSS styles for the navbar here */
.navbar {
  background-color: #333;
  color: #fff;
}

.navbar-brand a {
  color: rgba(176, 179, 179, 0.285);
  font-weight: bold;
}

.navbar-menu .navbar-item {
  color: rgba(176, 179, 179, 0.285);
  margin: 0 10px;
  text-decoration: none;
}

.navbar-item:hover {
  text-decoration: underline;
  color: aqua;
}
#nav  .active-blog {
  color: #fff;
}
</style>