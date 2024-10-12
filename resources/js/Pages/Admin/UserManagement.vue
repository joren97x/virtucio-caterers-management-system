
<script setup>

import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref } from 'vue'

defineOptions({
    layout: AdminLayout
})

const users = ref([
  {
    name: 'Lindsay Walton',
    email: 'lindsay.walton@example.com',
    title: 'Front-end Developer',
    department: 'Optimization',
    status: 'Active',
    role: 'Member',
    avatar: 'https://randomuser.me/api/portraits/women/1.jpg',
  },
  {
    name: 'Courtney Henry',
    email: 'courtney.henry@example.com',
    title: 'Designer',
    department: 'Intranet',
    status: 'Active',
    role: 'Admin',
    avatar: 'https://randomuser.me/api/portraits/women/2.jpg',
  },
  {
    name: 'Tom Cook',
    email: 'tom.cook@example.com',
    title: 'Director of Product',
    department: 'Directives',
    status: 'Active',
    role: 'Member',
    avatar: 'https://randomuser.me/api/portraits/men/3.jpg',
  },
  {
    name: 'Whitney Francis',
    email: 'whitney.francis@example.com',
    title: 'Copywriter',
    department: 'Program',
    status: 'Active',
    role: 'Admin',
    avatar: 'https://randomuser.me/api/portraits/women/3.jpg',
  },
  {
    name: 'Leonard Krasner',
    email: 'leonard.krasner@example.com',
    title: 'Senior Designer',
    department: 'Mobility',
    status: 'Active',
    role: 'Owner',
    avatar: 'https://randomuser.me/api/portraits/men/4.jpg',
  },
  {
    name: 'Floyd Miles',
    email: 'floyd.miles@example.com',
    title: 'Principal Designer',
    department: 'Security',
    status: 'Active',
    role: 'Member',
    avatar: 'https://randomuser.me/api/portraits/men/5.jpg',
  },
]);
</script>


<template>
    <div class="p-8 bg-white shadow rounded-lg">
      <div class="flex items-center justify-between mb-4">
        <div>
          <h2 class="text-xl font-bold text-gray-800">Users</h2>
          <p class="text-sm text-gray-600">
            A list of all the users in your account including their name, title, email, and role.
          </p>
        </div>
        <button
          class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-500"
        >
          Add user
        </button>
      </div>
  
      <table class="min-w-full bg-white">
        <thead>
          <tr>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Name</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Title</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Status</th>
            <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Role</th>
            <th class="px-6 py-3 text-right text-sm font-medium text-gray-500"></th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <tr v-for="user in users" :key="user.email">
            <td class="px-6 py-4 flex items-center">
              <img :src="user.avatar" alt="Avatar" class="h-10 w-10 rounded-full mr-4" />
              <div>
                <p class="text-sm font-medium text-gray-900">{{ user.name }}</p>
                <p class="text-sm text-gray-500">{{ user.email }}</p>
              </div>
            </td>
            <td class="px-6 py-4">
              <p class="text-sm text-gray-900">{{ user.title }}</p>
              <p class="text-sm text-gray-500">{{ user.department }}</p>
            </td>
            <td class="px-6 py-4">
              <span class="inline-flex items-center px-2 py-0.5 rounded text-sm font-medium"
                :class="user.status === 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
                {{ user.status }}
              </span>
            </td>
            <td class="px-6 py-4 text-sm text-gray-900">{{ user.role }}</td>
            <td class="px-6 py-4 text-right">
              <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  