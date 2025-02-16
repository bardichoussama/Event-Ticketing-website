<template>
  <header class="sticky top-0 flex h-16 items-center gap-4 border-b bg-background px-4 md:px-6">
    <!-- Desktop Navigation -->
    <nav class="hidden flex-col gap-6 text-lg font-medium md:flex md:flex-row md:items-center md:gap-5 md:text-sm lg:gap-6">
      <router-link to="/" class="flex items-center gap-2 text-lg font-semibold md:text-base">
        <Package2 class="h-6 w-6" />
        <span class="sr-only">Eventive</span>
      </router-link>
      <router-link to="/" class="text-foreground transition-colors hover:text-foreground">
        Home
      </router-link>
    </nav>

    <!-- Mobile Navigation -->
    <Sheet>
      <SheetTrigger as-child>
        <Button variant="outline" size="icon" class="shrink-0 md:hidden">
          <Menu class="h-5 w-5" />
          <span class="sr-only">Toggle navigation menu</span>
        </Button>
      </SheetTrigger>
      <SheetContent side="left">
        <nav class="grid gap-6 text-lg font-medium">
          <router-link to="/" class="flex items-center gap-2 text-lg font-semibold">
            <Package2 class="h-6 w-6" />
            <span class="sr-only">Acme Inc</span>
          </router-link>
          <router-link to="/dashboard" class="hover:text-foreground">Dashboard</router-link>
        </nav>
      </SheetContent>
    </Sheet>

    <!-- Search & User Menu -->
    <div class="flex w-full items-center gap-4 md:ml-auto md:gap-2 lg:gap-4">
      <form class="ml-auto flex-1 sm:flex-initial">
        <div class="relative">
          <Search class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground" />
          <Input
            type="search"
            placeholder="Search products..."
            class="pl-8 sm:w-[300px] md:w-[200px] lg:w-[300px]"
          />
        </div>
      </form>

      <!-- User Dropdown Menu -->
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
            <router-link to="/home" class="w-full">Home</router-link>
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

      <!-- Login and Register Links -->
      <div v-else class="flex space-x-4">
        <router-link
          to="/login"
          class="text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white px-4 py-2 rounded-lg"
        >
          Login
        </router-link>
        <router-link
          to="/register"
          class="text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white px-4 py-2 rounded-lg"
        >
          Register
        </router-link>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref } from 'vue';
import { useAuthStore } from '../stores/auth';
import { useRouter } from 'vue-router';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import { Badge } from '@/components/ui/badge'
import { Button } from '@/components/ui/button'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card'
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu'
import { Input } from '@/components/ui/input'
import { Sheet, SheetContent, SheetTrigger } from '@/components/ui/sheet'
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table'
import { Activity, ArrowUpRight, CircleUser, CreditCard, DollarSign, Menu, Package2, Search, Users } from 'lucide-vue-next'

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

<style scoped>
/* Add any custom styles if needed */
</style>