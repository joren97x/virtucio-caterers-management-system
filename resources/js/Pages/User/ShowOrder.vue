<script setup>

import CustomerLayout from '@/Layouts/CustomerLayout.vue'
import { formatDate } from 'date-fns';
import { computed, ref } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
defineOptions({ layout: CustomerLayout })
const props = defineProps({ order: Object })

const formatCurrency = (amount) => {
    return `${parseFloat(amount).toLocaleString("en-US", { minimumFractionDigits: 2, })}`;
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

const cancelForm = useForm({})
const cancel = () => {
    cancelForm.put(route('orders.update', props.order.id), {
        onSuccess: () => {
            cancelDialog.value = false
        }
    })
}

</script>
<template>
    <div class="bg-gray-100 min-h-screen p-6 max-w-screen-xl mx-auto">
        <!-- Header -->
        <header class="bg-white -4 rounded shadow-md mb-6 justify-between flex">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Catering Reservation Details</h1>
                <p class="text-gray-600">Reservation for {{ order.name }}</p>
            </div>
            <div>
                <strong><span :class="statusClass">{{ order.status }}</span></strong>
            </div>
        </header>
        <div class="text-sm text-gray-600 mt-4 flex border border-red-500 p-3 bg-white mb-6" v-if="order.status == 'cancelled'">
            <svg fill="#ff0000" height="40px" width="40px" class="mr-4" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 310.806 310.806" xml:space="preserve" stroke="#ff0000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M305.095,229.104L186.055,42.579c-6.713-10.52-18.172-16.801-30.652-16.801c-12.481,0-23.94,6.281-30.651,16.801 L5.711,229.103c-7.145,11.197-7.619,25.39-1.233,37.042c6.386,11.647,18.604,18.883,31.886,18.883h238.079 c13.282,0,25.5-7.235,31.888-18.886C312.714,254.493,312.24,240.301,305.095,229.104z M155.403,253.631 c-10.947,0-19.82-8.874-19.82-19.82c0-10.947,8.874-19.821,19.82-19.821c10.947,0,19.82,8.874,19.82,19.821 C175.223,244.757,166.349,253.631,155.403,253.631z M182.875,115.9l-9.762,65.727c-1.437,9.675-10.445,16.353-20.119,14.916 c-7.816-1.161-13.676-7.289-14.881-14.692l-10.601-65.597c-2.468-15.273,7.912-29.655,23.185-32.123 c15.273-2.468,29.655,7.912,32.123,23.185C183.284,110.192,183.268,113.161,182.875,115.9z"></path> </g></svg>
            We're sorry to hear that you want to cancel your order. Please note that for a refund, you will need to visit our office.
        </div>
        <!-- order Details -->
        <section class="bg-white p-6 rounded shadow-md mb-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Order Information</h2>
            <div class="grid grid-cols-2">
                <div>
                    <ul class="space-y-2">
                        <li><strong>Name:</strong> {{ order.name }}</li>
                        <li><strong>Contact Number:</strong> {{ order.contact_number }}</li>
                        <li><strong>Venue:</strong> {{ order.venue }}</li>
                        <li><strong>Event Date:</strong> {{ formatDate(order.event_date, 'PPPP') }}</li>
                        <li><strong>Event Type:</strong> {{ order.event_type }}</li>

                    </ul>
                </div>
                <div>
                    <ul>
                        <li><strong>Total Amount:</strong> {{ formatCurrency(order.total_amount) }}</li>
                        <li><strong>Remaining Balance</strong> {{ formatCurrency(order.remaining_balance) }}</li>
                        <li><strong>Payment Method:</strong> {{ order.payment_method || 'Not Specified' }}</li>
                    </ul>
                </div>
            </div>
            <div class="flex justify-end space-x-2"
                v-if="!(order.status == 'fully_paid') && !(order.status == 'cancelled')">
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
                    @click="cancelDialog = true">
                    Cancel Order
                </button>
                <Link :href="route('checkout', order.id)">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                    v-if="!order.status != 'fully_paid'">
                    Pay Remaining Balance
                </button>
                </Link>
            </div>

        </section>

        <!-- Menu Details -->
        <section class="bg-white p-6 rounded shadow-md">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Menu Details</h2>
            <p class=" text-lg">{{ order.rate.pax }} Pax</p>
            <p class="mb-4 text-gray-600">{{ order.rate.instructions }}</p>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div v-for="item in order.order_items" :key="item.id"
                    class="bg-gray-50 p-4 rounded shadow hover:shadow-md">
                    <img :src="`/images/${item.product.image_path}`" :alt="item.product.name"
                        class="h-40 w-full object-cover rounded mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">{{ item.product.name }}</h3>
                    <p class="text-gray-600">{{ item.product.description }}</p>
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
                        <svg fill="#ff0000" height="40px" width="40px" class="mr-4" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 310.806 310.806" xml:space="preserve" stroke="#ff0000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M305.095,229.104L186.055,42.579c-6.713-10.52-18.172-16.801-30.652-16.801c-12.481,0-23.94,6.281-30.651,16.801 L5.711,229.103c-7.145,11.197-7.619,25.39-1.233,37.042c6.386,11.647,18.604,18.883,31.886,18.883h238.079 c13.282,0,25.5-7.235,31.888-18.886C312.714,254.493,312.24,240.301,305.095,229.104z M155.403,253.631 c-10.947,0-19.82-8.874-19.82-19.82c0-10.947,8.874-19.821,19.82-19.821c10.947,0,19.82,8.874,19.82,19.821 C175.223,244.757,166.349,253.631,155.403,253.631z M182.875,115.9l-9.762,65.727c-1.437,9.675-10.445,16.353-20.119,14.916 c-7.816-1.161-13.676-7.289-14.881-14.692l-10.601-65.597c-2.468-15.273,7.912-29.655,23.185-32.123 c15.273-2.468,29.655,7.912,32.123,23.185C183.284,110.192,183.268,113.161,182.875,115.9z"></path> </g></svg>
                        We're sorry to hear that you want to cancel your order. Please note that for a refund, you will need to visit our office.
                    </p>
                    <p class="text-sm text-gray-600 mt-2">
                      If you have any questions, feel free to reach out to our customer support team.
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
</template>