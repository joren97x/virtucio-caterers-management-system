
<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import FoodDialog from './Components/FoodDialog.vue';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { onMounted, ref } from 'vue'
import { useForm, usePage } from '@inertiajs/vue3'

defineOptions({
    layout: AuthenticatedLayout
})

defineProps({
    categories: Object,
    rates: Object,
    add_on_categories: Object
})

const $page = usePage()
const agreementFormModal = ref(false)
onMounted(() => {
    if(!$page.props.auth.user.agreed) {
        agreementFormModal.value = true
    }
})

const form = useForm({
    
})

</script>

<template>
    <div class="bg-white">
        <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
            <div class="text-h6 text-center">Virtucio Rates</div>
                <div class="p-4 space-y-4 border-solid border-2">
                    <div v-for="(rate, index) in rates" :key="index" class="relative flex items-start space-x-3">
                        <input
                            type="checkbox"
                            :id="rate.index"
                            v-model="rate.checked"
                            class="mt-1 h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                        />
                    <div>
                    <label :for="rate.value" class="font-medium text-gray-700">{{ rate.pax }} Pax</label>
                    <p class="text-sm text-gray-500">{{ rate.instructions }}</p>
                </div>
            <div class="absolute top-0 right-0 h-16 ">{{ rate.price }}</div>
        </div>
    </div>
    <!-- {{ add_on_categories.add_ons }} -->
    <div class="text-h6 text-center">Optional Add Ons</div>
        <div class="p-4 space-y-4 border-solid border-2">
            <div  v-for="(add_on_category, index) in add_on_categories" :key="index">
                {{ add_on_category.name }}
            <div v-for="add_on in add_on_category.add_ons" class="relative flex items-start space-x-3">
                <input
                    type="checkbox"
                    :id="add_on.index"
                    class="mt-1 h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                />
            <div>
                <label  class="font-medium text-gray-700">{{ add_on.name }}</label>
                <!-- <p class="text-sm text-gray-500">{{ add_on.instructions }}</p> -->
                <div class="absolute top-0 right-0 h-16 ">{{ add_on.price }}</div>
            </div>
            <div class="absolute top-0 right-0 h-16 ">{{ add_on.price }} bruh</div>
            </div>
        </div>

    </div>
        <h2 class="text-center">Food Menu</h2>
        <div  v-for="category in categories">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">{{ category.name }}</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 md:grid-cols-3 gap-6">
                <FoodDialog :product="product"  v-for="product in category.products"/>
            </div>
        </div>
    </div>
    </div>
    <TransitionRoot as="template" :show="agreementFormModal">
    <Dialog class="relative z-10" @close="agreementFormModal = false">
      <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
      </TransitionChild>

      <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
          <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
              <div class="bg-white  sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                 
                  <div class="mt-3 text-center  sm:mt-0 sm:text-left w-full">
                    <!-- <DialogTitle as="h3" class="text-base font-semibold leading-6 text-gray-900">Deactivate account</DialogTitle>
                    <div class="mt-2">
                      <p class="text-sm text-gray-500">Are you sure you want to deactivate your account? All of your data will be permanently removed. This action cannot be undone.</p>
                    </div> -->
                    <div>
                <h2 class="text-xl font-bold text-gray-800">Agreement Form </h2>
                <p class="text-sm text-gray-600">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste, delectus?
                </p>
            </div>
                  </div>
                </div>
              </div>
              <div class="bg-gray-50 px-4 py-3 sm:px-6">
                
                <button type="button" class="mt-3 inline-flex  justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="agreementFormModal = false" ref="cancelButtonRef">Decline</button>
                <button @click="submit" type="button" class="rounded-md bg-green-600 px-3 py-2 text-sm  mr-5 font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto" >Accept</button>
            </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
  </template>
  