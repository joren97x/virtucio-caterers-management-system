<script setup>

import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { useForm, Head } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';

defineOptions({
    layout: AdminLayout
})

defineProps({
    users: Object
})

const editDialog = ref(false)
const deleteDialog = ref(false)
const addUserDialog = ref(false)

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: 'user',
    id: ''
})

const showEditDialog = (user) => {
    console.log(user)
    form.name = user.name
    form.email = user.email
    form.id = user.id
    form.role = user.role
    editDialog.value = true
}

const showDeleteDialog = (user) => {
    form.name = user.name
    form.id = user.id
    deleteDialog.value = true
}

const submit = () => {
    form.post(route('admin.users.store'), {
        onSuccess: () => {
            addUserDialog.value = false
        }
    })
}

const update = () => {
    form.put(route('admin.users.update', form.id), {
        onSuccess: () => {
            editDialog.value = false
        }
    })
}

const deleteUser = () => {
    form.delete(route('admin.users.destroy', form.id), {
        onSuccess: () => {
            deleteDialog.value = false
        }
    })
}

</script>


<template>
    <Head title="User Management" />

    <div class="p-8 bg-white shadow rounded-lg">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Users</h2>
                <p class="text-sm text-gray-600">
                    A list of all the users in your account including their name, title, email, and role.
                </p>
            </div>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-500"
                @click="addUserDialog = true">
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
                <tr v-for="user in users" :key="user.email" class="hover:bg-gray-50 transition-colors">
                    <!-- User Details -->
                    <td class="px-6 py-4 flex items-center space-x-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-10 h-10 text-gray-400 rounded-full bg-gray-100 p-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
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
                        <PrimaryButton @click="showEditDialog(user)">Edit</PrimaryButton>
                        <DangerButton @click="showDeleteDialog(user)">Delete</DangerButton>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
    <TransitionRoot as="template" :show="addUserDialog">
        <Dialog class="relative z-10" @close="addUserDialog = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel
                            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <div class="bg-white  sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">

                                    <div class="mt-3 text-center  sm:mt-0 sm:text-left w-full">

                                        <div>
                                            <h2 class="text-xl font-bold text-gray-800">Add User</h2>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class=" bg-white shadow-md mx-4">
                                <div>
                                    <label for="website" class="block text-sm font-medium text-gray-700">Name</label>
                                    <input v-model="form.name"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                </div>

                                <div class=" bg-white shadow-md">
                                    <div>
                                        <label for="website" class="block text-sm font-medium text-gray-700">Email
                                            Address</label>
                                        <input v-model="form.email"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                    </div>

                                    <div class="max-w-lg mx-auto">
                                        <label for="country"
                                            class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                                        <select id="country" v-model="form.role"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                            <option value="user" selected>
                                                User
                                            </option>
                                            <option value="user">
                                                Admin
                                            </option>
                                        </select>
                                    </div>
                                    <div class=" bg-white shadow-md">
                                        <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-4">
                                            <div class="">
                                                <label for="website"
                                                    class=" text-sm font-medium text-gray-700">Password</label>
                                                <input v-model="form.password"
                                                    class="mt-1  w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                            </div>
                                            <div>
                                                <label for="website" class=" text-sm font-medium text-gray-700">Confirm
                                                    Password</label>
                                                <input v-model="form.password_confirmation"
                                                    class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                            </div>

                                            <!-- Cover Photo Upload -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 justify-end flex">

                                <button type="button"
                                    class="mt-3 inline-flex  justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                    @click="addUserDialog = false" ref="cancelButtonRef">Cancel</button>
                                <button @click="submit" type="button"
                                    class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Save</button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
    <TransitionRoot as="template" :show="editDialog">
        <Dialog class="relative z-10" @close="editDialog = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel
                            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <div class="bg-white  sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">

                                    <div class="mt-3 text-center  sm:mt-0 sm:text-left w-full">

                                        <div>
                                            <h2 class="text-xl font-bold text-gray-800">Add User</h2>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class=" bg-white shadow-md mx-4">
                                <div>
                                    <label for="website" class="block text-sm font-medium text-gray-700">Name</label>
                                    <input v-model="form.name"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                </div>

                                <div class=" bg-white shadow-md">
                                    <div>
                                        <label for="website" class="block text-sm font-medium text-gray-700">Email
                                            Address</label>
                                        <input v-model="form.email"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                    </div>

                                    <div class="max-w-lg mx-auto">
                                        <label for="country"
                                            class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                                        <select id="country" v-model="form.role"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                            <option value="user" selected>
                                                User
                                            </option>
                                            <option value="user">
                                                Admin
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 justify-end flex">

                                <button type="button"
                                    class="mt-3 inline-flex  justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                    @click="editDialog = false" ref="cancelButtonRef">Cancel</button>
                                <button @click="update" type="button"
                                    class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Update</button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
    <TransitionRoot as="template" :show="deleteDialog">
        <Dialog class="relative z-10" @close="deleteDialog = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel
                            class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            <div class="bg-white sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                        <div>
                                            <h2 class="text-xl font-bold text-gray-800">Delete User</h2>
                                            <p class="text-sm text-gray-600 mt-4 flex border border-red-500 p-3">
                                                <svg fill="#ff0000" height="40px" width="40px" class="mr-4"
                                                    version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                                    viewBox="0 0 310.806 310.806" xml:space="preserve" stroke="#ff0000">
                                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                        stroke-linejoin="round"></g>
                                                    <g id="SVGRepo_iconCarrier">
                                                        <path
                                                            d="M305.095,229.104L186.055,42.579c-6.713-10.52-18.172-16.801-30.652-16.801c-12.481,0-23.94,6.281-30.651,16.801 L5.711,229.103c-7.145,11.197-7.619,25.39-1.233,37.042c6.386,11.647,18.604,18.883,31.886,18.883h238.079 c13.282,0,25.5-7.235,31.888-18.886C312.714,254.493,312.24,240.301,305.095,229.104z M155.403,253.631 c-10.947,0-19.82-8.874-19.82-19.82c0-10.947,8.874-19.821,19.82-19.821c10.947,0,19.82,8.874,19.82,19.821 C175.223,244.757,166.349,253.631,155.403,253.631z M182.875,115.9l-9.762,65.727c-1.437,9.675-10.445,16.353-20.119,14.916 c-7.816-1.161-13.676-7.289-14.881-14.692l-10.601-65.597c-2.468-15.273,7.912-29.655,23.185-32.123 c15.273-2.468,29.655,7.912,32.123,23.185C183.284,110.192,183.268,113.161,182.875,115.9z">
                                                        </path>
                                                    </g>
                                                </svg>
                                               <p>
                                                Are you sure you want to delete 
                                                <span class="font-bold">{{ form.name }}</span>?
                                                This process cannot be undone.
                                               </p>
                                            </p>
                                            <!-- <p class="text-sm text-gray-600 mt-2">
                                                If you have any questions, feel free to reach out to our customer
                                                support team.
                                            </p> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white shadow-md mx-4"></div>
                            <div class="bg-gray-50  py-3 sm:px-6 flex justify-end">
                                <button type="button"
                                    class="mt-3 inline-flex justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                    @click="deleteDialog = false" ref="cancelButtonRef">No</button>
                                <button @click="deleteUser" :disabled="form.processing" type="button"
                                    class="rounded-md bg-red-600 px-3 py-2 text-sm  font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Delete</button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>