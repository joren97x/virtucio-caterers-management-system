<script setup>

import { useOrderStore } from '@/Stores/OrderStore'
import { format } from 'date-fns'
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({ order: Object, payment_details: Object })
const orderStore = useOrderStore()

const form = useForm({
    order_id: props.order.id,
    amount: props.payment_details.amount,
    payment_type: props.payment_details.payment_type,
    payment_method: 'online',
    pax: props.order.rate.pax
})

const submit = () => {
    form.post(route('checkout.pay'), {

    })
}

const formatCurrency = (amount) => {
    return `₱${parseFloat(amount).toLocaleString("en-US", { minimumFractionDigits: 2, })}`
}

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

</script>

<template>
    <!-- {{ order }} -->

    <div class="flex flex-col items-center border-b bg-white py-4 sm:flex-row sm:px-10 lg:px-20 xl:px-32">
        <div class="flex items-center justify-center h-16 border-b">
            <!-- <img src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=600" alt="Logo" class="h-8 w-auto"> -->
            <Link class="flex" :href="route('home')">
            <img class="h-8 w-auto" src="/logo.png" alt="">
            <img class="h-8 w-auto" src="/logo-name.png" alt="">
            </Link>
        </div>
        <div class="mt-4 py-2 text-xs sm:mt-0 sm:ml-auto sm:text-base">
            <div class="relative">
                <ul class="relative flex w-full items-center justify-between space-x-2 sm:space-x-4">
                    <li class="flex items-center space-x-3 text-left sm:space-x-4">
                        <span class="font-semibold text-gray-900">Shop</span>
                    </li>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                    <li class="flex items-center space-x-3 text-left sm:space-x-4">
                        <a class="flex h-6 w-6 items-center justify-center rounded-full bg-gray-600 text-xs font-semibold text-white ring ring-gray-600 ring-offset-2"
                            href="#">2</a>
                        <span class="font-semibold text-gray-900">Checkout</span>
                    </li>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                    <li class="flex items-center space-x-3 text-left sm:space-x-4">
                        <a class="flex h-6 w-6 items-center justify-center rounded-full bg-gray-400 text-xs font-semibold text-white"
                            href="#">3</a>
                        <span class="font-semibold text-gray-500">Payment</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-5 max-w-screen-xl mx-auto gap-5">
        <div class="pt-8 col-span-3">
            <div class="space-y-3 rounded-lg border bg-white px-2 py-4 sm:px-6">

                <div class="font-bold text-lg">
                    Customer Information
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <div class="text-xs font-normal text-gray-700">Name</div>
                        {{ order.name }}
                    </div>
                    <div>
                        <div class="text-xs font-normal text-gray-700">Contact Number</div>
                        {{ order.contact_number }}
                    </div>
                    <div>
                        <div class="text-xs font-normal text-gray-700">Venue</div>
                        {{ order.venue }}
                    </div>
                    <div>
                        <div class="text-xs font-normal text-gray-700">Event Type</div>
                        {{ order.event_type }}
                    </div>
                    <div>
                        <div class="text-xs font-normal text-gray-700">Event Date</div>
                        {{ format(new Date(order.event_date), 'MMM d, yyyy h:mm') }}
                    </div>
                    <div>
                        <div class="text-xs font-normal text-gray-700">Status</div>
                        {{ order.status }}
                    </div>
                </div>
                <div class="font-bold text-lg">
                    Payment
                </div>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div class="rounded-lg border  p-4 ps-4 border-gray-700 ">
                        <div class="flex items-start">
                            <div class="flex h-5 items-center">
                                <input id="credit-card" v-model="form.payment_method"
                                    aria-describedby="credit-card-text" type="radio" name="payment-method"
                                    value="online"
                                    class="h-4 w-4 border-gray-300 bg-white text-primary-600 focus:ring-2 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600"
                                    checked />
                            </div>

                            <div class="ms-4 text-sm">
                                <label for="credit-card" class="font-medium leading-none text-black"> Online </label>
                                <p id="credit-card-text" class="mt-1 text-xs font-normal ">Pay online trough e-wallet or
                                    card</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg border  p-4 ps-4 border-gray-700 ">
                        <div class="flex items-start">
                            <div class="flex h-5 items-center">
                                <input id="pay-on-delivery" v-model="form.payment_method"
                                    aria-describedby="pay-on-delivery-text" type="radio" name="payment-method"
                                    value="walk_in"
                                    class="h-4 w-4 border-gray-300 bg-white text-primary-600 focus:ring-2 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-primary-600" />
                            </div>

                            <div class="ms-4 text-sm">
                                <label for="pay-on-delivery" class="font-medium leading-none text-black">
                                    Walk-in</label>
                                <p id="pay-on-delivery-text" class="mt-1 text-xs font-normal "> Lorem, ipsum dolor sit
                                    amet consectetur </p>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="font-bold text-lg">
                    Menu
                </div>
                <div class="rounded-lg"
                    v-for="(order_item, index) in groupItemsByCategory(order.order_items)">
                    <div v-for="item in order_item.items">
                        <img class="h-24 w-28 rounded-md border object-cover object-center"
                            :src="`/storage/${item.product.image_path}`" alt="" />
                        <div class="flex w-full flex-col px-4 py-4">
                            <span class="font-semibold">{{ item.product.name }}</span>
                            <span class="">{{ item.product.description }}</span>
                            <p class="text-lg font-bold">{{ item.product.price }}</p>
                        </div>
                        <!-- <div class="absolute right-0 relative flex">
                            {{ category }}
                        </div> -->
                    </div>
                    <!-- {{ order_item }} -->
                </div>

            </div>


        </div>

        <div class="bg-gray-50 pt-8 col-span-2">
            <div class="mx-auto bg-white shadow-md rounded-lg p-6 border">
                <div class="font-bold text-lg mb-4">
                    Payment Details
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="font-semibold text-gray-600">Pax</span>
                        <span class="text-gray-800">{{ formatCurrency(order.rate.price) }}</span>
                    </div>
                    <div class="flex justify-between" v-for="order_item in order.add_ons">
                        <span class="font-semibold text-gray-600">{{ order_item.add_on.name }}</span>
                        <span class="text-gray-800">
                            {{ formatCurrency(order_item.add_on.price) }}
                        </span>
                    </div>
                    <div class="flex justify-between" v-if="order.event_type == 'wedding'">
                        <span class="font-semibold text-gray-600">Service Charge Total</span>
                        <span class="text-gray-800">
                            {{ formatCurrency(payment_details.service_charge) }}
                        </span>
                    </div>
                    <div v-if="order.event === 'wedding'" class="flex justify-between text-red-600">
                        <span class="font-semibold">Service Charge (20%):</span>
                        <span>{{ formatCurrency(payment_details.service_charge) }}</span>
                    </div>
                    <div class="flex justify-between border-t pt-2">
                        <span class="font-semibold text-gray-800">Total Amount:</span>
                        <span class="text-gray-800 font-bold">{{ formatCurrency(payment_details.total_amount) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-semibold text-gray-600">Payment Type:</span>
                        <span class="text-gray-800">
                            {{ payment_details.payment_type }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-semibold text-gray-600">Amount to Pay Now:</span>
                        <span class="text-gray-800 font-bold">{{ formatCurrency(payment_details.amount) }}</span>
                    </div>
                </div>


                <!-- Proceed Button -->
                <div class="mt-8">
                    <button @click="submit"
                        class="w-full bg-green-500 text-white py-3 rounded-lg font-bold transition hover:bg-green-600">
                        Proceed to Payment
                    </button>
                </div>
            </div>


        </div>
    </div>

</template>