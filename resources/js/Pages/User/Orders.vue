<script setup>
// Add any logic if necessary.
import { Link } from '@inertiajs/vue3';
import CustomerLayout from '@/Layouts/CustomerLayout.vue';
import FoodDialog from './Components/FoodDialog.vue';
import { format } from 'date-fns';


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

</script>

<template>
    <div class="p-6 min-h-screen max-w-screen-xl mx-auto">
      <h1 class="text-2xl font-bold mb-4">Orders</h1>
      <div class="space-y-4">
        <div v-if="orders.length == 0" class="flex items-center h-96 justify-center">
            <img src="empty_orders.png" class="justify-center" style="height: 120px; width: 120px;" alt="">
            <h1 class="text-lg">Oops no orders yet...</h1>
        </div>
        <div 
          v-for="order in orders" 
          :key="order.id" 
          class="bg-gray-100  shadow rounded-lg p-4"
        >
          <div class="flex justify-between items-center border-b pb-2 mb-2">
            <h2 class="text-lg font-semibold">{{ order.name }} (Order #{{ order.id }})</h2>
            {{ format(new Date(order.event_date), 'PPP') }}

            <span :class="statusClass(order.status)">
              {{ order.status }}
            </span>
          </div>
  
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <p><strong>Contact:</strong> {{ order.contact_number }}</p>
              <p><strong>Venue:</strong> {{ order.venue }}</p>
              <p><strong>Date:</strong> {{ new Date(order.event_date).toLocaleDateString() }}</p>
              <p><strong>Event Typr:</strong> {{ order.event_type }}</p>
              <p><strong>Message:</strong> {{ order.message || 'N/A' }}</p>
            </div>
            <div>
              <p><strong>Payment Method:</strong> {{ order.payment_method }}</p>
              <p><strong>Contract Payments:</strong> {{ order.contract_payments }}</p>
              <p><strong>Total Amount:</strong> {{ order.total_amount }}</p>
              <p><strong>Created At:</strong> {{ new Date(order.created_at).toLocaleString() }}</p>
              <p><strong>Updated At:</strong> {{ new Date(order.updated_at).toLocaleString() }}</p>
              {{ order.remaining_balance  }}
            </div>
          </div>
          <div class="grid grid-cols-2 justify-between">
             <div>
             </div>
             <div>
            <Link :href="route('orders.show', order.id)">
              <button class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 mr-2">
                View Recieipt</button>
              </Link>
               <Link :href="route('checkout', order.id)">
                <button v-if="active_order_status.includes(order.status)" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 mr-2">
                  Checkout</button>
                </Link>
                <!-- // '', -->
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
  