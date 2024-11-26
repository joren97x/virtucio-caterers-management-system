import { defineStore } from 'pinia'
import { useForm } from '@inertiajs/vue3'

export const useOrderStore = defineStore('orders', () => {

    const form = useForm({
        rate: null,
        add_ons: [],
        name: '',
        contact_number: '',
        event_date: null,
        venue: '',
        event_type: 'party',
        message: '',
        status: 'pending',
        payment_method: 'online',
        contract_payments: 'full_payment',
        soup: null,
        main_dishes: [],
        dessert: null
    })

    function checkout() {
      form.post(route('checkout'))
    }
  
    return { form, checkout }
  })