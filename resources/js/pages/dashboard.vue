<template>
  <div>
    <h2>Welcome to the Dashboard, {{ user.name }}</h2>
    <p>Email: {{ user.email }}</p>
    <BlogForm />

    <!-- Add more user details here -->
  </div>
</template>
  
<script>
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';
import axios from 'axios';
import BlogForm from '../components/BlogForm.vue';
import ApiService from '../services/ApiService';

export default {
  components: {
    BlogForm
  },
  setup() {
    const router = useRouter();
    const store = useStore();
    const user = ref({});


    const fetchUserDetail = () => {


      ApiService.post('/api/auth/me', null)
        .then((response) => {
          user.value = response.data; // Update the user ref with the response data
        })
        .catch((error) => {
          // Handle error when fetching user data
          console.error('Failed to fetch user data', error);
        });
    };
    // Fetch user data when the component is mounted
    onMounted(() => {
      fetchUserDetail();
    });

    return { user };
  },
};
</script>