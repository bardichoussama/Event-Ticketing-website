<script setup>
import { ref, onMounted, computed } from "vue";
import { useAuthStore } from "../../stores/auth";
import { useReservationStore } from "../../stores/reservation";
import { useRoute } from "vue-router";

const authStore = useAuthStore();
const reservationStore = useReservationStore();
const route = useRoute();

const userId = computed(() => authStore.user?.id); 
const purchases = ref([]);

const fetchReservations = async () => {
  if (!userId.value) return; // Avoid making a request if userId is not available

  try {
    await reservationStore.getUserReservations(userId.value);
    purchases.value = reservationStore.reservation; // Corrected assignment
  } catch (err) {
    console.error("Error getting user reservations:", err);
  }
};

onMounted(fetchReservations);
</script>

<template>
  <div>
    <ul>
      <li v-for="purchase in purchases" :key="purchase.reservation_id">
        <div>
          <p>{{ purchase.event_title }}</p>
      
        </div>
      </li>
    </ul>
  </div>
</template>
