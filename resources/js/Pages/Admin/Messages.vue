<script setup>

import AdminLayout from '@/Layouts/AdminLayout.vue'
import { Head } from '@inertiajs/vue3';
import { formatDate } from 'date-fns'
defineOptions({ layout: AdminLayout })
const props = defineProps({ messages: Object })

</script>
<template>
    <Head title="Contact Messages"/>
    <section class="bg-gray-50 min-h-screen p-6">
  <!-- Page Header -->
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Contact Messages</h1>
  </div>

  <!-- Messages Table -->
  <div class="bg-white shadow rounded-lg p-4">
    <table class="w-full table-auto border-collapse">
      <thead>
        <tr class="border-b bg-gray-100">
          <th class="text-left p-3 text-gray-600 font-semibold">Name</th>
          <th class="text-left p-3 text-gray-600 font-semibold">Email</th>
          <th class="text-left p-3 text-gray-600 font-semibold">Message</th>
          <th class="text-left p-3 text-gray-600 font-semibold">Date</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="message in messages"
          :key="message.id"
          class="border-b hover:bg-gray-50"
        >
          <td class="p-3 text-gray-800">{{ message.name }}</td>
          <td class="p-3 text-gray-800">{{ message.email }}</td>
          <td class="p-3 text-gray-800 truncate max-w-xs">{{ message.message }}</td>
          <td class="p-3 text-gray-800">{{ formatDate(message.created_at, 'PPpp') }}</td>
         
        </tr>
        <tr v-if="messages.length === 0">
          <td colspan="5" class="p-3 text-center text-gray-500">
            No messages received yet.
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</section>

</template>