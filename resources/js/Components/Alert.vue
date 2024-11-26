<script setup>
import { ref, computed, watch, defineEmits } from 'vue';
const props = defineProps({
    color: {
        type: String,
        default: 'white'
    },
    show: {
        type: Boolean,
        default: false
    },
    title: {
        type: String,
        default: 'Lorem ipsum',
    },
    subtitle: {
        type: String,
        default: 'Lorem ispum subtitle'
    }
})

const emit = defineEmits(['close'])

const show = computed(() => props.show);
const isVisible = ref(props.show)
// Lifecycle to automatically hide the alert
// onMounted(() => {
//   setTimeout(() => {
//     show.value = false;
//   }, 3000);
// });

watch(
  () => props.show,
  (newVal) => {
    isVisible.value = newVal;
    if (newVal) {
      setTimeout(() => {
        isVisible.value = false; // Automatically hide the alert after 3 seconds
        emit('close')
      }, 3000);
    }
  },
  { immediate: true } // Ensure it initializes correctly
);

</script>

<template>
    <div
    v-if="isVisible"
  :class="`fixed bottom-4 left-1/2 transform -translate-x-1/2 bg-${color} border border-gray-200 shadow-lg rounded-lg p-4 flex items-center space-x-4 animate-slide-up`"
>
{{ `bg-${color}` }}
  <div :class="color == 'white' ? 'text-black' : 'text-white'">
    <!-- Checkmark icon -->
     hii
    <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
  </div>
  <div>
    <p :class="[color == 'white' ? 'text-black' : 'text-white', 'font-medium']">{{ title }}</p>
    <p :class="[color == 'white' ? 'text-black' : 'text-white', 'text-sm']">{{ subtitle }}</p>
  </div>
  <button
    :class="`ml-auto text-gray-400 hover:text-gray-500 focus:outline-none`"
    onclick="this.parentElement.remove()"
  >
    <!-- Close icon -->
    <svg
      xmlns="http://www.w3.org/2000/svg"
      class="h-5 w-5"
      fill="none"
      viewBox="0 0 24 24"
      stroke="currentColor"
      stroke-width="2"
    >
      <path
        stroke-linecap="round"
        stroke-linejoin="round"
        d="M6 18L18 6M6 6l12 12"
      />
    </svg>
  </button>
</div>
</template>