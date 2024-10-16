
<script setup>
import SidebarItem from './Components/SidebarItem.vue'
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue';

const toggleOrders = ref(false)
</script>


<template>
    <div class="flex h-screen bg-gray-100">
      <!-- Sidebar -->
      <aside class="w-64 bg-white shadow-lg">
        <div class="flex items-center justify-center h-16 border-b">
          <img src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=600" alt="Logo" class="h-8 w-auto">
        </div>
        <nav class="px-4 py-6 space-y-6">
          <div class="space-y-1">
            <SidebarItem icon="home" label="Dashboard" url="admin.dashboard" />
            <SidebarItem icon="chart-bar" url="admin.menu_management" label="Menu Management" />
            <!-- <SidebarItem icon="user-group" url="admin.orders.index" label="Order Management" @click="toggleOrders = !toggleOrders" /> -->
            <div class="mb-2">
              <button @click="toggleOrders = !toggleOrders" class="flex items-center justify-between w-full py-2 px-3 text-gray-600 rounded-md hover:bg-gray-100">
                <span class="text-gray-700 font-medium">Order Management</span>
                <span v-if="toggleOrders">▲</span>
                <span v-else>▼</span>
              </button>
              <div v-if="toggleOrders" class="ml-4">
                <SidebarItem icon="chart-bar" url="admin.orders.pending" label="Pending Orders" />
                <SidebarItem icon="chart-bar" url="admin.orders.confirmed" label="Confirmed Orders" />
                <SidebarItem icon="chart-bar" url="admin.orders.history" label="Order History" />
<!-- 
                <a href="#" class="block py-2 text-gray-600 hover:text-gray-800">Engineering</a>
                <a href="#" class="block py-2 text-gray-600 hover:text-gray-800">Human Resources</a>
                <a href="#" class="block py-2 text-gray-600 hover:text-gray-800">Customer Success</a> -->
              </div>
            </div>
            <!-- <SidebarItem icon="folder" url="admin.orders.history" label="Order History" badge="12" /> -->
            <SidebarItem icon="document" url="admin.users.index" label="User Management" />
            <SidebarItem icon="calendar" url="admin.sales" label="Sales" badge="20+" />
            <SidebarItem icon="calendar" url="admin.rates.index" label="Rates" />
            <SidebarItem icon="calendar" url="admin.add_ons.index" label="Add Ons" />
            <SidebarItem icon="document" url="admin.expenses.index" label="Expense" />
            <SidebarItem icon="document" url="admin.ingredients.index" label="Ingredients" />
          </div>
  
          <!-- <div>
            <h3 class="px-3 text-sm font-semibold text-gray-500 uppercase tracking-wider">
              Your teams
            </h3>
            <div class="mt-2 space-y-1">
              <SidebarTeam name="Heroicons" />
              <SidebarTeam name="Tailwind Labs" />
              <SidebarTeam name="Workcation" />
            </div>
          </div> -->
        </nav>
  
        <div class="flex items-center p-4 border-t absolute bottom-0">
          <img
            src="https://randomuser.me/api/portraits/men/1.jpg"
            alt="Profile"
            class="h-10 w-10 rounded-full"
          />
          <div class="ml-3">
            <p class="text-sm font-medium text-gray-900">Tom Cook</p>
          </div>
          <Link :href="route('logout')" method="post">
            <button>logout</button>
          </Link>
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
  