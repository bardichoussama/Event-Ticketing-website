<script setup>
import { ref, onMounted, computed } from "vue";
import { useRoute } from "vue-router";
import { useEventDetailsStore } from "../../stores/eventDetails";
import { useAuthStore } from "../../stores/auth";
import { useReservationStore } from "../../stores/reservation";
import { useToast } from "@/components/ui/toast";
import { Dialog, DialogContent, DialogTitle, DialogDescription, DialogFooter } from "@/components/ui/dialog";

const route = useRoute();
const eventDetailsStore = useEventDetailsStore();
const authStore = useAuthStore();
const reservationStore = useReservationStore();
const toast = useToast(); 

// Ticket quantities
const regularTickets = ref(0);
const discountTickets = ref(0);
const showLoginModal = ref(false);

onMounted(() => {
  eventDetailsStore.fetchEventDetails(route.params.id);
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
  return "0.00"; // Default value if eventDetails is not loaded
});

// Reserve Tickets function
const reserveTickets = async () => {
  // Check if no tickets are selected
  if (regularTickets.value === 0 && discountTickets.value === 0) {
    toast({
      title: "Error",
      description: "Please select at least one ticket to proceed.",
      variant: "destructive",
    });
    return;
  }

  // Check if user is logged in
  if (!authStore.isAuthenticated) {
    showLoginModal.value = true;
    return;
  }

  try {
    await reservationStore.createReservation(
      route.params.id,
      regularTickets.value,
      discountTickets.value
    );
    alert("Success");

    // Show success toast
    toast({
      title: "Success",
      description: "Your reservation was successful!",
      variant: "success",
    });

    // Reset ticket quantities after successful reservation
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
</script>

<template>
  <div v-if="eventDetailsStore.loading" class="flex justify-center items-center h-96">
    <Loader2 class="animate-spin text-gray-500 h-10 w-10" />
  </div>

  <div v-else-if="eventDetailsStore.error" class="text-red-500 text-center">
    {{ eventDetailsStore.error }}
  </div>

  <div v-else-if="eventDetailsStore.eventDetails" class="container mx-auto px-4 py-6 space-y-6">
    <!-- Event Banner -->
    <div class="flex h-96 bg-black relative rounded-md">
      <img class="h-full w-full object-cover opacity-50 rounded-md" src="../../../../public/assets/imgs/bg-login.jpg" alt="Event Background" />
      <h1 class="absolute inset-0 flex items-center justify-center text-white text-4xl font-bold">
        Event Details
      </h1>
    </div>

    <div class="flex flex-col md:flex-row gap-6">
      <!-- Event Details -->
      <div class="flex-1">
        <div class="h-[400px]">
          <img class="h-full w-full object-cover rounded-md" :src="getImageUrl(eventDetailsStore.eventDetails.image)" alt="Event Image" />
        </div>
        <h2 class="text-3xl font-bold mt-4">
          {{ eventDetailsStore.eventDetails.title }} 
        </h2>
        <p class="text-gray-600 mt-2">
          {{ eventDetailsStore.eventDetails.description }}
        </p>
        <p class="mt-2 text-gray-800 font-medium">📅 Date: {{ formatDate(eventDetailsStore.eventDetails.event_date) }}</p>
        <p class="mt-2 text-gray-800 font-medium">📍 Location: {{ eventDetailsStore.eventDetails.address }}</p>
      </div>

      <!-- Ticket Reservation -->
      <div class="w-full md:w-1/3 p-6 rounded-lg shadow-lg bg-white">
        <h3 class="text-lg font-bold mb-4 text-primary">Reserve Your Tickets</h3>

        <div class="space-y-4">
          <!-- Regular Ticket -->
          <div class="flex items-center justify-between">
            <p class="text-gray-700">
              Regular Price: 
              <span class="font-semibold text-primary">${{ eventDetailsStore.eventDetails.regular_price }}</span>
            </p>
            <input 
              v-model="regularTickets" 
              type="number" 
              min="0"
              class="border rounded-md p-2 w-20 text-center border-primary focus:ring-2 focus:ring-primary" 
            />
          </div>

          <!-- Discounted Ticket -->
          <div class="flex items-center justify-between">
            <p class="text-gray-700">
              Discount Price: 
              <span class="font-semibold text-primary">${{ eventDetailsStore.eventDetails.discount_price }}</span>
            </p>
            <input 
              v-model="discountTickets" 
              type="number" 
              min="0"
              class="border rounded-md p-2 w-20 text-center border-primary focus:ring-2 focus:ring-primary" 
            />
          </div>
        </div>
        <div>
          <p>  Time left to the event: {{ countdown }}</p>
        </div>

        <!-- Reserve Button -->
        <button 
          @click="reserveTickets" 
          class="w-full bg-primary text-white py-2 rounded-lg shadow-md hover:bg-primary/80 focus:outline-none focus:ring-2 focus:ring-primary mt-4 flex items-center justify-center space-x-2">
          <!-- Ticket Icon -->
          <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 3v18h12V3H6zm3 14h6v-4H9v4z" />
          </svg>
          
          <!-- Total Price Text -->
          <span class="font-semibold">
            Reserve Tickets - ${{ totalPrice }}
          </span>
        </button>
      </div>
    </div>
  </div>

  <!-- ShadCN Dialog for Login Alert -->
  <Dialog v-model:open="showLoginModal">
    <DialogContent class="sm:max-w-[425px] p-6 rounded-lg shadow-lg bg-white transform transition-all duration-300 ease-in-out">
      <DialogTitle class="text-lg font-semibold text-primary">
        Not Logged In
      </DialogTitle>
      <DialogDescription class="mt-2 text-muted-foreground">
        You need to log in to reserve tickets. Please sign in to continue.
      </DialogDescription>
      <DialogFooter class="mt-4">
        <Button @click="$router.push('/login')" class="bg-gradient-to-r from-primary to-primary/90 text-white px-5 py-2 rounded-lg shadow-md hover:scale-105 transition-all hover:shadow-lg">
          🔑 Go to Login
        </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>