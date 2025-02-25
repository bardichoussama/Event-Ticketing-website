import { defineStore } from "pinia";
import { ref } from "vue";
import apiClient from "../../axios";

export const useEventDetailsStore = defineStore('eventDetails', () => {
  const eventDetails = ref(null);
  const loading = ref(false);
  const error = ref(null);

  const fetchEventDetails = async (eventId) => {
    loading.value = true;
    error.value = null;
    try {
      const response = await apiClient.get(`/events/${eventId}`);
      const data = response.data;

      eventDetails.value = {
        title: data.event.title,
        description: data.event.description,
        image: data.event.image,
        address: data.event.address,
        regular_price: data.event.regular_price,
        discount_price: data.event.discount_price,
        event_date: data.event_timestamp,
        room_code: data.room_code,
            
      };

    } catch (err) {
      console.error("Error fetching event details:", err);
      error.value = "Failed to load event details";
    } finally {
      loading.value = false;
    }
  };

  return { eventDetails, loading, error, fetchEventDetails };
});