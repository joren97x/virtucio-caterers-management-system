<script setup>
// Add any logic if necessary.
import OrderLayout from '@/Layouts/OrderLayout.vue'
import { useOrderStore } from '@/Stores/OrderStore';

// defineOptions({
//     layout: OrderLayout
// })
const orderStore = useOrderStore()
defineProps({
    rates: Object
})
</script>

<template>
    <OrderLayout back="dashboard" next="order.add_ons" loading="20">
        <div class="text-h6 text-center">Virtucio Rates</div>
                <div class="p-4 space-y-4 border-solid border-2">
                    <div v-for="(rate, index) in rates" :key="index" class="relative flex items-start space-x-3">
                        <input
                            type="radio"
                            :id="rate.index"
                            :value="rate"
                            v-model="orderStore.form.rate"
                            class="mt-1 h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                        />
                    <div>
                    <label :for="rate.value" class="font-medium text-gray-700">{{ rate.pax }} Pax</label>
                    <p class="text-sm text-gray-500" style="white-space: pre-line;">{{ rate.instructions }}</p>
                </div>
            <div class="absolute top-0 right-0 h-16 ">{{ rate.price }}</div>
        </div>
        </div>
    </OrderLayout>
</template>

  
  <style scoped>
  /* Add any custom styling here if needed */
  </style>
  