
<script setup>
import { ref } from "vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { router, Head } from "@inertiajs/vue3";
import { formatDate } from "date-fns";

defineOptions({ layout: AdminLayout })
const props = defineProps({ 
    orders: Object, 
    expenses: Object, 
    total_revenue: Number, 
    total_expenses: Number, 
    profit: Number,
    start_date: String,
    end_date: String,
})
const filterDates = ref({
    start_date: props.start_date,
    end_date: props.end_date
})

const applyFilter = () => {
    router.get(route('admin.sales', filterDates.value))
}
const formatCurrency = (amount) => {
    return `₱${parseFloat(amount).toLocaleString("en-US", { minimumFractionDigits: 2, })}`
}

// Helper Functions
</script>

<template>
    <Head title="Sales" />
     <div class=" p-6 ">
    <!-- Page Header -->
    <header class="bg-white p-4 rounded shadow-md mb-6">
      <h1 class="text-3xl font-bold text-gray-800">Sales Overview</h1>
      <p class="text-gray-600">Filter sales data by date range below:</p>
    </header>
    <!-- Date Filter -->
    <section class="bg-white p-4 rounded shadow-md mb-6 flex flex-col sm:flex-row sm:items-center gap-4">
      <div class="flex flex-col">
        <label for="start_date" class="text-gray-800 font-semibold mb-1">Start Date</label>
        <input
          type="date"
          id="start_date"
          v-model="filterDates.start_date"
          class="border rounded p-2 text-gray-800"
        />
      </div>
      <div class="flex flex-col">
        <label for="end_date" class="text-gray-800 font-semibold mb-1">End Date</label>
        <input
          type="date"
          id="end_date"
          v-model="filterDates.end_date"
          class="border rounded p-2 text-gray-800"
        />
      </div>
      <button
        @click="applyFilter"
        class="bg-blue-500 mt-6 hover:bg-blue-600 text-white px-6 py-2 rounded shadow self-start sm:self-center"
      >
        Apply Filters
      </button>
    </section>

    <!-- Summary Cards -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
      <!-- Total Revenue -->
      <div class="bg-blue-50 p-4 rounded shadow-md">
        <h2 class="text-lg font-bold text-gray-800">Total Revenue</h2>
        <p class="text-xl font-semibold text-blue-600">{{ formatCurrency(total_revenue) }}</p>
      </div>

      <!-- Total Expenses -->
      <div class="bg-red-50 p-4 rounded shadow-md">
        <h2 class="text-lg font-bold text-gray-800">Total Expenses</h2>
        <p class="text-xl font-semibold text-red-600">{{ formatCurrency(total_expenses) }}</p>
      </div>

      <!-- Profit -->
      <div class="bg-green-50 p-4 rounded shadow-md">
        <h2 class="text-lg font-bold text-gray-800">Net Profit</h2>
        <p
          :class="profit >= 0 ? 'text-green-600' : 'text-red-600'"
          class="text-xl font-semibold"
        >
         {{ formatCurrency(profit) }}
        </p>
      </div>
    </section>

    <!-- Orders Table -->
    <section>
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Orders</h2>
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg">
          <thead class="bg-gray-100">
            <tr>
              <th class="text-left px-4 py-2 text-gray-600">Order ID</th>
              <th class="text-left px-4 py-2 text-gray-600">Customer</th>
              <th class="text-right px-4 py-2 text-gray-600">Total Amount</th>
              <th class="text-right px-4 py-2 text-gray-600">Date</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="order in orders"
              :key="order.id"
              class="hover:bg-gray-50"
            >
              <td class="px-4 py-2">{{ order.id }}</td>
              <td class="px-4 py-2">{{ order.name }}</td>
              <td class="px-4 py-2 text-right">{{ formatCurrency(order.total_amount) }}</td>
              <td class="px-4 py-2 text-right">{{ formatDate(order.event_date, 'PP') }}</td>
            </tr>
            <tr v-if="orders.length == 0">
                <td colspan="6" class="text-center">
                    <div class="p-2">
                        <div class="justify-center flex items-center ">
                            <img src="/empty_orders.png" class="mr-6" height="100px" width="100px" alt="">There are no orders
                        </div>
                    </div>
                </td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>

    <!-- Expenses Table -->
    <section class="mt-8">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">Expenses</h2>
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg">
          <thead class="bg-gray-100">
            <tr>
              <th class="text-left px-4 py-2 text-gray-600">Item</th>
              <th class="text-left px-4 py-2 text-gray-600">Quantity</th>
              <th class="text-right px-4 py-2 text-gray-600">Unit Price</th>
              <th class="text-right px-4 py-2 text-gray-600">Total</th>
              <th class="text-right px-4 py-2 text-gray-600">Date</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="expense in expenses"
              :key="expense.id"
              class="hover:bg-gray-50"
            >
              <td class="px-4 py-2">{{ expense.category }}</td>
              <td class="px-4 py-2">{{ expense.quantity }}</td>
              <td class="px-4 py-2 text-right">{{ formatCurrency(expense.amount) }}</td>
              <td class="px-4 py-2 text-right">{{ formatCurrency(expense.amount * expense.quantity) }}</td>
              <td class="px-4 py-2 text-right">{{ formatDate(expense.date, 'PP') }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
  </div>
  </template>
  