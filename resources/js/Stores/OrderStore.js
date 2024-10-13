import { defineStore } from 'pinia'
import { useForm } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

export const useOrderStore = defineStore('orders', () => {
    const count = ref(0)
    const name = ref('Eduardo')

    const form = useForm({
        rate: null,
        add_ons: [],
        foods: [],
        name: '',
        contact_number: '',
        date: null,
        event_details: '',
        message: ''
    })

    const doubleCount = computed(() => count.value * 2)

    function increment() {
      count.value++
    }

    function checkout() {
      form.post(route('checkout'))
    }
  
    return { count, name, doubleCount, increment, form, checkout }
  })