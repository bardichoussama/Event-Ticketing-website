<template>
    <div id="app">
        <Toaster />
        <Navbar class="px-60"></Navbar>
        <router-view></router-view>
        <Footer class="px-60"></Footer>
    </div>
</template>

<script setup>
import Navbar from './components/Navbar.vue';
import Footer from './components/Footer.vue';
import { Toaster } from "@/components/ui/toast";
</script>


