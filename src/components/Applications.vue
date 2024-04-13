<template>
  <div class="container">
    <table class="centered">
      <thead>
        <tr>
          <th>Name</th>
          <th>Description</th>
          <th>Platform</th>
          <th>Developer</th>
          <th>Rating</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(app, index) in displayedApplications" :key="index">
          <td>{{ app.name }}</td>
          <td>{{ app.description }}</td>
          <td>{{ app.platform }}</td>
          <td>{{ app.developer }}</td>
          <td>{{ app.rating }}</td>
        </tr>
      </tbody>
    </table>

    <nav aria-label="Pagination">
      <ul class="pagination">
        <li class="page-item" :class="{ disabled: currentPage === 1 }">
          <a class="page-link" href="#" @click.prevent="prevPage" tabindex="-1">Previous</a>
        </li>
        <li v-for="page in totalPages" :key="page" class="page-item" :class="{ active: page === currentPage }">
          <a class="page-link" href="#" @click.prevent="changePage(page)">{{ page }}</a>
        </li>
        <li class="page-item" :class="{ disabled: currentPage === totalPages }">
          <a class="page-link" href="#" @click.prevent="nextPage">Next</a>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';

const itemsPerPage = ref(5);
const currentPage = ref(1);
const applications = ref([]);

const totalPages = computed(() => Math.ceil(applications.value.length / itemsPerPage.value));
const displayedApplications = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value;
  const end = start + itemsPerPage.value;
  return applications.value.slice(start, end);
});

const fetchApplications = () => {
  fetch('src/data/applications.json')
    .then(response => response.json())
    .then(data => {
      applications.value = data.applications;
    })
    .catch(error => {
      console.error('Error fetching applications:', error);
    });
};

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
};

const prevPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
};

const changePage = (page) => {
  currentPage.value = page;
};

onMounted(fetchApplications);
</script>

<style>
.container {
  text-align: center;
  margin-top: 20px;
}

h1 {
  margin-bottom: 20px;
}

.centered {
  margin: 0 auto;
  width: 80%;
  border-collapse: collapse;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.centered th,
.centered td {
  border: 1px solid #ddd;
  padding: 25px;
}

.centered th {
  background-color: lightgray;
  font-weight: bold;
  text-align: center;
  font-size: 16px;
}

.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
}

.pagination .page-item {
  display: inline-block;
}

.pagination .page-item.disabled .page-link {
  cursor: not-allowed;
  color: #6c757d;
}

.pagination .page-item.disabled .page-link:hover {
  background-color: transparent;
}

.pagination .page-item.active .page-link {
  z-index: 3;
  color: #fff;
  background-color: #007bff;
  border-color: #007bff;
}

.pagination .page-link {
  position: relative;
  display: block;
  padding: 0.5rem 0.75rem;
  margin-left: -1px;
  line-height: 1.25;
  color: #007bff;
  background-color: #fff;
  border: 1px solid #dee2e6;
}

.pagination .page-link:hover {
  z-index: 2;
  color: #0056b3;
  text-decoration: none;
  background-color: #e9ecef;
  border-color: #dee2e6;
}

.pagination .page-link:focus {
  z-index: 3;
  outline: 0;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.pagination .sr-only {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border: 0;
}
</style>