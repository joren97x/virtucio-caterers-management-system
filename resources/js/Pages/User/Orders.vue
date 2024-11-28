<script setup>
// Add any logic if necessary.
import { Link } from '@inertiajs/vue3';
import CustomerLayout from '@/Layouts/CustomerLayout.vue';
import FoodDialog from './Components/FoodDialog.vue';
import { formatDate } from 'date-fns';


defineOptions({
    layout: CustomerLayout
})

defineProps({
    orders: Object
})

function statusClass(status) {
  switch (status) {
    case 'pending':
      return 'text-yellow-500 bg-yellow-100 px-2 py-1 rounded';
    case 'approved':
      return 'text-green-500 bg-green-100 px-2 py-1 rounded';
    case 'canceled':
      return 'text-red-500 bg-red-100 px-2 py-1 rounded';
    default:
      return 'text-gray-500 bg-gray-100 px-2 py-1 rounded';
  }
}

const active_order_status = [
    'pending', 
    'reservation_fee_paid',
    'down_payment_paid',
]

const formatCurrency = (amount) => {
    return `₱${parseFloat(amount).toLocaleString("en-US", { minimumFractionDigits: 2, })}`
}

</script>

<template>
  <div class="min-h-screen p-2 md:p-6 lg:p-6 xl:p-6 max-w-screen-xl mx-auto">
    <!-- Header -->
    <header class="bg-white p-4 rounded shadow-md mb-6">
      <h1 class="text-2xl font-bold text-gray-800">All Orders</h1>
      <p class="text-gray-600">Manage all your catering orders in one place.</p>
    </header>

    <!-- Orders Table -->
    <section class="bg-white p-2 md:p-6 lg:p-6 xl:p-6 rounded shadow-md">
      <h2 class="text-xl font-semibold text-gray-700 mb-4">Orders Overview</h2>

      <div class="overflow-x-auto">
  <!-- Table for larger screens -->
  <table class="hidden sm:table w-full border-collapse border border-gray-200">
    <thead>
      <tr class="bg-gray-200">
        <th class="border border-gray-300 p-3 text-left text-gray-600">#</th>
        <th class="border border-gray-300 p-3 text-left text-gray-600">Name</th>
        <th class="border border-gray-300 p-3 text-left text-gray-600">Event Type</th>
        <th class="border border-gray-300 p-3 text-left text-gray-600">Event Date</th>
        <th class="border border-gray-300 p-3 text-left text-gray-600">Status</th>
        <th class="border border-gray-300 p-3 text-center text-gray-600">Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr
        v-for="(order, index) in orders"
        :key="order.id"
        class="hover:bg-gray-100"
      >
        <td class="border border-gray-300 p-3">{{ index + 1 }}</td>
        <td class="border border-gray-300 p-3">{{ order.name }}</td>
        <td class="border border-gray-300 p-3 capitalize">{{ order.event_type }}</td>
        <td class="border border-gray-300 p-3">{{ formatDate(order.event_date, 'PPPP') }}</td>
        <td class="border border-gray-300 p-3">
          <span
            :class="{
              'bg-green-100 text-green-700 px-2 py-1 rounded': order.status === 'fully_paid',
              'bg-yellow-100 text-yellow-700 px-2 py-1 rounded': order.status === 'pending',
              'bg-red-100 text-red-700 px-2 py-1 rounded': order.status === 'cancelled',
              'bg-orange-100 text-orange-700 px-2 py-1 rounded': order.status === 'down_payment_paid',
            }"
          >
            {{ order.status }}
          </span>
        </td>
        <td class="border border-gray-300 p-3 text-center">
          <Link :href="route('orders.show', order.id)"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
          >
            View Details
          </Link>
        </td>
      </tr>
    </tbody>
  </table>

  <!-- Card-based design for mobile screens -->
  <div class="sm:hidden space-y-4">
    <div
      v-for="(order, index) in orders"
      :key="order.id"
      class="border border-gray-200 rounded-lg p-4 shadow-md"
    >
      <div class="flex justify-between mb-2">
        <h3 class="text-lg font-bold text-gray-800">#{{ index + 1 }} {{ order.name }}</h3>
        <span
          :class="{
            'bg-green-100 text-green-700 px-2 py-1 rounded': order.status === 'fully_paid',
            'bg-yellow-100 text-yellow-700 px-2 py-1 rounded': order.status === 'pending',
            'bg-red-100 text-red-700 px-2 py-1 rounded': order.status === 'cancelled',
            'bg-orange-100 text-orange-700 px-2 py-1 rounded': order.status === 'down_payment_paid',
          }"
        >
          {{ order.status }}
        </span>
      </div>
      <div class="text-sm text-gray-600">
        <p><strong>Event Type:</strong> {{ order.event_type }}</p>
        <p><strong>Event Date:</strong> {{ formatDate(order.event_date, 'PPPP') }}</p>
      </div>
      <div class="text-right mt-4">
        <Link :href="route('orders.show', order.id)"
          class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
        >
          View Details
        </Link>
      </div>
    </div>
  </div>
</div>

    </section>
  </div>
  </template>

  
  <style scoped>
  /* Add any custom styling here if needed */
  </style>
  

  <!-- <Link :href="route('orders.show', order.id)">
    <button class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 mr-2">
      View Details</button>
    </Link>
     <Link :href="route('checkout', order.id)">
      <button v-if="active_order_status.includes(order.status)" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 mr-2">
        Pay Remaining Balance</button>
      </Link>
       // '',
    <Link v-if="order.contract_payments == 'down_payment'" :href="route('order.pay_balance', order.id)" method="POST">
        <button class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
        Pay Remaining Balance
      </button>
    </Link> -->