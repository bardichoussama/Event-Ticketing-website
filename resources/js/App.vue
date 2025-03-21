<template>
  <div id="app" class="flex flex-col min-h-screen">
    <Toaster />
    <Navbar class="px-4 md:px-8 lg:px-60"></Navbar>
    
    <main class="flex-grow flex flex-col">
      <router-view></router-view>
    </main>
    
    <Footer class="mt-auto"></Footer>
  </div>
</template>

<script setup>
import Navbar from './components/Navbar.vue';
import Footer from './components/Footer.vue';
import { Toaster } from "@/components/ui/toast";
</script>


<!-- <template>
  <div id="app" class="flex flex-col min-h-screen">
    <Toaster />
    <Navbar class="px-4 md:px-8 lg:px-60"></Navbar>
    
    <main class="flex-grow flex flex-col">
      <router-view></router-view>
    </main>
    
    <Footer class="mt-auto"></Footer>
  </div>
</template>

<script setup>
import Navbar from './components/Navbar.vue';
import Footer from './components/Footer.vue';
import { Toaster } from "@/components/ui/toast";
import { onMounted } from 'vue';
import { useAuthStore } from './stores/auth'; // Make sure this path is correct

// Initialize auth on app mount
const authStore = useAuthStore();

onMounted(async () => {
  if (authStore.token) {
    try {
      // Try to fetch the user with the current token
      const success = await authStore.fetchUser();
      
      if (!success && authStore.token) {
        // If fetch fails but we have a token, try refreshing it
        const refreshed = await authStore.refreshToken();
        if (refreshed) {
          await authStore.fetchUser();
        }
      }
    } catch (error) {
      console.error("Failed to initialize auth:", error);
    }
  }
});
</script> -->