import { defineStore } from "pinia";
import { ref } from "vue";
import apiClient from "../../axios";

export const useReservationStore = defineStore('reservation', () => {
  const loading = ref(false);
  const error = ref(null);
  const reservation = ref(null); // 

  const createReservation = async (eventId, regularTickets, discountTickets) => {
    loading.value = true;
    error.value = null;
    
    try {
      const response = await apiClient.post("/reservations", {
        event_id: eventId,
        regular_tickets: regularTickets,
        discount_tickets: discountTickets,
      });
      
      reservation.value = response.data; // Store the reservation data
      return response.data;
    } catch (err) {
      console.error("Error making reservation:", err);
      error.value = "Failed to make a reservation.";
      return null;
    } finally {
      loading.value = false;
    }
  };

  const checkAvailability = async (eventId) => {
    loading.value = true;
    error.value = null;
    
    try {
      const response = await apiClient.get(`/events/${eventId}/availability`);
      availability.value = response.data;
      return response.data;
    } catch (err) {
      console.error("Error checking ticket availability:", err);
      error.value = "Failed to check ticket availability.";
      return null;
    } finally {
      loading.value = false;
    }
  };
  
  return { 
    createReservation, 
    reservation, 
    loading, 
    error 
  };
});