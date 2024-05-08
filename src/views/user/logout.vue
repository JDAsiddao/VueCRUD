<template>
    <div>
      <h2>Logout</h2>
      <button @click="logoutUser" class="btn btn-primary">Logout</button>
    </div>
  </template>
  
  <script setup>
  import { onBeforeUnmount } from 'vue';
  import { useRouter } from 'vue-router';
  
  const router = useRouter();
  
  const logoutUser = () => {
    // Clear username from localStorage
    localStorage.removeItem('username');
  
    // Navigate to the login page after logout
    router.push('/user/login');
  };
  
  // Clear localStorage and navigate to login page when component is unmounted
  onBeforeUnmount(() => {
    localStorage.removeItem('username');
    router.push('/user/login');
  });
  </script>
  