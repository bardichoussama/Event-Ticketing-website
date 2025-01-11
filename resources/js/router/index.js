import { createRouter, createWebHistory } from 'vue-router';

import Home from '../components/Home.vue';
import Login from '../components/Auth/Login.vue';
import Register from '../components/Auth/Register.vue';


const routes = [
    { path: '/', component: Home, },  
    { path: '/login', name: 'login', component: Login },
    { path: '/register', name: 'register', component: Register },
    { path: '/home', name: 'home', component: Home }, // Add this line

];


const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Navigation Guard
// router.beforeEach((to, from, next) => {
//     const isAuthenticated = !!localStorage.getItem('token'); // Check for token
//     if (to.meta.requiresAuth && !isAuthenticated) {
//         next({ name: 'login' });
//     } else {
//         next();
//     }
// });

export default router;
