<script setup>
const storedUsername = localStorage.getItem('username');
      console.log("Stored username:", storedUsername);
</script>

<template>
  <header>
    This is a home page
  </header>
</template>

<style scoped>
header{
 text-align: center;
 margin-top: 400px;
}
</style>
