import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura'



const app = createApp(App);
app.use(router);    // Use the Vue router
app.use(PrimeVue,{
    theme :{
        preset : Aura,

    } 
});  // Add PrimeVue to the app
app.mount('#app');  // Mount the app
