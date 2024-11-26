<script setup>
import { ref } from 'vue'
import CustomerLayout from '@/Layouts/CustomerLayout.vue'
import SoupDialog from './Components/SoupDialog.vue'
import DessertDialog from './Components/DessertDialog.vue'
import MainDishDialog from './Components/MainDishDialog.vue'

defineOptions({
    layout: CustomerLayout
})

// Sample menu data (you can fetch this from an API or a store)
const soups = [
    { image: 'products/soup.jpg', id: 1, name: 'Tomato Soup', description: 'lorem ipsumnida' },
    { image: 'products/soup.jpg', id: 2, name: 'Chicken Soup', description: 'lorem ipsumnida' },
    { image: 'products/soup.jpg', id: 3, name: 'Vegetable Soup', description: 'lorem ipsumnida' }
]

const mainDishes = [
    { image: 'products/soup.jpg', description: 'lorem ipsumnida', id: 1, name: 'Grilled Chicken' },
    { image: 'products/soup.jpg', description: 'lorem ipsumnida', id: 2, name: 'Beef Stir-fry' },
    { image: 'products/soup.jpg', description: 'lorem ipsumnida', id: 3, name: 'Vegetable Curry' },
    { image: 'products/soup.jpg', description: 'lorem ipsumnida', id: 4, name: 'Pasta Primavera' },
    { image: 'products/soup.jpg', description: 'lorem ipsumnida', id: 5, name: 'Fish Fillet' },
    { image: 'products/soup.jpg', description: 'lorem ipsumnida', id: 6, name: 'Lamb Chop' },
    { image: 'products/soup.jpg', description: 'lorem ipsumnida', id: 7, name: 'Shrimp Fried Rice' }
]

const desserts = [
    { image: 'products/soup.jpg', description: 'lorem ipsumnida', id: 1, name: 'Chocolate Cake' },
    { image: 'products/soup.jpg', description: 'lorem ipsumnida', id: 2, name: 'Fruit Salad' },
    { image: 'products/soup.jpg', description: 'lorem ipsumnida', id: 3, name: 'Cheesecake' }
]

const addOns = [
    { image: 'products/soup.jpg', description: 'lorem ipsumnida', id: 1, name: 'Basic Theme' },
    { image: 'products/soup.jpg', description: 'lorem ipsumnida', id: 2, name: 'Advanced Theme' },
    { image: 'products/soup.jpg', description: 'lorem ipsumnida', id: 3, name: 'Floral Arrangement' }
]

const selectedSoup = ref(null)

// Method to handle soup selection
const selectSoup = (soupId) => {
    selectedSoup.value = soupId
}
const selectedMainDishes = ref([])
const selectedDessert = ref(null)
const selectedPax = ref(50) // Default pax selection
const selectedAddOns = ref([])

// Automatically update the quantity of selected items based on pax
const updateQuantity = (item) => {
    return selectedPax.value;
}
</script>

<template>
    <div class="bg-white p-6">
        <h1 class="text-2xl font-bold mb-4">Menu Selection</h1>

        <!-- Soup Selection -->
        <div class="mb-4">
            <h2 class="text-lg font-semibold">Select Soup</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <SoupDialog 
                    v-for="soup in soups" 
                    :product="soup" 
                />
            </div>
        </div>


        <!-- Main Dishes Selection -->
        <div class="mb-4">
            <h2 class="text-lg font-semibold">Select 5 Main Dishes</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <MainDishDialog v-for="mainDish in mainDishes" :product="mainDish"/>
            </div>
            <!-- <p v-if="selectedMainDishes.length >= 5" class="text-sm text-red-500">You can only select 5 main dishes.</p> -->
        </div>

        <!-- Dessert Selection -->
        <div class="mb-4">
            <h2 class="text-lg font-semibold">Select Dessert</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <DessertDialog v-for="dessert in desserts" :key="dessert.id" :product="dessert"/>
            </div>
        </div>

        <!-- Pax Selection -->
        <div class="mb-4">
            <h2 class="text-lg font-semibold">Select Pax</h2>
            <select v-model="selectedPax" class="form-select w-full p-2 border border-gray-300 rounded">
                <option value="50">50 Pax</option>
                <option value="80">80 Pax</option>
                <option value="100">100 Pax</option>
            </select>
        </div>

        <!-- Add-Ons Selection -->
        <div class="mb-4">
            <h2 class="text-lg font-semibold">Select Add-Ons</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div v-for="addOn in addOns" :key="addOn.id" class="flex items-center space-x-2">
                    <input 
                        type="checkbox" 
                        :id="'addOn_' + addOn.id" 
                        v-model="selectedAddOns" 
                        :value="addOn.id" 
                        class="form-checkbox text-indigo-600" />
                    <label :for="'addOn_' + addOn.id" class="text-lg">{{ addOn.name }}</label>
                </div>
            </div>
        </div>

        <!-- Summary Section -->
        <div class="mt-6">
            <h2 class="text-xl font-semibold">Summary</h2>
            <p>Soup: {{ soups.find(soup => soup.id === selectedSoup)?.name }}</p>
            <p>Main Dishes: {{ selectedMainDishes.map(id => mainDishes.find(dish => dish.id === id)?.name).join(', ') }}</p>
            <p>Dessert: {{ desserts.find(dessert => dessert.id === selectedDessert)?.name }}</p>
            <p>Pax: {{ selectedPax }} Pax</p>
            <p>Add-Ons: {{ selectedAddOns.map(id => addOns.find(addOn => addOn.id === id)?.name).join(', ') }}</p>
        </div>

        <button 
            @click="submitOrder" 
            class="mt-6 bg-indigo-600 text-white p-3 rounded hover:bg-indigo-700 w-full">
            Proceed to Checkout
        </button>
    </div>
</template>

