<script setup>
import { ref, defineEmits } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
// import { ExclamationTriangleIcon } from '@heroicons/vue/24/outline'
import { useOrderStore } from '@/Stores/OrderStore'


const props = defineProps({
    product: Object,
    selected: Boolean
})

const emit = defineEmits(['clicked'])
const orderStore = useOrderStore()
const open = ref(false)
const form = ref({
    product: props.product,
    special_instructions: '',
})

const addToCart = () => {
    open.value = false
    orderStore.form.foods.push(form.value)
}

</script>

<template>
    
    <div @click="emit('clicked')" :class="{'border-2 border-green-500': selected, 'border-2 border-transparent': !selected}">
        <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
          {{ product.image_path }}
            <img :src="`/storage/${product.image_path}`" :alt="product.name" class="h-56 w-full object-cover object-center group-hover:opacity-75" />
        </div>
        <p class="mt-4 text-lg font-medium "> {{ product.name }}</p>
        <h3 class="mt-1 text-sm text-gray-700">{{ product.description }}</h3>
    </div>
    <TransitionRoot as="template" :show="open">
    <Dialog class="relative z-10" @close="open = false">
      <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
      </TransitionChild>

      <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
          <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
              <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                  <!-- <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                    <ExclamationTriangleIcon class="h-6 w-6 text-red-600" aria-hidden="true" /> 
                  </div>
                  -->
                  <div class="mt-3 text-center sm:mt-0 sm:text-left">
                    <!-- <DialogTitle as="h3" class="text-base font-semibold leading-6 text-gray-900">Deactivate account</DialogTitle>
                    <div class="mt-2">
                      <p class="text-sm text-gray-500">Are you sure you want to deactivate your account? All of your data will be permanently removed. This action cannot be undone.</p>
                    </div> -->
                    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
                        <img :src="`/storage/${product.image_path}`" :alt="product.name" class="h-full w-full object-cover object-center group-hover:opacity-75" />
                    </div>
                    <h3 class="mt-4 text-sm text-gray-700">{{ product.name }}</h3>
                    <h3 class="text-sm text-gray-900">Food Description Lorem ipsum, dolor sit amet consectetur adipisicing elit.</h3>
                    <p class="mt-1 text-lg font-medium text-gray-900">{{ product.price }}</p>
                  </div>
                </div>
              </div>
              <div class="bg-gray-50 px-4 py-3 sm:px-6">
                <div>
      <label for="about" class="block text-sm font-medium text-gray-700">Special Instructions</label>
      <textarea
        id="about"
        v-model="form.special_instructions"
        rows="2"
        placeholder="Write a few sentences about the food."
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
      ></textarea>
    </div>
                <div>
                    <!-- <label for="price" class="block text-sm font-medium leading-6 text-gray-900">Quantity</label> -->
                    <div class="relative mt-2 rounded-md shadow-sm">
                    <!-- <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <span class="text-gray-500 sm:text-sm">$</span>
                    </div>
                    <input v-model="form.quantity" type="text" name="price" id="price" class="block  rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="0" /> -->
                    <div class="absolute inset-y-0 right-0 flex items-center">
                        
                        <button type="button" @click="addToCart" class="rounded-md bg-indigo-600 p-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto" >Add To Cart</button>
                    </div>
                    
                    </div>
                </div>
                <!-- <button type="button" class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto" @click="open = false">Deactivate</button> -->
                <!-- <button type="button" class="mt-3 inline-flex  justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="open = false" ref="cancelButtonRef">Cancel</button> -->
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>