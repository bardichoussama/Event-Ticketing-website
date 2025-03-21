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
    router.push('/');
  } catch (error) {
    alert('Login failed. Please check your credentials.');
  }
};
</script>
<template>
  <div class="flex justify-center items-center min-h-screen w-full bg-gray-50 ">
    <div class="w-full max-w-md bg-violet-50 rounded-md overflow-hidden px-7 py-4 mb-20 ">
      <!-- Header with Logo -->
      <div class="text-center p-3 ">
        <h1 class="text-xl font-bold text-primary">Eventive</h1>
        <p class="text-xs text-gray-500">Sign in to your account</p>
      </div>
      
      <!-- Form Section -->
      <div class="p-4">
        <form @submit.prevent="handleLogin" class="space-y-3">
          <div class="space-y-1">
            <Label for="email" class="text-xs font-medium">Email</Label>
            <Input 
              id="email" 
              v-model="email" 
              type="email" 
              placeholder="m@example.com" 
              required 
              class="w-full h-8 text-sm"
            />
          </div>
          
          <div class="space-y-1">
            <div class="flex items-center justify-between">
              <Label for="password" class="text-xs font-medium">Password</Label>
              <a href="/forgot-password" class="text-xs text-primary hover:underline">
                Forgot?
              </a>
            </div>
            <Input 
              id="password" 
              v-model="password" 
              type="password" 
              required 
              class="w-full h-8 text-sm"
            />
          </div>
          
          <div class="flex items-center space-x-1">
            <input type="checkbox" id="remember" class="rounded border-gray-300 h-3 w-3" />
            <label for="remember" class="text-xs text-gray-600">Remember me</label>
          </div>
          
          <Button type="submit" class="w-full bg-primary text-white h-8 text-sm">
            Sign in
          </Button>
        </form>
        
        <div class="relative my-3">
          <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-200"></div>
          </div>
          <div class="relative flex justify-center">
            <span class="px-2 bg-white text-gray-500 text-xs">Or continue with</span>
          </div>
        </div>
        
        <div class="grid grid-cols-1 gap-2">
          <Button variant="outline" class="w-full h-8 border border-gray-300 flex items-center justify-center text-xs">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 16 16" fill="none" class="mr-1">
              <path d="M15.5453 6.54545H8.36364V9.63636H12.5091C12.0545 11.6 10.3636 12.7273 8.36364 12.7273C5.89091 12.7273 3.90909 10.7455 3.90909 8.27273C3.90909 5.8 5.89091 3.81818 8.36364 3.81818C9.47273 3.81818 10.4727 4.2 11.2364 4.87273L13.5636 2.54545C12.1455 1.21818 10.3455 0.454545 8.36364 0.454545C4.01818 0.454545 0.545456 3.92727 0.545456 8.27273C0.545456 12.6182 4.01818 16.0909 8.36364 16.0909C12.3273 16.0909 15.8182 13.0909 15.8182 8.27273C15.8182 7.70909 15.7091 7.12727 15.5453 6.54545Z" fill="#4285F4"/>
              <path d="M1.89091 5.01818L4.56364 7.01818C5.2 5.12727 6.67273 3.81818 8.36364 3.81818C9.47273 3.81818 10.4727 4.2 11.2364 4.87273L13.5636 2.54545C12.1455 1.21818 10.3455 0.454545 8.36364 0.454545C5.56364 0.454545 3.12727 2.34545 1.89091 5.01818Z" fill="#EA4335"/>
              <path d="M8.36364 16.0909C10.3091 16.0909 12.0727 15.3636 13.4727 14.1091L10.9091 11.9455C10.1818 12.4364 9.30909 12.7273 8.36364 12.7273C6.38182 12.7273 4.70909 11.6182 4.24545 9.67273L1.56364 11.7636C2.78182 14.3818 5.27273 16.0909 8.36364 16.0909Z" fill="#34A853"/>
              <path d="M15.5453 6.54545H8.36364V9.63636H12.5091C12.2908 10.5851 11.7581 11.4288 11 12.0545L11.0036 12.0516L13.5673 14.2152C13.3855 14.3818 15.8182 12.4364 15.8182 8.27273C15.8182 7.70909 15.7091 7.12727 15.5453 6.54545Z" fill="#4285F4"/>
              <path d="M4.24545 9.67273C4.07273 9.12727 3.98182 8.54545 3.98182 7.94545C3.98182 7.34545 4.07273 6.76364 4.23636 6.21818L4.23273 6.23273L1.51273 4.14H1.50909C0.909091 5.34545 0.545456 6.71818 0.545456 8.27273C0.545456 9.82727 0.909091 11.2 1.50909 12.4055L4.24545 9.67273Z" fill="#FBBC05"/>
            </svg>
            Sign in with Google
          </Button>
        </div>
      </div>
      
      <!-- Footer -->
      <div class="p-3 border-t text-center">
        <p class="text-xs text-gray-600">
          Don't have an account? 
          <a href="/signup" class="text-primary font-medium hover:underline">
            Create account
          </a>
        </p>
      </div>
    </div>
  </div>
</template>