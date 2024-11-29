<script setup>
import CustomerLayout from '@/Layouts/CustomerLayout.vue';
import { Head } from '@inertiajs/vue3';
defineOptions({ layout: CustomerLayout })
const props = defineProps({ soups: Object, desserts: Object, main_dishes: Object })


</script>


<template>
  <Head title="Menu" />

    <section class="py-10 px-6 max-w-screen-xl mx-auto">
      <div class="container mx-auto">
        <h1 class="text-4xl font-bold text-gray-800 mb-8 text-center">Our Menu</h1>
        <!-- Soups Section -->
        <div class="mb-12">
          <h2 class="text-2xl font-semibold text-gray-800 mb-6">Soups</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="soup in soups.products" :key="soup.id" class="bg-white rounded-lg shadow-md overflow-hidden">
              <img :src="`storage/${soup.image_path}`" :alt="soup.name" class="w-full h-40 object-cover">
              <div class="p-4">
                <h3 class="text-lg font-bold text-gray-800 mb-2">{{ soup.name }}</h3>
                <p class="text-gray-600 text-sm">{{ soup.description }}</p>
              </div>
            </div>
          </div>
        </div>
  
        <!-- Main Dishes Section -->
        <div class="mb-12">
          <h2 class="text-2xl font-semibold text-gray-800 mb-6">Main Dishes</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="mainDish in main_dishes.products" :key="mainDish.id" class="bg-white rounded-lg shadow-md overflow-hidden">
              <img :src="`/storage/${mainDish.image_path}`" :alt="mainDish.name" class="w-full h-40 object-cover">
              <div class="p-4">
                <h3 class="text-lg font-bold text-gray-800 mb-2">{{ mainDish.name }}</h3>
                <p class="text-gray-600 text-sm">{{ mainDish.description }}</p>
              </div>
            </div>
          </div>
        </div>
  
        <!-- Desserts Section -->
        <div class="mb-12">
          <h2 class="text-2xl font-semibold text-gray-800 mb-6">Desserts</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="dessert in desserts.products" :key="dessert.id" class="bg-white rounded-lg shadow-md overflow-hidden">
              <img :src="`/storage/${dessert.image_path}`" :alt="dessert.name" class="w-full h-40 object-cover">
              <div class="p-4">
                <h3 class="text-lg font-bold text-gray-800 mb-2">{{ dessert.name }}</h3>
                <p class="text-gray-600 text-sm">{{ dessert.description }}</p>
              </div>
            </div>
          </div>
        </div>
  
        <!-- Add-Ons Section -->
        <!-- <div>
          <h2 class="text-2xl font-semibold text-gray-800 mb-6">Add-Ons</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="addOn in addOns" :key="addOn.id" class="bg-white rounded-lg shadow-md overflow-hidden">
              <div class="p-4">
                <h3 class="text-lg font-bold text-gray-800 mb-2">{{ addOn.name }}</h3>
                <p class="text-gray-600 text-sm">{{ addOn.description }}</p>
              </div>
            </div>
          </div>
        </div> -->
      </div>
    </section>
  </template>
  