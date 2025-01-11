<template>
    <div id="app">
        <nav>
            <router-link to="/">Home</router-link>
            <router-link to="/login">Login</router-link>
            <router-link to="/register">Register</router-link>
        
        </nav>
        <router-view />
    </div>
</template>

<script setup>
</script>

<style>
nav {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
}
</style>
