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