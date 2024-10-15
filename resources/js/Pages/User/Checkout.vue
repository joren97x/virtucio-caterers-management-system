<script setup>

import { useOrderStore } from '@/Stores/OrderStore'
defineProps({
    order: Object
})
const orderStore = useOrderStore()

const submit = () => {
    orderStore.form.post(route('order.pay'), {
        
    })
}

</script>

<template>
    <!-- {{ order }} -->
    <div class="flex flex-col items-center border-b bg-white py-4 sm:flex-row sm:px-10 lg:px-20 xl:px-32">
        <div class="flex items-center justify-center h-16 border-b">
        <img src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=600" alt="Logo" class="h-8 w-auto">
    </div>
    <div class="mt-4 py-2 text-xs sm:mt-0 sm:ml-auto sm:text-base">
        <div class="relative">
        <ul class="relative flex w-full items-center justify-between space-x-2 sm:space-x-4">
            <li class="flex items-center space-x-3 text-left sm:space-x-4">
            <a class="flex h-6 w-6 items-center justify-center rounded-full bg-emerald-200 text-xs font-semibold text-emerald-700" href="#"
                ><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg
            ></a>
            <span class="font-semibold text-gray-900">Shop</span>
            </li>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
            <li class="flex items-center space-x-3 text-left sm:space-x-4">
            <a class="flex h-6 w-6 items-center justify-center rounded-full bg-gray-600 text-xs font-semibold text-white ring ring-gray-600 ring-offset-2" href="#">2</a>
            <span class="font-semibold text-gray-900">Checkout</span>
            </li>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
            <li class="flex items-center space-x-3 text-left sm:space-x-4">
            <a class="flex h-6 w-6 items-center justify-center rounded-full bg-gray-400 text-xs font-semibold text-white" href="#">3</a>
            <span class="font-semibold text-gray-500">Payment</span>
            </li>
        </ul>
        </div>
    </div>
    </div>
    <div class="grid sm:px-10 lg:grid-cols-2 lg:px-20 xl:px-32">
    <div class="px-4 pt-8">
        <p class="text-xl font-medium">Order Summary</p>
        <p class="text-gray-400">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dolores, animi?</p>
        <div class="mt-8 space-y-3 rounded-lg border bg-white px-2 py-4 sm:px-6">
        <div class="mt-4 mb-2 block text-sm font-medium">Foods</div>
        <div class="flex flex-col rounded-lg bg-white sm:flex-row" v-for="(food, index) in orderStore.form.foods">
            <img class="m-2 h-24 w-28 rounded-md border object-cover object-center" :src="`/storage/${food.product.image_path}`" alt="" />
            <div class="flex w-full flex-col px-4 py-4">
            <span class="font-semibold">{{ food.product.name }}</span>
            <span class="font-semibold">{{ food.product.price }}</span>
            <span class="float-right text-gray-400">{{ food.special_instructions }}</span>
            <p class="text-lg font-bold">{{ food.price }}</p>
            </div>
            <div class="absolute right-0 relative">
                {{ index }}
                <button @click="orderStore.form.foods[index].quantity--">-</button>
                {{ food.quantity }}
                <button @click="orderStore.form.foods[index].quantity++">+</button>
            </div>
        </div>
        what
        <!-- <div class="flex flex-col rounded-lg bg-white sm:flex-row">
            <img class="m-2 h-24 w-28 rounded-md border object-cover object-center" src="https://images.unsplash.com/photo-1600185365483-26d7a4cc7519?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8OHx8c25lYWtlcnxlbnwwfHwwfHw%3D&auto=format&fit=crop&w=500&q=60" alt="" />
            <div class="flex w-full flex-col px-4 py-4">
                <span class="font-semibold">Nike Air Max Pro 8888 - Super Light</span>
                <span class="float-right text-gray-400">42EU - 8.5US</span>
                <p class="mt-auto text-lg font-bold">$238.99</p>
            </div>
        </div> -->
        {{ orderStore.form }}
        <div class="mt-4 mb-2 block text-sm font-medium">Pax</div>
        <div class="flex flex-col rounded-lg bg-white sm:flex-row">
            <div class="flex w-full flex-col px-4 py-4">
                <span class="font-semibold">{{ orderStore.form.rate.pax }} Pax</span>
                <span class="float-right text-gray-400">{{ orderStore.form.rate.instructions }}</span>
                <p class="mt-auto text-lg font-bold">P{{ orderStore.form.rate.price }}</p>
            </div>
        </div>
        <div class="mt-4 mb-2 block text-sm font-medium">Add Ons</div>
        <div class="flex flex-col rounded-lg bg-white sm:flex-row" v-for="add_on in orderStore.form.add_ons">
            <div class="flex w-full flex-col px-4">
                <span class="font-semibold">{{ add_on.name }}</span>
                <!-- <span class="float-right text-gray-400">Style</span> -->
                <p class="mt-auto text-lg font-bold">{{ add_on.price }}</p>
            </div>
        </div>
        </div>

        
    </div>
    <div class="mt-10 bg-gray-50 px-4 pt-8 lg:mt-0">
        
        <!-- {{ orderStore.form }} -->
        <p class="text-xl font-medium">Payment Details</p>
        <p class="text-gray-400">Complete your order by providing your payment details.</p>
        <div class="">
            
            <p class="mt-8 text-lg font-medium">Payment Methods</p>
            <div class="max-w-lg mx-auto">
                {{ orderStore.form.contract_payments }}
                {{ orderStore.form.payment_method }}
    <div class="grid grid-cols-2 divide-x divide-gray-300 border border-gray-300 rounded-md text-center w-full">
        <div class="py-2" @click="orderStore.form.contract_payments = 'down_payment'">Half</div>
        <div class="py-2" @click="orderStore.form.contract_payments = 'full_payment'">Full</div>
    </div>
