<script setup>
// Add any logic if necessary.
import OrderLayout from '@/Layouts/OrderLayout.vue'
import { useOrderStore } from '@/Stores/OrderStore';
import FoodDialog from './Components/FoodDialog.vue'
import { computed, ref } from 'vue'
import { router, Head } from '@inertiajs/vue3'
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Alert from '@/Components/Alert.vue';

const showAlert = ref(false)
const orderStore = useOrderStore()
const onNext = () => {
    console.log('bruh')
    if(orderStore.form.main_dishes.length != 5) {
        showAlert.value = true
        alert('Choose up to 5 main dishes')
}
    else {

        orderStore.form.main_dishes = orderStore.form.main_dishes.map(dish => ({
            ...dish  // Spread the dish to ensure the entire object is copied
        }))

        router.visit(route('order.add_ons'))
    }
}

defineProps({ categories: Object })
const isSelected = computed(() => {
    return (product) => orderStore.form.main_dishes.find(
    (dish) => dish.id === product.id
  );
})

function toggleProduct(product) {
  const index = orderStore.form.main_dishes.findIndex(dish => dish.id === product.id);
  console.log(product)
  if (index > -1) {
    // Product exists, so remove it
    orderStore.form.main_dishes.splice(index, 1);
  } else {
    // Product does not exist, so check if the limit is reached
    if (orderStore.form.main_dishes.length < 5) {
    //   orderStore.form.main_dishes.push(product);
      orderStore.form.main_dishes = [...orderStore.form.main_dishes, product];
    } else {
      // Optional: show a message or alert if the max limit is reached
      alert("You can select a maximum of 5 products.");
    }
  }
}

</script>

<template>
  <Head title="Choose Main Dishes" />

    <!-- <Alert :show="showAlert" @close="showAlert = false" color="red" title="Choose a dessert" subtitle="Pag choose ra gud og dessert dong" /> -->
    <OrderLayout back="order.desserts" next="order.add_ons" loading="64">
        <div class="sticky top-0 z-10 bg-white shadow-md py-2 px-4 mb-4 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Choose 5 Main Dishes</h1>
                <p class="text-sm text-gray-600">You can select up to 5 dishes.</p>
            </div>

            <!-- Selection Indicator -->
            <div class="text-sm text-indigo-600 font-semibold">
                {{ orderStore.form.main_dishes.length }} of 5 selected
            </div>
        </div>
        <div class="" >
            <div v-for="category in categories" class="relative">
                <div class="flex items-center justify-between mb-4 bg-white">
                    <h2 class="text-xl font-bold text-gray-800">{{ category.name }}</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 md:grid-cols-3 gap-6">
                    <FoodDialog 
                        :product="product" 
                        v-for="product in category.products" 
                        @clicked="toggleProduct(product)" 
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
  