<script setup>
import SidebarItem from './Components/SidebarItem.vue'
import { Link, Head } from '@inertiajs/vue3'
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const toggleOrders = ref(false)
const currentRoute = computed(() => usePage().props.value?.ziggy?.location.name)
</script>

<template>
    <div class="flex h-screen bg-gray-100">
        <aside class="w-64 bg-white shadow-lg fixed h-screen">
            <div class="flex items-center justify-center h-16 border-b">
                <Link :href="route('home')" class="-m-1.5 p-1.5">
                    <span class="sr-only">Your Company</span>
                    <div class="flex">
                        <img class="h-8 w-auto" src="/logo.png" alt="">
                        <img class="h-8 w-auto" src="/logo-name.png" alt="">
                    </div>
                </Link>
            </div>
            <nav class="px-4 py-6 space-y-6">
                <div class="space-y-1">
                    <!-- Highlight Active Sidebar Items -->
                    <SidebarItem
                        icon="home"
                        label="Dashboard"
                        url="admin.dashboard"
                        :isActive="$page.component === 'Admin/Dashboard'"
                    />
                    <SidebarItem
                        icon="chart-bar"
                        label="Menu Management"
                        url="admin.menu_management"
                        :isActive="$page.component === 'Admin/MenuManagement'"
                    />

                    <div class="mb-2">
                        <!-- Highlight Active and Toggle Orders -->
                        <button
                            @click="toggleOrders = !toggleOrders"
                            :class="isOrderManagementActive ? 'bg-gray-200' : ''"
                            class="flex items-center justify-between w-full py-2 px-3 text-gray-600 rounded-md hover:bg-gray-100"
                        >
                            <span class="text-gray-700 font-medium">Order Management</span>
                            <span v-if="toggleOrders">▲</span>
                            <span v-else>▼</span>
                        </button>
                        <div v-if="toggleOrders" class="ml-4">
                            <SidebarItem
                                icon="chart-bar"
                                label="Pending Orders"
                                url="admin.orders.pending"
                                :isActive="$page.component === 'Admin/PendingOrders'"
                            />
                            <SidebarItem
                                icon="chart-bar"
                                label="Confirmed Orders"
                                url="admin.orders.confirmed"
                                :isActive="$page.component === 'Admin/ConfirmedOrders'"
                            />
                            <SidebarItem
                                icon="chart-bar"
                                label="Cancelled Orders"
                                url="admin.orders.cancelled"
                                :isActive="$page.component === 'Admin/CancelledOrders'"
                            />
                            <SidebarItem
                                icon="chart-bar"
                                label="Order History"
                                url="admin.orders.history"
                                :isActive="$page.component === 'Admin/OrderHistory'"
                            />
                        </div>
                    </div>

                    <!-- Other Sidebar Items -->
                    <SidebarItem
                        icon="document"
                        url="admin.users.index"
                        label="User Management"
                        :isActive="$page.component === 'Admin/UserManagement'"
                    />
                    <SidebarItem
                        icon="calendar"
                        url="admin.sales"
                        label="Sales"
                        :isActive="$page.component === 'Admin/Sales'"
                    />
                    <SidebarItem
                        icon="calendar"
                        url="admin.rates.index"
                        label="Rates"
                        :isActive="$page.component === 'Admin/Rates'"
                    />
                    <SidebarItem
                        icon="calendar"
                        url="admin.add_ons.index"
                        label="Add Ons"
                        :isActive="$page.component === 'Admin/AddOns'"
                    />
                    <SidebarItem
                        icon="document"
                        url="admin.expenses.index"
                        label="Expense"
                        :isActive="$page.component === 'Admin/Expenses'"
                    />
                    <SidebarItem
                        icon="document"
                        url="admin.messages.index"
                        label="Messages"
                        :isActive="$page.component === 'Admin/Messages'"
                    />
                </div>
            </nav>

            <div class="flex items-center p-4 border-t absolute bottom-0 w-full">
                <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="Profile" class="h-10 w-10 rounded-full" />
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">{{ $page.props.auth.user.name }}</p>
                    <p class="text-xs font-medium text-gray-900">{{ $page.props.auth.user.email }}</p>
                </div>
                <Link :href="route('logout')" method="post" class="absolute right-0 text-red-500 mr-4">
                    <button>Logout</button>
                </Link>
            </div>
            
        </aside>

        <main class="ml-64 flex-1 bg-white overflow-y-auto">
            <slot />
        </main>
    </div>
</template>
