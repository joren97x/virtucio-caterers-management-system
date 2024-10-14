<script setup>
// Add any logic if necessary.
import OrderLayout from '@/Layouts/OrderLayout.vue'
import { useOrderStore } from '@/Stores/OrderStore';
import FoodDialog from './Components/FoodDialog.vue';
// defineOptions({
//     layout: OrderLayout
// })
defineProps({
    categories: Object
})
const orderStore = useOrderStore()
</script>

<template>
    bruh
    <OrderLayout back="order.add_ons" next="order.contact_form" loading="75">
        {{ orderStore.subtotal }}
        <div class="mx-7 overflow-y-auto" style="max-height: 70vh;">
    <div v-for="category in categories" class="relative">
        <div class="flex items-center justify-between mb-4 bg-white">
            <h2 class="text-xl font-bold text-gray-800">{{ category.name }}</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 md:grid-cols-3 gap-6">
            <FoodDialog :product="product" v-for="product in category.products" />
        </div>
    </div>
</div>
    </OrderLayout>
</template>

  
  <style scoped>
  /* Add any custom styling here if needed */
  </style>
  