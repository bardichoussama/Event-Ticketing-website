<script setup lang="ts">
import { ref } from 'vue';
import { useAuthStore } from '../../stores/auth';
import { useRouter } from 'vue-router';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const authStore = useAuthStore();
const router = useRouter();
const email = ref('');
const password = ref('');

const handleLogin = async () => {
  try {
    await authStore.login(email.value, password.value);
    alert('Logged in successfully!');
    router.push('/'); // Redirect to home page
  } catch (error) {
    alert('Login failed. Please check your credentials.');
  }
};
</script>

<template>
  <div class=" flex gap-4 bg-violet-50 p-4 gap-4w-full lg:grid lg:min-h-[600px] lg:grid-cols-2 xl:min-h-[800px] ">
    <!-- Left Side (Form) -->
    <div class="flex items-center justify-center py-12 bg-white rounded-md ">
      <div class="mx-auto grid w-[350px] gap-6 ">
        <div class="grid gap-2 text-center">
          <h1 class="text-3xl font-bold">Login</h1>
          <p class="text-muted-foreground">
            Enter your email below to login to your account
          </p>
        </div>
        <form @submit.prevent="handleLogin" class="grid gap-4">
          <div class="grid gap-2">
            <Label for="email">Email</Label>
            <Input id="email" v-model="email" type="email" placeholder="m@example.com" required />
          </div>
          <div class="grid gap-2">
            <div class="flex items-center">
              <Label for="password">Password</Label>
              <a href="/forgot-password" class="ml-auto inline-block text-sm underline">
                Forgot your password?
              </a>
            </div>
            <Input id="password" v-model="password" type="password" required />
          </div>
          <Button type="submit" class="w-full bg-primary text-white">Login</Button>
          <Button variant="outline" class="w-full">Login with Google</Button>
        </form>
        <div class="mt-4 text-center text-sm">
          Don't have an account?
          <a href="#" class="underline">Sign up</a>
        </div>
      </div>
    </div>

    <!-- Right Side (Image) -->
    <div class="hidden rounded-md bg-muted lg:block">
      <img
        src="../../../../public/assets/imgs/bg-login.jpg"
        alt="Login Image"
        width="1920"
        height="1080"
        class=" rounded-md h-full w-full object-cover dark:brightness-[0.2] dark:grayscale"
      >
    </div>
  </div>
</template>
