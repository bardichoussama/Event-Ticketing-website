import { defineStore } from 'pinia';
import { ref } from 'vue';
import apiClient from '../../axios';

export const useTicketAvailabilityStore = defineStore('ticketAvailability', () => {
    const loading = ref(false);
    const error = ref(null);
    const ticketAvailability = ref({ availableSeats: 0 }); 
    
    const checkAvailability = async (eventId) => {
        loading.value = true;
        error.value = null;
        try {
            const response = await apiClient.get(`/tickets/availability/${eventId}`);
            ticketAvailability.value = response.data;
        } catch (err) {
            console.error('Error checking ticket availability:', err);
            error.value = err.response?.data?.message || 'Failed to check ticket availability.';
        } finally {
            loading.value = false;
        }
    };

    return {
        checkAvailability,
        ticketAvailability,
        loading,
        error
    };
});
