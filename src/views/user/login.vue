<template>
    <div>
      <h2>Login</h2>
      <form @submit.prevent="loginUser">
        <div class="form-group">
          <label for="username">Username:</label>
          <input type="text" id="username" v-model="username" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" id="password" v-model="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
      </form>
    </div>
  </template>
  
  <script setup>
import { ref } from "vue";
import axios from "axios";
import Swal from "sweetalert2";
import { useRouter } from 'vue-router';

const router = useRouter();

const username = ref("");
const password = ref("");

const loginUser = () => {
  const credentials = {
    action: "login",
    username: username.value,
    password: password.value,
  };
  axios
    .post("http://localhost/demovuecrud/backend/personapi.php", credentials)
    .then((response) => {
      Swal.fire({
        icon: 'success',
        title: 'Success',
        text: 'Login successful!'
      });
      localStorage.setItem('username', credentials.username);
      console.log("Login successful:", response.data);
      // Redirect to the "Home" route after successful login
      router.push('/');
    })
    .catch((error) => {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Invalid username or password. Please try again.'
      });
      console.error("Error logging in:", error);
    });
};
</script>
  