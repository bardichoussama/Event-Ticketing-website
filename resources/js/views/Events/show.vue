<script setup>
import { ref, onMounted, computed } from "vue";
import { useEventDetailsStore } from "../../stores/eventDetails";
import { useReservationStore } from "../../stores/reservation";
import { useTicketAvailabilityStore } from "../../stores/ticketavailability";
import { useAuthStore } from "../../stores/auth";
import { useRouter, useRoute } from 'vue-router';
import { useToast } from "@/components/ui/toast"; // ✅ FIXED IMPORT
import { Loader2, AlertTriangle, CheckCircle } from 'lucide-vue-next';
import { Button } from "@/components/ui/button";
import { LoaderPinwheel } from "lucide-vue-next";
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogTitle } from '@/components/ui/dialog';

const { toast } = useToast(); // ✅ Will now work correctly

const eventDetailsStore = useEventDetailsStore();
const ticketAvailabilityStore = useTicketAvailabilityStore();
const authStore = useAuthStore();
const reservationStore = useReservationStore();

const router = useRouter();
const route = useRoute();
// Ticket quantities
const regularTickets = ref(0);
const discountTickets = ref(0);
const showLoginModal = ref(false);
const showEmptyFieldsAlert = ref(false);
const showReservationSuccess = ref(false);
const showConfirmDialog = ref(false);
onMounted(async () => {

  await eventDetailsStore.fetchEventDetails(route.params.id);
  await ticketAvailabilityStore.checkAvailability(route.params.id);
});
// Countdown logic
const countdown = ref('0.00');
const updateCountdown = () => {
  const eventDate = new Date(eventDetailsStore.eventDetails.event_date);
  const now = new Date();
  const timeDiff = eventDate - now;

  if (timeDiff <= 0) {
    countdown.value = "Event has started!";
    clearInterval(timer);
    return;
  }

  const days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
  const hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
  const seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);

  countdown.value = `${days}d ${hours}h ${minutes}m ${seconds}s`;
};

const timer = setInterval(updateCountdown, 1000);

// Computed property for the total price
const totalPrice = computed(() => {
  const eventDetails = eventDetailsStore.eventDetails;

  // Check if eventDetails is loaded before calculating the total
  if (eventDetails && eventDetails.regular_price && eventDetails.discount_price) {
    const regularTicketTotal = regularTickets.value * eventDetails.regular_price;
    const discountTicketTotal = discountTickets.value * eventDetails.discount_price;

    return (regularTicketTotal + discountTicketTotal).toFixed(2); // Ensure 2 decimal places
  }
});

const isEventPassed = computed(() => {
  const eventDate = new Date(eventDetailsStore.eventDetails.event_date);
  const now = new Date();
  return eventDate < now;
});




// Reserve Tickets function
const reserveTickets = async () => {
  // Check if at least one ticket is selected
  if (regularTickets.value === 0 && discountTickets.value === 0) {
    toast({
      title: "Error",
      description: "Please select at least one ticket to proceed.",
      variant: "destructive",
    });
    return;
  }

  // Check if user is trying to reserve more tickets than available
  const totalTicketsSelected = regularTickets.value + discountTickets.value;
  const availableSeats = ticketAvailabilityStore.ticketAvailability.availableSeats;

  if (totalTicketsSelected > availableSeats) {
    toast({
      title: "Not enough tickets",
      description: `You can only reserve up to ${availableSeats} tickets. Please adjust your selection.`,
      variant: "destructive",
    });
    return;
  }

  // Check if user is logged in
  if (!authStore.isAuthenticated) {
    showLoginModal.value = true;
    return;
  }

  showConfirmDialog.value = true;
};

const confirmReservation = async () => {
  showConfirmDialog.value = false;
  try {
    await reservationStore.createReservation(
      route.params.id,
      regularTickets.value,
      discountTickets.value
    );

    // Update available seats count
    const totalReserved = regularTickets.value + discountTickets.value;
    ticketAvailabilityStore.updateAvailableSeats(-totalReserved);

    // Success message
    toast({
      title: "Success!",
      description: "Your tickets have been reserved successfully.",
      variant: "success",
    });

    // Redirect to tickets page after a short delay
    setTimeout(() => {
      router.push('/user/purchases');
    }, 1500);

    // Reset ticket quantities
    regularTickets.value = 0;
    discountTickets.value = 0;
  } catch (error) {
    // Show error toast
    toast({
      title: "Error",
      description: "Something went wrong. Please try again.",
      variant: "destructive",
    });
  }
};

