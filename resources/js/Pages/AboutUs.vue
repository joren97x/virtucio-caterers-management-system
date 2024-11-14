<script setup>
import CustomerLayout from '@/Layouts/CustomerLayout.vue'
defineOptions({ layout: CustomerLayout })
</script>

<template>
        <div class="px-8 lg:px-16 py-16">
            <!-- Hero Section -->
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">We’re changing the way people connect</h1>
                <p class="mt-4 text-lg text-gray-500">
                    Cupidatat minim id magna ipsum sint dolor qui. Sunt sit in quis cupidatat mollit aute velit.
                    Et labore commodo nulla aliqua proident mollit ullamco exercitation tempor.
                </p>
            </div>
    
            <!-- Mission Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 mb-16">
                <div>
                    <h2 class="text-3xl font-semibold text-gray-900">Our mission</h2>
                    <p class="mt-4 text-lg text-gray-500">
                        Aliquet nec orci mattis amet quisque ullamcorper neque, nibh sem. At arcu, sit dui mi, nibh dui,
                        diam eget aliquam. Quisque id at vitae feugiat egestas ac. Diam nulla orci at in viverra
                        scelerisque eget.
                    </p>
                </div>
                <div class="flex flex-col justify-center">
                    <div class="text-4xl font-semibold text-gray-900">44 million</div>
                    <p class="text-gray-500">Transactions every 24 hours</p>
                    <div class="text-4xl font-semibold text-gray-900 mt-6">119 trillion</div>
                    <p class="text-gray-500">Assets under holding</p>
                    <div class="text-4xl font-semibold text-gray-900 mt-6">46,000</div>
                    <p class="text-gray-500">New users annually</p>
                </div>
            </div>
    
            <!-- Values Section -->
            <div class="mb-16">
                <h2 class="text-3xl font-semibold text-gray-900 text-center">Our values</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-8">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900">Be world-class</h3>
                        <p class="mt-2 text-gray-500">
                            At velit qui et et autem ullam et nisi. In dolore commodo sit et tempor.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900">Take responsibility</h3>
                        <p class="mt-2 text-gray-500">
                            Sit minus expedita quam in ullam molestiae dignissimos in harum.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900">Enjoy downtime</h3>
                        <p class="mt-2 text-gray-500">
                            Ipsum in earum deserunt aut. Quos minus aut animi et soluta.
                        </p>
                    </div>
                    <!-- Add more value items as needed -->
                </div>
            </div>
    
            <!-- Team Section -->
            <div class="mb-16 text-center">
                <h2 class="text-3xl font-semibold text-gray-900">Our team</h2>
                <p class="mt-4 text-gray-500">
                    We’re a dynamic group of individuals who are passionate about what we do.
                </p>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-8 mt-8">
                    <!-- Team member cards -->
                    <div class="text-center">
                        <img class="w-24 h-24 rounded-full mx-auto" src="https://via.placeholder.com/96" alt="Team member">
                        <h3 class="mt-4 text-lg font-semibold text-gray-900">Michael Foster</h3>
                        <p class="text-gray-500">Co-Founder / CTO</p>
                    </div>
                    <!-- Repeat for each team member as needed -->
                </div>
            </div>
    
            <!-- Blog Section -->
            <div>
                <h2 class="text-3xl font-semibold text-gray-900 text-center">From the blog</h2>
                <div class="grid grid-cols-2 gap-4">
                        <div>
            <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fthevirtuciocaterers%2Fposts%2Fpfbid06d1qsgbHf9poStaQt97SHedvfG9Tvuddf6My2FBY5wzxJFtea9sUjxYoLCRhEHhSl&width=750&show_text=true&appId=293603553600965&height=815" width="100%" height="815" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>

                </div>
                <div>
                    <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fthevirtuciocaterers%2Fposts%2Fpfbid02DGJpNi37MT7hEXTA726E5cfYohZDhuQUHh2gm3esWgkL4wYQkMc1J4DvEyk4ZzAWl&width=750&show_text=true&appId=293603553600965&height=937" width="100%" height="937" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                </div>
                </div>
            </div>
        </div>
    </template>