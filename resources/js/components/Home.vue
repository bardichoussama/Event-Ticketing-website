<!-- resources/js/components/Home.vue -->

<template>
    <div>
      <h1>Event List</h1>
      <ul v-if="events.length">
        <li v-for="event in events" :key="event.id">
          {{ event.name }} - {{ event.date }}
        </li>
      </ul>
      <p v-else>Loading events...</p>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  
  const events = ref([]); // To hold the events data
  
  // Fetch events when the component is mounted
  onMounted(async () => {
    try {
      const response = await axios.get('http://127.0.0.1:8000/api/events');
      events.value = response.data; // Populate the events array with the response data
    } catch (error) {
      console.error('Error fetching events:', error);
    }
  });
  </script>
  
  <style scoped>
  /* Add some styles here if needed */
  </style>
  