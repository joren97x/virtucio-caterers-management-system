<script setup>

import { useOrderStore } from '@/Stores/OrderStore'
import { format } from 'date-fns'
import { ref } from 'vue';
import { Link, useForm, Head } from '@inertiajs/vue3';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'

const props = defineProps({ order: Object, payment_details: Object })
const orderStore = useOrderStore()
const termsDialog = ref(false)
const form = useForm({
    order_id: props.order.id,
    amount: props.payment_details.amount,
    payment_type: props.payment_details.payment_type,
    payment_method: 'online',
    pax: props.order.rate.pax
})

const calculateAmount = () => {
    if (form.payment_type === 'full_payment') {
        form.amount = props.payment_details.total_amount;
    } else if (form.payment_type === 'down_payment') {
        form.amount = props.payment_details.total_amount * 0.50;
    }
    else if(form.payment_type === 'reservation_fee') {
        form.amount = 3000
    }
}

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

const isPaymentTypeVisible = () => {
        // List of statuses where the user can choose payment type
    const visibleStatuses = [
        'pending',
        'reservation_fee_pending',
    ];

    // Return true if the order status is in the visibleStatuses array
    return visibleStatuses.includes(props.order.status);
}

</script>

<template>
    <!-- {{ order }} -->
    <Head title="Home" />

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
                                <p id="pay-on-delivery-text" class="mt-1 text-xs font-normal "> Pay in our office </p>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="font-bold text-lg mb-4">Menu</div>
                    <div class="space-y-4">
                        <!-- Iterate over grouped items by category -->
                        <div 
                        v-for="(order_item, index) in groupItemsByCategory(order.order_items)" 
                        :key="index" 
                        class="bg-white rounded-lg shadow p-2"
                        >
                        <!-- Category Title -->
                        <h2 class="font-semibold text-gray-700 mb-2">{{ order_item.name == 'main_dish' ? 'Main Dishes' : order_item.name }}</h2>
                        
                        <!-- Iterate over items in the category -->
                        <div 
                            v-for="item in order_item.items" 
                            :key="item.id" 
                            class="flex items-center space-x-4 border-b py-4 last:border-none"
                        >
                            <!-- Image on the left -->
                            <img 
                            class="h-16 w-16 rounded-md object-cover"
                            :src="`/storage/${item.product.image_path}`" 
                            alt="Product Image" 
                            />

                            <!-- Name and Description -->
                            <div class="flex-1">
                            <p class="font-semibold text-gray-800">{{ item.product.name }}</p>
                            <p class="text-sm text-gray-600">{{ item.product.description }}</p>
                            </div>

                            <!-- Price -->
                        </div>
                        </div>
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
                        <span class="font-semibold text-gray-600"> {{ order.rate.pax }} Pax</span>
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
                            <!-- {{ payment_details.payment_type }} -->
                        <select v-model="form.payment_type" @change="calculateAmount" v-if="['pending','reservation_fee_pending' ,'down_payment_pending', 'reservation_fee_paid'].includes(order.status)" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="full_payment">Full Payment</option>
                            <option value="down_payment">Down Payment</option>
                            <option value="reservation_fee" v-if="payment_details.payment_type == 'reservation_fee'">Reservation Fee</option>
                        </select>
                        <div v-else>
                            {{ payment_details.payment_type }}
                        </div>
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-semibold text-gray-600">Amount to Pay Now:</span>
                        
                        <span class="text-gray-800 font-bold">{{ formatCurrency(form.amount) }}</span>
                    </div>
                </div>


                <!-- Proceed Button -->
                <div class="mt-8">
                    <div class="inline-flex items-center">
                        <label class="flex items-center cursor-pointer relative" for="check-with-link">
                            <input type="checkbox"
                            checked
                            class="peer h-5 w-5 cursor-pointer transition-all appearance-none rounded shadow hover:shadow-md border border-slate-300 checked:bg-slate-800 checked:border-slate-800"
                            id="check-with-link" />
                            <span class="absolute text-white opacity-0 peer-checked:opacity-100 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"
                                stroke="currentColor" stroke-width="1">
                                <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd"></path>
                            </svg>
                            </span>
                        </label>
                        <label class="cursor-pointer ml-2 text-slate-600 text-sm" for="check-with-link">
                            <div class="flex">
                            I agree with the 
                            <div
                                @click="termsDialog = true"
                                class="font-medium hover:text-slate-800 underline ml-2"
                            >
                                 terms and conditions
                            </div>
                            .
                            </div>
                        </label>
                        </div>
                    <button @click="submit"
                        class="w-full bg-green-500 text-white py-3 rounded-lg font-bold transition hover:bg-green-600">
                        Proceed to Payment
                    </button>
                </div>
            </div>


        </div>
    </div>
    <TransitionRoot as="template" :show="termsDialog">
  <Dialog class="relative z-10" @close="termsDialog = false">
    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
      leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
    </TransitionChild>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
      <div class="flex min-h-screen items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <TransitionChild as="template" enter="ease-out duration-300"
          enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
          leave-from="opacity-100 translate-y-0 sm:scale-100"
          leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
          <DialogPanel
            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 ">
            <div class="bg-white sm:p-6 sm:pb-4">
              <div class="sm:flex sm:items-start">
                <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                  <div>
                    <h2 class="text-xl font-bold text-gray-800">Contract of Agreement</h2>
                    <img src="/images/contract.jpg" style="height: 100%; width: 100%;" alt="">
                  </div>
                </div>
              </div>
            </div>
            <div class="bg-white shadow-md mx-4"></div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end">
              <button type="button"
                class="mt-3 inline-flex justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                @click="termsDialog = false" ref="cancelButtonRef">Close</button>
            </div>
          </DialogPanel>
        </TransitionChild>
      </div>
    </div>
  </Dialog>
</TransitionRoot>
</template>