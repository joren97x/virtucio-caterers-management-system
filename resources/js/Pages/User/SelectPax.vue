<script setup>
// Add any logic if necessary.
import OrderLayout from '@/Layouts/OrderLayout.vue'
import { useOrderStore } from '@/Stores/OrderStore';
import { router } from '@inertiajs/vue3'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import { ref } from 'vue'
import Alert from '@/Components/Alert.vue';

const showAlert = ref(false)
const onNext = () => {
    if(orderStore.form.rate == null) {
        showAlert.value = true
        alert('Choose a pax')
    }
    else {
        router.visit(route('order.soups'))
    }
}

const orderStore = useOrderStore()
defineProps({
    rates: Object
})
</script>

<template>
    
    <Alert :show="showAlert" @close="showAlert = false" color="red" title="Choose a pax" subtitle="Pag choose ra gud og pax dong" />
    <OrderLayout back="home" next="order.soups" loading="20" >
        <!-- <div class="text-h6 text-center">Virtucio Rates</div> -->
        <div class="sticky top-0 z-10 bg-white shadow-md py-2 px-4 mb-4 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">How many people are you serving?</h1>
                <p class="text-sm text-gray-600">You can select only select 1 soup.</p>
            </div>

            <!-- Selection Indicator -->
            <div class="text-sm text-indigo-600 font-semibold">
                0 of 1 selected
            </div>
        </div>
                <!-- <h1 class="text-2xl font-bold mb-4">How many people are you serving?</h1> -->
                <div v-for="(rate, index) in rates" :key="index" class="relative flex items-start space-x-3 mt-5">
                    <input
                        type="radio"
                        :id="rate.index"
                        :value="rate"
                        v-model="orderStore.form.rate"
                        class="mt-1 h-4 w-4 rounded focus:ring-blue-500 ml-5"
                    />
                <div>
                <div :for="rate.value" class="text-md font-bold">{{ rate.pax }} Pax</div>
                <p class="text-sm text-gray-500" style="white-space: pre-line;">{{ rate.instructions }}</p>
            <div class="absolute top-0 right-0 h-16 ">
                <!-- {{ rate.price }} -->
                ₱{{ parseFloat(rate.price).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) }}
            </div>
        </div>
        </div>
        <template v-slot:nextButton>
            <PrimaryButton @click="onNext"> 
                Next
            </PrimaryButton>
        </template>
    </OrderLayout>
</template>

  
  <style scoped>
  /* Add any custom styling here if needed */
  </style>
  