<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">FinalProj</a>
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <router-link to="/" class="nav-link">Home</router-link>
        </li>
        <li class="nav-item">
          <router-link to="/about" class="nav-link">About</router-link>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li v-if="isLoggedIn" class="nav-item">
          <span class="nav-link">Hello, {{ getUsername }}</span>
        </li>
        <li v-if="isLoggedIn" class="nav-item">
          <router-link to="/user/logout" class="nav-link">Logout</router-link>
        </li>
        <li v-else class="nav-item">
          <router-link to="/user/login" class="nav-link">Login</router-link>
        </li>
        <li v-if="!isLoggedIn" class="nav-item">
          <router-link to="/user/register" class="nav-link">Register</router-link>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script setup>
import { computed } from 'vue';
import { useRoute } from 'vue-router';

// Use reactive data to track authentication state
const isLoggedIn = computed(() => {
  return localStorage.getItem('username') !== null;
});

// Get the stored username from localStorage
const getUsername = computed(() => {
  return localStorage.getItem('username');
});

// Use the useRoute hook to access the current route
const route = useRoute();

// Redirect to login page if logout route is accessed directly
if (route.name === 'Logout') {
  localStorage.removeItem('username');
  router.push('/user/login');
}
</script>

<style>
.navbar-brand {
  margin-left: 15px;
  font-family: "Franklin Gothic Medium", "Arial Narrow", Arial, sans-serif;
}

.nav-link {
  margin-left: 10px;
  margin-right: 5px;
  font-family: "Franklin Gothic Medium", "Arial Narrow", Arial, sans-serif;
}
</style>
