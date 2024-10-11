
<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import FoodDialog from './Components/FoodDialog.vue';

defineOptions({
    layout: AuthenticatedLayout
})

const products = [
  {
    id: 1,
    name: 'Earthen Bottle',
    href: '#',
    price: '$48',
    imageSrc: 'https://tailwindui.com/plus/img/ecommerce-images/category-page-04-image-card-01.jpg',
    imageAlt: 'Tall slender porcelain bottle with natural clay textured body and cork stopper.',
  },
  {
    id: 2,
    name: 'Nomad Tumbler',
    href: '#',
    price: '$35',
    imageSrc: 'https://tailwindui.com/plus/img/ecommerce-images/category-page-04-image-card-02.jpg',
    imageAlt: 'Olive drab green insulated bottle with flared screw lid and flat top.',
  },
  {
    id: 3,
    name: 'Focus Paper Refill',
    href: '#',
    price: '$89',
    imageSrc: 'https://tailwindui.com/plus/img/ecommerce-images/category-page-04-image-card-03.jpg',
    imageAlt: 'Person using a pen to cross a task off a productivity paper card.',
  },
  {
    id: 4,
    name: 'Machined Mechanical Pencil',
    href: '#',
    price: '$35',
    imageSrc: 'https://tailwindui.com/plus/img/ecommerce-images/category-page-04-image-card-04.jpg',
    imageAlt: 'Hand holding black machined steel mechanical pencil with brass tip and top.',
  },
  // More products...
]

const notificationOptions = [
  {
    value: 'comments',
    label: '30 pax',
    description: '1 lollipop, 2 sabon',
    checked: false,
  },
  {
    value: 'candidates',
    label: '60 pax',
    description: '5 happy meals, 2 toblerone, 1 ice water',
    checked: false,
  },
  {
    value: 'offers',
    label: '100 pax',
    description: 'Get notified when a candidate accepts or rejects an offer.',
    checked: false,
  },
]

</script>

<template>
    <div class="bg-white">
      <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
        <div class="text-h6 text-center">Virtucio Rates</div>
        <div class="p-4 space-y-4 border-solid border-2">
    <div v-for="(option, index) in notificationOptions" :key="index" class="relative flex items-start space-x-3">
      <input
        type="checkbox"
        :id="option.value"
        v-model="option.checked"
        class="mt-1 h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
      />
      <div>
        <label :for="option.value" class="font-medium text-gray-700">{{ option.label }}</label>
        <p class="text-sm text-gray-500">{{ option.description }}</p>
      </div>
      <div class="absolute top-0 right-0 h-16 ">P23, 000.00</div>
    </div>
  </div>
        <h2 class="text-center">Food Menu</h2>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-4" >
          <div class="qa-10 bg-yellow" style="background-color: red;" v-for="n in 5">
            hi
          </div>
        </div>
        <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
          <a v-for="product in products" :key="product.id" :href="product.href" class="group">
            <FoodDialog :product="product" />
          </a>
        </div>
      </div>
    </div>
  </template>
  