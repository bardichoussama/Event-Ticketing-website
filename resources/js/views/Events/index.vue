<script setup>
import { ref, onMounted } from "vue";
import {
  Card,
  CardHeader,
  CardTitle,
  CardDescription,
  CardContent,
} from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";
import { Search } from "lucide-vue-next";
import { useEventStore } from "../../stores/event";
import{useCategoryStore} from "../../stores/category";
import EventCard from "../../components/EventCard.vue";
import Slider from "../../components/Slider.vue";
import { Calendar } from "@/components/ui/calendar";
import { CalendarIcon } from "lucide-vue-next";

import {
  Popover,
  PopoverTrigger,
  PopoverContent,
} from "@/components/ui/popover";
import { format } from "date-fns";

const eventStore = useEventStore();
const categoryStore = useCategoryStore();

// Filter states
const searchQuery = ref("");
const startDate = ref(null);
const endDate = ref(null);
const timeFilter = ref("all");
const categoryFilter = ref("");

// Search and filter function
const searchEvents = () => {
  eventStore.fetchEvents(searchQuery.value, startDate.value, endDate.value);
};

// Initialize events on component mount
onMounted(() => {
  searchEvents();
});
</script>

<template>
   <router-link
          to="/edit/profile"
          class="text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white px-4 py-2 rounded-lg"
        >
          Login
        </router-link>
  <div class="container mx-auto px-4 py-6 space-y-6">
    <!-- Slider Section -->
    <Slider class="w-full h-64 rounded-lg mb-8" />

    <!-- Date Filters & Search -->
    <div class="flex flex-wrap items-center justify-between gap-4">
      <!-- Date Pickers -->
      <div class="flex items-center gap-4">
        <!-- Start Date -->
        <div class="flex flex-col gap-1.5">
          <Label class="text-sm text-gray-600">Start Date</Label>
          <Popover>
            <PopoverTrigger as-child>
              <div
                class="w-[200px] px-3 py-2 text-sm flex items-center justify-between rounded-md border border-input bg-background hover:bg-accent hover:text-accent-foreground cursor-pointer">
                <span :class="!startDate && 'text-muted-foreground'">
                  {{ startDate ? format(startDate, "PPP") : "Pick a date" }}
                </span>
                <CalendarIcon class="h-4 w-4 text-primary opacity-70" />
              </div>
            </PopoverTrigger>
            <PopoverContent class="w-auto p-0">
              <Calendar v-model="startDate" :initial-focus="true" @update:model-value="searchEvents" />
            </PopoverContent>
          </Popover>
        </div>

        <!-- End Date -->
        <div class="flex flex-col gap-1.5">
          <Label class="text-sm text-gray-600">End Date</Label>
          <Popover>
            <PopoverTrigger as-child>
              <div
                class="w-[200px] px-3 py-2 text-sm flex items-center justify-between rounded-md border border-input bg-background hover:bg-accent hover:text-accent-foreground cursor-pointer">
                <span :class="!endDate && 'text-muted-foreground'">
                  {{ endDate ? format(endDate, "PPP") : "Pick a date" }}
                </span>
                <CalendarIcon class="h-4 w-4 text-primary opacity-70" />
              </div>
            </PopoverTrigger>
            <PopoverContent class="w-auto p-0">
              <Calendar v-model="endDate" :initial-focus="true" @update:model-value="searchEvents" />
            </PopoverContent>
          </Popover>
        </div>
      </div>
      <div class="flex flex-wrap items-center  gap-4">
      <!-- Event Time -->
      <div class="flex flex-col gap-1.5">
        <Label class="text-sm text-gray-600">Event Time</Label>
        <Select v-model="timeFilter" @update:modelValue="searchEvents">
          <SelectTrigger class="border border-input w-[200px]">
            <SelectValue placeholder="Select time filter" />
            <span class="absolute right-3 top-2.5 text-primary">&#9662;</span>
          </SelectTrigger>
          <SelectContent>
            <SelectItem value="all">All Events</SelectItem>
            <SelectItem value="upcoming">Upcoming Events</SelectItem>
            <SelectItem value="past">Past Events</SelectItem>
          </SelectContent>
        </Select>
      </div>

      <!-- Category -->
      <div class="flex flex-col gap-1.5">
        <Label class="text-sm text-gray-600">Category</Label>
        <Select v-model="categoryFilter" @update:modelValue="searchEvents">
          <SelectTrigger class="border border-input w-[200px]">
            <SelectValue placeholder="Select category" />
            <span class="absolute right-3 top-2.5 text-primary">&#9662;</span>
          </SelectTrigger>
          <SelectContent>
            <SelectItem value="">All Categories</SelectItem>
          </SelectContent>
        </Select>
      </div>
    </div>

      <!-- Search Field -->
      <div class="flex flex-col gap-1.5">
        <Label class="text-sm text-gray-600">Search</Label>
        <div class="relative w-[240px]">
          <Search class="absolute left-3 top-2.5 h-4 w-4 text-gray-500" />
          <Input v-model="searchQuery" placeholder="Search events..." class="pl-9" @input="searchEvents" />
        </div>
      </div>
    </div>

    <!-- Event Time & Category Filters -->
    
   <p>Information Of Event Schedule </p>
    <!-- Events Grid -->
    <div  v-if="eventStore.events.length" class="flex flex-col bg-violet-50 mx-20">
      <EventCard v-for="event in eventStore.events" :key="event.id" :event="event" />
    </div>

    <!-- Loading and Error States -->
    <p v-if="eventStore.loading" class="text-center text-gray-500">Loading events...</p>
    <p v-if="eventStore.error" class="text-center text-red-500">{{ eventStore.error }}</p>
  </div>
</template>


<!-- Search Input (Right Side) -->
