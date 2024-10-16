<script setup>

import AdminLayout from '@/Layouts/AdminLayout.vue'

defineOptions({
    layout: AdminLayout
})

defineProps({
    orders: Object
})

</script>

<template>
     <div class="p-8 bg-white shadow rounded-lg">
      <div class="flex items-center justify-between mb-4">
        <div>
          <h2 class="text-xl font-bold text-gray-800">Order Management</h2>
          <p class="text-sm text-gray-600">
            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Autem, perferendis forda ferson
          </p>
        </div>
        <!-- <button
          class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-500"
        >
          Add user
        </button> -->
      </div>
  
      <table class="min-w-full bg-white">
        <thead>
          <tr>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Name</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Contact</th>
            <!-- <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Quantity</th> -->
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Venue</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Date</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Payment Method</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Status</th>
            <th class="px-6 py-3 text-right text-sm font-medium text-gray-500"></th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <tr v-for="order in orders" :key="order.id">
            <td class="px-6 py-4">
              <!-- <img :src="order.avatar" alt="Avatar" class="h-10 w-10 rounded-full mr-4" /> -->
                <p class="text-sm font-medium text-gray-900">{{ order.user.name }}</p>
            </td>
            <td class="px-6 py-4">
              <p class="text-sm text-gray-900">{{ order.contact_number }}</p>
            </td>
            <!-- <td class="px-6 py-4">
              <p class="text-sm text-gray-900">{{ order.rate.pax }} Pax</p>
            </td> -->
            <td class="px-6 py-4">
              <p class="text-sm text-gray-900">{{ order.venue }}</p>
            </td>
            <td class="px-6 py-4">
              <p class="text-sm text-gray-900">{{ order.created_at }} Pax</p>
            </td>
            <td class="px-6 py-4">
              <p class="text-sm text-gray-900">{{ order.payment_method }}</p>
            </td>
            <td class="px-6 py-4">
              <p class="text-sm text-gray-900">{{ order.status }} Pax</p>
            </td>
            <!-- <td class="px-6 py-4">
              <span class="inline-flex items-center px-2 py-0.5 rounded text-sm font-medium"
                :class="order.status === 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
                {{ order.status }}
              </span>
            </td>
            <td class="px-6 py-4 text-sm text-gray-900">{{ order.role }}</td> -->
            <td class="px-6 py-4 text-right">
              <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
</template>