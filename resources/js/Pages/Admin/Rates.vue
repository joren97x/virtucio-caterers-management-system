<script setup>

import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { useForm, Head } from '@inertiajs/vue3'
import { ref } from 'vue'

defineOptions({ layout: AdminLayout })
defineProps({ rates: Object })

const addRateDialog = ref(false)
const editDialog = ref(false)
const deleteDialog = ref(false)

const showEditDialog = (rate) => {
    console.log(rate)
    form.pax = rate.pax
    form.price = rate.price
    form.instructions = rate.instructions
    form.id = rate.id
    editDialog.value = true
}

const showDeleteDialog = (add_on) => {
    form.pax = add_on.pax
    form.id = add_on.id
    deleteDialog.value = true
}

const form = useForm({
    pax: '',
    price: 0,
    instructions: `1 Soup wt FREE cruotions
        5 Main Dishes
        1 Dessert Or Salad
        Package with rice and one round of softdrink`,
    id: ''
    })

const submit = () => {
    form.post(route('admin.rates.store'), {
        onSuccess: () => {
            addRateDialog.value = false
        }
    })
}

const update = () => {
    form.put(route('admin.rates.update', form.id), {
        onSuccess: () => {
            editDialog.value = false
        }
    })
}

const deleteRate = () => {
    form.delete(route('admin.rates.destroy', form.id), {
        onSuccess: () => {
            deleteDialog.value = false
        }
    })
}

const formatCurrency = (amount) => {
    return `₱${parseFloat(amount).toLocaleString("en-US", { minimumFractionDigits: 2, })}`
}

</script>

<template>
    <Head title="Rates" />
    
    <div class="p-8 bg-white shadow rounded-lg">
        <!-- Header Section -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Virtucio Rates</h2>
                <p class="text-sm text-gray-600">
                    Manage and update the rates for various pax sizes easily. Ensure accurate pricing for each event.
                </p>
            </div>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-500 focus:outline-none"
                @click="addRateDialog = true">
                Add Rate
            </button>
        </div>

        <!-- Rates Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Pax</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Price</th>
                        <th class="px-6 py-3 text-right text-sm font-medium text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr v-for="rate in rates" :key="rate.id">
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-900">{{ rate.pax }} Pax</p>
                            <p class="text-sm text-gray-500" style="white-space: pre-line;">{{ rate.instructions }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-sm font-medium bg-green-100 text-green-800">
                                <!-- ₱{{ rate.price }} -->
                                {{ formatCurrency(rate.price) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right  space-x-2">
                            <PrimaryButton @click="showEditDialog(rate)">Edit</PrimaryButton>
                            <DangerButton @click="showDeleteDialog(rate)">Delete</DangerButton>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    <TransitionRoot as="template" :show="addRateDialog">
        <Dialog class="relative z-10" @close="addRateDialog = false">
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

                                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                        <div>
                                            <h2 class="text-2xl font-bold text-gray-800">Add Rate</h2>
                                        </div>
                                        <div class="bg-white shadow-md rounded-lg">
                                            <!-- Pax Field -->
                                            <div class="mb-4">
                                                <label for="pax"
                                                    class="block text-sm font-medium text-gray-700">Pax</label>
                                                <input type="number" id="pax" v-model="form.pax"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                                    placeholder="Enter the number of pax" required />
                                            </div>

                                            <!-- Instructions / Freebies Field -->
                                            <div class="mb-4">
                                                <label for="instructions"
                                                    class="block text-sm font-medium text-gray-700">Instructions/Freebies</label>
                                                <textarea id="instructions" rows="4" v-model="form.instructions"
                                                    placeholder="Describe the instructions or any freebies"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                                    required></textarea>
                                            </div>

                                            <!-- Price Field -->
                                            <div class="mb-4">
                                                <label for="price"
                                                    class="block text-sm font-medium text-gray-700">Price</label>
                                                <div class="relative rounded-md shadow-sm">
                                                    <div
                                                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                                        <span class="text-gray-500 sm:text-sm">₱</span>
                                                    </div>
                                                    <input v-model="form.price" type="text" id="price" name="price"
                                                        class="block w-full rounded-md border-0 py-2 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                                        placeholder="0.00" required />
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 justify-end flex">

                                <button type="button"
                                    class="mt-3 inline-flex  justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                    @click="addRateDialog = false" ref="cancelButtonRef">Cancel</button>
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

                                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                        <div>
                                            <h2 class="text-2xl font-bold text-gray-800">Add Rate</h2>
                                        </div>
                                        <div class="bg-white shadow-md rounded-lg">
                                            <!-- Pax Field -->
                                            <div class="mb-4">
                                                <label for="pax"
                                                    class="block text-sm font-medium text-gray-700">Pax</label>
                                                <input type="number" id="pax" v-model="form.pax"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                                    placeholder="Enter the number of pax" required />
                                            </div>

                                            <!-- Instructions / Freebies Field -->
                                            <div class="mb-4">
                                                <label for="instructions"
                                                    class="block text-sm font-medium text-gray-700">Instructions/Freebies</label>
                                                <textarea id="instructions" rows="4" v-model="form.instructions"
                                                    placeholder="Describe the instructions or any freebies"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                                    required></textarea>
                                            </div>

                                            <!-- Price Field -->
                                            <div class="mb-4">
                                                <label for="price"
                                                    class="block text-sm font-medium text-gray-700">Price</label>
                                                <div class="relative rounded-md shadow-sm">
                                                    <div
                                                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                                        <span class="text-gray-500 sm:text-sm">₱</span>
                                                    </div>
                                                    <input v-model="form.price" type="text" id="price" name="price"
                                                        class="block w-full rounded-md border-0 py-2 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                                        placeholder="0.00" required />
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 justify-end flex">

                                <button type="button"
                                    class="mt-3 inline-flex  justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                    @click="editDialog = false" ref="cancelButtonRef">Cancel</button>
                                <button @click="update" :disabled="form.processing" type="button"
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
                                            <h2 class="text-xl font-bold text-gray-800">Delete Rate</h2>
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
                                                <span class="font-bold">{{ form.pax }} Pax</span>?
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
                                <button @click="deleteRate" :disabled="form.processing" type="button"
                                    class="rounded-md bg-red-600 px-3 py-2 text-sm  font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Delete</button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>

</template>