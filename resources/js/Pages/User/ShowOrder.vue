<script setup>

import CustomerLayout from '@/Layouts/CustomerLayout.vue'
import { formatDate } from 'date-fns';
import { computed, ref } from 'vue';
import { Link, useForm, Head } from '@inertiajs/vue3';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
defineOptions({ layout: CustomerLayout })
const props = defineProps({ order: Object, 
    user_rated: {
        default: false,
        type: Boolean
    }
 })

const formatCurrency = (amount) => {
    return `₱${parseFloat(amount).toLocaleString("en-US", { minimumFractionDigits: 2, })}`;
}

const cancelDialog = ref(false)
const groupItemsByCategory = (items) => {
    const categories = {};
    items.forEach((item) => {
        if (!categories[item.category]) {
            categories[item.category] = [];
        }
        categories[item.category].push(item);
    });
    return Object.keys(categories).map((key) => ({
        name: key,
        items: categories[key],
    }));
}

const statusClass = computed(() => {
    return {
        "text-green-500 font-bold": props.order.status === "fully_paid",
        "text-red-500 font-bold": props.order.status === "pending",
        "text-orange-500 font-bold": props.order.status === "down_payment_paid",
    };
})

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

const getStatusClass = (status) => {
    switch (status) {
        case 'cancelled':
            return 'bg-red-100 text-red-700';
        case 'pending':
        case 'reservation_fee_pending':
        case 'down_payment_pending':
        case 'fully_paid_pending':
            return 'bg-yellow-100 text-yellow-700';
        case 'reservation_fee_paid':
        case 'down_payment_paid':
            return 'bg-blue-100 text-blue-700';
        case 'fully_paid':
            return 'bg-green-100 text-green-700';
        case 'complete':
            return 'bg-gray-100 text-gray-700';
        default:
            return 'bg-gray-100 text-gray-700';
    }
};

const cancelForm = useForm({})
const cancel = () => {
    cancelForm.put(route('orders.update', props.order.id), {
        onSuccess: () => {
            cancelDialog.value = false
        }
    })
}


const rateDialog = ref(false)
const rateForm = useForm({
    message: '',
    rating: 0
})

const submit = () => {
    rateForm.post(route('reviews.store'), {
        onSuccess: () => {
            rateDialog.value = false
        }
    })
}


