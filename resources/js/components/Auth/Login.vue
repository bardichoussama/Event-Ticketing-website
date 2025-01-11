<template>
    <div>
        <h1>Login</h1>
        <form @submit.prevent="login">
            <input type="email" v-model="email" placeholder="Email" />
            <input type="password" v-model="password" placeholder="Password" />
            <button type="submit">Login</button>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue';


const email = ref('');
const password = ref('');


</script>
