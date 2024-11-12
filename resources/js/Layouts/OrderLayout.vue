<script setup>
// Add any logic if necessary.
import { Link } from '@inertiajs/vue3';
import { useOrderStore } from '@/Stores/OrderStore';
defineProps({
    next: String,
    back: String,
    loading: String
})

const orderStore = useOrderStore()

</script>

<template>
    <div class="h-screen w-screen" >
        <div class="flex justify-between mx-5">
            <div class="flex items-center justify-center h-16 border-b">
                <img src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=600" alt="Logo" class="h-8 w-auto">
            </div>
            <div>
                <Link :href="route('dashboard')" class=" rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Exit
                </Link>
            </div>
        </div>
        <slot />
        <div class="absolute bottom-0 w-full" >
            <div class="my-1 h-3" :style="`background-color: red; width: ${loading}%;`"></div>
            <div class="flex justify-between mx-5 py-10 my-10">
                <Link :href="route(back)" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Back
                </Link>
            <div>
                <!-- <Link :href="route('checkout')"  >
                    
                </Link> -->
                <button @click="orderStore.checkout()" v-if="$page.component == 'User/ContactForm'" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Proceed to Checkout
                </button>
                <Link :href="route(next)" v-else class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Next
                </Link>
                <!-- {{ $page.component }} -->
                
            </div>
            
        </div>
        </div>
    </div>
</template>

  
  <style scoped>
  /* Add any custom styling here if needed */
  </style>
  