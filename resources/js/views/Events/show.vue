<template>
  <div class="container mx-auto p-6">
    <!-- Loading State -->
    <div v-if="eventDetailsStore.loading" class="flex justify-center items-center h-96">
      <Loader2 class="animate-spin text-gray-500 h-10 w-10" />
    </div>

    <!-- Error State -->
    <div v-else-if="eventDetailsStore.error" class="text-red-500 text-center">
      {{ eventDetailsStore.error }}
    </div>

    <!-- Event Title -->
    <div v-else-if="eventDetailsStore.eventDetails" class="max-w-4xl mx-auto bg-white shadow-lg rounded-xl overflow-hidden">
      <div class="p-6">
        <h1 class="text-3xl font-semibold text-gray-900">
          {{ eventDetailsStore.eventDetails.title }}
        </h1>
      </div>
    </div>

    <!-- No Data State -->
    <div v-else class="text-center text-gray-500">
      No event details found.
    </div>
  </div>
</template>

<script setup>
import { onMounted } from "vue";
import { useRoute } from "vue-router";
import { useEventDetailsStore } from "../../stores/eventDetails";
import { Loader2 } from 'lucide-vue-next';

const route = useRoute();
const eventDetailsStore = useEventDetailsStore();

// Fetch event details on mount
onMounted(() => {
  eventDetailsStore.fetchEventDetails(route.params.id);
});
</script>