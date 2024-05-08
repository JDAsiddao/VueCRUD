<template>
    <div>
      <h2>Register</h2>
      <form @submit.prevent="registerUser">
        <div class="form-group">
          <label for="firstName">First Name:</label>
          <input type="text" id="firstName" v-model="firstName" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="lastName">Last Name:</label>
          <input type="text" id="lastName" v-model="lastName" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="username">Username:</label>
          <input type="text" id="username" v-model="username" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" id="email" v-model="email" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" id="password" v-model="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref } from "vue";
  import axios from "axios";
  import Swal from "sweetalert2";
  
  const lastName = ref("");
  const firstName = ref("");
  const username = ref("");
  const email = ref("");
  const password = ref("");
  
  const registerUser = () => {
    const newUser = {
      action: "register",
      lastName: lastName.value,
      firstName: firstName.value,
      username: username.value, 
      email: email.value,
      password: password.value,
    };
    axios
      .post("http://localhost/demovuecrud/backend/personapi.php", newUser) 
      .then((response) => {
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: 'Registration successful!'
        });
        console.log("Registration successful:", response.data);
      })
      .catch((error) => {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Error registering user. Please try again.'
        });
        console.error("Error registering user:", error);
      });
  };
  </script>
  