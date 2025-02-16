<template>
  <div>
    <div class="flex gap-4  h-48 p-4 rounded-lg">
      
      <!-- Image (Outside the Card) -->
      <div class="h-full w-1/4 rounded-lg overflow-hidden">
        <img 
          class="h-full w-full object-cover rounded-lg shadow-xl" 
          :src="getImageUrl(event.image)" 
          :alt="event.title"
        />
      </div>

      <!-- Content Section -->
      <div class="flex gap-8 w-full h-full p-6 bg-white rounded-lg">
        <div class="flex flex-col justify-between flex-grow">
          
          <!-- Date & Time (With Border) -->
          <div class="flex items-center gap-3 p-2 border rounded-2xl w-80  justify-center text-gray-500 text-sm font-medium">
            <CalendarIcon class="h-5 w-5 text-primary opacity-70" />
            <p>{{ formatDate(event.event_timestamp) }}</p>
            <span class="mx-2">|</span>
            <ClockIcon class="h-5 w-5 text-primary opacity-70" />
            <p>{{ formatTime(event.event_timestamp) }}</p>
          </div>

          <!-- Title -->
          <p class="text-xl font-medium text-gray-900 mt-3">{{ event.title }}</p>

          <!-- Address -->
          <div class="mt-7 flex items-center gap-2 text-gray-600 text-sm font-medium">
            <MapPinIcon class="h-5 w-5 text-primary opacity-70" />
            <p>{{ event.address }}</p>
          </div>
        </div>

        <!-- Vertical Divider -->
        <div class="w-px h-auto bg-gray-300 mx-4"></div>

        <!-- Button & Price Section -->
        <div class="flex flex-col justify-center items-center">
          <router-link :to="`/event/${event.id}`">
            <button type="button"
              class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">
              Buy Ticket
            </button>
          </router-link>
          <div class="text-center mt-2">
            <span class="text-lg font-semibold text-gray-900">${{ event.discount_price }}</span>
            <span class="text-sm text-gray-500 line-through ml-1">${{ event.regular_price }}</span>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>


<script setup>
import { defineProps } from 'vue'
import { CalendarIcon, ClockIcon, MapPinIcon } from 'lucide-vue-next' // Import icons

defineProps({
  event: {
    type: Object,
    required: true
  }
})

// Format Date
const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    weekday: 'long',
    month: 'long',
    day: 'numeric'
  })
}

// Format Time
const formatTime = (dateString) => {
  return new Date(dateString).toLocaleTimeString('en-US', {
    hour: '2-digit',
    minute: '2-digit'
  })
}

// Get Image URL
const getImageUrl = (image) => {
  return `/assets/imgs/${image}`;
}
</script>
