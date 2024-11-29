<script setup>

import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { useForm, Head } from '@inertiajs/vue3'
import { ref } from 'vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import DangerButton from '@/Components/DangerButton.vue'

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
    add_on_category_id: '',
    id: '',
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

const editAddOnDialog = ref(false)
const deleteDialog = ref(false)
const showEditAddOnDialog = (add_on) => {
    updateForm.name = add_on.name
    updateForm.price = add_on.price
    updateForm.id = add_on.id
    updateForm.add_on_category_id = add_on.add_on_category_id
    editAddOnDialog.value = true
}

const showDeleteDialog = (add_on) => {
    deleteForm.add_on = add_on
    deleteDialog.value = true
}

const updateForm = useForm({
    name: '',
    price: 0,
    add_on_category_id: '',
    id: '',
})

const update = () => {
    console.log(route('admin.add_ons.update', updateForm.id));
    updateForm.put(route('admin.add_ons.update', updateForm.id), {
        onSuccess: () => {
            editAddOnDialog.value = false
        }
    })
}

const deleteForm = useForm({
    add_on: null
})

const deleteAddOn = () => {
    console.log(route('admin.add_ons.destroy', deleteForm.add_on.id));
    deleteForm.delete(route('admin.add_ons.destroy', deleteForm.add_on.id), {
        onSuccess: () => {
            deleteDialog.value = false
        }
    })
}


</script>

