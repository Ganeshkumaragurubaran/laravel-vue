<template>
    <div class="blog-post">
      <h2>{{ post.title }}</h2>
      <p>{{ post.content }}</p>
      <!-- Display image if available -->
      <img v-if="post.image" :src="'/images/' + post.image" alt="Blog Image" />
    </div>
  </template>
  
  <script>
  export default {
    props: {
      post: Object, // The blog post data
    },
  };
  </script>