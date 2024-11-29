<script setup>

import AdminLayout from '@/Layouts/AdminLayout.vue'
import { useForm, Head } from '@inertiajs/vue3';
import { formatDate } from 'date-fns'
import { ref } from 'vue';

defineOptions({ layout: AdminLayout })
const props = defineProps({ orders: Object })

const markAsPaidForm = useForm({})
const selectedOrder = ref(null)
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

const viewOrder = (order) => {
    selectedOrder.value = order;
}

const markAsPaid = (order_id) => {
    markAsPaidForm.put(route('admin.orders.update', order_id))
}

const formatCurrency = (amount) => {
    return `₱${parseFloat(amount).toLocaleString("en-US", { minimumFractionDigits: 2, })}`
}

</script>
<template>

    <Head title="Confirmed Orders" />

    <div class="p-4 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto">
            <!-- Page Title -->
            <h1 class="text-2xl font-bold text-gray-700 mb-6">Confirmed Orders</h1>

            <!-- Filter Section -->
            <div class="flex items-center mb-4">
                <input v-model="searchQuery" type="text" placeholder="Search Orders..."
                    class="px-4 py-2 border border-gray-300 rounded-lg w-64" />
            </div>

            <!-- Table for Pending Orders -->
            <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                <table class="min-w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Customer</th>
                            <th class="py-3 px-6 text-left">Event Type</th>
                            <th class="py-3 px-6 text-left">Event Date</th>
                            <th class="py-3 px-6 text-left">Total Amount</th>
                            <th class="py-3 px-6 text-center">Status</th>
                            <th class="py-3 px-6 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        <tr v-for="(order, index) in orders" :key="order.id"
                            class="border-b border-gray-200 hover:bg-gray-100">
                            <!-- Order Details -->
                            <td class="py-3 px-6 text-left">
                                <div>
                                    <p class="font-semibold">{{ order.name }}</p>
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
                                <span :class="{
                                    'bg-yellow-100 text-yellow-700 px-2 py-1 rounded': order.status === 'pending',
                                    'bg-red-100 text-red-700 px-2 py-1 rounded': order.status === 'down_payment_pending',
                                }">
                                    {{ STATUS_LABELS[order.status] }}
                                </span>
                            </td>
                            <!-- Actions -->
                            <td class="py-3 px-6 text-center">
                                <button @click="selectedOrder = order"
                                    class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-4 py-2 rounded shadow">
                                    View
                                </button>
                                <!-- <button
                                    @click="markAsPaid(order.id)"
                                    v-if="order.status != 'pending' && order.status != 'fully_paid' && order.status != 'completed' "
                                    class="bg-green-500 hover:bg-green-600 text-white text-sm px-4 py-2 rounded shadow ml-2"
                                    >
                                    Mark as Paid
                                    </button> -->
                            </td>
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
        </div>
        <!-- Modal for Order Details -->
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

    </div>
</template>