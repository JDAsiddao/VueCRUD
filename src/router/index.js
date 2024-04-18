import { createRouter, createWebHistory } from "vue-router";
import Applications from "../components/Applications.vue";
import About from "../components/About.vue";
import Update from "../views/person/Update.vue";

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: "/", component: Applications },
    { path: "/about", component: About },
    {
      path: "/person/view",
      name: "view",
      component: () => import("../views/person/View.vue"),
    },
    {
      path: "/person/create",
      name: "create",
      component: () => import("../views/person/Create.vue"),
    },
    { path: '/person/update/:id', 
      name: 'update', 
      component: Update, 
      props: true 
    },
  ],
});

export default router;
