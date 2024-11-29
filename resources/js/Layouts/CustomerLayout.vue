<script setup>
import { Head, Link } from '@inertiajs/vue3'
import { ref } from 'vue'

const dropdownOpen = ref(false)
const menu = ref(false)

const links = [
    { name: 'Home', route: 'home' },
    { name: 'Menu', route: 'menu' },
    { name: 'About Us', route: 'about' },
    { name: 'Blog', route: 'blog' },
    { name: 'Contact', route: 'contact' },
]

</script>

<template>

    <Head title="Welcome" />
    <div>
        <header class="sticky top-0 bg-white shadow z-max z-50">
            <nav class="flex items-center justify-between p-4 lg:px-8" aria-label="Global">
                <div class="flex lg:flex-1">
                    <Link :href="route('home')" class="-m-1.5 p-1.5">
                        <span class="sr-only">Your Company</span>
                        <div class="flex">
                            <img class="h-8 w-auto" src="logo.png" alt="">
                            <img class="h-8 w-auto" src="logo-name.png" alt="">
                        </div>
                    </Link>
                </div>
                <div class="flex lg:hidden">
                    <button type="button"
                        @click="menu = true"
                        class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            aria-hidden="true" data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                </div>
                <div class="hidden lg:flex lg:gap-x-12">
                    <Link :href="route(link.route)" v-for="link in links" class="text-sm font-semibold leading-6 text-gray-900">{{ link.name }}</Link>
                </div>
                <div class="hidden lg:flex lg:flex-1 lg:justify-end">
                    <template v-if="$page.props.auth.user">
                        <Link class="relative mr-4 text-gray-500 hover:text-gray-700 focus:outline-none" href="/orders">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                        </Link>

                        <!-- User Profile Dropdown -->
                        <div class="relative">
                            <button @click="dropdownOpen = !dropdownOpen"
                                class="flex items-center text-gray-500 focus:outline-none focus:text-gray-700">
                                <!-- User Avatar -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>

                            </button>

                            <!-- Dropdown Menu -->
                            <div v-if="dropdownOpen" @click.away="dropdownOpen = false"
                                class="absolute  right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg py-1 z-20">
                                <Link href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Your Profile
                                </Link>
                                <Link :href="route('logout')" method="POST">
                                <button
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign
                                    out</button>
                                </Link>
                            </div>
                        </div>
                    </template>
                    <template v-else>
                        <Link :href="route('register')" class="text-sm font-semibold leading-6 text-gray-900 pr-5">
                        Register</Link>
                        <Link :href="route('login')" class="text-sm font-semibold leading-6 text-gray-900">Log in <span
                            aria-hidden="true">&rarr;</span></Link>
                    </template>
                </div>
            </nav>
            <!-- Mobile menu, show/hide based on menu open state. -->
            <div class="lg:hidden" role="dialog" aria-modal="true" v-if="menu">
                <div class="fixed inset-0 z-50"></div>
                <div
                    class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white p-4 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                    <div class="flex items-center justify-between">
                        <Link :href="route('home')" class="-m-1.5 p-1.5">
                            <span class="sr-only">Your Company</span>
                            <div class="flex">
                                <img class="h-8 w-auto" src="logo.png" alt="">
                                <img class="h-8 w-auto" src="logo-name.png" alt="">
                            </div>
                        </Link>
                        <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700" @click="menu = false">
                            <span class="sr-only">Close menu</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true" data-slot="icon">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="mt-6 flow-root">
                        <div class="-my-6 divide-y divide-gray-500/10">
                            <div class="space-y-2 py-6">
                                <Link href="/profile"
                                    class="-mx-3 block flex rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6 mr-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                                    Profile
                                </Link>
                                <Link :href="route('orders.index')"
                                    class="-mx-3 block flex rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="size-6 mr-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                    </svg>
                                    Orders
                                </Link>
                                <hr>
                                <Link :href="route(link.route)"
                                    v-for="link in links"
                                    @click="menu = false"
                                    class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">
                                    {{ link.name }}
                                </Link>
                            </div>
                            <div class="py-6" v-if="!$page.props.auth.user">
                                <Link :href="route('register')"
                                    class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">
                                Register</Link>
                                <Link :href="route('login')"
                                    class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">
                                Log in</Link>
                            </div>
                            <div v-else>
                                <Link :href="route('logout')" method="POST"
                                class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-red-500 hover:bg-gray-50">
                                    Sign out
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="bg-gray-100 ">
            <slot />
        </div>
    </div>
    <footer class="bg-gray-800 text-white py-8">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap justify-between items-center">
          <!-- Left Column (Logo and Company Info) -->
          <div class="flex items-center space-x-4">
            <img class="h-8 w-auto" src="logo.png" alt="Company Logo" />
            <span class="text-xl font-semibold">Virtucio Caterers</span>
          </div>

          <!-- Right Column (Social Links) -->
          <div class="flex space-x-6">
            <a href="#" class="text-gray-400 hover:text-white">Facebook</a>
            <a href="#" class="text-gray-400 hover:text-white">Twitter</a>
            <a href="#" class="text-gray-400 hover:text-white">Instagram</a>
          </div>
        </div>

        <div class="mt-6 border-t border-gray-700 pt-4 text-center text-sm">
          <p>© 2024 Virtucio Caterers. All rights reserved.</p>
        </div>
      </div>
    </footer>
 

</template>
