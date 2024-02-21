<template>
    <div>
     <RegisterForm :name="name" :email="email" :password="password" @submit="registerUser"/>
    </div>
  </template>
  <script>
  import { ref } from 'vue';
  import axios from 'axios';
  import RegisterForm from '../components/RegisterForm.vue';
  import {  useRouter } from 'vue-router'; 

  export default({
    components:{
      RegisterForm
    },
    setup() {
      const name=ref('');
      const email=ref('');
      const password=ref('');
      const router = useRouter(); 
      
      const registerUser = async (formData) => {
        const data = formData;
        console.log(data)
        try {
            await axios.post('/api/register', formData);

             router.push({ name: 'login' });
        } catch (error) {
          // Handle login error here
          console.error('Login failed', error);
        }
      };
      return {name, email, password, registerUser}
    },
  
  })
  </script>
  