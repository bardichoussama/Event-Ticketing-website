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

    <!-- Event Details -->
    <div v-else-if="eventDetailsStore.eventDetails" class="max-w-4xl mx-auto bg-white shadow-lg rounded-xl overflow-hidden">
      <div class="p-6">
        <h1 class="text-3xl font-semibold text-gray-900">
          {{ eventDetailsStore.eventDetails.title }}
        </h1>

        <!-- Ticket Reservation Form -->
        <div class="mt-6">
          <label class="block text-lg font-medium text-gray-700">Regular Tickets</label>
          <input type="number" v-model="regularTickets" min="0" class="w-full p-2 border rounded mt-2" />

          <label class="block text-lg font-medium text-gray-700 mt-4">Discounted Tickets</label>
          <input type="number" v-model="discountTickets" min="0" class="w-full p-2 border rounded mt-2" />

          <button @click="reserveTickets" class="mt-4 bg-purple-600 text-white px-4 py-2 rounded">
            Reserve
          </button>
        </div>
      </div>
    </div>

    <!-- No Data State -->
    <div v-else class="text-center text-gray-500">
      No event details found.
    </div>

    <!-- Login Modal (if user is not logged in) -->
    <LoginModal v-if="showLoginModal" @close="showLoginModal = false" />
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import { useEventDetailsStore } from "../../stores/eventDetails";
import { useAuthStore } from "../../stores/auth";
import { useReservationStore } from "../../stores/reservation";
import { Loader2 } from 'lucide-vue-next';

const route = useRoute();
const eventDetailsStore = useEventDetailsStore();
const authStore = useAuthStore();
const reservationStore = useReservationStore();

const regularTickets = ref(0);
const discountTickets = ref(0);
const showLoginModal = ref(false);

onMounted(() => {
  eventDetailsStore.fetchEventDetails(route.params.id);
});

const reserveTickets = async () => {
  if (!authStore.isAuthenticated) {
    showLoginModal.value = true;
    return;
  }

  await reservationStore.createReservation(route.params.id, regularTickets.value, discountTickets.value);
};
</script>
