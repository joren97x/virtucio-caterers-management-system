<script setup>
// Add any logic if necessary.
import { Link } from '@inertiajs/vue3';
import { useOrderStore } from '@/Stores/OrderStore'
import DangerButton from '@/Components/DangerButton.vue';
import Alert from '@/Components/Alert.vue';
import { computed, ref } from 'vue';
defineProps({
    next: String,
    back: String,
    loading: String,
})

const orderStore = useOrderStore()
const currentStep = ref(1)

const steps = [
    { title: 'Choose Pax', description: 'Select the number of people for your event.' },
    { title: 'Choose Soup', description: 'Pick your preferred soup for the meal.' },
    { title: 'Choose Dessert', description: 'Select your desired dessert options.' },
    { title: 'Choose Main Dishes', description: 'Choose 5 main dishes from the menu.' },
    { title: 'Enter Contact Details', description: 'Fill in your name and contact information.' },
]

const currentStepContent = computed(() => {
    return steps[currentStep.value - 1]?.title || '';
}) 

const nextStep = () => {
      if (currentStep.value < steps.length) {
        currentStep.value++;
      }
}
const prevStep = () => {
    if (currentStep.value > 1) {
    currentStep.value--;
    }
}
</script>

<template>
    <div class="h-screen w-screen max-w-screen-xl mx-auto" >
        <div class="flex justify-between mx-5">
            <div class="flex items-center justify-center h-16 border-b">
                <!-- <img src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=600" alt="Logo" class="h-8 w-auto"> -->
                <Link :href="route('home')">
                    <div class="flex">
                        <img class="h-8 w-auto" src="logo.png" alt="">
                        <img class="h-8 w-auto" src="logo-name.png" alt="">
                    </div>
                </Link>
            </div>
            <div>
                <Link :href="route('home')" >
                    <DangerButton class="mt-4">
                        Exit
                    </DangerButton>
                </Link>
            </div>
        </div>
        <div style="max-width: 1280px; max-height: 82vh;" class="mx-auto overflow-y-auto overflow-hidden md:m-2">
            <slot />
        </div>
        <div class="absolute bottom-0 w-full max-w-screen-xl" >
            <!-- <div class="my-2 h-2" :style="`background-color: yellow; width: ${loading}%; transition: width 0.5s ease;`"></div>
            <div class="my-2 h-2" :style="`background-color: yellow; width: ${loading}%; transition: width 0.5s ease;`"></div> -->
            <div class="my-2 h-2 my-transition" :style="`background-color: yellow; width: ${loading}%;`"></div>
            <div class="flex md:justify-between sm:justify-start mx-5 mb-4 space-x-2">
                <Link :href="route(back)" class="rounded-md px-3.5 py-2.5 text-sm font-semibold text-black shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    BACK
                </Link>
            <div>
                <button @click="orderStore.checkout()" v-if="$page.component == 'User/ContactForm'" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Proceed to Checkout
                </button>

                <slot name="nextButton" />
                <!-- <Link :href="route(next)" v-else >
                    <PrimaryButton>
                        Next
                    </PrimaryButton>
                </Link> -->
            </div>
            
        </div>
        </div>
    </div>
</template>

<style scoped>
.my-transition {
  transition: width 0.5s ease;
}
</style>
  