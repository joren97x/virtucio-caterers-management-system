<script setup>

import AdminLayout from '@/Layouts/AdminLayout.vue'
import { useForm, Head } from '@inertiajs/vue3';
import { formatDate } from 'date-fns'
import { ref } from 'vue';

defineOptions({ layout: AdminLayout })
const props = defineProps({ orders: Object })

const markAsPaidForm = useForm({})
const selectedOrder = ref(null)
const formatStatus = (status) => {
      if (status === "pending") return "Pending";
      if (status === "down_payment_pending") return "Down Payment Pending";
      if (status === "fully_paid_pending") return "Fully Paid Pending";
      if (status === "reservation_fee_pending") return "Reservation Fee Pending";
      return status;
}

const viewOrder = (order) => {
    selectedOrder.value = order;
}

const markAsPaid = (order_id) => {
    markAsPaidForm.put(route('admin.orders.update', order_id))
}

</script>
<template>
    <Head title="Cancelled Orders" />

    <div class="p-4 bg-gray-100 min-h-screen">
      <div class="max-w-7xl mx-auto">
        <!-- Page Title -->
        <h1 class="text-2xl font-bold text-gray-700 mb-6">Cancelled Orders</h1>
  
        <!-- Filter Section -->
        <div class="flex items-center mb-4">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search Orders..."
            class="px-4 py-2 border border-gray-300 rounded-lg w-64"
          />
        </div>
  
        <!-- Table for Pending Orders -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
          <table class="min-w-full border-collapse">
            <thead>
              <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">#</th>
                <th class="py-3 px-6 text-left">Customer</th>
                <th class="py-3 px-6 text-left">Event Type</th>
                <th class="py-3 px-6 text-left">Event Date</th>
                <th class="py-3 px-6 text-left">Total Amount</th>
                <th class="py-3 px-6 text-center">Status</th>
                <th class="py-3 px-6 text-center">Actions</th>
              </tr>
            </thead>
          <tbody class="text-gray-600 text-sm font-light">
            <tr
              v-for="(order, index) in orders"
              :key="order.id"
              class="border-b border-gray-200 hover:bg-gray-100"
            >
              <!-- Order Details -->
              <td class="py-3 px-6 text-left whitespace-nowrap">{{ index + 1 }}</td>
              <td class="py-3 px-6 text-left">
                <div>
                  <p class="font-semibold">{{ order.user.name }}</p>
                  <p class="text-xs text-gray-500">{{ order.contact_number }}</p>
                </div>
              </td>
              <td class="py-3 px-6 text-left capitalize">{{ order.event_type }}</td>
              <td class="py-3 px-6 text-left">
                {{ formatDate(order.event_date, 'PPPP') }}
              </td>
              <td class="py-3 px-6 text-left">
                ₱{{ parseFloat(order.total_amount).toLocaleString() }}
              </td>
              <td class="py-3 px-6 text-center">
                <span
                  :class="{
                    'bg-yellow-100 text-yellow-700 px-2 py-1 rounded': order.status === 'pending',
                    'bg-red-100 text-red-700 px-2 py-1 rounded': order.status === 'down_payment_pending',
                  }"
                >
                  {{ formatStatus(order.status) }}
                </span>
              </td>
              <!-- Actions -->
              <td class="py-3 px-6 text-center">
                <button
                  @click="selectedOrder = order"
                  class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-4 py-2 rounded shadow"
                >
                  View
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <!-- Modal for Order Details -->
    <div
  v-if="selectedOrder"
  class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
>
  <div class="bg-white p-6 rounded-lg shadow-xl max-w-lg w-full relative">
    <!-- Close Button -->
    <button
      @click="selectedOrder = null"
      class="absolute top-3 right-3 text-gray-500 hover:text-gray-700"
      aria-label="Close"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor"
        class="w-6 h-6"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M6 18L18 6M6 6l12 12"
        />
      </svg>
    </button>

    <!-- Dialog Header -->
    <h2 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-3">
      Order Details
    </h2>

    <!-- Order Details -->
    <div class="space-y-4">
      <p class="text-sm">
        <strong class="font-medium text-gray-700">Customer:</strong>
        <span class="text-gray-900">{{ selectedOrder.user.name }}</span>
      </p>
      <p class="text-sm">
        <strong class="font-medium text-gray-700">Event Type:</strong>
        <span class="text-gray-900">{{ selectedOrder.event_type }}</span>
      </p>
      <p class="text-sm">
        <strong class="font-medium text-gray-700">Event Date:</strong>
        <span class="text-gray-900">{{ formatDate(selectedOrder.event_date, 'PPPP') }}</span>
      </p>
      <p class="text-sm">
        <strong class="font-medium text-gray-700">Total Amount:</strong>
        <span class="text-green-600 font-medium">₱{{ selectedOrder.total_amount }}</span>
      </p>
      <p class="text-sm">
        <strong class="font-medium text-gray-700">Remaining Balance:</strong>
        <span class="text-green-600 font-medium">₱{{ selectedOrder.remaining_balance }}</span>
      </p>
      <p class="text-sm">
        <strong class="font-medium text-gray-700">Venue:</strong>
        <span class="text-gray-900">{{ selectedOrder.venue }}</span>
      </p>
    </div>

    <!-- Order Items -->
    <div class="mt-6">
      <p class="text-sm font-medium text-gray-700">Order Items:</p>
      <ul class="list-disc ml-6 mt-2 space-y-1 text-gray-900">
        <li
          v-for="item in selectedOrder.order_items"
          :key="item.id"
          class="text-sm"
        >
          {{ item.product.name }} 
        </li>
      </ul>
    </div>

    <!-- Actions -->
    <div class="mt-6 flex justify-end">
      <button
        @click="selectedOrder = null"
        class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow hover:bg-indigo-700 transition"
      >
        Close
      </button>
    </div>
  </div>
</div>

  </div>
</template>