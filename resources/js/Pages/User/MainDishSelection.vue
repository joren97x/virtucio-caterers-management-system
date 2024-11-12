<script setup>
// Add any logic if necessary.
import OrderLayout from '@/Layouts/OrderLayout.vue'
import { useOrderStore } from '@/Stores/OrderStore';
import FoodDialog from './Components/FoodDialog.vue'
import { computed } from 'vue'
// defineOptions({
//     layout: OrderLayout
// })
defineProps({
    categories: Object
})
const orderStore = useOrderStore()
const isSelected = computed(() => {
    return (product) => orderStore.form.main_dishes.find(
    (dish) => dish.id === product.id
  );
})

function toggleProduct(product) {
  const index = orderStore.form.main_dishes.findIndex(dish => dish.id === product.id);
  
  if (index > -1) {
    // Product exists, so remove it
    orderStore.form.main_dishes.splice(index, 1);
  } else {
    // Product does not exist, so check if the limit is reached
    if (orderStore.form.main_dishes.length < 5) {
      orderStore.form.main_dishes.push(product);
    } else {
      // Optional: show a message or alert if the max limit is reached
      alert("You can select a maximum of 5 products.");
    }
  }
}

</script>

<template>
    <OrderLayout back="order.soups" next="order.desserts" loading="75">
        <div class="mx-7 overflow-y-auto" style="max-height: 70vh;">
    <div v-for="category in categories" class="relative">
        <div class="flex items-center justify-between mb-4 bg-white">
            <h2 class="text-xl font-bold text-gray-800">{{ category.name }}</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 md:grid-cols-3 gap-6">
            <FoodDialog 
                :product="product" 
                v-for="product in category.products" 
                :selected="isSelected(product)" 
                @clicked="toggleProduct(product)" 
            />
        </div>
    </div>
</div>
    </OrderLayout>
</template>

  
  <style scoped>
  /* Add any custom styling here if needed */
  </style>
  