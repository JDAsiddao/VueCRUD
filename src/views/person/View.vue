<script setup>
import { onMounted, ref } from "vue";
import axios from "axios";
import Swal from 'sweetalert2';

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

const deleteRecord = (personId) => {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      axios
        .post(`http://localhost/demovuecrud/backend/personapi.php?id=${personId.value}`, {
          action: 'delete',
          id: personId
        })
        .then((response) => {
          Swal.fire('Deleted!', 'Your record has been deleted.', 'success').then(() => {
            window.location.reload();
          });
        })
        .catch((error) => {
          Swal.fire('Error', 'Error deleting record.', 'error');
          console.error('Error deleting record:', error);
        });
    }
  });
};


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
          <th scope="col">First Name</th>
          <th scope="col">Last Name</th>
          <th scope="col">email</th>
          <th scope="col">isDeleted</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(person, index) in persons" :key="person.id">
          <th scope="row">{{ index + 1 }}</th>
          <td>{{ person.id }}</td>
          <td>{{ person.lastName }}</td>
          <td>{{ person.firstName }}</td>
          <td>{{ person.email }}</td>
          <td>{{ person.isDeleted }}</td>
          <td>
            <router-link :to="{ path: '/person/update/' + person.id }" class="btn btn-primary">edit</router-link>
            <span style="margin-left: 10px;"></span> 
            <button class="btn btn-danger" @click="deleteRecord(person.id)">delete</button>
          </td>

        </tr>
      </tbody>
    </table>
  </div>
</template>

