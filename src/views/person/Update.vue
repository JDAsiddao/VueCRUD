<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import Swal from "sweetalert2";
import { useRoute } from 'vue-router';

const route = useRoute();
const personId = ref(route.params.id);
const editLastName = ref("");
const editFirstName = ref("");
const editEmail = ref("");
const editIsDeleted = ref(false);

onMounted(() => {
  axios
    .get(`http://localhost/demovuecrud/backend/personapi.php?action=get_by_id&id=${personId.value}`)
    .then((response) => {
      const personData = response.data;
      editLastName.value = personData.lastName;
      editFirstName.value = personData.firstName;
      editEmail.value = personData.email;
      editIsDeleted.value = personData.isDeleted;
    })
    .catch((error) => {
      console.error("Error fetching data for edit:", error);
    });
});

const saveRecord = () => {
  const updatedRecord = {
    action: "update",
    id: personId.value,
    lastName: editLastName.value,
    firstName: editFirstName.value,
    email: editEmail.value,
    isDeleted: editIsDeleted.value
  };
  axios
    .post("http://localhost/demovuecrud/backend/personapi.php?id=${personId.value}", updatedRecord)
    .then((response) => {
      Swal.fire({
        icon: 'success',
        title: 'Success',
        text: 'Record updated successfully!'
      });
      console.log("Record updated successfully:", response.data);
    })
    .catch((error) => {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Error updating record. Please try again.'
      });
      console.error("Error updating record:", error);
    });
};
</script>
<template>
    <div class="container mt-4">
      <div class="card">
        <div class="card-header">
          <h4>Edit Person</h4>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label for="lastName">Last Name:</label><br />
            <input
              type="text"
              id="lastName"
              class="form-control"
              v-model="editLastName"
            />
          </div>
          <div class="form-group">
            <label for="firstName">First Name:</label><br />
            <input
              type="text"
              id="firstName"
              class="form-control"
              v-model="editFirstName"
            />
          </div>
          <div class="form-group">
            <label for="email">Email:</label><br />
            <input
              type="email"
              id="email"
              class="form-control"
              v-model="editEmail"
            />
          </div>
          <div class="form-group">
            <label for="isDeleted">Is Deleted:</label><br />
            <input
              type="checkbox"
              id="isDeleted"
              class="form-check-input"
              v-model="editIsDeleted"
            />
          </div>
        </div>
        <div class="card-footer">
          <button type="button" class="btn btn-success" @click="saveRecord">
            Update
          </button>
        </div>
      </div>
    </div>
  </template>
  <style scoped>
  .form-group {
    text-align: left;
  }
  </style>