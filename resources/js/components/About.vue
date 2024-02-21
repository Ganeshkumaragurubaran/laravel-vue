<template>
  <div>
    <form  @submit.prevent="registerUser">
      <input type="text" name="name" v-model="name"/>
      <input type="text" name="email" v-model="email"/>
      <input type="password" name="password" v-model="password"/>
      <button type="submit">Submit</button>
    </form>
  </div>
</template>
<script>
import { ref } from 'vue';
import axios from 'axios';

export default({
  setup() {
    const name=ref('');
    const email=ref('');
    const password=ref('');

    const registerUser = async () => {
      try {
        const response = await axios.post('/api/register', {
          name: name.value,
          email: email.value,
          password: password.value,
        });

        // Handle a successful login response here
        console.log('Login successful', response.data);

        // You can also redirect the user to a dashboard or another page on success
        // For example, you can use Vue Router for this purpose
        // router.push('/dashboard');
      } catch (error) {
        // Handle login error here
        console.error('Login failed', error);
      }
    };
    return {name, email, password, registerUser}
  },

})
</script>
