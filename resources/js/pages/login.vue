<template>
  <div>
    <LoginForm :email="email" :password="password" @submit="loginUser" />
  </div>
</template>
<script>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';
import LoginForm from '../components/LoginForm.vue';
export default {
  components: {
    LoginForm,
  },
  setup() {
    const router = useRouter();
    const email = ref('');
    const password = ref('');
    const store = useStore();

    const loginUser = async (formData) => {
      try {
        const response = await axios.post('/api/auth/login', formData);

        const token = response.data.access_token;
        localStorage.setItem('token', token);

        store.commit('setUser', response.data.user);
        store.commit('setToken', token);
        router.push({ name: 'dashboard' });
      } catch (error) {
        console.error('Login failed', error);
      }
    };
    return { email, password, loginUser }
  },

}
</script>
  