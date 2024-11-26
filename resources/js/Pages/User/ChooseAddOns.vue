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
    <OrderLayout back="order.main_dishes" next="order.contact_details" loading="50">
        <div class="sticky top-0 z-10 bg-white shadow-md py-2 px-4 mb-4 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Choose a Add Ons</h1>
                <p class="text-sm text-gray-600">You can select only select 1 dessert.</p>
            </div>

            <!-- Selection Indicator -->
            <div class="text-sm text-indigo-600 font-semibold">
                0 of 1 selected
            </div>
        </div>
        <!-- <input type="radio" v-model="orderStore.form.event" value="wedding"> Wedding <br>
                <input type="radio" v-model="orderStore.form.event" value="birthday"> Birthday <br>
                <input type="radio" v-model="orderStore.form.event" value="thanksgiving"> Thanks Giving <br> -->
        <div class="p-4 space-y-4 border-solid border-2">
            <div  v-for="(add_on_category, index) in add_on_categories" :key="index">
             <!-- <div class="text-lg">   {{ add_on_category.name }}</div> -->
             <div class="flex justify-between ...">
                <div class="text-lg">   {{ add_on_category.name }}</div>
                <!-- <div>Optional</div> -->
            </div>
             <div class="grid grid-cols-2 gap-4">
                <div v-for="add_on in add_on_category.add_ons" @click="toggleAddOn(add_on)" class="relative border-solid border-2 border-grey-200 p-2  flex mt-4 items-start space-x-3">
                    <input
                        type="checkbox"
                        :id="add_on.index"
                        v-model="orderStore.form.add_ons"
                        :value="add_on"
                        class="mt-1 h-4 w-4 text-blue-600 border-black rounded focus:ring-blue-500"
                    />
                <div>
                    <label  class="font-medium text-gray-700">{{ add_on.name }}</label>
                    <br>
                    <label  class="font-medium text-gray-700">
                        ₱{{ parseFloat(add_on.price).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) }}
                        </label>
                </div>
                </div>
             </div>

        <!-- {{ orderStore.form.event }} -->
        <br>
                <div class="mt-6">
                    <!-- <label class="block text-sm font-medium text-gray-700">Event Details</label> -->
                    <!-- <textarea
                id="about"
                rows="2"
                v-model="orderStore.form.event_details"
                placeholder="Write a few sentences about the food."
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
            ></textarea> -->
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
  