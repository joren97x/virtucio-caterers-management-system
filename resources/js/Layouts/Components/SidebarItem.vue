<script setup>

import { Link } from '@inertiajs/vue3'

defineProps({
    icon: String,
    label: String,
    badge: String,
    url: String,
    isActive: {
        default: false,
        tyle: Boolean
    }
})

</script>

<template>
    <Link :href="route(url)" :class="[
            isActive ? 'bg-gray-200 text-gray-800 font-bold' : ''
        ]">
        <div :class="`flex items-center space-x-3 hover:bg-gray-100 p-2 rounded-md cursor-pointer ${isActive ? 'bg-gray-200' : ''}`">
            <!-- <span class="material-icons-outlined text-gray-500">{{ icon }}</span> -->
            <span class="text-gray-700 font-medium">{{ label }}</span>
            <span v-if="badge" class="ml-auto text-sm text-gray-500 bg-gray-200 rounded-full px-2 py-0.5">{{ badge }}</span>
        </div>
    </Link>
</template>