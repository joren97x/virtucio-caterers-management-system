<script setup>
import { ref } from 'vue';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { useForm } from '@inertiajs/vue3';


defineProps({ add_on: Object })

const dialog = ref(false)
const form = useForm({})

</script>
<template>
    <button @click="dialog = true">Delete</button>
    {{ dialog }}
    <TransitionRoot as="template" :show="dialog">
    <Dialog class="relative z-10" @close="dialog = false">
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
                <h2 class="text-xl font-bold text-gray-800">Delete Add On</h2>
                <p class="text-sm text-gray-600">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste, delectus?
                </p>
            </div>
                    <div class=" bg-white shadow-md">
  </div>
                  </div>
                </div>
              </div>
              <div class="bg-gray-50 px-4 py-3 sm:px-6">
                
                <button type="button" class="mt-3 inline-flex  justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="addAddOnCategoryDialog = false" ref="cancelButtonRef">Cancel</button>
                <button @click="submitAddOnCategoryForm" type="button" class="rounded-md bg-green-600 px-3 py-2 text-sm  mr-5 font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto" >Delete</button>
            </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>