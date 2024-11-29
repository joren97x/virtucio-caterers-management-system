<script setup>

import AdminLayout from '@/Layouts/AdminLayout.vue'
import { ref } from 'vue';
import { router, Head } from '@inertiajs/vue3';
import { formatDate } from 'date-fns';

defineOptions({ layout: AdminLayout })
const props = defineProps({ orders: Object })

const filters = ref({
  start_date: '',
  end_date: '',
  status: '',
});

const applyFilters = () => {
  // Using router.visit to pass the filters as query parameters in the URL
  router.visit(route('admin.sales', {
    start_date: filters.value.start_date,
    end_date: filters.value.end_date,
    status: filters.value.status,
  }));
};

</script>

<template>
    <Head title="Sales" />

  <div class="sales-container">
    <div class="filters flex justify-between mb-6">
      <div class="date-filters">
        <label>Start Date</label>
        <input type="date" v-model="filters.start_date">
        <label>End Date</label>
        <input type="date" v-model="filters.end_date">
        <button @click="fetchSales">Apply Filters</button>
      </div>
      <div class="status-filters">
        <label>Status</label>
        <select v-model="filters.status">
          <option value="">All</option>
          <option value="Completed">Completed</option>
          <option value="Pending">Pending</option>
          <option value="Cancelled">Cancelled</option>
        </select>
      </div>
    </div>

    <!-- Sales Summary -->
    <div class="sales-summary grid grid-cols-3 gap-6 mb-6">
      <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-xl font-semibold">Total Sales</h3>
        <p class="text-2xl font-bold text-indigo-600">₱{{ totalSales }}</p>
      </div>
      <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-xl font-semibold">Average Order Value</h3>
        <p class="text-2xl font-bold text-green-600">₱{{ averageOrderValue }}</p>
      </div>
      <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-xl font-semibold">Number of Orders</h3>
        <p class="text-2xl font-bold text-gray-900">{{ numberOfOrders }}</p>
      </div>
    </div>

    <!-- Sales by Payment Method -->
    <div class="payment-methods mt-6">
      <h3 class="text-xl font-semibold">Sales by Payment Method</h3>
      <div class="grid grid-cols-2 gap-6">
        <div class="bg-white shadow rounded-lg p-6">
          <h4 class="text-lg">Cash</h4>
          <p class="text-xl font-bold text-green-600">₱{{ salesByCash }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
          <h4 class="text-lg">Card</h4>
          <p class="text-xl font-bold text-blue-600">₱{{ salesByCard }}</p>
        </div>
      </div>
    </div>

    <!-- Sales Orders Table -->
    <div class="sales-orders mt-8">
      <h3 class="text-xl font-semibold">Sales Orders</h3>
      <table class="min-w-full bg-white mt-6">
        <thead>
          <tr>
            <th class="px-6 py-3 text-left">Order ID</th>
            <th class="px-6 py-3 text-left">Customer</th>
            <th class="px-6 py-3 text-left">Total Amount</th>
            <th class="px-6 py-3 text-left">Status</th>
            <th class="px-6 py-3 text-left">Payment Status</th>
            <th class="px-6 py-3 text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="order in orders" :key="order.id">
            <td class="py-4 px-6">{{ order.id }}</td>
            <td class="py-4 px-6">{{ order.customer_name }}</td>
            <td class="py-4 px-6">₱{{ order.total_amount }}</td>
            <td class="py-4 px-6">{{ order.status }}</td>
            <td class="py-4 px-6">{{ order.payment_status }}</td>
            <td class="py-4 px-6">
              <button @click="editOrder(order)">Edit</button>
              <button @click="cancelOrder(order)">Cancel</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>