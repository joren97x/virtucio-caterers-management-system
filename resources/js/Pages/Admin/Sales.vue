<script setup>

import AdminLayout from '@/Layouts/AdminLayout.vue'
import { ref } from 'vue';
import { formatDate } from 'date-fns';

defineOptions({ layout: AdminLayout })
const props = defineProps({ orders: Object })

const filters = ref({
  from: '',
  to: '',
});

</script>

<template>
  <div class="p-6 bg-gray-100 min-h-screen">

    <div class="max-w-7xl mx-auto">
      <!-- Page Title -->
      <h1 class="text-2xl font-bold text-gray-700 mb-6">Sales Overview</h1>

      <!-- Filter Section -->
      <div class="bg-white p-4 rounded shadow-md mb-6 flex items-center space-x-4">
        <div class="flex space-x-2">
          <label for="fromDate" class="text-sm font-medium text-gray-700">From:</label>
          <input
            id="fromDate"
            type="date"
            v-model="filters.from"
            class="px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
          />
        </div>

        <div class="flex space-x-2">
          <label for="toDate" class="text-sm font-medium text-gray-700">To:</label>
          <input
            id="toDate"
            type="date"
            v-model="filters.to"
            class="px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
          />
        </div>

        <button
          class="bg-indigo-600 text-white px-4 py-2 rounded-md shadow hover:bg-indigo-500"
        >
          Filter
        </button>
      </div>

      <!-- Sales Table -->
      <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full border-collapse">
          <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
              <th class="py-3 px-6 text-left">Order #</th>
              <th class="py-3 px-6 text-left">Customer</th>
              <th class="py-3 px-6 text-left">Total Amount</th>
              <th class="py-3 px-6 text-left">Date</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <tr v-for="order in orders" :key="order.id">
              <td class="py-4 px-6 text-sm text-gray-900">{{ order.id }}</td>
              <td class="py-4 px-6 text-sm text-gray-900">{{ order.user.name }}</td>
              <td class="py-4 px-6 text-sm text-gray-900">₱{{ order.total_amount }}</td>
              <td class="py-4 px-6 text-sm text-gray-900">{{ formatDate(order.event_date, 'PPPP') }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Total Sales Section -->
      <div class="mt-6 bg-white p-4 rounded shadow-md flex justify-between items-center">
        <div class="text-xl font-semibold text-gray-700">Total Sales</div>
        <div class="text-lg font-bold text-indigo-600">₱2423.00</div>
      </div>
    </div>
  </div>
</template>