<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head } from '@inertiajs/vue3'
import { ref } from 'vue';
import { formatDate } from 'date-fns'

defineOptions({ layout: AdminLayout })
const props = defineProps({
    metrics: Object,
    recent_orders: Object,
    expense_breakdown: Object
})

const expenseCategories = [
    { category: 'Ingredients', total: 7000 },
    { category: 'Staff Salaries', total: 5000 },
    { category: 'Utilities', total: 3000 }
]
const selectedOrder = ref(null)

const formatCurrency = (amount) => {
    return `₱${parseFloat(amount).toLocaleString("en-US", { minimumFractionDigits: 2, })}`
}

const STATUS_LABELS = {
    cancelled: 'Cancelled',
    pending: 'Pending',
    reservation_fee_paid: 'Reservation Fee Paid',
    down_payment_paid: 'Down Payment Paid',
    fully_paid: 'Fully Paid',
    complete: 'Complete',
    reservation_fee_pending: 'Reservation Fee Pending',
    down_payment_pending: 'Down Payment Pending',
    fully_paid_pending: 'Fully Paid Pending',
};
</script>

<template>

    <Head title="Dashboard" />
    <div class="p-6 ">
        <!-- Metrics -->
        <h2 class="text-2xl font-extrabold text-gray-800 mb-6">Dashboard</h2>

<!-- Metrics Overview -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
  <!-- Total Revenue -->
  <div class="bg-gradient-to-r from-green-100 to-green-200 p-6 shadow-lg rounded-xl">
    <h2 class="text-lg font-bold text-gray-800">Total Revenue</h2>
    <p class="text-3xl font-semibold text-green-600 mt-2">
      {{ formatCurrency(metrics.total_revenue) }}
    </p>
  </div>

  <!-- Total Expenses -->
  <div class="bg-gradient-to-r from-red-100 to-red-200 p-6 shadow-lg rounded-xl">
    <h2 class="text-lg font-bold text-gray-800">Total Expenses</h2>
    <p class="text-3xl font-semibold text-red-600 mt-2">
      {{ formatCurrency(metrics.total_expenses) }}
    </p>
  </div>

  <!-- Profit -->
  <div class="bg-gradient-to-r from-blue-100 to-blue-200 p-6 shadow-lg rounded-xl">
    <h2 class="text-lg font-bold text-gray-800">Profit</h2>
    <p class="text-3xl font-semibold text-blue-600 mt-2">
      {{ formatCurrency(metrics.profit) }}
    </p>
  </div>
</div>

<!-- Orders Overview -->
<div class="bg-white mt-8 p-6 rounded-xl">
  <h2 class="text-2xl font-extrabold text-gray-800 mb-6">Orders Overview</h2>

  <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
    <!-- Total Orders -->
    <div class="bg-gray-50 p-4 rounded-lg border border-gray-300 shadow-sm hover:shadow-md transition">
      <h3 class="text-sm font-medium text-gray-500 uppercase">Total Orders</h3>
      <p class="text-3xl font-bold text-gray-900 mt-2">{{ metrics.total_orders }}</p>
    </div>

    <!-- Completed Orders -->
    <div class="bg-gray-50 p-4 rounded-lg border border-gray-300 shadow-sm hover:shadow-md transition">
      <h3 class="text-sm font-medium text-gray-500 uppercase">Completed Orders</h3>
      <p class="text-3xl font-bold text-green-600 mt-2">
        {{ metrics.completed_orders }}
      </p>
    </div>

    <!-- Processing Orders -->
    <div class="bg-gray-50 p-4 rounded-lg border border-gray-300 shadow-sm hover:shadow-md transition">
      <h3 class="text-sm font-medium text-gray-500 uppercase">Processing Orders</h3>
      <p class="text-3xl font-bold text-yellow-600 mt-2">
        {{ metrics.processing_orders }}
      </p>
    </div>

    <!-- Cancelled Orders -->
    <div class="bg-gray-50 p-4 rounded-lg border border-gray-300 shadow-sm hover:shadow-md transition">
      <h3 class="text-sm font-medium text-gray-500 uppercase">Cancelled Orders</h3>
      <p class="text-3xl font-bold text-red-600 mt-2">
        {{ metrics.cancelled_orders }}
      </p>
    </div>
  </div>
