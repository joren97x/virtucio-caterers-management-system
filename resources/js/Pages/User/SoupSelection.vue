<script setup>
// Add any logic if necessary.
import OrderLayout from '@/Layouts/OrderLayout.vue'
import { useOrderStore } from '@/Stores/OrderStore';
import FoodDialog from './Components/FoodDialog.vue';
import { computed } from 'vue';
// defineOptions({
//     layout: OrderLayout
// })
const orderStore = useOrderStore()

const isSelected = computed(() => {
    return (product) => orderStore.form.soup && orderStore.form.soup.id === product.id;
})
defineProps({
    categories: Object
})
</script>

<template>
    <OrderLayout back="order.add_ons" next="order.main_dishes" loading="40">
        <div>{{ orderStore.form.soup ? '1/1' : '0/1' }}</div>
        <div class="mx-7 overflow-y-auto" style="max-height: 70vh;">
    <div v-for="category in categories" class="relative">
        <div class="flex items-center justify-between mb-4 bg-white">
            <h2 class="text-xl font-bold text-gray-800">{{ category.name }}</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 md:grid-cols-3 gap-6">
            <FoodDialog 
                :product="product" 
                v-for="product in category.products" 
                @clicked="orderStore.form.soup = product" 
                :selected="isSelected(product)"
            />
        </div>
    </div>
</div>
    </OrderLayout>
</template>

  
  <style scoped>
  /* Add any custom styling here if needed */
  </style>
  