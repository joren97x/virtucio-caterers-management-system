
<script setup>

import CustomerLayout from '@/Layouts/CustomerLayout.vue'
import FoodDialog from './Components/FoodDialog.vue';
import { ref } from 'vue';
import { useOrderStore } from '@/Stores/OrderStore';

defineOptions({ layout: CustomerLayout })
const orderStore = useOrderStore()
const cartItems = ref([
  {
    name: 'Nomad Tumbler',
    color: 'White',
    size: '',
    inStock: true,
    price: 35.0,
    quantity: 1,
    image: 'https://via.placeholder.com/100', // Replace with actual image URL
  },
  {
    name: 'Basic Tee',
    color: 'Sienna',
    size: 'Large',
    inStock: true,
    price: 32.0,
    quantity: 1,
    image: 'https://via.placeholder.com/100', // Replace with actual image URL
  },
  {
    name: 'Basic Tee',
    color: 'Black',
    size: 'Large',
    inStock: false,
    price: 32.0,
    quantity: 1,
    image: 'https://via.placeholder.com/100', // Replace with actual image URL
  },
]);

const subtotal = ref(
  cartItems.value.reduce((sum, item) => sum + item.price * item.quantity, 0)
);
const shipping = ref(5.0);
const tax = ref(subtotal.value * 0.08);
const orderTotal = ref(subtotal.value + shipping.value + tax.value);

const formatCurrency = (amount) => {
  return `$${amount.toFixed(2)}`;
};

const removeItem = (index) => {
  cartItems.value.splice(index, 1);
  updateTotals();
};

const updateTotals = () => {
  subtotal.value = cartItems.value.reduce((sum, item) => sum + item.price * item.quantity, 0);
  tax.value = subtotal.value * 0.08;
  orderTotal.value = subtotal.value + shipping.value + tax.value;
};

const checkout = () => {
//   alert('Proceeding to checkout!');
	orderStore.form.post(route('checkout.pay'))
};
</script>

<template>
  <div class="max-w-5xl mx-auto">
    <h1 class="text-xl font-bold mb-6">Shopping Cart</h1>
    
    <div class="bg-white rounded-lg shadow-md mb-6 grid grid-cols-3 gap-4">
      


      <div class="col-span-2">
        <div class="text-center">Soup</div>
      <div class="flex items-center p-4 border-b last:border-b-0">
        <img src="https://via.placeholder.com/100" alt="Product Image" class="w-20 h-20 rounded-lg object-cover mr-4" />
        <div class="flex-1">
          <h3 class="text-lg font-medium">Lorem ipsum</h3>
          <p class="text-gray-500">red</p>
          <p class="text-gray-500">20</p>
          <!-- <div v-if="item.inStock" class="flex items-center text-green-500">
            <span class="mr-1">✔</span> In stock
          </div>
          <div v-else class="flex items-center text-gray-500">
            <span class="mr-1">🕒</span> Ships in 3-4 weeks
          </div> -->
        </div>
        <div class="flex items-center">
          <button class="ml-4 text-purple-600">Remove</button>
        </div>
      </div>
      <div class="text-center">Dessert</div>
      <div class="flex items-center p-4 border-b last:border-b-0">
        <img src="https://via.placeholder.com/100" alt="Product Image" class="w-20 h-20 rounded-lg object-cover mr-4" />
        <div class="flex-1">
          <h3 class="text-lg font-medium">Lorem ipsum</h3>
          <p class="text-gray-500">red</p>
          <p class="text-gray-500">20</p>
          <!-- <div v-if="item.inStock" class="flex items-center text-green-500">
            <span class="mr-1">✔</span> In stock
          </div>
          <div v-else class="flex items-center text-gray-500">
            <span class="mr-1">🕒</span> Ships in 3-4 weeks
          </div> -->
        </div>
        <div class="flex items-center">
          <button class="ml-4 text-purple-600">Remove</button>
        </div>
      </div>
      <div class="text-center">Main Dishes</div>
      <div v-for="(item, index) in cartItems" :key="index" class="flex items-center p-4 border-b last:border-b-0">
        <img :src="item.image" alt="Product Image" class="w-20 h-20 rounded-lg object-cover mr-4" />
        <div class="flex-1">
          <h3 class="text-lg font-medium">{{ item.name }}</h3>
          <p class="text-gray-500">{{ item.color }}</p>
          <p class="text-gray-500">{{ item.size }}</p>
          <!-- <div v-if="item.inStock" class="flex items-center text-green-500">
            <span class="mr-1">✔</span> In stock
          </div>
          <div v-else class="flex items-center text-gray-500">
            <span class="mr-1">🕒</span> Ships in 3-4 weeks
          </div> -->
        </div>
        <div class="flex items-center">
          <button @click="removeItem(index)" class="ml-4 text-purple-600">Remove</button>
        </div>
      </div>
      </div>


      <div>
         <!-- Order Summary Section -->
    <div class="bg-white rounded-lg shadow-md p-4">
      <h2 class="text-lg font-semibold mb-4">Order Summary</h2>
      <div class="space-y-2">
        <div class="flex justify-between">
          <span>Subtotal</span>
          <span>{{ formatCurrency(subtotal) }}</span>
        </div>
        <!-- <div class="flex justify-between">
          <span>Shipping</span>
          <span>{{ formatCurrency(shipping) }}</span>
        </div>
        <div class="flex justify-between">
          <span>Tax</span>
          <span>{{ formatCurrency(tax) }}</span>
        </div> -->
        <div class="flex justify-between font-bold">
          <span>Order total</span>
          <span>{{ formatCurrency(orderTotal) }}</span>
        </div>
      </div>
      <button @click="checkout" class="w-full bg-purple-600 text-white py-2 rounded-md mt-4">Checkout</button>
      <p class="text-center mt-2">
        or <a href="#" class="text-purple-600">Continue Shopping →</a>
      </p>
    </div>
      </div>



    </div>
    
   
  </div>
</template>
  