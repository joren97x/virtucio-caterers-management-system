<script setup>
// Add any logic if necessary.
import OrderLayout from '@/Layouts/OrderLayout.vue'
import { useOrderStore } from '@/Stores/OrderStore';

// defineOptions({
//     layout: OrderLayout
// })
const orderStore = useOrderStore()
defineProps({
    rates: Object
})
</script>

<template>
    <OrderLayout back="order.foods" next="checkout" loading="100">
        {{ orderStore.form }}
        <div class="max-w-2xl mx-auto p-6 bg-white shadow-md">
    <form>
        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700">Full Name</label>
            <input v-model="orderStore.form.name"  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Full Name">
        </div>

        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700">Contact Number</label>
            <input v-model="orderStore.form.contact_number" type="number" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Email address">
        </div>

        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700">Venue</label>
            <input v-model="orderStore.form.venue" type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Venue">
        </div>

        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700">Date And Time</label>
            <input v-model="orderStore.form.date" type="date" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Email address">
        </div>

        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700">Event Details</label>
            <input v-model="orderStore.form.event_details" type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Street address">
        </div>

        <div class="mt-6">
            <label for="about" class="block text-sm font-medium text-gray-700">Message</label>
            <textarea
                id="about"
                rows="2"
                v-model="orderStore.form.message"
                placeholder="Write a few sentences about the food."
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
            ></textarea>
        </div>
    </form>
</div>
    </OrderLayout>
</template>

  
  <style scoped>
  /* Add any custom styling here if needed */
  </style>
  