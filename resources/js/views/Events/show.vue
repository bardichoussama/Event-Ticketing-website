<template>
    <div>
    <h1>Event Details</h1>
    <p>Event ID: yy</p>
    <!-- Fetch event details based on the ID -->
  </div>

</template>
<script setup>
const props = defineProps({
  id: {
    type: String,
    required: true,
  },
});

</script>