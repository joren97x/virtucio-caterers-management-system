<script setup>

import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head } from '@inertiajs/vue3';
defineOptions({ layout: AdminLayout })
const props = defineProps({ total_sales: Number, total_expenses: Number, profit: Number })

</script>

<template>
    <Head title="Dashboard" />
   <div class="dashboard-container">
    <div class="overview">
      <h2 class="text-2xl font-bold">Dashboard</h2>
      <p class="text-gray-600">Overview of your sales and expenses</p>
    </div>

    <!-- Total Sales, Expenses, Profit -->
    <div class="grid grid-cols-3 gap-6 mt-6">
      <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-xl font-semibold text-gray-800">Total Sales</h3>
        <p class="text-2xl font-bold text-indigo-600">₱{{ total_sales }}</p>
      </div>
      <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-xl font-semibold text-gray-800">Total Expenses</h3>
        <p class="text-2xl font-bold text-red-600">₱{{ total_expenses }}</p>
      </div>
      <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-xl font-semibold text-gray-800">Profit</h3>
        <p class="text-2xl font-bold" :class="profitClass">₱{{ profit }}</p>
      </div>
    </div>

    <!-- Quick View of Latest Orders -->
    <div class="latest-orders mt-8">
      <h3 class="text-xl font-semibold text-gray-800">Latest Orders</h3>
      <table class="min-w-full mt-4 bg-white rounded-lg">
        <thead>
          <tr>
            <th class="py-2 px-4 text-left">Order ID</th>
            <th class="py-2 px-4 text-left">Customer</th>
            <th class="py-2 px-4 text-left">Total Amount</th>
            <th class="py-2 px-4 text-left">Date</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="order in latestOrders" :key="order.id">
            <td class="py-2 px-4">{{ order.id }}</td>
            <td class="py-2 px-4">{{ order.customer_name }}</td>
            <td class="py-2 px-4">₱{{ order.total_amount }}</td>
            <td class="py-2 px-4">{{ order.created_at }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>