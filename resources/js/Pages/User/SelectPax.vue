<script setup>
// Add any logic if necessary.
import OrderLayout from '@/Layouts/OrderLayout.vue'
import { useOrderStore } from '@/Stores/OrderStore';
import { router, Head } from '@inertiajs/vue3'
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
  <Head title="Home" />
    
    <Alert :show="showAlert" @close="showAlert = false" color="red" title="Choose a pax" subtitle="Pag choose ra gud og pax dong" />
    <OrderLayout back="home" next="order.soups" loading="16">
    <!-- Sticky Header -->
    <div class="sticky top-0 z-10 bg-white shadow-md py-4 px-6 flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-800">How many people are you serving?</h1>
        <p class="text-sm text-gray-600">Please select one option to proceed.</p>
      </div>
      <!-- Selection Indicator -->
      <div class="text-sm text-indigo-600 font-semibold">
        {{ orderStore.form.rate ? '1 of 1 selected' : '0 of 1 selected' }}
      </div>
    </div>
    <!-- Pax Options -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 py-6 px-6">
      <div
        v-for="(rate, index) in rates"
        :key="index"
        @click="orderStore.form.rate = rate"
        :class="['cursor-pointer border rounded-lg p-4 shadow-md hover:shadow-lg transition-all', 
          orderStore.form.rate?.id === rate.id ? 'border-indigo-500' : 'border-gray-300']"
      >
        <div class="flex justify-between items-center">
          <h3 class="text-xl font-semibold text-gray-800">{{ rate.pax }} Pax</h3>
          <p class="text-lg text-indigo-600 font-bold">
            ₱{{ parseFloat(rate.price).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) }}
          </p>
        </div>
        <p class="text-sm text-gray-600 mt-2" style="white-space: pre-line;">
          {{ rate.instructions }}
        </p>
      </div>
    </div>

    <!-- Next Button -->
    <template v-slot:nextButton>
        <PrimaryButton :disabled="!orderStore.form.rate" :class="{ 'opacity-50 cursor-not-allowed': !orderStore.form.rate }" @click="onNext">
            Next
        </PrimaryButton>
      </template>
  </OrderLayout>
</template>

  
  <style scoped>
  /* Add any custom styling here if needed */
  </style>
  