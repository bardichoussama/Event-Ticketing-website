<template>
  <div>
    <div class="flex flex-col md:flex-row gap-3 h-auto md:h-36 p-2 rounded-lg">
      <!-- Image (Outside the Card) -->
      <div class="w-full md:w-1/3 h-36 md:h-full rounded-lg overflow-hidden">
        <img class="h-full w-full object-cover rounded-lg shadow-md" :src="getImageUrl(event.image)"
          :alt="event.title" />
      </div>

      <!-- Content Section -->
      <div class="flex flex-col md:flex-row gap-2 md:gap-4 w-full h-full p-2 md:p-3 bg-white rounded-lg">
        <div class="flex flex-col justify-between flex-grow">
          <!-- Date & Time (With Border) -->
          <div
            class="flex flex-col sm:flex-row items-center p-1 border rounded-xl w-full md:w-52 justify-center text-gray-500 text-xs font-medium">
            <div class="flex items-center gap-1">
              <CalendarIcon class="h-3 w-3 text-primary opacity-70 flex-shrink-0" />
              <p class="text-xs">{{ formatDate(event.event_timestamp) }}</p>
            </div>
            <span class="hidden sm:block mx-1">|</span>
            <div class="flex items-center gap-1 mt-1 sm:mt-0">
              <ClockIcon class="h-3 w-3 text-primary opacity-70 flex-shrink-0" />
              <p class="text-xs">{{ formatTime(event.event_timestamp) }}</p>
            </div>
          </div>

          <!-- Title -->
          <p class="text-sm md:text-base font-medium text-gray-900 mt-4">{{ event.title }}</p>

          <!-- Address -->
          <div class="mt-1 md:mt-4 flex items-center gap-1 text-gray-600 text-xs font-medium">
            <MapPinIcon class="h-3 w-3 text-primary opacity-70 flex-shrink-0" />
            <p class="truncate text-sm">{{ event.address }}</p>
          </div>
        </div>

        <!-- Vertical Divider - Hidden on mobile, visible on md and up -->
        <div class="hidden md:block w-px h-auto bg-gray-300 mx-1"></div>

        <!-- Horizontal Divider - Visible on mobile, hidden on md and up -->
        <div class="md:hidden w-full h-px bg-gray-300 my-2"></div>

        <!-- Button & Price Section -->
        <div class="flex flex-col justify-center items-center">
          <router-link :to="`/event/${event.id}`">
            <button type="button" :class="[
              'focus:outline-none text-white font-medium rounded-lg text-xs px-3 py-1',
              isEventPassed ? 'bg-purple-300 hover:bg-purple-200' : 'bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900'
            ]">
              {{ isEventPassed ? 'Ended Event' : 'Buy Ticket' }}
            </button>
          </router-link>
          <div class="text-center mt-1">
            <span class="text-xs md:text-sm font-semibold text-gray-900">${{ event.regular_price }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>







<script setup>
import { ref, computed } from 'vue';
import { CalendarIcon, ClockIcon, MapPinIcon } from 'lucide-vue-next';

// Props
const props = defineProps({
  event: {
    type: Object,
    required: true
  }
});

// Computed property to check if event has passed
const isEventPassed = computed(() => {
  const eventDate = new Date(props.event.event_timestamp);
  const now = new Date();
  return eventDate < now;
});


const getImageUrl = (image) => {
  return `/assets/imgs/${image}`;
}

const formatDate = (timestamp) => {
  const date = new Date(timestamp);
  return date.toLocaleDateString('en-US', {
    weekday: 'short',
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  });
};

const formatTime = (timestamp) => {
  const date = new Date(timestamp);
  return date.toLocaleTimeString('en-US', {
    hour: '2-digit',
    minute: '2-digit'
  });
};
</script>
