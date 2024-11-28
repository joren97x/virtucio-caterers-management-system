<script setup>
import CustomerLayout from '@/Layouts/CustomerLayout.vue';
defineOptions({ layout: CustomerLayout })
const props = defineProps({ soups: Object, desserts: Object, main_dishes: Object })
// Menu data
// const soups = [
//   { image: 'products/soup.jpg', id: 1, name: 'Tomato Soup', description: 'A comforting classic with a rich, tangy flavor.' },
//   { image: 'products/soup.jpg', id: 2, name: 'Chicken Soup', description: 'Hearty and warm, perfect for any occasion.' },
//   { image: 'products/soup.jpg', id: 3, name: 'Vegetable Soup', description: 'Packed with fresh, seasonal vegetables.' }
// ]

// const mainDishes = [
//   { image: 'products/soup.jpg', id: 1, name: 'Grilled Chicken', description: 'Juicy, tender chicken grilled to perfection.' },
//   { image: 'products/soup.jpg', id: 2, name: 'Beef Stir-fry', description: 'Savory and full of flavor with fresh veggies.' },
//   { image: 'products/soup.jpg', id: 3, name: 'Vegetable Curry', description: 'A rich, creamy curry with vibrant spices.' },
//   { image: 'products/soup.jpg', id: 4, name: 'Pasta Primavera', description: 'A colorful medley of pasta and fresh veggies.' },
//   { image: 'products/soup.jpg', id: 5, name: 'Fish Fillet', description: 'Lightly seasoned and pan-fried to perfection.' },
//   { image: 'products/soup.jpg', id: 6, name: 'Lamb Chop', description: 'Succulent and flavorful with a smoky finish.' },
//   { image: 'products/soup.jpg', id: 7, name: 'Shrimp Fried Rice', description: 'A delightful mix of shrimp and fragrant rice.' }
// ]

// const desserts = [
//   { image: 'products/soup.jpg', id: 1, name: 'Chocolate Cake', description: 'Rich and indulgent with a velvety texture.' },
//   { image: 'products/soup.jpg', id: 2, name: 'Fruit Salad', description: 'A refreshing mix of seasonal fruits.' },
//   { image: 'products/soup.jpg', id: 3, name: 'Cheesecake', description: 'Creamy and smooth with a hint of sweetness.' }
// ]

const addOns = [
  { image: 'products/soup.jpg', id: 1, name: 'Basic Theme', description: 'Simple and elegant decorations.' },
  { image: 'products/soup.jpg', id: 2, name: 'Advanced Theme', description: 'Extravagant and stylish setups.' },
  { image: 'products/soup.jpg', id: 3, name: 'Floral Arrangement', description: 'Beautiful and fresh floral designs.' }
]
</script>


<template>
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
        <div>
          <h2 class="text-2xl font-semibold text-gray-800 mb-6">Add-Ons</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="addOn in addOns" :key="addOn.id" class="bg-white rounded-lg shadow-md overflow-hidden">
              <img :src="addOn.image" :alt="addOn.name" class="w-full h-40 object-cover">
              <div class="p-4">
                <h3 class="text-lg font-bold text-gray-800 mb-2">{{ addOn.name }}</h3>
                <p class="text-gray-600 text-sm">{{ addOn.description }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </template>
  