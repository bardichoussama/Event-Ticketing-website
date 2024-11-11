import { createRouter,createWebHashHistory, createWebHistory } from "vue-router";
import homeIndex from '../views/Home/index.vue'

const routes = [
    {path:'/',name:'home.index',component:homeIndex}
]

const router =createRouter({history: createWebHistory(), routes})

export default router;