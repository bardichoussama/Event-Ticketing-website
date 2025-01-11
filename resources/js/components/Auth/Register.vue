<template>
    <div>
        <h1>Register</h1>
        <form @submit.prevent="register">
            <input type="email" v-model="email" placeholder="Email" />
            <input type="password" v-model="password" placeholder="Password" />
            <input type="password" v-model="passwordConfirmation" placeholder="Confirm Password" />
            <button type="submit">Register</button>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue';


const email = ref('');
const password = ref('');
const passwordConfirmation = ref('');

</script>
