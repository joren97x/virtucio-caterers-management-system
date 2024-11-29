<script setup>

import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { useForm, Head, router } from '@inertiajs/vue3'
import { ref } from 'vue'

defineOptions({
    layout: AdminLayout
})

defineProps({
    categories: Object
})

const addFoodModal = ref(false)
const editDialog = ref(false)
const deleteDialog = ref(false)

const addCategoryModal = ref(false)

const form = useForm({
    name: '',
    description: '',
    price: 0,
    category: null,
    image_path: null,
    id: ''
})

const categoryForm = useForm({
    name: ''
})

const showEditDialog = (product) => {
    photoPreview.value = null
    console.log(product)
    form.name = product.name
    form.description = product.description
    form.id = product.id
    form.price = product.price
    form.category = product.category_id
    form.image_path = product.image_path
    editDialog.value = true
}

const showDeleteDialog = (product) => {
    form.name = product.name
    form.id = product.id
    deleteDialog.value = true
}

const submit = () => {
    form.post(route('admin.products.store'), {
        onSuccess: () => {
            form.reset()
            photoPreview.value = null
            addFoodModal.value = false
        }
    })
}

const update = () => {
    form.post(route('admin.products.update', form.id), {
        onSuccess: () => {
            editDialog.value = false
        }
    })
}

const deleteProduct = () => {
    form.delete(`/admin/products/${form.id}`, {
        onSuccess: () => {
            deleteDialog.value = false
        }
    })
    // router.get('/admin/dashboard')
}

const submitCategoryForm = () => {
    categoryForm.post(route('admin.categories.store'), {
        onSuccess: () => {
            categoryForm.reset()
            addCategoryModal.value = false
        }
    })
}

const formatCurrency = (amount) => {
    return `₱${parseFloat(amount).toLocaleString("en-US", { minimumFractionDigits: 2, })}`
}

const photoPreview = ref(null);

// const handlePhotoUpload = (event) => {
//   const file = event.target.files[0];
//   if (file) {
//     photo.value = file;
//     photoPreview.value = URL.createObjectURL(file);
//   }
// };

const handleCoverUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        photoPreview.value = URL.createObjectURL(file)
        form.image_path = file;
    }
};

</script>

