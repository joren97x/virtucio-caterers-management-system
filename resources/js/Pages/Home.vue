<script setup>
import { Head } from '@inertiajs/vue3';
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
    <Head title="Welcome" />
    <div class="relative h-[80vh] flex items-center justify-center bg-gray-900 overflow-hidden isolate">
        <!-- Carousel Images -->
        <div
            v-for="(slide, index) in slides"
            :key="index"
            v-show="activeSlide === index"
            class="absolute inset-0 w-full h-full transition-opacity duration-500"
        >
            <img :src="slide" alt="Hero Background" class="w-full h-full object-cover opacity-70" />
            <div class="absolute inset-0 bg-black opacity-50"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative z-10 text-center text-white">
            <h1 class="text-4xl md:text-6xl font-bold mb-2">Elevate Your Event with Deliciously Crafted Dishes from Virtucio Caterers</h1>
            <p class="text-lg md:text-xl mb-4">POBLACION CORDOVA CEBU, 6017 | 0908 8877 992 | 032 496 7740 |0923 0827086</p>
            
            <!-- Social Icons -->
            <div class="flex justify-center space-x-4 mt-10">
                <a href="#" class="text-white hover:text-gray-400">
                    <!-- Your SVG icons here -->
                    <svg role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title>Facebook</title><path d="M9.101 23.691v-7.98H6.627v-3.667h2.474v-1.58c0-4.085 1.848-5.978 5.858-5.978.401 0 .955.042 1.468.103a8.68 8.68 0 0 1 1.141.195v3.325a8.623 8.623 0 0 0-.653-.036 26.805 26.805 0 0 0-.733-.009c-.707 0-1.259.096-1.675.309a1.686 1.686 0 0 0-.679.622c-.258.42-.374.995-.374 1.752v1.297h3.919l-.386 2.103-.287 1.564h-3.246v8.245C19.396 23.238 24 18.179 24 12.044c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.628 3.874 10.35 9.101 11.647Z"/></svg>
                </a>
                <!-- Additional icons as needed -->
            </div>
        </div>

        <!-- Navigation Dots -->
        <div class="absolute bottom-4 flex space-x-2">
            <button
                v-for="(slide, index) in slides"
                :key="index"
                @click="activeSlide = index"
                :class="{
                    'bg-white': activeSlide === index,
                    'bg-gray-400': activeSlide !== index,
                }"
                class="w-3 h-3 rounded-full transition-colors duration-300"
            ></button>
        </div>
    </div>
    <div class="location-section text-center py-10 bg-gray-100">
        <p class="text-xl font-semibold">
            We are located on Poblacion Cordova Cebu<br>
            from 8:00am to 8:00pm.
        </p>
        <p class="text-sm text-gray-500 mt-2">March 13, 2015</p>
        <button class="follow-button mt-4 px-4 py-2 bg-black text-white rounded">
            FOLLOW @LUNCHBOX
        </button>
    </div>

    <!-- Catering Description Section -->
    <div class="catering-section text-center py-12 bg-white">
        <h2 class="text-3xl font-bold">We'll cater any size party</h2>
        <p class="text-gray-600 mt-4 px-6 md:px-32">
            Virtucio Caiterers, where each dish is crafted with love, passion, and attention to detail. 
            Book now to bring unforgettable flavors to your gathering!
        </p>
        <button class="book-button mt-6 px-6 py-2 border-2 border-green-500 text-green-500 rounded hover:bg-green-500 hover:text-white transition">
            BOOK AND EVENT
        </button>
    </div>

    <!-- Menu Preview Section -->
    <div class="menu-preview-section py-12 bg-gray-100">
        <div class="menu-images grid grid-cols-2 md:grid-cols-4 gap-4 px-4">
            <img :src="slide" alt="Dish 1" class="w-full h-40 object-cover rounded-lg" v-for="slide in slides">
            <!-- <img src="path-to-image2.jpg" alt="Dish 2" class="w-full h-40 object-cover rounded-lg">
            <img src="path-to-image3.jpg" alt="Dish 3" class="w-full h-40 object-cover rounded-lg">
            <img src="path-to-image4.jpg" alt="Dish 4" class="w-full h-40 object-cover rounded-lg"> -->
        </div>
        <div class="text-center mt-8">
            <h2 class="text-3xl font-bold">SOMETHING FOR EVERYONE</h2>
            <p class="text-gray-600 mt-2">BURGERS + SANDWICHES + SOUPS + SALADS</p>
            <button class="view-menu-button mt-4 px-6 py-2 bg-black text-white rounded">
                VIEW MENU
            </button>
        </div>
    </div>
</template>