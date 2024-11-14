<script setup>
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ref, computed } from 'vue'
import { useOrderStore } from '@/Stores/OrderStore';

const props = defineProps({ product: Object })
const dialog = ref(false)
const orderStore = useOrderStore()

const addToCart = () => {
    orderStore.form.main_dishes = props.product
    dialog.value = false
}

const isSelected = computed(() => {
    return orderStore.form.main_dishes.find((dish) => dish.id === props.product.id);
})

function toggleProduct() {
  const index = orderStore.form.main_dishes.findIndex(dish => dish.id === props.product.id);
  if (index > -1) {
    // Product exists, so remove it
    orderStore.form.main_dishes.splice(index, 1);
  } else {
    // Product does not exist, so check if the limit is reached
    if (orderStore.form.main_dishes.length < 5) {
        orderStore.form.main_dishes.push(props.product)
        dialog.value = false
    } else {
      // Optional: show a message or alert if the max limit is reached
      alert("You can select a maximum of 5 products.");
    }
  }
}

const removeFromCart = () => {
  const index = orderStore.form.main_dishes.findIndex(dish => dish.id === props.product.id);
  if (index > -1) {
    // Product exists, so remove it
    orderStore.form.main_dishes.splice(index, 1);
    dialog.value = false; // Optionally close the dialog after removal
  }
}

</script>

<template>

<div 
    class="cursor-pointer border p-4 rounded-lg shadow-md hover:shadow-lg"
    :class="{'border-indigo-600': isSelected, 'border-gray-300': isSelected}"
    @click="dialog = true"
>
    <!-- Image -->
    <img :src="product.image" alt="product image" class="w-full h-32 object-cover rounded-t-lg mb-3">
    
    <!-- product Name and Description -->
    <h3 class="text-xl font-semibold mb-2">{{ product.name }}</h3>
    <p class="text-sm text-gray-600">{{ product.description }}</p>
</div>
<!-- Dialog -->
<TransitionRoot as="template" :show="dialog">
    <Dialog @close="closeDialog" class="">
        <DialogOverlay class="fixed inset-0 bg-black opacity-30 " />
        <DialogPanel class="fixed inset-0 flex items-center justify-center p-6 ">
            <div class="bg-white rounded-lg shadow-lg max-w-sm w-full max-w-3xl">
                <img :src="`storage/${product.image}`" alt="">
                <div class="p-4">
                    <DialogTitle class="text-lg font-semibold ">{{ product.name }}</DialogTitle>
                    <p class="text-gray-600 mb-4">{{ product.description }}</p>
                    <div class="flex justify-end space-x-4">
                        <button @click="toggleProduct" class="bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-900" v-if="!isSelected">Add to cart</button>
                        <button @click="removeFromCart" class="bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-900" v-else>Remove from cart</button>
                        <button @click="dialog = false" class="bg-gray-300 text-gray-800 py-2 px-4 rounded-md hover:bg-gray-400">Cancel</button>
                    </div>
                </div>
            </div>
        </DialogPanel>
    </Dialog>
</TransitionRoot>

</template>