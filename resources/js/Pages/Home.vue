<script setup>
import { Head, Link } from '@inertiajs/vue3';
import CustomerLayout from '@/Layouts/CustomerLayout.vue';
import { ref, onMounted, onUnmounted } from 'vue';

defineOptions({
  layout: CustomerLayout
});

const activeSlide = ref(0);
const slides = [
  'images/banner.png',
  'images/banner2.png',
  'images/banner3.png',
];

// Auto-slide function
onMounted(() => {
  const interval = setInterval(() => {
    activeSlide.value = (activeSlide.value + 1) % slides.length;
  }, 5000); // Change slide every 5 seconds

  // Clear interval when component is unmounted
  onUnmounted(() => {
    clearInterval(interval);
  });
});
</script>

<template>

  <Head title="Home" />
  <div class="relative h-[80vh] flex items-center justify-center bg-gray-900 overflow-hidden isolate">
    <div v-for="(slide, index) in slides" :key="index" v-show="activeSlide === index"
      class="absolute inset-0 w-full h-full transition-opacity duration-500">
      <img :src="slide" alt="Hero Background" class="w-full h-full object-cover opacity-70" />
      <div class="absolute inset-0 bg-black opacity-50"></div>
    </div>

    <div class="relative z-10 text-center text-white">
      <h1 class="text-4xl md:text-6xl font-bold mb-2">Elevate Your Event with Deliciously Crafted Dishes from
        Virtucio Caterers</h1>
      <p class="text-lg md:text-xl mb-4">POBLACION CORDOVA CEBU, 6017 | 0908 8877 992 | 032 496 7740 |0923 0827086
      </p>
      <Link :href="route('order.pax')">
      <button
        class="bg-yellow-500 text-white hover:bg-primary-600  font-bold py-3 px-6 rounded-full shadow-lg focus:outline-none transition">
        START CUSTOMIZING YOUR PACKAGE
      </button>
      </Link>
      <div class="flex justify-center space-x-4 mt-10">
        <a href="#" class="text-white hover:text-gray-400">
          <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <title>Facebook</title>
            <path
              d="M9.101 23.691v-7.98H6.627v-3.667h2.474v-1.58c0-4.085 1.848-5.978 5.858-5.978.401 0 .955.042 1.468.103a8.68 8.68 0 0 1 1.141.195v3.325a8.623 8.623 0 0 0-.653-.036 26.805 26.805 0 0 0-.733-.009c-.707 0-1.259.096-1.675.309a1.686 1.686 0 0 0-.679.622c-.258.42-.374.995-.374 1.752v1.297h3.919l-.386 2.103-.287 1.564h-3.246v8.245C19.396 23.238 24 18.179 24 12.044c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.628 3.874 10.35 9.101 11.647Z" />
          </svg>
        </a>
      </div>
    </div>

    <!-- <div class="absolute bottom-4 flex space-x-2">
      <button v-for="(slide, index) in slides" :key="index" @click="activeSlide = index" :class="{
        'bg-white': activeSlide === index,
        'bg-gray-400': activeSlide !== index,
      }" class="w-3 h-3 rounded-full transition-colors duration-300"></button>
    </div> -->

  </div>
  <!-- <div class="location-section text-center py-10 bg-gray-100">
        <p class="text-xl font-semibold">
            We are located on Poblacion Cordova Cebu<br>
            from 8:00am to 8:00pm.
        </p>
        <p class="text-sm text-gray-500 mt-2">March 13, 2015</p>
        <button class="follow-button mt-4 px-4 py-2 bg-black text-white rounded">
            FOLLOW @LUNCHBOX
        </button>
    </div> -->

  <!-- Catering Description Section -->
  <!-- <div class="catering-section text-center py-12 bg-white">
        <h2 class="text-3xl font-bold">We'll cater any size party</h2>
        <p class="text-gray-600 mt-4 px-6 md:px-32">
            Virtucio Caiterers, where each dish is crafted with love, passion, and attention to detail.
            Book now to bring unforgettable flavors to your gathering!
        </p>
        <button
            class="book-button mt-6 px-6 py-2 border-2 border-green-500 text-green-500 rounded hover:bg-green-500 hover:text-white transition">
            BOOK AND EVENT
        </button>
    </div> -->

  <!-- Menu Preview Section -->
  <!-- <div class="menu-preview-section py-12 bg-gray-100">
        <div class="menu-images grid grid-cols-2 md:grid-cols-4 gap-4 px-4">
            <img :src="slide" alt="Dish 1" class="w-full h-40 object-cover rounded-lg" v-for="slide in slides">
        </div>
        <div class="text-center mt-8">
            <h2 class="text-3xl font-bold">SOMETHING FOR EVERYONE</h2>
            <p class="text-gray-600 mt-2">BURGERS + SANDWICHES + SOUPS + SALADS</p>
            <button class="view-menu-button mt-4 px-6 py-2 bg-black text-white rounded">
                VIEW MENU
            </button>
        </div>
    </div> -->

  <!-- Hero Section -->
  <!-- <section class="bg-cover bg-center h-screen flex items-center justify-center relative" style="background-image: url('images/banner.png');">
      <div class="absolute inset-0 bg-black bg-opacity-50"></div>
      <div class="z-10 text-center text-white">
        <h1 class="text-5xl font-bold mb-6">Welcome to Virtucio Caterers</h1>
        <p class="text-lg mb-6">
          Elevate your events with our deliciously crafted dishes and exceptional service.
        </p>
        <Link :href="route('orders.pax')">
          <button class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded shadow">
          Explore Our Menu
        </button>
      </Link>
      </div>
    </section> -->
  <!-- Features Section -->
  <section class="py-16 max-w-screen-xl mx-auto text-center px-2 xs:px-2 sm:px-2 md:px-6 lg:px-6 xl:px-6">
    <h2 class="text-3xl font-bold text-gray-800 mb-8">Why Choose Us?</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div class="bg-white rounded-lg shadow p-2 md:p-6 lg:p-6 xl:p-6">
        <img src="images/image5.jpg" style="height: 300px; object-fit: cover; width: 100%;" alt="Quality"
          class="mx-auto mb-4">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Unmatched Quality</h3>
        <p class="text-gray-600">
          We source the freshest ingredients to create meals that leave a lasting impression.
        </p>
      </div>
      <div class="bg-white rounded-lg shadow p-2 md:p-6 lg:p-6 xl:p-6">
        <img src="images/image4.jpg" style="height: 300px; object-fit: cover; width: 100%;" alt="Customizable Menus"
          class="mx-auto mb-4">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Customizable Menus</h3>
        <p class="text-gray-600">
          Tailor our offerings to perfectly suit your event's theme and preferences.
        </p>
      </div>
      <div class="bg-white rounded-lg shadow p-2 md:p-6 lg:p-6 xl:p-6">
        <img src="images/image3.jpg" style="height: 300px; object-fit: cover; width: 100%;" alt="Professional Service"
          class="mx-auto mb-4">
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Professional Service</h3>
        <p class="text-gray-600">
          Our dedicated team ensures every detail is taken care of with precision and care.
        </p>
      </div>
    </div>
  </section>

  <!-- Services Section -->
  <section class="bg-gray-100 py-16 px-2 xs:px-2 sm:px-2 md:px-6 lg:px-6 xl:px-6">
    <div class="max-w-screen-xl mx-auto text-center">
      <h2 class="text-3xl font-bold text-gray-800 mb-8">Our Services</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
        <div class="bg-white rounded-lg shadow p-2 md:p-6 lg:p-6 xl:p-6">
          <img src="images/catering.jpg" style="height: 300px; width: 100%; object-fit: cover;" alt="Wedding Catering"
            class="mx-auto mb-4">
          <h3 class="text-xl font-semibold text-gray-800 mb-2">Wedding Catering</h3>
          <p class="text-gray-600">
            Make your special day unforgettable with our premium wedding packages.
          </p>
        </div>
        <div class="bg-white rounded-lg shadow p-2 md:p-6 lg:p-6 xl:p-6">
          <img src="images/corporate.jpg" style="height: 300px; width: 100%; object-fit: cover;" alt="Corporate Events"
            class="mx-auto mb-4">
          <h3 class="text-xl font-semibold text-gray-800 mb-2">Corporate Events</h3>
          <p class="text-gray-600">
            Impress your clients and employees with our professional catering services.
          </p>
        </div>
        <div class="bg-white rounded-lg shadow p-2 md:p-6 lg:p-6 xl:p-6">
          <img src="images/birthday.jpg" style="height: 300px; width: 100%; object-fit: cover;" alt="Private Parties"
            class="mx-auto mb-4">
          <h3 class="text-xl font-semibold text-gray-800 mb-2">Private Parties</h3>
          <p class="text-gray-600">
            Host memorable gatherings with our exquisite culinary offerings.
          </p>
        </div>
        <div class="bg-white rounded-lg shadow p-2 md:p-6 lg:p-6 xl:p-6">
          <img src="images/birthday2.jpg" style="height: 300px; width: 100%; object-fit: cover;" alt="Custom Events"
            class="mx-auto mb-4">
          <h3 class="text-xl font-semibold text-gray-800 mb-2">Custom Events</h3>
          <p class="text-gray-600">
            No matter the occasion, we’ll bring your vision to life with our tailored services.
          </p>
        </div>
      </div>
    </div>
  </section>
  <section class="py-16 max-w-7xl mx-auto px-6">
    <h2 class="text-3xl font-bold text-center mb-8">How It Works</h2>
    <div class="grid md:grid-cols-4 sm:grid-cols-2 grid-cols-1 gap-6">
      <!-- Step 1 -->
      <div class="text-center">
        <div class="bg-indigo-500 text-white w-16 h-16 flex items-center justify-center mx-auto rounded-full mb-4">
          <span class="text-2xl font-bold">1</span>
        </div>
        <h3 class="font-semibold text-lg">Select Pax</h3>
        <p class="text-sm text-gray-600">Choose how many people you're serving.</p>
      </div>
      <!-- Step 2 -->
      <div class="text-center">
        <div class="bg-indigo-500 text-white w-16 h-16 flex items-center justify-center mx-auto rounded-full mb-4">
          <span class="text-2xl font-bold">2</span>
        </div>
        <h3 class="font-semibold text-lg">Customize Your Package</h3>
        <p class="text-sm text-gray-600">Pick your soup, dessert, and main dishes.</p>
      </div>
      <!-- Step 3 -->
      <div class="text-center">
        <div class="bg-indigo-500 text-white w-16 h-16 flex items-center justify-center mx-auto rounded-full mb-4">
          <span class="text-2xl font-bold">3</span>
        </div>
        <h3 class="font-semibold text-lg">Provide Details</h3>
        <p class="text-sm text-gray-600">Tell us when and where you need it.</p>
      </div>
      <!-- Step 4 -->
      <div class="text-center">
        <div class="bg-indigo-500 text-white w-16 h-16 flex items-center justify-center mx-auto rounded-full mb-4">
          <span class="text-2xl font-bold">4</span>
        </div>
        <h3 class="font-semibold text-lg">Confirm & Enjoy!</h3>
        <p class="text-sm text-gray-600">Relax—we'll take care of the rest!</p>
      </div>
    </div>
  </section>
</template>