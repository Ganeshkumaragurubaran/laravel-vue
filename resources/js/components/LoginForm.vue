<template>
    <div class="login-form">
      <h1>Login</h1>
      <form @submit.prevent="validateAndSubmit">
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="text" id="email" name="email" v-model="email" class="input-field" />
          <span class="error">{{ errors.email }}</span>
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" v-model="password" class="input-field" />
          <span class="error">{{ errors.password }}</span>
        </div>
        <button type="submit" class="submit-button">Submit</button>
      </form>
    </div>
  </template>
  
  <script>
  import { ref, defineComponent } from 'vue';
  
  export default defineComponent({
    props: {
      email: String,
      password: String,
    },
    setup(props, { emit }) {
      const email = ref(props.email);
      const password = ref(props.password);
      const errors = ref({
        email: null,
        password: null,
      });
  
      const validateAndSubmit = () => {
        clearErrors();
  
        if (!email.value) {
          errors.value.email = 'email is required';
        }
  
        if (!password.value) {
          errors.value.password = 'password is required';
        }
  
        if (email.value && password.value) {
          emit('submit', { email: email.value, password: password.value });
        }
      };
  
      const clearErrors = () => {
        errors.value.email = null;
        errors.value.password = null;
      };
  
      return {
        email,
        password,
        errors,
        validateAndSubmit,
      };
    },
  });
  </script>
  
  <!-- <style scoped>
  .login-form {
    max-width: 300px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f5f5f5;
  }
  
  .form-group {
    margin-bottom: 15px;
  }
  
  .input-field {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #fff;
  }
  
  .error {
    color: red;
    font-size: medium;
  }
  
  .submit-button {
    background-color: #007BFF;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    cursor: pointer;
  }
  </style> -->