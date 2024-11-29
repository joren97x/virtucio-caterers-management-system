<!-- <script setup>
import CustomerLayout from '@/Layouts/CustomerLayout.vue'
defineOptions({ layout: CustomerLayout })
</script>

<template>
    <div class="flex flex-col items-center text-center">
        <h1 class="text-balance text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl mb-6">BLOG</h1>
        <div class="w-full flex justify-center">
            <div class="grid grid-cols-1 gap-10">
                <div>
            <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fthevirtuciocaterers%2Fposts%2Fpfbid06d1qsgbHf9poStaQt97SHedvfG9Tvuddf6My2FBY5wzxJFtea9sUjxYoLCRhEHhSl&width=750&show_text=true&appId=293603553600965&height=815" width="750" height="815" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>

                </div>
                <div>
                    <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fthevirtuciocaterers%2Fposts%2Fpfbid02DGJpNi37MT7hEXTA726E5cfYohZDhuQUHh2gm3esWgkL4wYQkMc1J4DvEyk4ZzAWl&width=750&show_text=true&appId=293603553600965&height=937" width="750" height="937" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                </div>
        </div>
        
        </div>
    </div>
</template> -->

<template>
    <Head title="About Us" />

     <section class="py-10 px-6 max-w-screen-xl mx-auto">
    <div class="mx-auto">
      <h1 class="text-4xl font-bold text-gray-800 mb-8 text-center">Our Blog</h1>
      <p class="text-lg text-gray-600 mb-12 text-center">
        Explore our latest updates, stories, and tips straight from Facebook.
      </p>

      <!-- Embedded Facebook Posts -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
        <div
          v-for="(post, index) in facebookPosts"
          :key="post.id"
          class="bg-white rounded-lg shadow-md overflow-hidden"
        >
          <div class="p-4">
            <h2 class="text-lg font-bold text-gray-800 mb-4">{{ post.title }}</h2>
            <iframe
            :id="'fb-post-' + index"
              :src="post.embedUrl"
              width="100%"
              height="700"
              style="border:none;overflow:hidden"
              scrolling="no"
              frameborder="0"
              allowfullscreen="true"
              allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
            ></iframe>
          </div>
        </div>
      </div>
    </div>
  </section>
  </template>
  
  <script setup>
  import { onMounted, ref } from 'vue'
  import CustomerLayout from '@/Layouts/CustomerLayout.vue';
  import { Head } from '@inertiajs/vue3';
  
  defineOptions({ layout: CustomerLayout })
  // Dummy Facebook post data
  

  const facebookPosts = ref([
  {
    id: 1,
    title: 'Birthday party of Mam Daphne Lagon',
    embedUrl: 'https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fthevirtuciocaterers%2Fposts%2Fpfbid02DGJpNi37MT7hEXTA726E5cfYohZDhuQUHh2gm3esWgkL4wYQkMc1J4DvEyk4ZzAWl&width=750&show_text=true&appId=293603553600965&height=937', // Replace with your actual post URL
  },
  {
    id: 2,
    title: 'Another busy day after Valentines Day!',
    embedUrl: 'https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fthevirtuciocaterers%2Fposts%2Fpfbid06d1qsgbHf9poStaQt97SHedvfG9Tvuddf6My2FBY5wzxJFtea9sUjxYoLCRhEHhSl&width=750&show_text=true&appId=293603553600965&height=815', // Replace with your actual post URL

  },
  {
    id: 3,
    title: 'Ysabella Rose turns 1 |November 17, 2024',
    embedUrl: 'https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fthevirtuciocaterers%2Fposts%2Fpfbid023qW1wRETxhs3oRyzNLQ4ts51w1bE9Ye7XVrNQNgHWrHd1GjGmhJ1r8SbKyoUbb7bl&width=750&show_text=true&appId=293603553600965&height=915', // Replace with your actual post URL

  },
  {
    id: 3,
    title: 'ROSELYN DE LUNA | November 21, 2024',
    embedUrl: 'https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fthevirtuciocaterers%2Fposts%2Fpfbid026sz4YvtGCwnnyF9opVnESqiruzixsSdGA9p9jZ9HGAwSFNbXbcKP6QCWpTadtxSzl&show_text=true&width=500', // Replace with your actual post URL

  },
])
const adjustIframeHeight = (index) => {
  const iframe = document.getElementById(`fb-post-${index}`)
  if (iframe) {
    console.log('hii')
    console.log(iframe.contentWindow.document.body.scrollHeight)
    iframe.style.height = iframe.contentWindow.document.body.scrollHeight + 'px'
  }
}
  
  </script>
  
  <style scoped>
  /* Add custom styling here if needed */
  </style>
  