<template>
    <Head title="Add Ons" />
    <div class="p-8 bg-white shadow rounded-lg">
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Add-Ons Management</h2>
            <p class="text-sm text-gray-600">
                Manage add-on categories and items easily. Add or update items to customize offerings.
            </p>
        </div>
        <div class="flex space-x-4">
            <button
                @click="addAddOnCategoryDialog = true"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-500 focus:outline-none">
                Add Add-On Category
            </button>
            <button
                @click="addAddOnDialog = true"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-500 focus:outline-none">
                Add Add-On
            </button>
        </div>
    </div>
    <!-- Add-On Categories -->
    <div v-for="add_on_category in add_on_categories" :key="add_on_category.id" class="mb-8">
        <!-- Category Header -->
        <div class="flex items-center justify-between mb-4 border-b pb-2">
            <h3 class="text-xl font-semibold text-gray-800">{{ add_on_category.name }}</h3>
        </div>

        <!-- Add-Ons Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div v-for="add_on in add_on_category.add_ons" :key="add_on.id"
                class="bg-white border border-gray-200 rounded-lg shadow hover:shadow-lg transition-shadow">
                <div class="p-4">
                    <!-- Add-On Name -->
                    <h4 class="text-lg font-semibold text-gray-800">{{ add_on.name }}</h4>

                    <!-- Add-On Price -->
                    <div class="text-sm text-gray-600 mt-2">
                        <span class="font-semibold text-gray-800">Price:</span> ₱{{ add_on.price }}
                    </div>

                    <!-- Actions -->
                    <div class="mt-4 flex items-center justify-end space-x-2">
                        <PrimaryButton
                            @click="showEditAddOnDialog(add_on)"
                            class="px-3 py-1 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-500 focus:outline-none">
                            Edit
                        </PrimaryButton>
                        <!-- <DangerButton @click="showDeleteDialog(add_on)">Delete</DangerButton> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <TransitionRoot as="template" :show="addAddOnDialog">
        <Dialog class="relative z-10" @close="addAddOnDialog = false">
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
                                            <h2 class="text-xl font-bold text-gray-800">Add Add On</h2>
                                        </div>
                                        <div class=" bg-white shadow-md">
                                            <div>
                                                <label for="website"
                                                    class="block text-sm font-medium text-gray-700">Name</label>
                                                <input v-model="form.name"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                            </div>

                                            <div class="max-w-lg mx-auto">
                                                <label for="country"
                                                    class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                                <select id="country" v-model="form.add_on_category_id"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                                    <option v-for="category in add_on_categories" :key="category.id"
                                                        :value="category.id">
                                                        {{ category.name }}
                                                    </option>
                                                </select>
                                            </div>

                                            <div>
                                                <label for="price"
                                                    class="block text-sm font-medium leading-6 text-gray-900">Price</label>
                                                <div class="relative rounded-md shadow-sm">
                                                    <div
                                                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                                        <span class="text-gray-500 sm:text-sm">$</span>
                                                    </div>
                                                    <input v-model="form.price" type="text" name="price" id="price"
                                                        class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                                        placeholder="0.00" />

                                                </div>
                                            </div>
                                            <!-- Cover Photo Upload -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6">

                                <button type="button"
                                    class="mt-3 inline-flex  justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                    @click="addAddOnDialog = false" ref="cancelButtonRef">Cancel</button>
                                <button @click="submit" type="button"
                                    class="rounded-md bg-green-600 px-3 py-2 text-sm  mr-5 font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Save</button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>


    <TransitionRoot as="template" :show="addAddOnCategoryDialog">
        <Dialog class="relative z-10" @close="addAddOnCategoryDialog = false">
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
                                        <!-- <DialogTitle as="h3" class="text-base font-semibold leading-6 text-gray-900">Deactivate account</DialogTitle>
                    <div class="mt-2">
                      <p class="text-sm text-gray-500">Are you sure you want to deactivate your account? All of your data will be permanently removed. This action cannot be undone.</p>
                    </div> -->
                                        <div>
                                            <h2 class="text-xl font-bold text-gray-800">Add Add On Category</h2>
                                        </div>
                                        <div class=" bg-white shadow-md">
                                            <div>
                                                <label for="website"
                                                    class="block text-sm font-medium text-gray-700">Name</label>
                                                <input v-model="addOnCategoryForm.name"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6">

                                <button type="button"
                                    class="mt-3 inline-flex  justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                    @click="addAddOnCategoryDialog = false" ref="cancelButtonRef">Cancel</button>
                                <button @click="submitAddOnCategoryForm" type="button"
                                    class="rounded-md bg-green-600 px-3 py-2 text-sm  mr-5 font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Save</button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
    <TransitionRoot as="template" :show="editAddOnDialog">
        <Dialog class="relative z-10" @close="editAddOnDialog = false">
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
                                            <h2 class="text-xl font-bold text-gray-800">Edit Add On</h2>
                                            <p class="text-sm text-gray-600">
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste, delectus?
                                            </p>
                                        </div>
                                        <div class=" bg-white shadow-md">
                                            <div>
                                                <label for="website"
                                                    class="block text-sm font-medium text-gray-700">Name</label>
                                                <input v-model="updateForm.name"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                            </div>
                                            <div class="max-w-lg mx-auto">
                                                <label for="country"
                                                    class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                                <select id="country" v-model="updateForm.add_on_category_id"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                                    <option v-for="category in add_on_categories" :key="category.id"
                                                        :value="category.id">
                                                        {{ category.name }}
                                                    </option>
                                                </select>
                                            </div>

                                            <div>
                                                <label for="price"
                                                    class="block text-sm font-medium leading-6 text-gray-900">Price</label>
                                                <div class="relative rounded-md shadow-sm">
                                                    <div
                                                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                                        <span class="text-gray-500 sm:text-sm">$</span>
                                                    </div>
                                                    <input v-model="updateForm.price" type="text" name="price" id="price"
                                                        class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                                        placeholder="0.00" />

                                                </div>
                                            </div>
                                            <!-- Cover Photo Upload -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6">
                                <button type="button"
                                    class="mt-3 inline-flex  justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                    @click="editAddOnDialog = false" ref="cancelButtonRef">Cancel</button>
                                <button @click="update" type="button"
                                    class="rounded-md bg-green-600 px-3 py-2 text-sm  mr-5 font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Update</button>
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
                                            <h2 class="text-xl font-bold text-gray-800">Delete Add On</h2>
                                            <div class="text-sm text-gray-600 mt-4 flex border border-red-500 p-3">
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
                                               <div>
                                                Are you sure you want to delete 
                                                <span class="font-bold">{{ deleteForm.add_on.name }}</span>?
                                                This process cannot be undone.
                                               </div>
                                            </div>
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
                                <button @click="deleteAddOn" type="button"
                                    class="rounded-md bg-red-600 px-3 py-2 text-sm  font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Delete</button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>