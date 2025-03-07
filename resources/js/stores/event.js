import { defineStore } from "pinia";
import { ref } from "vue";
import apiClient from "../../axios";

export const useEventStore = defineStore('event', () => {
    const events = ref([]); 
    const loading = ref(false); 
    const error = ref(null); 

    const fetchEvents = async (searchQuery = '', startDate = '', endDate = '', timeFilter = 'all', categoryFilter = '') => {
        loading.value = true;
        error.value = null;
        try {
            const params = {
                name: searchQuery,
                start_date: startDate,
                end_date: endDate,
                time_filter: timeFilter,
                category_id: categoryFilter,
            };

            const response = await apiClient.get('/events', { params });

            events.value = response.data.map(recurrence => ({
                id: recurrence.id, 
                event_id: recurrence.event.id,
                title: recurrence.event.title, 
                category: recurrence.event.category,
                image: recurrence.event.image,
                address: recurrence.event.address,
                regular_price: recurrence.event.regular_price,
                discount_price: recurrence.event.discount_price,
                event_timestamp: recurrence.event_timestamp, 
            }));

        } catch (err) {
            console.error('Error fetching events:', err);
            error.value = 'Failed to load events';
        } finally {
            loading.value = false;
        }
    };
  
    return { events, loading, error, fetchEvents };
});
