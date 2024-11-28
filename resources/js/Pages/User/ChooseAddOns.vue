<script setup>
// Add any logic if necessary.
import OrderLayout from '@/Layouts/OrderLayout.vue'
import { useOrderStore } from '@/Stores/OrderStore';
import { Link, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue'
import { computed } from 'vue';
// defineOptions({
//     layout: OrderLayout
// })
defineProps({
    add_on_categories: Object
})
const onNext = () => {
    router.visit(route('order.contact_details'))
}


const orderStore = useOrderStore()

const isSelected = computed(() => {
    return (add_on) => orderStore.form.add_ons.find(
    (a) => a.id === add_on.id
  );
})

function toggleAddOn(add_on) {
  const index = orderStore.form.add_ons.findIndex(a => a.id === add_on.id);
  
  if (index > -1) {
    // add_on exists, so remove it
    orderStore.form.add_ons.splice(index, 1);
  } else {
    // add_on does not exist, so check if the limit is reached
    if (orderStore.form.add_ons.length < 5) {
      orderStore.form.add_ons.push(add_on);
    } else {
      // Optional: show a message or alert if the max limit is reached
      alert("You can select a maximum of 5 products.");
    }
  }
}

</script>

<template>
   <OrderLayout back="order.main_dishes" next="order.contact_details" loading="80">
    <!-- Sticky Header -->
    <div class="sticky top-0 z-10 bg-white shadow-md py-4 px-6 flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-800">Choose Your Add-Ons</h1>
        <p class="text-sm text-gray-600">
          Customize your event with additional services. You can select multiple add-ons.
        </p>
      </div>
      <!-- Selection Indicator -->
      <div class="text-sm text-indigo-600 font-semibold">
        {{ orderStore.form.add_ons.length }} selected
      </div>
    </div>

    <!-- Add-Ons Selection -->
    <div class="px-6 py-6 space-y-8">
      <!-- Add-On Categories -->
      <div v-for="(add_on_category, index) in add_on_categories" :key="index">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{ add_on_category.name }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <!-- Add-On Card -->
          <div
            v-for="add_on in add_on_category.add_ons"
            :key="add_on.index"
            @click="toggleAddOn(add_on)"
            :class="['relative border rounded-lg p-4 shadow-md hover:shadow-lg transition-all cursor-pointer', isSelected(add_on) ? 'border-indigo-500 bg-indigo-50' : 'border-gray-300']"
          >
            <div class="flex items-center">
              <input
                type="checkbox"
                :id="'addon-' + add_on.index"
                v-model="orderStore.form.add_ons"
                :value="add_on"
                class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-indigo-500 mr-4"
                @click.stop
              />
              <div>
                <label :for="'addon-' + add_on.index" class="font-semibold text-gray-800">{{ add_on.name }}</label>
                <p class="text-gray-600 text-sm">
                  ₱{{ parseFloat(add_on.price).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Next Button -->
        <template v-slot:nextButton>
      <PrimaryButton  @click="onNext">
        Next
      </PrimaryButton>
    </template>
  </OrderLayout>
</template>

  
  <style scoped>
  /* Add any custom styling here if needed */
  </style>
  