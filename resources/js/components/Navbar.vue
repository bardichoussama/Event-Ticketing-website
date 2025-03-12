<template>
  <header class="sticky top-0 flex h-16 items-center justify-between border-b bg-background px-4 md:px-6 z-10">
    <!-- Logo - Always visible on all screen sizes -->
    <router-link to="/" class="flex items-center gap-2 text-lg font-semibold md:text-base">
      <!-- <Package2 class="h-6 w-6" /> -->
      <span>Eventive</span>
    </router-link>
    <div class="flex items-center gap-2 md:gap-4">
      <!-- User Dropdown Menu - When Authenticated -->
      <DropdownMenu v-if="authStore.isAuthenticated">
        <DropdownMenuTrigger as-child>
          <Button variant="secondary" size="icon" class="rounded-full">
            <CircleUser class="h-5 w-5" />
            <span class="sr-only">Toggle user menu</span>
          </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end">
          <DropdownMenuLabel>My Account</DropdownMenuLabel>
          <DropdownMenuSeparator />
          <DropdownMenuItem>
            <router-link to="/dashboard" class="w-full">Dashboard</router-link>
          </DropdownMenuItem>
          <DropdownMenuItem>
            <router-link to="/user/purchases" class="w-full">My Purchases</router-link>
          </DropdownMenuItem>
          <DropdownMenuItem>
            <router-link to="/edit/profile" class="w-full">Settings</router-link>
          </DropdownMenuItem>
          <DropdownMenuSeparator />
          <DropdownMenuItem @click="handleLogout">Logout</DropdownMenuItem>
        </DropdownMenuContent>
      </DropdownMenu>

      <!-- Login and Register Links - When Not Authenticated -->
      <div v-else class="hidden sm:flex space-x-2">
        <router-link
          to="/login"
          class="text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white px-3 py-2 rounded-lg transition-colors"
        >
          Login
        </router-link>
        <router-link
          to="/register"
          class="text-sm text-white bg-primary hover:bg-primary/90 px-3 py-2 rounded-lg transition-colors"
        >
          Register
        </router-link>
      </div>

      <!-- Mobile Navigation Menu Button -->
      <Sheet>
        <SheetTrigger as-child>
          <Button variant="outline" size="icon" class="shrink-0 md:hidden">
            <Menu class="h-5 w-5" />
            <span class="sr-only">Menu</span>
          </Button>
        </SheetTrigger>
        <SheetContent side="right">
          <div class="grid gap-6 text-lg font-medium py-6">
       
            
            <!-- Mobile Auth Links -->
            <div class="pt-4 border-t">
              <div v-if="authStore.isAuthenticated">
                <router-link to="/dashboard" class="block py-2 hover:text-primary">Dashboard</router-link>
                <router-link to="/user/purchases" class="block py-2 hover:text-primary">My Purchases</router-link>
                <router-link to="/edit/profile" class="block py-2 hover:text-primary">Settings</router-link>
                <button @click="handleLogout" class="w-full text-left py-2 hover:text-primary">Logout</button>
              </div>
              <div v-else class="flex flex-col gap-2 mt-2">
                <router-link
                  to="/login"
                  class="block text-center py-2 border rounded-lg hover:bg-gray-100 transition-colors"
                >
                  Login
                </router-link>
                <router-link
                  to="/register"
                  class="block text-center py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors"
                >
                  Register
                </router-link>
              </div>
            </div>
          </div>
        </SheetContent>
      </Sheet>
    </div>
  </header>
</template>

<script setup>
import { useAuthStore } from '../stores/auth';
import { useRouter } from 'vue-router';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Sheet, SheetContent, SheetTrigger } from '@/components/ui/sheet';
import { CircleUser, Menu, Package2 } from 'lucide-vue-next';

const authStore = useAuthStore();
const router = useRouter();

const handleLogout = async () => {
  try {
    await authStore.logout();
    router.push('/login');
  } catch (error) {
    console.error('Logout failed:', error);
  }
};
</script>