</script>
<template>

    <Head title="Show Order" />

    <div class="bg-gray-100 min-h-screen p-2 md:p-6 lg:p-6 xl:p-6 max-w-screen-xl mx-auto">
        <!-- Header -->
        <header class="bg-white p-4 rounded shadow-md mb-6 flex flex-col md:flex-row md:justify-between gap-4">
            <!-- Left Section -->
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Catering Order Details</h1>
                <p class="text-gray-600">Order for {{ order.name }}</p>
            </div>

            <!-- Right Section -->
            <div class="md:flex md:items-center">
                <strong>
                    <span
                        :class="`px-3 py-1 text-sm font-semibold rounded-full block md:inline-block ${getStatusClass(order.status)}`">
                        {{ STATUS_LABELS[order.status] || 'Unknown Status' }}
                    </span>
                </strong>
            </div>
        </header>
        <div class="text-sm text-gray-600 mt-4 flex border border-red-500 p-3 bg-white mb-6"
            v-if="order.status == 'cancelled'">
            <svg fill="#ff0000" height="40px" width="40px" class="mr-4" version="1.1" id="Capa_1"
                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                viewBox="0 0 310.806 310.806" xml:space="preserve" stroke="#ff0000">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path
                        d="M305.095,229.104L186.055,42.579c-6.713-10.52-18.172-16.801-30.652-16.801c-12.481,0-23.94,6.281-30.651,16.801 L5.711,229.103c-7.145,11.197-7.619,25.39-1.233,37.042c6.386,11.647,18.604,18.883,31.886,18.883h238.079 c13.282,0,25.5-7.235,31.888-18.886C312.714,254.493,312.24,240.301,305.095,229.104z M155.403,253.631 c-10.947,0-19.82-8.874-19.82-19.82c0-10.947,8.874-19.821,19.82-19.821c10.947,0,19.82,8.874,19.82,19.821 C175.223,244.757,166.349,253.631,155.403,253.631z M182.875,115.9l-9.762,65.727c-1.437,9.675-10.445,16.353-20.119,14.916 c-7.816-1.161-13.676-7.289-14.881-14.692l-10.601-65.597c-2.468-15.273,7.912-29.655,23.185-32.123 c15.273-2.468,29.655,7.912,32.123,23.185C183.284,110.192,183.268,113.161,182.875,115.9z">
                    </path>
                </g>
            </svg>
            We're sorry to hear that you want to cancel your order. Please note that for a refund, you will need to
            visit our office.
        </div>
        <!-- Order Details -->
        <section class="bg-white p-4 md:p-6 lg:p-8 rounded-lg shadow-lg mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Order Information</h2>

            <!-- Order Information Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Column 1 -->
                <div>
                    <ul class="space-y-4">
                        <li>
                            <strong class="text-gray-600">Name:</strong>
                            <span class="text-gray-800">{{ order.name }}</span>
                        </li>
                        <li>
                            <strong class="text-gray-600">Contact Number:</strong>
                            <span class="text-gray-800">{{ order.contact_number }}</span>
                        </li>
                        <li>
                            <strong class="text-gray-600">Venue:</strong>
                            <span class="text-gray-800">{{ order.venue }}</span>
                        </li>
                        <li>
                            <strong class="text-gray-600">Event Date:</strong>
                            <span class="text-gray-800">{{ formatDate(order.event_date, 'PPPP') }}</span>
                        </li>
                        <li>
                            <strong class="text-gray-600">Event Type:</strong>
                            <span class="text-gray-800">{{ order.event_type }}</span>
                        </li>
                    </ul>
                </div>

                <!-- Column 2 -->
                <div>
                    <ul class="space-y-4">
                        <li>
                            <strong class="text-gray-600">Total Amount:</strong>
                            <span class="text-green-600 font-semibold">{{ formatCurrency(order.total_amount) }}</span>
                        </li>
                        <li>
                            <strong class="text-gray-600">Remaining Balance:</strong>
                            <span class="text-red-500 font-semibold">{{ formatCurrency(order.remaining_balance)
                                }}</span>
                        </li>
                        <li>
                            <strong class="text-gray-600">Payment Method:</strong>
                            <span class="text-gray-800">{{ order.payment_method || 'Not Specified' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Action Buttons -->
             <div class="flex justify-end mt-6 space-x-4">
                <button type="button"
                    v-if="order.status == 'fully_paid' && !user_rated"
                    class="bg-yellow-500 text-white px-6 py-2 rounded-lg shadow-md hover:bg-red-600 transition"
                    @click="rateDialog = true">
                    Rate
                </button>
             </div>
            <div class="flex justify-end mt-6 space-x-4"
                v-if="!(order.status == 'fully_paid') && !(order.status == 'cancelled')">
                <!-- Cancel Order -->
                <button type="button"
                    class="bg-red-500 text-white px-6 py-2 rounded-lg shadow-md hover:bg-red-600 transition"
                    @click="cancelDialog = true">
                    Cancel Order
                </button>
                
                
                <!-- Pay Remaining Balance -->
                <Link :href="route('checkout', order.id)">
                <button type="button"
                    class="bg-blue-500 text-white px-6 py-2 rounded-lg shadow-md hover:bg-blue-600 transition"
                    v-if="!order.status != 'fully_paid'">
                    Pay Remaining Balance
                </button>
                </Link>
            </div>
        </section>


        <!-- Menu Details -->
        <section class="bg-white p-2 md:p-6 lg:p-6 xl:p-6 rounded shadow-md">
            <!-- Header -->
            <div class="mb-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Menu Details</h2>
                <p class="font-bold text-lg">{{ order.rate.pax }} Pax</p>
                <p>{{ order.rate.instructions }}</p>
                {{ formatCurrency(order.rate.price) }}
            </div>
            <!-- Add-ons Section -->
            <div class="mb-6">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Add-Ons</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="addon in order.add_ons" :key="addon.id"
                        class="bg-gray-50 p-4 rounded-lg shadow border border-gray-400">
                        <!-- <img 
                            :src="`/images/${addon.image_path}`" 
                            :alt="addon.name" 
                            class="h-32 w-full object-cover rounded mb-4"> -->
                        <h3 class="text-lg font-semibold text-gray-800">{{ addon.add_on.name }}</h3>
                        <p class="text-gray-600">{{ addon.add_on.description }}</p>
                        <p class="text-sm font-semibold text-indigo-600">{{ formatCurrency(addon.add_on.price) }}</p>
                    </div>
                </div>
            </div>

            <!-- Menu Items -->
            <div class="mb-2">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Menu Items</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="item in order.order_items" :key="item.id"
                        class="bg-gray-50 p-4 rounded-lg shadow hover:shadow-md transition">
                        <img :src="`/images/${item.product.image_path}`" :alt="item.product.name"
                            class="h-40 w-full object-cover rounded mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">{{ item.product.name }}</h3>
                        <p class="text-gray-600">{{ item.product.description }}</p>
                    </div>
                </div>
            </div>


        </section>
    </div>
    <TransitionRoot as="template" :show="cancelDialog">
        <Dialog class="relative z-10" @close="cancelDialog = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel
                            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <div class="bg-white sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                        <div>
                                            <h2 class="text-xl font-bold text-gray-800">Cancel Order</h2>
                                            <p class="text-sm text-gray-600 mt-4 flex border border-red-500 p-3">
                                                <svg fill="#ff0000" height="40px" width="40px" class="mr-4"
                                                    version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                    viewBox="0 0 310.806 310.806" xml:space="preserve" stroke="#ff0000">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <path
                                                            d="M305.095,229.104L186.055,42.579c-6.713-10.52-18.172-16.801-30.652-16.801c-12.481,0-23.94,6.281-30.651,16.801 L5.711,229.103c-7.145,11.197-7.619,25.39-1.233,37.042c6.386,11.647,18.604,18.883,31.886,18.883h238.079 c13.282,0,25.5-7.235,31.888-18.886C312.714,254.493,312.24,240.301,305.095,229.104z M155.403,253.631 c-10.947,0-19.82-8.874-19.82-19.82c0-10.947,8.874-19.821,19.82-19.821c10.947,0,19.82,8.874,19.82,19.821 C175.223,244.757,166.349,253.631,155.403,253.631z M182.875,115.9l-9.762,65.727c-1.437,9.675-10.445,16.353-20.119,14.916 c-7.816-1.161-13.676-7.289-14.881-14.692l-10.601-65.597c-2.468-15.273,7.912-29.655,23.185-32.123 c15.273-2.468,29.655,7.912,32.123,23.185C183.284,110.192,183.268,113.161,182.875,115.9z">
                                                        </path>
                                                    </g>
                                                </svg>
                                                We're sorry to hear that you want to cancel your order. Please note that
                                                for a refund, you will need to visit our office.
                                            </p>
                                            <p class="text-sm text-gray-600 mt-2">
                                                If you have any questions, feel free to reach out to our customer
                                                support team.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white shadow-md mx-4"></div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end">
                                <button type="button"
                                    class="mt-3 inline-flex justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                    @click="cancelDialog = false" ref="cancelButtonRef">No</button>
                                <button @click="cancel" type="button"
                                    class="rounded-md bg-red-600 px-3 py-2 text-sm mr-5 font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Cancel</button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>


    <TransitionRoot as="template" :show="rateDialog">
        <Dialog class="relative z-10" @close="rateDialog = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel
                            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <div class="bg-white sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                        <div>
                                            <h2 class="text-xl font-bold text-gray-800">Rate Order</h2>
                                            <!-- Rating -->
                                                    <div class="flex flex-row-reverse justify-end items-center">
                                                    <input id="hs-ratings-readonly-1" @click="rateForm.rating = 5" type="radio" class="peer -ms-5 size-5 bg-transparent border-0 text-transparent cursor-pointer appearance-none checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0" name="hs-ratings-readonly" value="1">
                                                    <label for="hs-ratings-readonly-1" class="peer-checked:text-yellow-400 text-gray-300 pointer-events-none">
                                                        <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                                        </svg>
                                                    </label>
                                                    <input id="hs-ratings-readonly-2" @click="rateForm.rating = 4" type="radio" class="peer -ms-5 size-5 bg-transparent border-0 text-transparent cursor-pointer appearance-none checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0" name="hs-ratings-readonly" value="2">
                                                    <label for="hs-ratings-readonly-2" class="peer-checked:text-yellow-400 text-gray-300 pointer-events-none">
                                                        <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                                        </svg>
                                                    </label>
                                                    <input id="hs-ratings-readonly-3" @click="rateForm.rating = 3" type="radio" class="peer -ms-5 size-5 bg-transparent border-0 text-transparent cursor-pointer appearance-none checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0" name="hs-ratings-readonly" value="3">
                                                    <label for="hs-ratings-readonly-3" class="peer-checked:text-yellow-400 text-gray-300 pointer-events-none">
                                                        <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                                        </svg>
                                                    </label>
                                                    <input id="hs-ratings-readonly-4" @click="rateForm.rating = 2" type="radio" class="peer -ms-5 size-5 bg-transparent border-0 text-transparent cursor-pointer appearance-none checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0" name="hs-ratings-readonly" value="4">
                                                    <label for="hs-ratings-readonly-4" class="peer-checked:text-yellow-400 text-gray-300 pointer-events-none">
                                                        <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                                        </svg>
                                                    </label>
                                                    <input id="hs-ratings-readonly-5" @click="rateForm.rating = 1" type="radio" class="peer -ms-5 size-5 bg-transparent border-0 text-transparent cursor-pointer appearance-none checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0" name="hs-ratings-readonly" value="5">
                                                    <label for="hs-ratings-readonly-5" class="peer-checked:text-yellow-400 text-gray-300 pointer-events-none">
                                                        <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                                                        </svg>
                                                    </label>
                                                    </div>
                                                    <!-- End Rating -->
                                                    <div>
                                                        <label for="message" class="block text-gray-700">Message</label>
                                                        <textarea id="message" v-model="rateForm.message" class="w-full border border-gray-300 rounded p-2" placeholder="Your Message" rows="5" required></textarea>
                                                    </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white shadow-md mx-4"></div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end">
                                <button type="button"
                                    class="mt-3 inline-flex justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                    @click="rateDialog = false" ref="cancelButtonRef">No</button>
                                <button @click="submit" type="button"
                                    class="rounded-md bg-red-600 px-3 py-2 text-sm mr-5 font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Submit</button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>

</template>