</div>


        <!-- Recent Orders -->
        <div class="bg-white mt-4 shadow rounded">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Recent Orders</h2>
            <table class="w-full table-auto border-collapse shadow rounded-lg overflow-hidden">
                <!-- Table Header -->
                <thead class="bg-gray-100 text-gray-700 uppercase text-sm">
                    <tr>
                    <th class="text-left p-4">Customer</th>
                    <th class="text-left p-4">Event Date</th>
                    <th class="text-left p-4">Total</th>
                    <th class="text-left p-4">Status</th>
                    <th class="text-left p-4">Actions</th>
                    </tr>
                </thead>
                
                <!-- Table Body -->
                <tbody>
                    <tr 
                    v-for="order in recent_orders" 
                    :key="order.id" 
                    class="border-b hover:bg-gray-50 transition"
                    >
                    <!-- Customer -->
                    <td class="p-4 text-gray-900 font-medium">{{ order.name }}</td>

                    <!-- Event Date -->
                    <td class="p-4 text-gray-700">{{ formatDate(order.event_date, 'PPPP') }}</td>

                    <!-- Total -->
                    <td class="p-4 text-green-600 font-semibold">{{ formatCurrency(order.total_amount) }}</td>

                    <!-- Status -->
                    <td class="p-4">
                        <span
                        :class="{
                            'bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs': order.status === 'complete',
                            'bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs': order.status === 'pending',
                            'bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs': order.status === 'cancelled',
                            'bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs': order.status === 'fully_paid',
                        }"
                        >
                        {{ STATUS_LABELS[order.status] }}
                        </span>
                    </td>

                    <!-- Actions -->
                    <td class="p-4">
                        <button 
                        @click="selectedOrder = order" 
                        class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-4 py-2 rounded shadow"
                        >
                        View
                        </button>
                    </td>
                    </tr>

                    <!-- Empty State -->
                    <tr v-if="recent_orders.length === 0">
                    <td colspan="5" class="text-center p-6">
                        <div class="flex flex-col items-center">
                        <img 
                            src="/empty_orders.png" 
                            class="mb-4" 
                            alt="No orders" 
                            style="height: 100px; width: 100px;"
                        />
                        <p class="text-gray-500">There are no orders</p>
                        </div>
                    </td>
                    </tr>
                </tbody>
                </table>

        </div>
    </div>
    <div v-if="selectedOrder" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white p-6 md:p-8 rounded-lg shadow-2xl relative max-w-4xl w-full">
                <!-- Close Button -->
                <button @click="selectedOrder = null"
                    class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-full"
                    aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Dialog Header -->
                <header class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Order Details</h2>
                    <p class="text-sm text-gray-500">Review the details of the selected order below.</p>
                </header>

                <!-- Order Details -->
                <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                    <!-- Left Section (Order Info & Items) -->
                    <div class="col-span-3 space-y-6">
                        <section aria-labelledby="order-information" class="space-y-4">
                            <h3 id="order-information" class="text-lg font-semibold text-gray-700">Order Information
                            </h3>
                            <p class="text-sm">
                                <strong class="text-gray-700">Customer:</strong>
                                <span class="text-gray-900">{{ selectedOrder.name }}</span>
                            </p>
                            <p class="text-sm">
                                <strong class="text-gray-700">Event Type:</strong>
                                <span class="text-gray-900">{{ selectedOrder.event_type }}</span>
                            </p>
                            <p class="text-sm">
                                <strong class="text-gray-700">Event Date:</strong>
                                <span class="text-gray-900">{{ formatDate(selectedOrder.event_date, 'PPPP') }}</span>
                            </p>
                            <p class="text-sm">
                                <strong class="text-gray-700">Venue:</strong>
                                <span class="text-gray-900">{{ selectedOrder.venue }}</span>
                            </p>
                        </section>

                        <section aria-labelledby="order-items">
                            <h3 id="order-items" class="text-lg font-semibold text-gray-700">Order Items</h3>
                            <ul class="list-disc pl-6 mt-2 space-y-2 text-gray-900">
                                <li v-for="item in selectedOrder.order_items" :key="item.id" class="text-sm">
                                    {{ item.product.name }}
                                </li>
                            </ul>
                        </section>
                    </div>

                    <!-- Right Section (PAX, Add-Ons, and Summary) -->
                    <div class="col-span-2 space-y-6">
                        <section aria-labelledby="pax-details">
                            <h3 id="pax-details" class="text-lg font-semibold text-gray-700">PAX Details</h3>
                            <ul class="list-none mt-2 space-y-2">
                                <li class="flex justify-between items-center text-sm">
                                    <span>{{ selectedOrder.rate.pax }} PAX</span>
                                    <span class="text-gray-600">₱{{ selectedOrder.rate.price }}</span>
                                </li>
                            </ul>
                        </section>

                        <section aria-labelledby="add-ons">
                            <h3 id="add-ons" class="text-lg font-semibold text-gray-700">Add-Ons</h3>
                            <ul class="list-none mt-2 space-y-2">
                                <li v-for="add_on in selectedOrder.add_ons" :key="add_on.id"
                                    class="flex justify-between items-center text-sm">
                                    <span>{{ add_on.add_on.name }}</span>
                                    <span class="text-gray-600">₱{{ add_on.add_on.price }}</span>
                                </li>
                            </ul>
                        </section>

                        <section aria-labelledby="pax-details" v-if="selectedOrder.event_type == 'wedding'">
                            <h3 id="pax-details" class="text-lg font-semibold text-gray-700">Wedding Service Charge</h3>
                            <ul class="list-none mt-2 space-y-2">
                                <li class="flex justify-between items-center text-sm">
                                    <span>Service Charge (20%)</span>
                                    <span class="text-gray-600">{{ formatCurrency(selectedOrder.service_charge)
                                        }}</span>
                                </li>
                            </ul>
                        </section>

                        <section aria-labelledby="order-summary" class="pt-4 border-t border-gray-200">
                            <h3 id="order-summary" class="text-lg font-semibold text-gray-700">Summary</h3>
                            <p class="text-sm">
                                <li class="flex justify-between items-center text-sm">
                                    <strong class="text-gray-700">Total Amount</strong>
                                    <span class="text-gray-600">{{ formatCurrency(selectedOrder.total_amount) }}</span>
                                </li>
                                <li class="flex justify-between items-center text-sm">
                                    <strong class="text-gray-700">Remaining Balance</strong>
                                    <span class="text-gray-600">{{ formatCurrency(selectedOrder.remaining_balance)
                                        }}</span>
                                </li>
                            </p>

                        </section>
                    </div>
                </div>
                <footer class="mt-8 flex justify-end space-x-4">
                    <button @click="selectedOrder = null"
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-600 transition focus:outline-none focus:ring-2 focus:ring-gray-400">
                        Close
                    </button>
                </footer>
            </div>
        </div>

</template>
