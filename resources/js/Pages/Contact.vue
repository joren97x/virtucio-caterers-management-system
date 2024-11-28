<script setup>
import CustomerLayout from '@/Layouts/CustomerLayout.vue'
defineOptions({ layout: CustomerLayout })
</script>

<template>
    <section class="py-10 max-w-screen-xl mx-auto min-h-screen">
      <div class="w-fit">
        <h1 class="text-4xl font-bold text-gray-800 mb-8 text-center">Contact Us</h1>
        <p class="text-lg text-gray-600 mb-12 text-center">
          We’d love to hear from you! Reach out to us using the form below or through our contact information.
        </p>
        <!-- <h1 class="text-3xl font-bold text-gray-800 mb-4">Contact Us</h1>
        <p class="text-gray-600 mb-6">We’d love to hear from you! Reach out to us using the form below or through our contact information.</p> -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <!-- Contact Info -->
          <div class="grid grid-cols-2">
            <div class="items-center flex">
              <div>
                <div class="flex mb-6">
                    <img class="h-16 w-auto" src="logo.png" alt="">
                    <img class="h-16 w-auto" src="logo-name.png" alt="">
                </div>
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Our Contact Details</h2>
              <ul class="text-gray-600 space-y-2">
                <li><strong>Phone:</strong> +1 123-456-7890</li>
                <li><strong>Email:</strong> info@virtuciocaterers.com</li>
                <li><strong>Address:</strong> 123 Main Street, Cityville, Country</li>
              </ul>
              </div>
            </div>
          </div>
          <!-- Contact Form -->
          <div>
            <h2 class="text-xl font-semibold text-gray-800 mb-2">Send Us a Message</h2>
            <form class="space-y-4">
              <div>
                <label for="name" class="block text-gray-700">Name</label>
                <input type="text" id="name" class="w-full border border-gray-300 rounded p-2" placeholder="Your Name" required>
              </div>
              <div>
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" class="w-full border border-gray-300 rounded p-2" placeholder="Your Email" required>
              </div>
              <div>
                <label for="message" class="block text-gray-700">Message</label>
                <textarea id="message" class="w-full border border-gray-300 rounded p-2" placeholder="Your Message" rows="5" required></textarea>
              </div>
              <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Send Message
              </button>
            </form>
          </div>
        </div>
      </div>
    </section>
</template>