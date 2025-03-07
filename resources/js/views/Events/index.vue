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
  const timeFilter = ref("all");  // Adding the time filter
  const categoryFilter = ref(""); // Adding the category filter

  // Search and filter function
  const searchEvents = () => {
    eventStore.fetchEvents(
      searchQuery.value,
      startDate.value,
      endDate.value,
      timeFilter.value,  // Pass the timeFilter here
      categoryFilter.value // Pass the categoryFilter here
    );
  };

  // Initialize events on component mount
  onMounted(() => {
    categoryStore.fetchCategories();
    searchEvents();
  });
</script>

<template>

  <div class="container mx-auto px-4 py-6 space-y-6">
    <!-- Slider Section -->
    <Slider class="w-full h-64 rounded-lg mb-8" />

    <!-- Date Filters & Search -->
    <div class="flex flex-wrap items-center justify-between gap-4 bg-violet-50 p-7 rounded-md">
      <!-- Date Pickers -->
      <div class="flex items-center gap-4">
        <!-- Start Date -->
        <div class="flex flex-col gap-1.5">
          <Popover>
            <PopoverTrigger as-child>
              <div
                class="w-[200px] px-3 py-2 text-sm flex items-center justify-between rounded-md border border-input bg-background hover:bg-accent hover:text-accent-foreground cursor-pointer">
                <span :class="!startDate && 'text-muted-foreground'">
                  {{ startDate ? format(startDate, "PPP") : "Start Date" }}
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
          <Popover>
            <PopoverTrigger as-child>
              <div
                class="w-[200px] px-3 py-2 text-sm flex items-center justify-between rounded-md border border-input bg-background hover:bg-accent hover:text-accent-foreground cursor-pointer">
                <span :class="!endDate && 'text-muted-foreground'">
                  {{ endDate ? format(endDate, "PPP") : "End Date" }}
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

      <!-- Event Time & Category Filters -->
      <div class="flex flex-wrap items-center gap-4">
        <!-- Event Time -->
        <div class="flex flex-col gap-1.5">
          <Select v-model="timeFilter" @update:modelValue="searchEvents">
            <SelectTrigger class="border border-input w-[200px]">
              <SelectValue placeholder="Select category" />
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
          <Select v-model="categoryFilter" @update:modelValue="searchEvents">
            <SelectTrigger class="border border-input w-[200px]">
              <SelectValue placeholder="Select Category">
                All Categories
              </SelectValue>
              <span class="absolute right-3 top-2.5 text-primary">&#9662;</span>
            </SelectTrigger>
            <SelectContent>
              <SelectItem :value="null">All Categories</SelectItem>
              <SelectItem v-for="category in categoryStore.categories" :key="category.id" :value="category.id">
                {{ category.name }}
              </SelectItem>
            </SelectContent>
          </Select>
        </div>
      </div>

      <!-- Search Field -->
      <div class="flex flex-col gap-1.5">
        <div class="relative w-[240px]">
          <Search class="absolute left-3 top-2.5 h-4 w-4 text-gray-500" />
          <Input v-model="searchQuery" placeholder="Search events..." class="pl-9" @input="searchEvents" />
        </div>
      </div>
    </div>

    <!-- Event Time & Category Filters -->

    <p>Information Of Event Schedule </p>
    <!-- Events Grid -->
    <div v-if="eventStore.events.length" class="flex flex-col bg-violet-50 mx-20">
      <EventCard v-for="event in eventStore.events" :key="event.id" :event="event" />
    </div>

    <!-- Loading and Error States -->
    <p v-if="eventStore.loading" class="text-center text-gray-500">Loading events...</p>
    <p v-if="eventStore.error" class="text-center text-red-500">{{ eventStore.error }}</p>
  </div>
</template>
