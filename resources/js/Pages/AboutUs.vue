<script setup>
import CustomerLayout from '@/Layouts/CustomerLayout.vue'
import { Head } from '@inertiajs/vue3';
defineOptions({ layout: CustomerLayout })
</script>
<template>
    <Head title="About Us" />

    <section class="py-10 px-6 max-w-screen-xl mx-auto  min-h-screen">
      <div class="mx-auto">
        <h1 class="text-4xl font-bold text-gray-800 mb-8 text-center">About Us</h1>
        <p class="text-lg text-gray-600 mb-12 text-center">
            At <strong class="text-gray-900">Virtucio Caterers</strong>, we believe that every event deserves a touch of perfection. 
          Our mission is to transform your celebrations into memorable experiences with meticulously crafted dishes 
          and unparalleled service. Whether it’s an intimate gathering or a grand celebration, we’re here to make it special.
        </p>
        <!-- About Us Header -->
        <!-- <h1 class="text-4xl font-bold text-gray-800 mb-6">About Us</h1>
        <p class="text-gray-700 text-lg leading-relaxed mb-12">
          At <strong class="text-gray-900">Virtucio Caterers</strong>, we believe that every event deserves a touch of perfection. 
          Our mission is to transform your celebrations into memorable experiences with meticulously crafted dishes 
          and unparalleled service. Whether it’s an intimate gathering or a grand celebration, we’re here to make it special.
        </p> -->
  
        <!-- Mission, Core Values, and Our Team -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
  <!-- Mission -->
  <div class="flex flex-col items-center">
    <img src="images/image1.jpg" alt="Mission" class="rounded-lg shadow-md mb-6 w-full md:w-4/5 lg:w-3/5">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4 text-center">Our Mission</h2>
    <p class="text-gray-600 leading-relaxed text-center px-4 sm:px-8 md:px-0">
      To deliver exceptional catering services with a focus on quality, taste, and creativity, ensuring every guest enjoys an unforgettable culinary experience.
    </p>
  </div>

  <!-- Core Values -->
  <div class="flex flex-col items-center">
    <img src="images/image2.jpg" alt="Core Values" class="rounded-lg shadow-md mb-6 w-full md:w-4/5 lg:w-3/5">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4 text-center">Core Values</h2>
    <ul class="list-disc pl-5 text-gray-600 leading-relaxed text-left sm:text-center">
      <li class="mb-2"><strong>Quality First:</strong> We prioritize excellence in every dish we create.</li>
      <li class="mb-2"><strong>Customer Satisfaction:</strong> Your happiness is our ultimate goal.</li>
      <li class="mb-2"><strong>Innovation & Creativity:</strong> Crafting unique menus tailored to your vision.</li>
    </ul>
  </div>

  <!-- Our Team -->
  <div class="flex flex-col col-span-1 md:col-span-2 items-center">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Our Team</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 w-full">
      <!-- Team Member 1 -->
      <div class="flex flex-col items-center">
        <img src="team/mariz.jpg" alt="Mariz Mante" class="shadow-md rounded-full mb-4 w-40 h-40 object-cover">
        <p class="text-gray-800 font-bold">Mariz Mante</p>
        <p class="text-gray-600 text-sm">Head Chef</p>
      </div>
      <!-- Team Member 2 -->
      <div class="flex flex-col items-center">
        <img src="team/gadwin.png" alt="Gadwin Pena" class="shadow-md rounded-full mb-4 w-40 h-40 object-cover">
        <p class="text-gray-800 font-bold">Gadwin Pena</p>
        <p class="text-gray-600 text-sm">Event Manager</p>
      </div>
      <!-- Team Member 3 -->
      <div class="flex flex-col items-center">
        <img src="team/queeni.jpg" alt="Queeni Serdan" class="shadow-md rounded-full mb-4 w-40 h-40 object-cover">
        <p class="text-gray-800 font-bold">Queeni Serdan</p>
        <p class="text-gray-600 text-sm">Sous Chef</p>
      </div>
    </div>
  </div>
</div>

      </div>
    </section>
  </template>