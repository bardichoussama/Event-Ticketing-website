import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '../stores/auth';

import Home from '../views/Events/index.vue';
import EventDetails from '../views/Events/show.vue';
import Login from '../views/Auth/Login.vue';
import Register from '../views/Auth/Register.vue';
import Profile from '../views/User/editProfile.vue';
import Purchases from '../views/User/userPurchases.vue';

const routes = [
  { path: '/', component: Home },
  { path: '/event/:id', name: 'EventDetails', component: EventDetails, props: true },
  { path: '/login', name: 'login', component: Login },
  { path: '/register', name: 'register', component: Register },
  { path: '/home', name: 'home', component: Home, meta: { requiresAuth: true } },
  { path: '/edit/profile', name: 'edit-profile', component: Profile, meta: { requiresAuth: true } },
  { path: '/user/purchases', name: 'user-purchases', component: Purchases, meta: { requiresAuth: true } },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
    const authStore = useAuthStore();
    const token = localStorage.getItem('token');
  
    if (to.meta.requiresAuth && !authStore.isAuthenticated && !token) {
      next({ name: 'login' }); // Redirect to login if not authenticated
    } else {
      next();
    }
  });

export default router;