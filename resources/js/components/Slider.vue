<template>
  <div class="swiper-container relative rounded-lg overflow-hidden shadow-lg">
    <div class="swiper-wrapper rounded-lg">
      <div class="swiper-slide" v-for="(image, index) in images" :key="index">
        <img :src="getImageUrl(image)" :alt="`Slide ${index + 1}`" class="w-full h-[300px] object-cover" />
        <div class="absolute inset-0 flex flex-col items-center justify-center bg-gradient-to-b from-black/30 to-black/70 text-white p-6">
          <h2 class="text-4xl font-bold mb-4 text-center drop-shadow-md">Buy Your Ticket Now</h2>
          <p class="text-lg text-center max-w-md">Experience the best events in town!</p>
        </div>
      </div>
    </div>
    <!-- Enhanced pagination -->
    <div class="swiper-pagination bottom-4"></div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import Swiper from 'swiper';
import { Autoplay, Pagination, EffectFade } from 'swiper/modules';
import 'swiper/swiper-bundle.css';

const images = ref(['s1.jpg', 's2.jpg', 's3.jpg']);

const getImageUrl = (image) => {
  return `/assets/imgs/${image}`;
};

onMounted(() => {
  new Swiper('.swiper-container', {
    loop: true,
    effect: 'fade',
    modules: [Autoplay, Pagination, EffectFade],
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
  height: 450px;
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

/* Enhanced pagination bullets */
.swiper-pagination-bullet {
  width: 10px;
  height: 10px;
  background: rgba(255, 255, 255, 0.6);
  opacity: 0.6;
}

.swiper-pagination-bullet-active {
  background: white;
  opacity: 1;
}

/* Animate content */
.swiper-slide-active h2 {
  animation: fadeIn 0.5s ease-out 0.2s both;
}

.swiper-slide-active p {
  animation: fadeIn 0.5s ease-out 0.4s both;
}

.swiper-slide-active button {
  animation: fadeIn 0.5s ease-out 0.6s both;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>