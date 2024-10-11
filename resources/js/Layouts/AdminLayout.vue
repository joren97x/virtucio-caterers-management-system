
<script setup>
import { defineComponent } from 'vue';
import SidebarItem from './Components/SidebarItem.vue';

// Define a reusable component for sidebar team items
const SidebarTeam = defineComponent({
props: {
  name: String
},
template: `
  <div class="flex items-center space-x-3 hover:bg-gray-100 p-2 rounded-md cursor-pointer">
    <span class="h-6 w-6 rounded-full bg-gray-200 flex items-center justify-center text-sm font-medium text-gray-600">
      {{ name[0] }}
    </span>
    <span class="text-gray-700 font-medium">{{ name }}</span>
  </div>
`
});
</script>


<template>
    <div class="flex h-screen bg-gray-100">
      <!-- Sidebar -->
      <aside class="w-64 bg-white shadow-lg">
        <div class="flex items-center justify-center h-16 border-b">
          <img src="https://tailwindcss.com/img/logos/workcation-logo-indigo-500-mark.svg" alt="Logo" class="h-8 w-auto">
        </div>
        <nav class="px-4 py-6 space-y-6">
          <div class="space-y-1">
            <SidebarItem icon="home" label="Dashboard" badge="5" />
            <SidebarItem icon="user-group" label="Team" />
            <SidebarItem icon="folder" label="Projects" badge="12" />
            <SidebarItem icon="calendar" label="Calendar" badge="20+" />
            <SidebarItem icon="document" label="Documents" />
            <SidebarItem icon="chart-bar" label="Reports" />
          </div>
  
          <div>
            <h3 class="px-3 text-sm font-semibold text-gray-500 uppercase tracking-wider">
              Your teams
            </h3>
            <div class="mt-2 space-y-1">
              <SidebarTeam name="Heroicons" />
              <SidebarTeam name="Tailwind Labs" />
              <SidebarTeam name="Workcation" />
            </div>
          </div>
        </nav>
  
        <div class="flex items-center p-4 border-t">
          <img
            src="https://randomuser.me/api/portraits/men/1.jpg"
            alt="Profile"
            class="h-10 w-10 rounded-full"
          />
          <div class="ml-3">
            <p class="text-sm font-medium text-gray-900">Tom Cook</p>
          </div>
        </div>
      </aside>
  
      <!-- Main Content Area -->
      <main class="flex-1 p-6 bg-white">
        <!-- Content goes here -->
         <slot />
      </main>
    </div>
  </template>
  
  <style scoped>
  /* Add custom styles if needed */
  </style>
  