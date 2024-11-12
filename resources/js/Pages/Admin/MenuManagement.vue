<script setup>

import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

defineOptions({
    layout: AdminLayout
})

defineProps({
    categories: Object
})

const addFoodModal = ref(false)
const addCategoryModal = ref(false)
const form = useForm({
    name: '',
    desc: '',
    price: 0,
    category: null,
    image_path: null
})

const categoryForm = useForm({
    name: ''
})

const submit = () => {
    form.post(route('admin.products.store'), {
        onSuccess: () => {
            form.reset()
            photoPreview.value = null
            addFoodModal.value = false
        }
    })
}

const submitCategoryForm = () => {
    categoryForm.post(route('admin.categories.store'), {
        onSuccess: () => {
            categoryForm.reset()
            addCategoryModal.value = false
        }
    })
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
     <div class="p-8 bg-white shadow rounded-lg">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Menu Management</h2>
                <p class="text-sm text-gray-600">
                    A list of all the users in your account including their name, title, email, and role.
                </p>
            </div>
            <div>
                <button @click="addCategoryModal = true" class="px-4 py-2 mr-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-500">
                Add Category
            </button>
            <button @click="addFoodModal = true" class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-500">
                Add Food
            </button>
            </div>
        </div>

        <!-- {{ categories[0].products }} -->

        <div  v-for="category in categories">
        <div class="flex items-center justify-between mb-4">
      <h2 class="text-xl font-bold text-gray-800">{{ category.name }}</h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 md:grid-cols-3 gap-6">
      <div
        v-for="food in category.products"
        :key="food.id"
        class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow"
      >
      <!-- {{ food.image_path }} -->
        <img :src="`/storage/${food.image_path}`" :alt="food.name" class="h-32 w-full object-cover rounded-t-lg" />
        <div class="p-4">
          <h3 class="text-lg font-semibold text-gray-800">{{ food.name }}</h3>
          <!-- <p class="text-sm text-gray-500">{{ food.desc }}</p> -->
          <div class="mt-4 flex items-center justify-between">
            <!-- <span class="text-lg font-bold text-gray-900">{{ food.price }}</span> -->
            <div>
                <button
              class="px-3 py-1 mr-2 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-500"
            >
              Edit
            </button>
            <button
              class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-indigo-500"
            >
              Delete
            </button>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
    <!-- <div class="flex items-center justify-between my-4">
      <h2 class="text-xl font-bold text-gray-800">Desserts</h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 md:grid-cols-3 gap-6">
      <div
        v-for="item in appetizers"
        :key="item.id"
        class="bg-white rounded-lg shadow hover:shadow-lg transition-shadow"
      >
        <img :src="item.image" :alt="item.name" class="h-32 w-full object-cover rounded-t-lg" />
        <div class="p-4">
          <h3 class="text-lg font-semibold text-gray-800">{{ item.name }}</h3>
          <p class="text-sm text-gray-500">{{ item.description }}</p>
          <div class="mt-4 flex items-center justify-between">
            <span class="text-lg font-bold text-gray-900">{{ item.price }}</span>
            <div>
                <button
              class="px-3 py-1 mr-2 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-500"
            >
              Edit
            </button>
            <button
              class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-indigo-500"
            >
              Delete
            </button>
            </div>
          </div>
        </div>
      </div>
    </div> -->



    </div>

    <TransitionRoot as="template" :show="addFoodModal">
    <Dialog class="relative z-10" @close="addFoodModal = false">
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
                <h2 class="text-xl font-bold text-gray-800">Add Food</h2>
                <p class="text-sm text-gray-600">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste, delectus?
                </p>
            </div>
                    <div class=" bg-white shadow-md">
    <div>
      <label for="website" class="block text-sm font-medium text-gray-700">Name</label>
      <input
        type="url"
        v-model="form.name"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
      />
    </div>

    <!-- <div>
      <label for="about" class="block text-sm font-medium text-gray-700">Description</label>
      <textarea
        id="about"
        rows="3"
        v-model="form.desc"
        placeholder="Write a few sentences about the food."
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
      ></textarea>
    </div> -->

    <div class="max-w-lg mx-auto">
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
  </div>

    <!-- <div>
                    <label for="price" class="block text-sm font-medium leading-6 text-gray-900">Price</label>
                    <div class="relative rounded-md shadow-sm">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <span class="text-gray-500 sm:text-sm">$</span>
                    </div>
                    <input v-model="form.price" type="text" name="price" id="price" class="block w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="0.00" />
                    
                    </div>
                </div> -->
    <!-- Cover Photo Upload -->
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">Image</label>
      <div
        class="relative flex justify-center items-center border-2 border-dashed border-gray-300 rounded-md p-6"
      >

        <input
          type="file"
          id="coverPhoto"
          class="absolute inset-0 opacity-0 cursor-pointer"
          @change="handleCoverUpload"
        />
      <img :src="photoPreview" v-if="photoPreview" class="w-full h-full">
        <div class="text-center" v-else>
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-10 w-10 text-gray-400 mx-auto"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm3 10a1 1 0 100-2 1 1 0 000 2zm3-6a2 2 0 100-4 2 2 0 000 4z"
              clip-rule="evenodd"
            />
          </svg>
          <p class="mt-2 text-sm text-gray-600">
            <span class="text-indigo-600 font-medium">Upload a file</span> or drag and drop
          </p>
          <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
        </div>
      </div>
    </div>
  </div>
                  </div>
                </div>
              </div>
              <div class="bg-gray-50 px-4 py-3 sm:px-6">
                
                <button type="button" class="mt-3 inline-flex  justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="open = false" ref="cancelButtonRef">Cancel</button>
                <button @click="submit" type="button" class="rounded-md bg-green-600 px-3 py-2 text-sm  mr-5 font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto" >Save</button>
            </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>

  <TransitionRoot as="template" :show="addCategoryModal">
    <Dialog class="relative z-10" @close="addCategoryModal = false">
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
                <h2 class="text-xl font-bold text-gray-800">Add Category</h2>
                <p class="text-sm text-gray-600">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste, delectus?
                </p>
            </div>
                    <div class=" bg-white shadow-md">
    <div>
      <label for="website" class="block text-sm font-medium text-gray-700">Name</label>
      <input
        type="url"
        v-model="categoryForm.name"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
      />
    </div>
  </div>
                  </div>
                </div>
              </div>
              <div class="bg-gray-50 px-4 py-3 sm:px-6">
                
                <button type="button" class="mt-3 inline-flex  justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="addCategoryModal = false" ref="cancelButtonRef">Cancel</button>
                <button @click="submitCategoryForm" type="button" class="rounded-md bg-green-600 px-3 py-2 text-sm  mr-5 font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto" >Save</button>
            </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
  
</template>