<script setup>

defineProps({
    icon: String,
    label: String,
    badge: String
})

</script>

<template>
    <div class="flex items-center space-x-3 hover:bg-gray-100 p-2 rounded-md cursor-pointer">
      <span class="material-icons-outlined text-gray-500">{{ icon }}</span>
      <span class="text-gray-700 font-medium">{{ label }}</span>
      <span v-if="badge" class="ml-auto text-sm text-gray-500 bg-gray-200 rounded-full px-2 py-0.5">{{ badge }}</span>
    </div>
</template>