import { defineStore } from 'pinia'
import { useForm } from '@inertiajs/vue3'
import { ref, computed } from 'vue'

export const useOrderStore = defineStore('orders', () => {

    const form = useForm({
        rate: null,
        add_ons: [],
        name: '',
        contact_number: '',
        date: null,
        venue: '',
        event: '',
        message: '',
        status: 'pending',
        payment_method: 'online',
        contract_payments: 'full_payment',
        soup: null,
        main_dishes: [],
        dessert: null
    })

    // const doubleCount = computed(() => count.value * 2)
    // const subtotal = computed(() => {
    //     let total = 0

    //     total += parseFloat(form.rate?.price)
    //     form.foods.forEach(food => {
    //         total += parseFloat(food.quantity * food.product.price)
    //     });

    //     form.add_ons.forEach((el) => {
    //         total += parseFloat(el.price)
    //     })
    //     return total
    // })

    // function increment() {
    //   count.value++
    // }

    function checkout() {
      form.get(route('checkout'))
    }
  
    return { form, checkout }
  })