<template>
    <Head title="Menu Management" />

    <div class="p-8 bg-white shadow rounded-lg">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">Menu Management</h2>
            </div>
            <div>
                <button @click="addCategoryModal = true"
                    class="px-4 py-2 mr-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-500">
                    Add Category
                </button>
                <button @click="addFoodModal = true"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-500">
                    Add Food
                </button>
            </div>
        </div>

        <div v-for="category in categories">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">{{ category.name }}</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 md:grid-cols-3 gap-6">
                <div v-for="food in category.products" :key="food.id"
                    class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow">
                    <!-- {{ food.image_path }} -->
                    <img :src="`/storage/${food.image_path}`" :alt="food.name"
                        class="h-32 w-full object-cover rounded-t-lg" />
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800">{{ food.name }}</h3>
                        <p class="text-sm text-gray-500">{{ food.description }}</p>
                        <div class="mt-4 flex items-center justify-between">
                            <!-- <span class="text-lg font-bold text-gray-900">{{ food.price }}</span> -->
                            <div class="space-x-2 justify-end flex">
                                <PrimaryButton @click="showEditDialog(food)">Edit</PrimaryButton>
                                <DangerButton @click="showDeleteDialog(food)">Delete</DangerButton>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div v-if="editDialog" class="fixed inset-0 z-10 flex items-center justify-center bg-gray-500 bg-opacity-75">
    <div class="bg-white w-full sm:max-w-lg p-6 rounded-lg shadow-xl">
      <h2 class="text-xl font-bold text-gray-800">Edit Food</h2>
      
      <!-- Form -->
      <div class="mt-4">
        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
        <input type="text" v-model="form.name"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
      </div>

      <div class="mt-4">
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <input type="text" v-model="form.description"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
      </div>

      <div class="mt-4">
        <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
        <select id="category" v-model="form.category"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
          <option v-for="category in categories" :key="category.id" :value="category.id">
            {{ category.name }}
          </option>
        </select>
      </div>

      <div class="mt-4">
        <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
        <div class="relative flex justify-center items-center border-2 border-dashed border-gray-300 rounded-md p-6">
          <input type="file" id="coverPhoto" class="absolute inset-0 opacity-0 cursor-pointer" @change="handleCoverUpload">
          <img :src="photoPreview" v-if="photoPreview" class="w-full h-full">
          <div v-else class="text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 mx-auto" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm3 10a1 1 0 100-2 1 1 0 000 2zm3-6a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
            </svg>
            <p class="mt-2 text-sm text-gray-600">
              <span class="text-indigo-600 font-medium">Upload a file</span> or drag and drop
            </p>
            <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
          </div>
        </div>
      </div>

      <div class="mt-6 flex justify-end space-x-4">
        <button @click="editDialog = false" class="inline-flex justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
          Cancel
        </button>
        <button @click="update" type="button" class="rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500">
          Update
        </button>
      </div>
    </div>
  </div>

    <TransitionRoot as="template" :show="addFoodModal">
        <Dialog class="relative z-10" @close="addFoodModal = false">
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
                                            <h2 class="text-xl font-bold text-gray-800">Add Food</h2>
                                            <p class="text-sm text-gray-600">
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste, delectus?
                                            </p>
                                        </div>
                                        <div class=" bg-white shadow-md">
                                            <div>
                                                <label for="website"
                                                    class="block text-sm font-medium text-gray-700">Name</label>
                                                <input type="url" v-model="form.name"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                            </div>
                                            <div>
                                                <label for="website"
                                                    class="block text-sm font-medium text-gray-700">Description</label>
                                                <input type="url" v-model="form.description"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                            </div>
                                            <div class="max-w-lg mx-auto">
                                                <label for="country"
                                                    class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                                <select id="country" v-model="form.category"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                                    <option v-for="category in categories" :key="category.id"
                                                        :value="category.id">
                                                        {{ category.name }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                                                <div
                                                    class="relative flex justify-center items-center border-2 border-dashed border-gray-300 rounded-md p-6">

                                                    <input type="file" id="coverPhoto"
                                                        class="absolute inset-0 opacity-0 cursor-pointer"
                                                        @change="handleCoverUpload" />
                                                    <img :src="photoPreview" v-if="photoPreview" class="w-full h-full">
                                                    <div class="text-center" v-else>
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-10 w-10 text-gray-400 mx-auto" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm3 10a1 1 0 100-2 1 1 0 000 2zm3-6a2 2 0 100-4 2 2 0 000 4z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        <p class="mt-2 text-sm text-gray-600">
                                                            <span class="text-indigo-600 font-medium">Upload a
                                                                file</span> or drag and drop
                                                        </p>
                                                        <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF up to 10MB
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 justify-end flex">

                                <button type="button"
                                    class="mt-3 inline-flex  justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                    @click="addFoodModal = false" ref="cancelButtonRef">Cancel</button>
                                <button @click="submit" type="button"
                                    class="rounded-md bg-green-600 px-3 py-2 text-sm  mr-5 font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Save</button>
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
                                            <h2 class="text-xl font-bold text-gray-800">Delete Product</h2>
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
                            <div class="bg-gray-50  py-3 sm:px-6 flex justify-end flex">
                                <button type="button"
                                    class="mt-3 inline-flex justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                    @click="deleteDialog = false" ref="cancelButtonRef">No</button>
                                <button @click="deleteProduct" :disabled="form.processing" type="button"
                                    class="rounded-md bg-red-600 px-3 py-2 text-sm  font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Delete</button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>

    <TransitionRoot as="template" :show="addCategoryModal">
        <Dialog class="relative z-10" @close="addCategoryModal = false">
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
                                            <h2 class="text-xl font-bold text-gray-800">Add Category</h2>
                                            <p class="text-sm text-gray-600">
                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste, delectus?
                                            </p>
                                        </div>
                                        <div class=" bg-white shadow-md">
                                            <div>
                                                <label for="website"
                                                    class="block text-sm font-medium text-gray-700">Name</label>
                                                <input type="url" v-model="categoryForm.name"
                                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6">

                                <button type="button"
                                    class="mt-3 inline-flex  justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto"
                                    @click="addCategoryModal = false" ref="cancelButtonRef">Cancel</button>
                                <button @click="submitCategoryForm" type="button"
                                    class="rounded-md bg-green-600 px-3 py-2 text-sm  mr-5 font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Save</button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>

</template>