<script setup>
// Add any logic if necessary.
import OrderLayout from '@/Layouts/OrderLayout.vue'
import { useOrderStore } from '@/Stores/OrderStore';
import FoodDialog from './Components/FoodDialog.vue';
import { computed, ref } from 'vue';
import { router } from '@inertiajs/vue3'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Alert from '@/Components/Alert.vue';

const showAlert = ref(false)
const orderStore = useOrderStore()
const onNext = () => {
    if(orderStore.form.soup == null) {
        showAlert.value = true
        alert('Choose one soup')
    }
    else {
        router.visit(route('order.desserts'))
    }
}

const isSelected = computed(() => {
    return (product) => orderStore.form.soup && orderStore.form.soup.id === product.id;
})
defineProps({ categories: Object })

</script>

<template>
    <!-- <Alert :show="showAlert" @close="showAlert = false" color="red" title="Choose a soup" subtitle="Pag choose ra gud og soup dong" />
    {{ alert }} -->
    <OrderLayout back="order.pax" next="order.desserts" loading="32">
        <div class="sticky top-0 z-10 bg-white shadow-md py-2 px-4 mb-4 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Choose a Soup</h1>
                <p class="text-sm text-gray-600">You can select only select 1 soup.</p>
            </div>

            <!-- Selection Indicator -->
            <div class="text-sm text-indigo-600 font-semibold">
                {{ orderStore.form.soup ? '1' : '0' }} of 1 selected
            </div>
        </div>
        <div class="" >
            <div v-for="category in categories" class="relative">
                <!-- <div class="flex items-center justify-between mb-4 bg-white">
                    <h2 class="text-xl font-bold text-gray-800">{{ category.name }}</h2>
                </div> -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 md:grid-cols-3 gap-6">
                    <FoodDialog 
                        :product="product" 
                        v-for="product in category.products" 
                        @clicked="orderStore.form.soup = product" 
                        :selected="isSelected(product)"
                    />
                    
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
  