</div>
        <form class="mt-5 grid gap-6">
            {{ orderStore.subtotal }}
        <div class="relative">
            <input class="peer hidden" @click="orderStore.form.payment_method = 'online'" id="radio_1" type="radio" name="radio" checked />
            <span class="peer-checked:border-gray-700 absolute right-4 top-1/2 box-content block h-3 w-3 -translate-y-1/2 rounded-full border-8 border-gray-300 bg-white"></span>
            <label class="peer-checked:border-2 peer-checked:border-gray-700 peer-checked:bg-gray-50 flex cursor-pointer select-none rounded-lg border border-gray-300 p-4" for="radio_1">
            <img class="w-14 object-contain" src="/images/naorrAeygcJzX0SyNI4Y0.png" alt="" />
            <div class="ml-5">
                <span class="mt-2 font-semibold">Online</span>
                <p class="text-slate-500 text-sm leading-6">Lorem ipsum dolor sit amet consectetur.</p>
            </div>
            </label>
        </div>
        <div class="relative">
            <input class="peer hidden" @click="orderStore.form.payment_method = 'walk_in'" id="radio_2" type="radio" name="radio" checked />
            <span class="peer-checked:border-gray-700 absolute right-4 top-1/2 box-content block h-3 w-3 -translate-y-1/2 rounded-full border-8 border-gray-300 bg-white"></span>
            <label class="peer-checked:border-2 peer-checked:border-gray-700 peer-checked:bg-gray-50 flex cursor-pointer select-none rounded-lg border border-gray-300 p-4" for="radio_2">
            <img class="w-14 object-contain" src="/images/oG8xsl3xsOkwkMsrLGKM4.png" alt="" />
            <div class="ml-5">
                <span class="mt-2 font-semibold">Walk In</span>
                <p class="text-slate-500 text-sm leading-6">Lorem ipsum dolor sit amet consectetur.</p>
            </div>
            </label>
        </div>
        </form>

        <!-- Total -->
        <div class="mt-6 border-t border-b py-2">
            <div class="flex items-center justify-between">
            <p class="text-sm font-medium text-gray-900">Subtotal</p>
            <p class="font-semibold text-gray-900">P{{ orderStore.subtotal }}</p>
            </div>
        </div>
        <div class="mt-6 flex items-center justify-between">
            <p class="text-sm font-medium text-gray-900">Total</p>
            <p class="text-2xl font-semibold text-gray-900">{{ orderStore.subtotal }}</p>
        </div>
        </div>
        <h1 class="text-red">AGREEMENT FORM SHOULD BE HERE IT COULD JUST BE A CHECKBOX</h1>
        <button class="mt-4 mb-8 w-full rounded-md bg-gray-900 px-6 py-3 font-medium text-white" @click="submit">Place Order</button>
    </div>
    </div>

</template>