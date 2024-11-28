<script setup>

import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import { formatDate } from 'date-fns'

defineOptions({
    layout: AdminLayout
})

defineProps({
    revenue: Object,
    expenses: Object,
    profit: Object,
    orders: Object,
    expenses_details: Object,
})

const addExpenseDialog = ref(false)
// const form = useForm({
//     name: '',
//     price: 0,
//     quantity: 0
// })

const form = useForm({
  category: '',
  amount: '',
  description: '',
  date: '',
});

const submit = () => {
    form.post(route('admin.expenses.store'), {
        onSuccess: () => {
            addExpenseDialog.value = false
        }
    })
}
</script>

<template>
    <div class="p-6 bg-gray-100 min-h-screen">
    <div class="max-w-7xl mx-auto">
      <!-- Page Title -->
      <h1 class="text-2xl font-bold text-gray-700 mb-6">Expense Management</h1>

      <!-- Expense Form -->
      <div class="bg-white p-4 rounded shadow-md mb-6">
        <h3 class="text-lg font-semibold mb-4">Add New Expense</h3>
        <form @submit.prevent="submit">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label for="category" class="text-sm font-medium text-gray-700">Category</label>
              <input v-model="form.category" id="category" type="text" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required />
            </div>

            <div>
              <label for="amount" class="text-sm font-medium text-gray-700">Amount</label>
              <input v-model="form.amount" id="amount" type="number" step="0.01" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required />
            </div>

            <div class="col-span-2">
              <label for="description" class="text-sm font-medium text-gray-700">Description</label>
              <textarea v-model="form.description" id="description" rows="3" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            </div>

            <div class="col-span-2 flex justify-between">
              <label for="date" class="text-sm font-medium text-gray-700">Date</label>
              <input v-model="form.date" id="date" type="date" class="w-1/3 px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required />
            </div>
          </div>

          <div class="mt-4 flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-500">Add Expense</button>
          </div>
        </form>
      </div>

      <!-- Expense Table -->
      <div>
    <h2 class="text-xl font-bold">Sales and Expenses Report</h2>

    <!-- Date Filters -->
    <div class="mb-6 flex items-center space-x-4">
      <div>
        <label class="block text-sm font-medium">Start Date</label>
        <input v-model="startDate" type="date" class="mt-1 p-2 border rounded" />
      </div>
      <div>
        <label class="block text-sm font-medium">End Date</label>
        <input v-model="endDate" type="date" class="mt-1 p-2 border rounded" />
      </div>
      <button
        @click="fetchReport"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
      >
        Generate Report
      </button>
    </div>

    <!-- Summary Section -->
    <div class="grid grid-cols-3 gap-4">
      <div class="p-4 bg-white rounded shadow">
        <h3 class="text-lg font-semibold">Total Revenue</h3>
        <p class="text-2xl font-bold">₱{{ revenue }}</p>
      </div>
      <div class="p-4 bg-white rounded shadow">
        <h3 class="text-lg font-semibold">Total Expenses</h3>
        <p class="text-2xl font-bold">₱{{ expenses }}</p>
      </div>
      <div class="p-4 bg-white rounded shadow">
        <h3 class="text-lg font-semibold">Profit</h3>
        <p class="text-2xl font-bold">₱{{ profit }}</p>
      </div>
    </div>

    <!-- Orders Table -->
    <div class="mt-8">
      <h3 class="text-lg font-semibold mb-4">Orders</h3>
      <table class="min-w-full bg-white shadow-md rounded-lg">
        <thead class="bg-gray-200">
          <tr>
            <th class="py-2 px-4 text-left">Order ID</th>
            <th class="py-2 px-4 text-left">Customer</th>
            <th class="py-2 px-4 text-left">Total Amount</th>
            <th class="py-2 px-4 text-left">Order Date</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="order in orders" :key="order.id" class="border-b">
            <td class="py-2 px-4">{{ order.id }}</td>
            <td class="py-2 px-4">{{ order.user_id }}</td>
            <td class="py-2 px-4">₱{{ order.total_amount }}</td>
            <td class="py-2 px-4">{{ order.order_date }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Expenses Table -->
    <div class="mt-8">
      <h3 class="text-lg font-semibold mb-4">Expenses</h3>
      <table class="min-w-full bg-white shadow-md rounded-lg">
        <thead class="bg-gray-200">
          <tr>
            <th class="py-2 px-4 text-left">Expense ID</th>
            <th class="py-2 px-4 text-left">Category</th>
            <th class="py-2 px-4 text-left">Description</th>
            <th class="py-2 px-4 text-left">Amount</th>
            <th class="py-2 px-4 text-left">Date</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="expense in expenses" :key="expense.id" class="border-b">
            <td class="py-2 px-4">{{ expense.id }}</td>
            <td class="py-2 px-4">{{ expense.category }}</td>
            <td class="py-2 px-4">{{ expense.description }}</td>
            <td class="py-2 px-4">₱{{ expense.amount }}</td>
            <td class="py-2 px-4">{{ expense.date }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
    </div>
  </div>
    <TransitionRoot as="template" :show="addExpenseDialog">
    <Dialog class="relative z-10" @close="addExpenseDialog = false">
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
                
                <button type="button" class="mt-3 inline-flex  justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="addExpenseDialog = false" ref="cancelButtonRef">Cancel</button>
                <button @click="submit" type="button" class="rounded-md bg-green-600 px-3 py-2 text-sm  mr-5 font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto" >Save</button>
            </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>