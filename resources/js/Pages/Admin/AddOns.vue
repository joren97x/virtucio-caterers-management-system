<script setup>

import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import DeleteAddOn from './Components/Partials/DeleteAddOn.vue'

defineOptions({
    layout: AdminLayout
})

defineProps({
    add_ons: Object,
    add_on_categories: Object
})

const addAddOnDialog = ref(false)
const addAddOnCategoryDialog = ref(false)
const form = useForm({
    name: '',
    price: 0,
    add_on_category: ''
})

const addOnCategoryForm = useForm({
    name: '',
})

const submit = () => {
    form.post(route('admin.add_ons.store'), {
        onSuccess: () => {
            addAddOnDialog.value = false
        }
    })
}

const submitAddOnCategoryForm = () => {
    addOnCategoryForm.post(route('admin.add_on_categories.store'), {
        onSuccess: () => {
          addAddOnCategoryDialog.value = false
        }
    })
}

</script>

<template>
    <div class="p-8 bg-white shadow rounded-lg">
      <div class="flex items-center justify-between mb-4">
        <div>
          <h2 class="text-xl font-bold text-gray-800">Add Ons</h2>
          <p class="text-sm text-gray-600">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui, eum.
          </p>
        </div>
        <div>
            <button
            class="px-4 py-2 bg-indigo-600 mr-2 text-white rounded-lg shadow hover:bg-indigo-500"
            @click="addAddOnCategoryDialog = true"
            >
            Add Add On Category
            </button>
            <button
            class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-500"
            @click="addAddOnDialog = true"
            >
            Add Add On
            </button>
        </div>
      </div>
      <div  v-for="add_on_category in add_on_categories">
        <div class="flex items-center justify-between mb-4">
      <h2 class="text-xl font-bold text-gray-800">{{ add_on_category.name }}</h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 md:grid-cols-3 gap-6">
      <div
        v-for="add_on in add_on_category.add_ons"
        :key="add_on.id"
        class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow"
      >
        <!-- <img :src="`/storage/${food.image_path}`" :alt="food.name" class="h-32 w-full object-cover rounded-t-lg" /> -->
        <div class="p-4">
          <h3 class="text-lg font-semibold text-gray-800">{{ add_on.name }}</h3>
          <!-- <p class="text-sm text-gray-500">{{ add_on.desc }}</p> -->
          <div class="mt-4 flex items-center justify-between">
            <span class="text-lg font-bold text-gray-900">{{ add_on.price }}</span>
            <div>
                <button
              class="px-3 py-1 mr-2 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-500"
            >
              Edit
            </button>
            <DeleteAddOn :add_on="add_on" />
            
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
      
    </div>


    <TransitionRoot as="template" :show="addAddOnDialog">
    <Dialog class="relative z-10" @close="addAddOnDialog = false">
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
                <h2 class="text-xl font-bold text-gray-800">Add Add On</h2>
                <p class="text-sm text-gray-600">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste, delectus?
                </p>
            </div>
                    <div class=" bg-white shadow-md">
    <div>
      <label for="website" class="block text-sm font-medium text-gray-700">Name</label>
      <input
        v-model="form.name"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
      />
    </div>
    <!-- <div>
      <label for="about" class="block text-sm font-medium text-gray-700">Instructions/Freebies</label>
      <textarea
        rows="3"
        v-model="form.instructions"
        placeholder="Lorem iosum dolor set amaet"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
      ></textarea>
    </div> -->

    <div class="max-w-lg mx-auto">
    <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
    <select
      id="country"
      v-model="form.add_on_category"
      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
    >
      <option v-for="category in add_on_categories" :key="category.id" :value="category.id">
        {{ category.name }}
      </option>
    </select>
  </div>

    <div>
                    <label for="price" class="block text-sm font-medium leading-6 text-gray-900">Price</label>
                    <div class="relative rounded-md shadow-sm">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <span class="text-gray-500 sm:text-sm">$</span>
                    </div>
                    <input v-model="form.price" type="text" name="price" id="price" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="0.00" />
                    
                    </div>
                </div>
    <!-- Cover Photo Upload -->
  </div>
                  </div>
                </div>
              </div>
              <div class="bg-gray-50 px-4 py-3 sm:px-6">
                
                <button type="button" class="mt-3 inline-flex  justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="addAddOnDialog = false" ref="cancelButtonRef">Cancel</button>
                <button @click="submit" type="button" class="rounded-md bg-green-600 px-3 py-2 text-sm  mr-5 font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto" >Save</button>
            </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>

  
    <TransitionRoot as="template" :show="addAddOnCategoryDialog">
    <Dialog class="relative z-10" @close="addAddOnCategoryDialog = false">
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
                <h2 class="text-xl font-bold text-gray-800">Add Add On Category</h2>
                <p class="text-sm text-gray-600">
                    {{ addOnCategoryForm }}
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste, delectus?
                </p>
            </div>
                    <div class=" bg-white shadow-md">
    <div>
      <label for="website" class="block text-sm font-medium text-gray-700">Name</label>
      <input
        v-model="addOnCategoryForm.name"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
      />
    </div>

  </div>
                  </div>
                </div>
              </div>
              <div class="bg-gray-50 px-4 py-3 sm:px-6">
                
                <button type="button" class="mt-3 inline-flex  justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="addAddOnCategoryDialog = false" ref="cancelButtonRef">Cancel</button>
                <button @click="submitAddOnCategoryForm" type="button" class="rounded-md bg-green-600 px-3 py-2 text-sm  mr-5 font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto" >Save</button>
            </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>



</template>