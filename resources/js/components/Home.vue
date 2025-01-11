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
  import apiClient from '../../axios'; 
  
  const events = ref([]); 
  

  const getEvents = async () => {
    try {
      const response = await apiClient.get('/events'); 
      events.value = response.data; 
    } catch (error) {
      console.error('Error fetching events:', error); 
    }
  };
  
  onMounted(() => {
    getEvents(); 
  });
  </script>
  
  
  <style scoped>
  /* Add some styles here if needed */
  </style>
  