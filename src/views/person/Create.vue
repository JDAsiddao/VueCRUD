<script setup>
import { ref } from "vue";
import axios from "axios";

const lastName = ref("");
const firstName = ref("");
const email = ref("");

const saveRecord = () => {
  const newRecord = {
    action: "create",
    lastName: lastName.value,
    firstName: firstName.value,
    email: email.value,
  };
  axios
    .post("http://localhost/demovuecrud/backend/personapi.php", newRecord)
    .then((response) => {
      console.log("Record saved successfully:", response.data);
      console.log(newRecord);
    })
    .catch((error) => {
      console.error("Error saving record:", error);
    });
};
</script>

<template>
  <div class="container mt-4">
    <div class="card">
      <div class="card-header">
        <h4>Add Person</h4>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="id">ID :</label><br />
          <input type="text" id="id" class="form-control" v-model="id" />
        </div>
        <div class="form-group">
          <label for="lastName">Last Name :</label><br />
          <input
            type="text"
            id="lastName"
            class="form-control"
            v-model="lastName"
          />
        </div>
        <div class="form-group">
          <label for="firstName">First Name :</label><br />
          <input
            type="text"
            id="firstName"
            class="form-control"
            v-model="firstName"
          />
          <div class="form-group">
            <label for="email">Email :</label><br />
            <input
              type="email"
              id="email"
              class="form-control"
              v-model="email"
            />
          </div>
          <div class="form-group">
            <label for="isDeleted">Is Deleted :</label><br />
            <input
              type="checkbox"
              id="isDeleted"
              class="form-check-input"
              v-model="isDeleted"
            />
          </div>
        </div>
        <div class="card-footer">
          <button type="button" class="btn btn-success" @click="saveRecord">
            Save
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.form-group {
  text-align: left;
}
</style>
