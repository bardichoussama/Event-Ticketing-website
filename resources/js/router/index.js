import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '../stores/auth';

const routes = [
  { path: '/', component: () => import('../views/Events/index.vue') },
  { path: '/event/:id', component: () => import('../views/Events/show.vue'), props: true },
  { path: '/login', name: 'login', component: () => import('../views/Auth/Login.vue') },
  { path: '/register', name: 'register', component: () => import('../views/Auth/Register.vue') },
  { 
    path: '/user/profile',
    name: 'user-profile',
    component: () => import('../views/User/userProfile.vue'),
    meta: { requiresAuth: true }
  },
  { 
    path: '/user/purchases', 
    name: 'user-purchases', 
    component: () => import('../views/User/userPurchases.vue'),  
    meta: { requiresAuth: true }  
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Improved authentication check
router.beforeEach(async (to, from, next) => {
  const authStore = useAuthStore();
  
  // Ensure token is set on page refresh
  if (!authStore.isAuthenticated) {
    const token = localStorage.getItem('token');
    if (token) {
      try {
        await authStore.fetchUser(); // Fetch user details with the token
      } catch (error) {
        console.error("Error fetching user:", error);
        localStorage.removeItem('token'); // Remove invalid token
      }
    }
  }

  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    next({ name: 'login' }); 
  } else {
    next();
  }
});

export default router;