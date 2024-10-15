<script setup>

import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue';

defineOptions({
    layout: AdminLayout
})

defineProps({
    ingredients: Object
})

const addIngredientDialog = ref(false)
const form = useForm({
    name: '',
    supplier: '',
    quantity: 0
})

const submit = () => {
    form.post(route('admin.ingredients.store'), {
        onSuccess: () => {
            addIngredientDialog.value = false
        }
    })
}
</script>

<template>
    <div class="p-8 bg-white shadow rounded-lg">
      <div class="flex items-center justify-between mb-4">
        <div>
          <h2 class="text-xl font-bold text-gray-800">Ingredients</h2>
          <p class="text-sm text-gray-600">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui, eum.
          </p>
        </div>
        <button
          class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-500"
          @click="addIngredientDialog = true"
        >
          Add Ingredient
        </button>
      </div>
  
      <table class="min-w-full bg-white">
        <thead>
          <tr>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Name</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Quantity</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Supplier</th>
            <th class="px-6 py-3 text-right text-sm font-medium text-gray-500"></th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <tr v-for="ingredients in ingredients" :key="ingredients.id">
            <td class="px-6 py-4">
              <p class="text-sm text-gray-900">{{ ingredients.name }} </p>
            </td>
            <td class="px-6 py-4">
              <p class="text-sm text-gray-900">{{ ingredients.quantity }} </p>
            </td>
            <td class="px-6 py-4">
              <span class="inline-flex items-center px-2 py-0.5 rounded text-sm font-medium">
                <!-- :class="rate.status === 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" -->
                {{ ingredients.supplier }}
              </span>
            </td>
            <td class="px-6 py-4 text-right">
              <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <TransitionRoot as="template" :show="addIngredientDialog">
    <Dialog class="relative z-10" @close="addIngredientDialog = false">
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
                <h2 class="text-xl font-bold text-gray-800">Add Expense</h2>
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
    <div>
      <label for="website" class="block text-sm font-medium text-gray-700">Quantity</label>
      <input
        type="number"
        v-model="form.quantity"
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

    <!-- <div class="max-w-lg mx-auto">
    <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
    <select
      id="country"
      v-model="form.category"
      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
    >
      <option v-for="category in categories" :key="category.id" :value="category.id">
        {{ category.name }}
      </option>
    </select>
  </div> -->

    <div>
                    <label for="supplier" class="block text-sm font-medium leading-6 text-gray-900">Supplier</label>
                    <div class="relative rounded-md shadow-sm">
                    
                    <input v-model="form.supplier" type="text" name="price" id="price" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                    
                    </div>
                </div>
    <!-- Cover Photo Upload -->
  </div>
                  </div>
                </div>
              </div>
              <div class="bg-gray-50 px-4 py-3 sm:px-6">
                
                <button type="button" class="mt-3 inline-flex  justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="addIngredientDialog = false" ref="cancelButtonRef">Cancel</button>
                <button @click="submit" type="button" class="rounded-md bg-green-600 px-3 py-2 text-sm  mr-5 font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto" >Save</button>
            </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>