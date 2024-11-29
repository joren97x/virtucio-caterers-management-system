<script setup>

import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { router, useForm, Head } from '@inertiajs/vue3'
import { computed, ref } from 'vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import DangerButton from '@/Components/DangerButton.vue'
import { formatDate } from 'date-fns'

defineOptions({ layout: AdminLayout })
const props = defineProps({
    expenses: Object,
    total_expenses: Object
})

const editExpenseDialog = ref(false)
const deleteDialog = ref(false)

const showEditExpenseDialog = (expense) => {
    form.category = expense.category
    form.amount = expense.amount
    form.date = expense.date
    form.quantity = expense.quantity
    form.id = expense.id
    editExpenseDialog.value = true
}

const showDeleteDialog = (expense) => {
    form.category = expense.category
    form.id = expense.id
    deleteDialog.value = true
}

const form = useForm({
    category: '',
    id: '',
    amount: '',
    description: '',
    date: '',
    quantity: 1,
});

const submit = () => {
    form.post(route('admin.expenses.store'), {
        onSuccess: () => {
            // addExpenseDialog.value = false
            form.reset()
        }
    })
}

const update = () => {
    form.put(route('admin.expenses.update', form.id,), {
        onSuccess: () => {
            editExpenseDialog.value = false
        }
    })
}

const deleteExpense = () => {
    console.log('hii')
    form.delete(route('admin.expenses.destroy', form.id), {
        onSuccess: () => {
            deleteDialog.value = false
        }
    })
}

// const dates = ref({
//     from: props.start_date,
//     to: props.end_date
// })

// const generate = () => {
//     router.visit(route('admin.expenses.index', dates.value))
// }

</script>

<template>
    <Head title="Expenses" />
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
                            <label for="category" class="text-sm font-medium text-gray-700">Item</label>
                            <input v-model="form.category" id="category" type="text"
                                class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                required />
                        </div>

                        <div>
                            <label for="amount" class="text-sm font-medium text-gray-700">Amount</label>
                            <input v-model="form.amount" id="amount" type="number" step="0.01"
                                class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                required />
                        </div>

                        <!-- <div class="col-span-2">
                            <label for="description" class="text-sm font-medium text-gray-700">Description</label>
                            <textarea v-model="form.description" id="description" rows="3"
                                class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        </div> -->
                        <div>
                            <label for="amount" class="text-sm font-medium text-gray-700">Quantity</label>
                            <input v-model="form.quantity" id="amount" type="number" step="0.01"
                                class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                required />
                        </div>

                        <div>
                            <label for="date" class="text-sm font-medium text-gray-700 mr-4">Date</label>
                            <br>
                            <input v-model="form.date" id="date" type="date"
                                class="w-1/3 px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                required />
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-500">Add
                            Expense</button>
                    </div>
                </form>
            </div>
            <div>
                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-4">Expenses</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white shadow-md rounded-lg">
                            <thead class="bg-gray-200">
                                <tr class="text-left text-gray-700">
                                    <th class="py-3 px-6">Item</th>
                                    <th class="py-3 px-6">Quantity</th>
                                    <th class="py-3 px-6">Unit Price</th>
                                    <th class="py-3 px-6">Total Amount</th>
                                    <th class="py-3 px-6">Date</th>
                                    <th class="py-3 px-6">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr 
                                    v-for="expense in expenses" 
                                    :key="expense.id" 
                                    class="border-b hover:bg-gray-100 transition duration-200"
                                >
                                    <td class="py-3 px-6 text-gray-800">{{ expense.category }}</td>
                                    <td class="py-3 px-6 text-gray-800">{{ expense.quantity }}</td>
                                    <td class="py-3 px-6 text-gray-800">₱{{ expense.amount }}</td>
                                    <td class="py-3 px-6 text-gray-800">₱{{ (expense.amount * expense.quantity) }}</td>
                                    <td class="py-3 px-6 text-gray-600">{{ expense.date }}</td>
                                    <td class="py-3 px-6 flex space-x-2">
                                        <button 
                                            @click="showEditExpenseDialog(expense)" 
                                            class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600"
                                        >
                                            Edit
                                        </button>
                                        <DangerButton 
                                            @click="showDeleteDialog(expense)"
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                                        >
                                            Delete
                                        </DangerButton>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="bg-gray-100 text-gray-800 font-bold">
                                    <td colspan="3" class="py-3 px-6 text-right">Total Expenses:</td>
                                    <td colspan="3" class="py-3 px-6">₱{{ total_expenses }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <TransitionRoot as="template" :show="editExpenseDialog">
        <Dialog class="relative z-10" @close="editExpenseDialog = false">
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
                                            <h2 class="text-xl font-bold text-gray-800 mb-4">Add Expense</h2>
                                        </div>
                                        <div class=" bg-white shadow-md">
                                            <div>
                                                <label for="website"
                                                    class="block text-sm font-medium text-gray-700">Item</label>
                                                <input v-model="form.category"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                            </div>
                                            <div>
                                                <label for="website"
                                                    class="block text-sm font-medium text-gray-700">Quantity</label>
                                                <input type="number" v-model="form.quantity"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                            </div>
                                            <div>
                                                <label for="price"
                                                    class="block text-sm font-medium leading-6 text-gray-900">Price</label>
                                                <div class="relative rounded-md shadow-sm">
                                                    <div
                                                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                                        <span class="text-gray-500 sm:text-sm">$</span>
                                                    </div>
                                                    <input v-model="form.amount" type="text" name="price" id="price"
                                                        class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                                        placeholder="0.00" />
                                                </div>
                                            </div>
                                            <div>
                                                <label for="price"
                                                    class="block text-sm font-medium leading-6 text-gray-900">Date</label>
                                                <div class="relative rounded-md shadow-sm">
                                                    <input v-model="form.date" id="amount" type="date" step="0.01"
                                                    class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                                    required />
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
                                    @click="editExpenseDialog = false" ref="cancelButtonRef">Cancel</button>
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
                                            <h2 class="text-xl font-bold text-gray-800">Delete Expense</h2>
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
                                                <span class="font-bold">{{ form.category }}</span>?
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
                                <button @click="deleteExpense" type="button"
                                    class="rounded-md bg-red-600 px-3 py-2 text-sm  font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Delete</button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>