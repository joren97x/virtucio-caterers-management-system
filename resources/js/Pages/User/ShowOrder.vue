<script setup>

import CustomerLayout from '@/Layouts/CustomerLayout.vue'
import { formatDate } from 'date-fns';
import { computed } from 'vue';

defineOptions({ layout: CustomerLayout })
const props = defineProps({ order: Object })

const formatCurrency = (amount) => {
    return parseFloat(amount).toLocaleString("en-US", { minimumFractionDigits: 2, });
}

const groupItemsByCategory = (items) => {
      const categories = {};
      items.forEach((item) => {
        if (!categories[item.category]) {
          categories[item.category] = [];
        }
        categories[item.category].push(item);
      });
      return Object.keys(categories).map((key) => ({
        name: key,
        items: categories[key],
      }));
}

const statusClass = computed(() => {
    return {
    "text-green-500 font-bold": props.order.status === "fully_paid",
    "text-red-500 font-bold": props.order.status === "pending",
    "text-orange-500 font-bold": props.order.status === "down_payment_paid",
    };
})

</script>
<template>
     <div class="bg-gray-100 min-h-screen p-6 max-w-screen-xl mx-auto">
    <!-- Header -->
    <header class="bg-white p-4 rounded shadow-md mb-6 justify-between flex">
      <div>
        <h1 class="text-2xl font-bold text-gray-800">Catering Reservation Details</h1>
        <p class="text-gray-600">Reservation for {{ order.name }}</p>
      </div>
      <div>
        <strong><span :class="statusClass">{{ order.status }}</span></strong>
      </div>
    </header>

    <!-- order Details -->
    <section class="bg-white p-6 rounded shadow-md mb-6">
      <h2 class="text-xl font-semibold text-gray-700 mb-4">Order Information</h2>
      <div class="grid grid-cols-2">
        <div>
            <ul class="space-y-2">
                <li><strong>Name:</strong> {{ order.name }}</li>
                <li><strong>Contact Number:</strong> {{ order.contact_number }}</li>
                <li><strong>Venue:</strong> {{ order.venue }}</li>
                <li><strong>Event Date:</strong> {{ formatDate(order.event_date, 'PPPP') }}</li>
                <li><strong>Event Type:</strong> {{ order.event_type }}</li>
               
            </ul>
        </div>
        <div>
            <ul>
                <li><strong>Total Amount:</strong> {{ order.total_amount }}</li>
                <li><strong>Remaining Balance</strong> {{ order.remaining_balance }}</li>
                <li><strong>Payment Method:</strong> {{ order.payment_method || 'Not Specified' }}</li>
            </ul>
        </div>
      </div>
      <div class="flex justify-end space-x-2">
        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
            Cancel Order
        </button>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Pay Remaining Balance
        </button>
      </div>
      
    </section>

    <!-- Menu Details -->
    <section class="bg-white p-6 rounded shadow-md">
      <h2 class="text-xl font-semibold text-gray-700 mb-4">Menu Details</h2>
      <p class=" text-lg">{{ order.rate.pax }} Pax</p>
      <p class="mb-4 text-gray-600">{{ order.rate.instructions }}</p>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="item in order.order_items" :key="item.id" class="bg-gray-50 p-4 rounded shadow hover:shadow-md">
          <img :src="`/images/${item.product.image_path}`" :alt="item.product.name" class="h-40 w-full object-cover rounded mb-4">
          <h3 class="text-lg font-semibold text-gray-800">{{ item.product.name }}</h3>
          <p class="text-gray-600">{{ item.product.description }}</p>
        </div>
      </div>
    </section>
  </div>
  </template>