const getImageUrl = (image) => `/assets/imgs/${image}`;

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('en-US', {
    weekday: 'long',
    month: 'long',
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

<template>
  <div class="bg-gray-50 min-h-screen">
    <!-- Breadcrumbs aligned with page content -->
    <div class="container mx-auto max-w-6xl px-4 py-3">
      <div class="text-sm text-gray-600 breadcrumbs">
        <a href="/" class="hover:text-primary">Home</a> &gt;
        <a href="/events" class="hover:text-primary">Event</a> &gt;
        <span class="text-gray-800">Event details</span>
      </div>
    </div>

    <div v-if="eventDetailsStore.loading" class="flex justify-center items-center h-96">
      <Loader2 class="animate-spin text-gray-500 h-10 w-10" />
    </div>

    <div v-else-if="eventDetailsStore.error" class="text-red-500 text-center">
      {{ eventDetailsStore.error }}
    </div>

    <div v-else-if="eventDetailsStore.eventDetails" class="container mx-auto px-4 py-6 space-y-6 max-w-6xl">
      <div class="flex flex-col md:flex-row gap-6">
        <!-- Event Details -->
        <div class="flex-1">
          <div class="h-72 md:h-96">
            <img class="h-full w-full object-cover rounded-lg shadow-md"
              :src="getImageUrl(eventDetailsStore.eventDetails.image)" alt="Event Image" />
          </div>

          <!-- Event info row improved -->
          <div
            class="flex flex-col sm:flex-row justify-between items-center mt-6 mb-4 p-4 bg-white rounded-lg shadow-sm">
            <div class="flex flex-col items-center mb-3 sm:mb-0">
              <p class="text-gray-500 text-sm">Event Date</p>
              <p class="font-medium">{{ formatDate(eventDetailsStore.eventDetails.event_date) }}</p>
            </div>

            <div class="hidden sm:block h-10 w-px bg-gray-200"></div>

            <div class="flex flex-col items-center mb-3 sm:mb-0">
              <p class="text-gray-500 text-sm">Event Time</p>
              <p class="font-medium">{{ formatTime(eventDetailsStore.eventDetails.event_date) }}</p>
            </div>

            <div class="hidden sm:block h-10 w-px bg-gray-200"></div>

            <div class="flex flex-col items-center">
              <p class="text-gray-500 text-sm">Event Location</p>
              <p class="font-medium">{{ eventDetailsStore.eventDetails.address }}</p>
            </div>
          </div>

          <div class="bg-white p-5 rounded-lg shadow-sm">
            <h2 class="text-xl font-semibold mb-3 text-gray-800">Event Description</h2>
            <p class="text-gray-700 leading-relaxed">{{ eventDetailsStore.eventDetails.description }}</p>
          </div>
        </div>

        <!-- Ticket Reservation -->
        <div class="flex flex-col full md:w-1/3 p-6 rounded-lg shadow-md bg-white space-y-4">
    <h3 class="text-xl font-semibold text-gray-800 border-b pb-2">Reserve Your Tickets</h3>

    <!-- Loading state -->
    <div v-if="ticketAvailabilityStore.loading" class="flex items-center justify-center h-64">
      <div class="text-center">
        <div class="animate-spin h-10 w-10 border-4 border-primary border-t-transparent rounded-full mx-auto mb-4"></div>
        <p class="text-gray-500">Loading ticket information...</p>
      </div>
    </div>

    <!-- Sold Out Message - Only show when loading is complete and seats are 0 -->
    <div v-else-if="ticketAvailabilityStore.ticketAvailability.availableSeats === 0"
      class="flex items-center justify-center h-64">
      <div class="text-center">
        <div class="text-red-600 text-3xl font-bold mb-2">🎟️ SOLD OUT</div>
        <p class="text-gray-500">No tickets available for this event</p>
      </div>
    </div>

    <!-- Event Ended Message -->
    <div v-else-if="isEventPassed" class="flex items-center justify-center h-64">
      <div class="text-center">
        <div class="text-gray-600 text-3xl font-bold mb-2">🗓️ EVENT ENDED</div>
        <p class="text-gray-500">This event has already taken place</p>
      </div>
    </div>

    <!-- Ticket Selection (Only if Available and loading is complete) -->
    <div v-else>
      <div class="flex flex-col items-center justify-center gap-4">
        <div class="flex items-center justify-between bg-violet-50 w-full px-4 py-4 rounded-xl">
          <div class="flex flex-col">
            <p class="font-medium text-gray-800">Regular Ticket</p>
            <p class="text-green-500 font-semibold">${{ eventDetailsStore.eventDetails.regular_price }}</p>
          </div>

          <input v-model="regularTickets" type="number" min="0"
            :max="ticketAvailabilityStore.ticketAvailability.availableSeats"
            class="bg-white rounded-lg text-base p-2 w-20 text-center border border-gray-200" />
        </div>

        <div class="flex items-center justify-between bg-violet-50 w-full px-4 py-4 rounded-xl">
          <div class="flex flex-col">
            <p class="font-medium text-gray-800">Discount Ticket</p>
            <p class="text-green-500 font-semibold">${{ eventDetailsStore.eventDetails.discount_price }}</p>
          </div>

          <input v-model="discountTickets" type="number" min="0"
            :max="ticketAvailabilityStore.ticketAvailability.availableSeats"
            class="bg-white rounded-lg text-base p-2 w-20 text-center border border-gray-200" />
        </div>
      </div>

      <div class="mt-4 p-4 bg-gray-50 rounded-lg">
        <div class="flex justify-between text-sm mb-2">
          <p class="text-gray-600">Total seats:</p>
          <p class="font-medium">{{ ticketAvailabilityStore.ticketAvailability.totalCapacity }}</p>
        </div>
        <div class="flex justify-between text-sm mb-2">
          <p class="text-gray-600">Total Quantity:</p>
          <p class="font-medium">{{ parseInt(regularTickets || 0) + parseInt(discountTickets || 0) }}</p>
        </div>
        <div class="flex justify-between text-base">
          <p class="font-medium text-gray-800">Total price:</p>
          <p class="font-bold text-primary"> ${{ totalPrice }}</p>
        </div>
      </div>

      <!-- Countdown -->
      <p class="text-gray-600 text-center text-sm py-2">⏳ Time left to the event: {{ countdown }}</p>

      <!-- Reserve Button -->
      <button @click="reserveTickets" :class="[
        'w-full py-3 rounded-xl shadow-md focus:outline-none focus:ring-2 focus:ring-primary flex items-center justify-center',
        'bg-primary text-white hover:bg-primary/80'
      ]">
        <span class="font-semibold">Reserve Now</span>
      </button>

      <div class="text-gray-700 text-sm text-center mt-2">
        🎫 Remaining Tickets: <span class="font-bold">{{ ticketAvailabilityStore.ticketAvailability.availableSeats }}</span>
      </div>
    </div>
  </div>
  </div>
    </div>
    <Dialog :open="showConfirmDialog" @update:open="showConfirmDialog = $event">
      <DialogContent>
        <DialogTitle>Confirm Reservation</DialogTitle>
        <DialogDescription>
          You are about to reserve {{ regularTickets }} regular and {{ discountTickets }} discount tickets.
        </DialogDescription>
        <DialogFooter>
          <button @click="showConfirmDialog = false" class="bg-gray-400 text-white px-4 py-2 rounded-lg">
            Cancel
          </button>
          <button @click="confirmReservation" class="bg-green-600 text-white px-4 py-2 rounded-lg flex items-center"
            :disabled="isLoading">
            <Loader2 v-if="isLoading" class="mr-2 h-4 w-4 animate-spin" />
            Confirm
          </button>
        </DialogFooter>
      </DialogContent>
    </Dialog>

    <!-- Login Alert Dialog -->
    <Dialog :open="showLoginModal" @update:open="showLoginModal = $event">
      <DialogContent
        class="sm:max-w-[425px] p-6 rounded-lg shadow-lg bg-white transform transition-all duration-300 ease-in-out">
        <DialogTitle class="text-lg font-semibold text-primary">
          Not Logged In
        </DialogTitle>
        <DialogDescription class="mt-2 text-muted-foreground">
          You need to log in to reserve tickets. Please sign in to continue.
        </DialogDescription>
        <DialogFooter class="mt-4">
          <Button @click="router.push('/login');"
            class="bg-gradient-to-r from-primary to-primary/90 text-white px-5 py-2 rounded-lg shadow-md hover:scale-105 transition-all hover:shadow-lg">
            🔑 Go to Login
          </Button>
        </DialogFooter>
      </DialogContent>
    </Dialog>
  </div>
</template>