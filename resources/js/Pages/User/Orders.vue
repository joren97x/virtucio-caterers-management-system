<script setup>
// Add any logic if necessary.
import { Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import FoodDialog from './Components/FoodDialog.vue';


defineOptions({
    layout: AuthenticatedLayout
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

</script>

<template>
    <div class="p-6 bg-gray-100 min-h-screen">
      <h1 class="text-2xl font-bold mb-4">Orders</h1>
      <div class="space-y-4">
        <div 
          v-for="order in orders" 
          :key="order.id" 
          class="bg-white shadow rounded-lg p-4"
        >
          <div class="flex justify-between items-center border-b pb-2 mb-2">
            <h2 class="text-lg font-semibold">{{ order.name }} (Order #{{ order.id }})</h2>
            <span :class="statusClass(order.status)">
              {{ order.status }}
            </span>
          </div>
  
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <p><strong>Contact:</strong> {{ order.contact_number }}</p>
              <p><strong>Venue:</strong> {{ order.venue }}</p>
              <p><strong>Date:</strong> {{ new Date(order.date).toLocaleDateString() }}</p>
              <p><strong>Event Details:</strong> {{ order.event_details }}</p>
              <p><strong>Message:</strong> {{ order.message || 'N/A' }}</p>
            </div>
            <div>
              <p><strong>Payment Method:</strong> {{ order.payment_method }}</p>
              <p><strong>Contract Payments:</strong> {{ order.contract_payments }}</p>
              <p><strong>Created At:</strong> {{ new Date(order.created_at).toLocaleString() }}</p>
              <p><strong>Updated At:</strong> {{ new Date(order.updated_at).toLocaleString() }}</p>
            </div>
          </div>
          <FoodDialog v-for="product in order.order_items" :product="product.product"/>
          <!-- Add-ons Section -->
          <!-- <div v-if="order.add_ons.length > 0" class="mt-4 grid grid-cols-2">
            <div>
              <h3 class="text-lg font-semibold">Pax</h3>
              {{ order.rate.pax }} Pax <br>
              {{ order.rate.instructions }}  <br>
              {{ order.rate.price }} 
            </div>
            <div>
              <h3 class="text-lg font-semibold">Add-ons</h3>
              <ul class="list-disc list-inside">
                <li 
                  v-for="addOn in order.add_ons" 
                  :key="addOn.id" 
                  class="text-gray-700"
                >
                  {{ addOn.add_on.name }} - ₱{{ addOn.add_on.price }} -
                  {{ addOn.add_on.add_on_category.name }}
                </li>
              </ul>
            </div>
            
          </div> -->
          
          <!-- Products Section -->
          <!-- <div v-if="order.products.length > 0" class="mt-4">
            <h3 class="text-lg font-semibold">Foods</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div 
                v-for="product in order.products" 
                :key="product.id" 
                class="flex items-center bg-gray-50 p-2 rounded"
              >
                <img 
                  :src="`/storage/${product.product.image_path}`" 
                  :alt="product.product.name" 
                  class="w-16 h-16 object-cover rounded mr-4"
                />
                <div>
                  <p><strong>{{ product.product.name }}</strong></p>
                  <p class="text-sm text-gray-500">₱{{ product.product.price }} x {{ product.quantity }}</p>
                  <p v-if="product.special_instructions" class="text-sm text-gray-600">Instructions: {{ product.special_instructions }}</p>
                </div>
              </div>
            </div>
          </div> -->
          <div class="grid grid-cols-2 justify-between">
             <div>
              <!-- Total Amount: {{ order.total_amount }}
              Remaining Balance: {{ order.total_amount }} -->
             </div>
             <div>
              <button class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 mr-2">
                View Recieipt</button>
              <Link v-if="order.contract_payments == 'down_payment'" :href="route('order.pay_balance', order.id)" method="POST">
                  <button class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                  Pay Remaining Balance
                </button>
              </Link>
             </div>
          </div>
        </div>
      </div>
    </div>
  </template>

  
  <style scoped>
  /* Add any custom styling here if needed */
  </style>
  