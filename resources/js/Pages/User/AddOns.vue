<script setup>
// Add any logic if necessary.
import OrderLayout from '@/Layouts/OrderLayout.vue'
import { useOrderStore } from '@/Stores/OrderStore';
// defineOptions({
//     layout: OrderLayout
// })
defineProps({
    add_on_categories: Object
})
const orderStore = useOrderStore()
</script>

<template>
    bruh
    <OrderLayout back="order.pax" next="order.foods" loading="50">
        {{ orderStore.form }}
        {{ add_on_categories }}
        <div class="text-h6 text-center">Optional Add Ons</div>
        <div class="p-4 space-y-4 border-solid border-2">
            <div  v-for="(add_on_category, index) in add_on_categories" :key="index">
                {{ add_on_category.name }}
            <div v-for="add_on in add_on_category.add_ons" class="relative flex items-start space-x-3">
                <input
                    type="checkbox"
                    :id="add_on.index"
                    v-model="orderStore.form.add_ons"
                    :value="add_on"
                    class="mt-1 h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                />
            <div>
                <label  class="font-medium text-gray-700">{{ add_on.name }}</label>
                <!-- <p class="text-sm text-gray-500">{{ add_on.instructions }}</p> -->
                <div class="absolute top-0 right-0 h-16 ">{{ add_on.price }}</div>
            </div>
            <div class="absolute top-0 right-0 h-16 ">{{ add_on.price }} bruh</div>
            </div>
        </div>

    </div>
    </OrderLayout>
</template>

  
  <style scoped>
  /* Add any custom styling here if needed */
  </style>
  