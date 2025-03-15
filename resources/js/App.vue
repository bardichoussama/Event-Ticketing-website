<template>
    <div id="app">
        <Toaster />
        <Navbar class="mx-40"></Navbar>
        <router-view></router-view>
    </div>
</template>

<script setup>
import Navbar from './components/Navbar.vue';
import { Toaster } from "@/components/ui/toast";
</script>


