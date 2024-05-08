import { createRouter, createWebHistory } from "vue-router";
import Applications from "../components/Applications.vue";
import About from "../components/About.vue";

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: "/", name: 'Home', component: Applications },
    { path: "/about", component: About },
    { path: '/user/register', 
      name: 'register', 
      component: () => import("../views/user/register.vue"),
    },
    { path: '/user/login', 
      name: 'login', 
      component: () => import("../views/user/login.vue"),
    },
    { path: '/user/logout', 
      name: 'logout', 
      component: () => import("../views/user/logout.vue"),
    },
  ],
});

export default router;
