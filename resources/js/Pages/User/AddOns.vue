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
    <OrderLayout back="order.pax" next="order.soups" loading="50">
        <div class="text-h6 text-center"></div>
        <input type="radio" v-model="orderStore.form.event" value="wedding"> Wedding <br>
                <input type="radio" v-model="orderStore.form.event" value="birthday"> Birthday <br>
                <input type="radio" v-model="orderStore.form.event" value="thanksgiving"> Thanks Giving <br>
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
            </div>
            </div>
            Event Details 
            <br>

        <!-- {{ orderStore.form.event }} -->
        <br>
                <div class="mt-6">
                    <!-- <label class="block text-sm font-medium text-gray-700">Event Details</label> -->
                    <!-- <textarea
                id="about"
                rows="2"
                v-model="orderStore.form.event_details"
                placeholder="Write a few sentences about the food."
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
            ></textarea> -->
                </div>
        </div>
    </div>
    </OrderLayout>
</template>

  
  <style scoped>
  /* Add any custom styling here if needed */
  </style>
  