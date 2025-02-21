import { defineStore } from "pinia";
import { ref } from "vue";
import apiClient from "../../axios";

export const useReservationStore = defineStore('reservation', () => {
  const loading = ref(false);
  const error = ref(null);

  const createReservation = async (eventId, regularTickets, discountTickets) => {
    loading.value = true;
    error.value = null;

    try {
      const response = await apiClient.post("/reservations", {
        event_id: eventId,
        regular_tickets: regularTickets,
        discount_tickets: discountTickets,
      });

      console.log("Reservation successful:", response.data);
      alert("Reservation successful!");

    } catch (err) {
      console.error("Error making reservation:", err);
      error.value = "Failed to make a reservation.";
    } finally {
      loading.value = false;
    }
  };

  return { createReservation, loading, error };
});
