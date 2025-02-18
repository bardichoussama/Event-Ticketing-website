  import { createRouter, createWebHistory } from 'vue-router';
  import { useAuthStore } from '../stores/auth';



  const routes = [
    { path: '/', component: () => import('../views/Events/index.vue') },
    { path: '/login', name: 'login', component: () => import('../views/Auth/Login.vue') },
    { path: '/register', name: 'register', component: () => import('../views/Auth/Register.vue') },
    { 
      path: '/edit/profile', 
      name: 'edit-profile', 
      component: () => import('../views/User/editProfile.vue'),  
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

  router.beforeEach((to, from, next) => {
    const authStore = useAuthStore();
    const token = localStorage.getItem('token'); 
  
    if (to.meta.requiresAuth && !authStore.isAuthenticated && !token) {
      next({ name: 'login' }); 
    } else {
      next();
    }
  });
  

  export default router;