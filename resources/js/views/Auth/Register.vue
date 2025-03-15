<script setup>
import { ref } from 'vue';
import { useAuthStore } from '@/stores/auth';
import { useRouter } from 'vue-router';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';

const authStore = useAuthStore();
const router = useRouter();
const name = ref('');
const email = ref('');
const password = ref('');
const passwordConfirmation = ref('');

const handleRegister = async () => {
  try {
    await authStore.register(name.value, email.value, password.value, passwordConfirmation.value);
    alert('Registered successfully!');
    router.push('/');
  } catch (error) {
    alert('Registration failed. Please try again.');
  }
};
</script>

<template>
  <div class="w-full lg:grid lg:min-h-[600px] lg:grid-cols-2 xl:min-h-[800px]">
    <!-- Left Side (Form) -->
    <div class="flex items-center justify-center py-12">
      <div class="mx-auto grid w-[350px] gap-6">
        <div class="grid gap-2 text-center">
          <h1 class="text-3xl font-bold">Register</h1>
          <p class="text-muted-foreground">
            Create an account to get started
          </p>
        </div>
        <form @submit.prevent="handleRegister" class="grid gap-4">
          <div class="grid gap-2">
            <Input v-model="name" type="text" placeholder="Name" required />
          </div>
          <div class="grid gap-2">
            <Input v-model="email" type="email" placeholder="Email" required />
          </div>
          <div class="grid gap-2">
            <Input v-model="password" type="password" placeholder="Password" required />
          </div>
          <div class="grid gap-2">
            <Input v-model="passwordConfirmation" type="password" placeholder="Confirm Password" required />
          </div>
          <Button type="submit" class="w-full text-white">Register</Button>
          <Button variant="outline" class="w-full">Register with Google</Button>
        </form>
        <div class="mt-4 text-center text-sm">
          Already have an account?
          <a href="#" class="underline">Login</a>
        </div>
      </div>
    </div>

    <!-- Right Side (Image) -->
    <div class="hidden bg-muted lg:block">
      <img
        src=""
        alt="Register Image"
        width="1920"
        height="1080"
        class="h-full w-full object-cover dark:brightness-[0.2] dark:grayscale"
      >
    </div>
  </div>
</template>
