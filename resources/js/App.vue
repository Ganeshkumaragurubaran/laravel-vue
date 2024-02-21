<template>
    <h1>
        How To Install Vue 3 in Laravel 10 
        <Navbar/>
    </h1>
</template>
<script>
import Navbar from './components/Navbar.vue';
export default {
  components: {
    Navbar,
  },
  computed: {
    userIsLoggedIn() {
      const isLoggedIn = this.$store.getters.isLoggedIn;
      console.log('userIsLoggedIn:', isLoggedIn); // Log the value to the console
      return isLoggedIn;

    },
  },
};
</script>
