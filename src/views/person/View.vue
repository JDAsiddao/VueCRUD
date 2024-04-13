<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";

const persons = ref([]);

onMounted(() => {
  axios
    .get("http://localhost/demovuecrud/backend/personapi.php?action=get_all")
    .then((response) => {
      persons.value = response.data;
    })
    .catch((error) => {
      console.error("Error fetching data:", error);
    });
});
</script>

<template>
  <div class="container">
    <h1>Person</h1>
    <router-link to="/person/create" class="btn btn-success">add</router-link>
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">id</th>
          <th scope="col">lastName</th>
          <th scope="col">firstName</th>
          <th scope="col">email</th>
          <th scope="col">isdeleted</th>
          <th scope="col">actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(person, index) in persons" :key="person.id">
          <th scope="row">{{ index + 1 }}</th>
          <td>{{ person.id }}</td>
          <td>{{ person.lastName }}</td>
          <td>{{ person.firstName }}</td>
          <td>{{ person.email }}</td>
          <td>{{ person.isdeleted }}</td>
          <td>
            <button class="btn btn-primary">edit</button>
            <button class="btn btn-danger">delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
