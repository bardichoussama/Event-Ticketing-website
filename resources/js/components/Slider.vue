<template>
    <div class="swiper-container relative rounded-sm">
      <div class="swiper-wrapper rounded-sm">
        <div class="swiper-slide" v-for="(image, index) in images" :key="index">
          <img :src="getImageUrl(image)" :alt="`Slide ${index + 1}`" class="w-full h-[400px] object-cover rounded-md" />
          <div class="absolute inset-0 flex flex-col items-center justify-center bg-black bg-opacity-50 text-white">
            <h2 class="text-4xl font-bold mb-4">Buy Your Ticket Now</h2>
            <p class="text-lg">Experience the best events in town!</p>
          </div>
        </div>
      </div>
      <!-- Add pagination if needed -->
      <div class="swiper-pagination"></div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import Swiper from 'swiper';
  import { Autoplay, Pagination } from 'swiper/modules';
  import 'swiper/swiper-bundle.css';
  
  const images = ref(['s1.jpg', 's2.jpg', 's3.jpg']);
  
  const getImageUrl = (image) => {
    return `/assets/imgs/${image}`;
  };
  
  onMounted(() => {
    new Swiper('.swiper-container', {
      loop: true,
      effect: 'fade',
      modules: [Autoplay, Pagination],
      autoplay: {
        delay: 4000,
        disableOnInteraction: false,
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
    });
  });
  </script>
  
  <style scoped>
  .swiper-container {
    width: 100%;
    height: 600px;
  }
  
  .swiper-slide {
    display: flex;
    justify-content: center;
    align-items: center;
  }
  
  img {
    max-width: 100%;
    height: 100%;
  }
  
  /* Add fade transition for smoother effect */
  .swiper-slide {
    opacity: 0;
    transition: opacity 1s ease-in-out;
  }
  
  .swiper-slide-active {
    opacity: 1;
  }
  </style>