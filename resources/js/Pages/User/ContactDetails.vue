<script setup>
// Add any logic if necessary.
import OrderLayout from '@/Layouts/OrderLayout.vue'
import { useOrderStore } from '@/Stores/OrderStore'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import { router } from '@inertiajs/vue3'

// defineOptions({
//     layout: OrderLayout
// })
const orderStore = useOrderStore()
defineProps({
    rates: Object
})

const onNext = () => {
    // console.log(orderStore.form.main_dishes)
    // orderStore.checkout()
    orderStore.form.post(route('orders.store'))
}

</script>

<template>
    <OrderLayout back="order.add_ons" next="checkout" loading="100">
        <div class="sticky top-0 z-10 bg-white shadow-md py-2 px-4 mb-4 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Contact Details</h1>
                <p class="text-sm text-gray-600">Please fill up the following form.</p>
            </div>

            <!-- Selection Indicator -->
            <!-- <div class="text-sm text-indigo-600 font-semibold">
                0 of 1 selected
            </div> -->
        </div>
        <div class="bg-white shadow-md">
    <form class="max-w-screen-md mx-auto">
        <div class="flex p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert" v-if="orderStore.form.hasErrors">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Danger</span>
            <div>
                <span class="font-medium">Ensure that these requirements are met:</span>
                <ul class="mt-1.5 list-disc list-inside">
                    <li v-for="error in orderStore.form.errors">
                        {{ error }}
                    </li>
                </ul>
            </div>
            </div>
        <div class="">
            <label class="block text-sm font-medium text-gray-700">Full Name</label>
            <input v-model="orderStore.form.name"  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Full Name">
        </div>

        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700">Contact Number</label>
            <input v-model="orderStore.form.contact_number" type="number" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Phone Number">
        </div>

        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700">Type of Event</label>
            <select v-model="orderStore.form.event_type" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Phone Number">
                <option value="party">Party</option>
                <option value="wedding" >Wedding</option>
                <option value="birthday">Birthday</option>
                <!-- <option value="audi">Audi</option> -->
            </select>
        </div>

        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700">Venue</label>
            <input v-model="orderStore.form.venue" type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Venue">
        </div>

        <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700">Date And Time</label>
            <input v-model="orderStore.form.event_date" 
           type="datetime-local" 
           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
           placeholder="Select date and time">
            <!-- <input v-model="orderStore.form.date" type="date" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Email address"> -->
        </div>

        <!-- <div class="mt-6">
            <label class="block text-sm font-medium text-gray-700">Event Details</label>
            <input v-model="orderStore.form.event_details" type="text" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Street address">
        </div> -->

        <div class="mt-6">
            <label for="about" class="block text-sm font-medium text-gray-700">Message</label>
            <textarea
                id="about"
                rows="3"
                v-model="orderStore.form.message"
                placeholder="Write a few sentences about the food."
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
            ></textarea>
        </div>
    </form>
</div>
        <template v-slot:nextButton>
            <PrimaryButton @click="onNext" :class="{ 'opacity-25': orderStore.form.processing }"
            :disabled="orderStore.form.processing"> 
                PROCEED TO CHECKOUT
            </PrimaryButton>
        </template>
    </OrderLayout>
</template>

  
  <style scoped>
  /* Add any custom styling here if needed */
  </style>
  