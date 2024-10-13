<script setup>
// Add any logic if necessary.
import { Link } from '@inertiajs/vue3';

</script>

<template>
    <div class="h-screen w-screen bg-blue-500" >
        <div class="flex justify-between mx-5">
            <div class="flex items-center justify-center h-16 border-b">
                <img src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=600" alt="Logo" class="h-8 w-auto">
            </div>
            <div>
                <button>Exit</button>
            </div>
        </div>
    <div class="mx-auto max-w-2xl ">
      <div class="text-center">
        annyeong
      </div>
    
  </div>
        <div class="absolute bottom-0 w-full" style="background-color: grey;">
            <div class="my-1 h-3" style="background-color: red;"></div>
            <div class="flex justify-between mx-5 py-10">
                <button>Back</button>
            <div>
                <button>Next</button>
            </div>
        </div>
        </div>
    </div>
</template>

  
  <style scoped>
  /* Add any custom styling here if needed */
  </style>
  