<script setup>
import { defineEmits } from 'vue'
const props = defineProps({
    product: Object,
    selected: Boolean
})

const emit = defineEmits(['clicked'])
</script>

<template>
    
    <div @click="emit('clicked')" 
    :class="['cursor-pointer border rounded-lg shadow-md hover:shadow-lg transition-all', 
          selected ? 'border-indigo-500' : 'border-gray-300']"
      
     class="rounded-lg">
    <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
        <img :src="`/storage/${product.image_path}`" :alt="product.name" class="h-56 w-full object-cover object-center group-hover:opacity-75" />
    </div>
    <div class="px-2 pb-2">
      <p class="mt-4 text-lg font-medium"> {{ product.name }}</p>
    <h3 class="mt-1 text-sm text-gray-700">{{ product.description }}</h3>
    </div>
</div>

</template>