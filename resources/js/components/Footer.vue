<template>
    <footer class="w-full bg-background border-t mt-12">
      <div class="w-full max-w-screen-2xl mx-auto px-4 md:px-6 py-8">
        <!-- Footer Content Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
          <!-- Company Info -->
          <div class="col-span-1 md:col-span-1">
            <h3 class="font-semibold text-base mb-4">Eventive</h3>
            <p class="text-xs text-gray-600 mb-4">
              Your premier destination for discovering and booking the best events in town.
            </p>
            <div class="flex space-x-4">
              <a href="#" class="text-gray-600 hover:text-primary">
                <!-- Facebook icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                </svg>
              </a>
              <a href="#" class="text-gray-600 hover:text-primary">
                <!-- Twitter/X icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path>
                </svg>
              </a>
              <a href="#" class="text-gray-600 hover:text-primary">
                <!-- Instagram icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                  <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                  <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                </svg>
              </a>
            </div>
          </div>
  
          <!-- Quick Links -->
          <div class="col-span-1">
            <h3 class="font-semibold text-base mb-4">Quick Links</h3>
            
            <ul class="space-y-2 text-xs">
              <li><router-link to="/" class="text-gray-600 hover:text-primary">Home</router-link></li>
              <li><router-link to="/" class="text-gray-600 hover:text-primary">Events</router-link></li>
              <li><router-link to="/" class="text-gray-600 hover:text-primary">About Us</router-link></li>
              <li><router-link to="/" class="text-gray-600 hover:text-primary">Contact</router-link></li>
            </ul>
          </div>
  
          <!-- Support -->
          <div class="col-span-1">
            <h3 class="font-semibold text-base mb-4">Support</h3>
            <ul class="space-y-2 text-xs">
              <li><router-link to="/" class="text-gray-600 hover:text-primary">Help Center</router-link></li>
              <li><router-link to="/" class="text-gray-600 hover:text-primary">FAQ</router-link></li>
              <li><router-link to="/" class="text-gray-600 hover:text-primary">Refund Policy</router-link></li>
              <li><router-link to="/" class="text-gray-600 hover:text-primary">Terms of Service</router-link></li>
            </ul>
          </div>
  
          <!-- Newsletter -->
          <div class="col-span-1">
            <h3 class="font-semibold text-base mb-4">Stay Updated</h3>
            <p class="text-xs text-gray-600 mb-3">Subscribe to our newsletter for the latest events.</p>
            <div class="flex">
              <input
                type="email"
                placeholder="Your email"
                class="text-xs px-3 py-2 rounded-l-md border border-r-0 border-gray-300 focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary"
              />
              <button class="bg-primary text-white text-xs px-3 py-2 rounded-r-md hover:bg-primary/90 transition-colors">
                Subscribe
              </button>
            </div>
          </div>
        </div>
  
        <!-- Copyright & Bottom Links -->
        <div class="w-full border-t mt-8 pt-6  flex flex-col md:flex-row justify-between items-center text-xs text-gray-600">
          <p>© 2025 Eventive. All rights reserved.</p>
          <div class="flex space-x-4 mt-4 md:mt-0">
            <router-link to="/" class="hover:text-primary">Privacy Policy</router-link>
            <router-link to="/" class="hover:text-primary">Terms</router-link>
            <router-link to="/" class="hover:text-primary">Sitemap</router-link>
          </div>
        </div>
      </div>
    </footer>
  </template>