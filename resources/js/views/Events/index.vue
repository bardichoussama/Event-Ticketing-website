<script setup>

import { Input } from "@/components/ui/input";
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from "@/components/ui/select";
import { Search } from "lucide-vue-next";
import EventCard from "../../components/EventCard.vue";
import Slider from "../../components/Slider.vue";
import { Calendar } from "@/components/ui/calendar";
import { CalendarIcon } from "lucide-vue-next";
import { LoaderPinwheel } from "lucide-vue-next";

import {
  Popover,
  PopoverTrigger,
  PopoverContent,
} from "@/components/ui/popover";
import { format } from "date-fns";
import { ref, onMounted } from "vue";
import { useEventStore } from "../../stores/event";
import { useCategoryStore } from "../../stores/category";

const eventStore = useEventStore();
const categoryStore = useCategoryStore();

// Filter states
const searchQuery = ref("");
const startDate = ref(null);
const endDate = ref(null);
const categoryFilter = ref("");
const eventTimingFilter = ref('all');

// Search and filter function
const searchEvents = () => {
  eventStore.fetchEvents(
    searchQuery.value,
    startDate.value,
    endDate.value,
    categoryFilter.value === 'null' ? '' : categoryFilter.value,
    eventTimingFilter.value

  );
};

// Initialize events on component mount
onMounted(() => {
  categoryStore.fetchCategories();
  searchEvents();
});
</script>

<template>
  <div class="container mx-auto px-3 py-4 space-y-4 max-w-4xl">
    <!-- Slider Section -->
    <div class="rounded-md mx-1">
      <Slider class="w-full h-9 rounded-md mb-3" />
    </div>

    <!-- Date Filters & Search Section -->
    <div class="mx-1 ">
      <h2 class="text-sm font-semibold mb-1.5 text-gray-800">Filter Events</h2>
      <div class="flex flex-wrap items-center justify-between gap-2 bg-violet-50 p-3 rounded-md shadow-sm text-xs">
        <!-- Date Pickers -->
        <div class="flex items-center gap-2">
          <!-- Start Date -->
          <div class="flex flex-col gap-0.5">
            <Popover>
              <PopoverTrigger as-child>
                <button
                  class="w-[140px] px-2 py-1 text-xs flex items-center justify-between rounded-md border border-input bg-background hover:bg-accent hover:text-accent-foreground cursor-pointer">
                  <span :class="!startDate && 'text-muted-foreground'">
                    {{ startDate ? format(startDate, "PPP") : "Start Date" }}
                  </span>
                  <CalendarIcon class="h-2.5 w-2.5 text-primary opacity-70" />
                </button>
              </PopoverTrigger>
              <PopoverContent class="w-auto p-0">
                <Calendar v-model:modelValue="startDate" :initial-focus="true" @update:modelValue="searchEvents" />
              </PopoverContent>
            </Popover>
          </div>

          <!-- End Date -->
          <div class="flex flex-col gap-0.5">
            <Popover>
              <PopoverTrigger as-child>
                <button
                  class="w-[140px] px-2 py-1 text-xs flex items-center justify-between rounded-md border border-input bg-background hover:bg-accent hover:text-accent-foreground cursor-pointer">
                  <span :class="!endDate && 'text-muted-foreground'">
                    {{ endDate ? format(endDate, "PPP") : "End Date" }}
                  </span>
                  <CalendarIcon class="h-2.5 w-2.5 text-primary opacity-70" />
                </button>
              </PopoverTrigger>
              <PopoverContent class="w-auto p-0">
                <Calendar v-model:modelValue="endDate" :initial-focus="true" @update:modelValue="searchEvents" />
              </PopoverContent>
            </Popover>
          </div>
        </div>

        <!-- Event Time & Category Filters -->
        <div class="flex flex-wrap items-center gap-2">
          <!-- Event Time -->
          <div class="flex flex-col gap-0.5">
            <Select v-model:modelValue="eventTimingFilter" @update:modelValue="searchEvents">
              <SelectTrigger class="border border-input w-[140px] h-7 text-xs">
                <SelectValue placeholder="Event Timing" />
                <span class="absolute right-2 top-1.5 text-primary">&#9662;</span>
              </SelectTrigger>
              <SelectContent>
                <SelectItem value="all">All Events</SelectItem>
                <SelectItem value="upcoming">Upcoming Events</SelectItem>
                <SelectItem value="past">Past Events</SelectItem>
              </SelectContent>
            </Select>
          </div>

          <!-- Category -->
          <div class="flex flex-col gap-0.5">
            <Select v-model:modelValue="categoryFilter" @update:modelValue="searchEvents">
              <SelectTrigger class="border border-input w-[140px] h-7 text-xs">
                <SelectValue placeholder="Select Category" />
                <span class="absolute right-2 top-1.5 text-primary">&#9662;</span>
              </SelectTrigger>
              <SelectContent>
                <!-- Ensure value is a string here -->
                <SelectItem :value="'null'">All Categories</SelectItem>
                <SelectItem v-for="category in categoryStore.categories" :key="category.id"
                  :value="String(category.id)">
                  {{ category.name }}
                </SelectItem>
              </SelectContent>
            </Select>
          </div>
        </div>

        <!-- Search Field -->
        <div class="flex flex-col gap-0.5">
          <div class="relative w-[140px]">
            <Search class="absolute left-2 top-2 h-2.5 w-2.5 text-gray-500" />
            <Input v-model="searchQuery" placeholder="Search events..." class="pl-6 h-7 text-xs"
              @input="searchEvents" />
          </div>
        </div>
      </div>
    </div>

    <div class="mx-1">
      <h2  class="text-sm font-semibold mb-1.5 text-gray-800">
        Event Schedule
      </h2>

      <!-- Loading State -->
      <div v-if="eventStore.loading" class="flex justify-center items-center h-40">
        <LoaderPinwheel class="animate-spin text-primary h-10 w-10" />
      </div>

      <!-- Events Grid -->
      <div v-else-if="eventStore.events.length" class="flex flex-col bg-violet-50 rounded-md shadow-sm p-3 text-xs">
        <EventCard v-for="event in eventStore.events" :key="event.id" :event="event" />
      </div>

      <!-- No Events Found -->
      <div v-else class="flex justify-center items-center h-96 text-gray-500 text-sm">
        No events available.
      </div>

      <!-- Error Message -->
      <p v-if="eventStore.error" class="text-center text-red-500 text-xs">
        {{ eventStore.error }}
      </p>
    </div>

  </div>
</template>