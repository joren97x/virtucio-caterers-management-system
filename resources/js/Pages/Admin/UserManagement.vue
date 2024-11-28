
<script setup>

import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { useForm } from '@inertiajs/vue3';

defineOptions({
    layout: AdminLayout
})

defineProps({
  users: Object
})


const addUserDialog = ref(false)
const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: 'user',
})

const submit = () => {
    form.post(route('admin.users.store'), {
        onSuccess: () => {
            addUserDialog.value = false
        }
    })
}

</script>


<template>
    <div class="p-8 bg-white shadow rounded-lg">
      <div class="flex items-center justify-between mb-4">
        <div>
          <h2 class="text-xl font-bold text-gray-800">Users</h2>
          <p class="text-sm text-gray-600">
            A list of all the users in your account including their name, title, email, and role.
          </p>
        </div>
        <button
          class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-500"
          @click="addUserDialog = true"
        >
          Add user
        </button>
      </div>
  
      <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
  <thead class="bg-gray-50 border-b border-gray-200">
    <tr>
      <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
        Name
      </th>
      <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
        Role
      </th>
      <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">
        Actions
      </th>
    </tr>
  </thead>
  <tbody class="divide-y divide-gray-200">
    <tr
      v-for="user in users"
      :key="user.email"
      class="hover:bg-gray-50 transition-colors"
    >
      <!-- User Details -->
      <td class="px-6 py-4 flex items-center space-x-4">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="w-10 h-10 text-gray-400 rounded-full bg-gray-100 p-2"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"
          />
        </svg>
        <div>
          <p class="text-sm font-medium text-gray-900">{{ user.name }}</p>
          <p class="text-sm text-gray-500">{{ user.email }}</p>
        </div>
      </td>

      <!-- Role -->
      <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ user.role }}</td>

      <!-- Actions -->
      <td class="px-6 py-4 text-right">
        <a
          href="#"
          class="text-sm font-medium text-indigo-600 hover:text-indigo-900 transition-colors"
        >
          Edit
        </a>
      </td>
    </tr>
  </tbody>
</table>

    </div>
    <TransitionRoot as="template" :show="addUserDialog">
    <Dialog class="relative z-10" @close="addUserDialog = false">
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
                <h2 class="text-xl font-bold text-gray-800">Add User</h2>
                <p class="text-sm text-gray-600">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste, delectus?
                </p>
                
      
    </div>
</div>
</div>
</div>
{{ form }}
                    <div class=" bg-white shadow-md mx-4">
    <div>
      <label for="website" class="block text-sm font-medium text-gray-700">Name</label>
      <input
        v-model="form.name"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
      />
    </div>

    <div class=" bg-white shadow-md">
    <div>
      <label for="website" class="block text-sm font-medium text-gray-700">Email Address</label>
      <input
        v-model="form.email"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
      />
    </div>
    
    <div class="max-w-lg mx-auto">
    <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Role</label>
    <select
      id="country"
      v-model="form.role"
      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
    >
      <option value="user" selected>
        User
      </option>
      <option value="user">
        Admin
      </option>
    </select>
  </div>
  <div class=" bg-white shadow-md">
    <div class="grid grid-cols-2">
      <div>
      <label for="website" class=" text-sm font-medium text-gray-700">Password</label>
      <input
        v-model="form.password"
        class="mt-1  w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
      />
      <div>
      <label for="website" class=" text-sm font-medium text-gray-700">Confirm Password</label>
      <input
        v-model="form.password_confirmation"
        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
      />
    </div>
    </div>
    
    <!-- Cover Photo Upload -->
  </div>
                  </div>
                </div>
              </div>
              <div class="bg-gray-50 px-4 py-3 sm:px-6">
                
                <button type="button" class="mt-3 inline-flex  justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="addUserDialog = false" ref="cancelButtonRef">Cancel</button>
                <button @click="submit" type="button" class="rounded-md bg-green-600 px-3 py-2 text-sm  mr-5 font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto" >Save</button>
            </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
  </template>
  