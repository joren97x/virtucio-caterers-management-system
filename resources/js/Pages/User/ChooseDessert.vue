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
    if(orderStore.form.dessert == null) {
        showAlert.value = true
        alert('choose dessert')
    }
    else {
        router.visit(route('order.main_dishes'))
    }
}

defineProps({ categories: Object })
const isSelected = computed(() => {
    return (product) => orderStore.form.dessert && orderStore.form.dessert.id === product.id;
})
</script>

<template>
    <!-- <Alert :show="showAlert" @close="showAlert = false" color="red" title="Choose a dessert" subtitle="Pag choose ra gud og dessert dong" /> -->
    <OrderLayout back="order.soups" next="order.main_dishes" loading="48">
        <div class="sticky top-0 z-10 bg-white shadow-md py-2 px-4 mb-4 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Choose a Dessert</h1>
                <p class="text-sm text-gray-600">You can select only select 1 dessert.</p>
            </div>

            <!-- Selection Indicator -->
            <div class="text-sm text-indigo-600 font-semibold">
                {{ orderStore.form.dessert ? '1' : '0' }} of 1 selected
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
                        @clicked="orderStore.form.dessert = product" 
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
  