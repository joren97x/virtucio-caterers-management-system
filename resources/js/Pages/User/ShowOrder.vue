<script setup>

import CustomerLayout from '@/Layouts/CustomerLayout.vue'
import { formatDate } from 'date-fns';

defineOptions({ layout: CustomerLayout })
const props = defineProps({ order: Object })

const formatCurrency = (amount) => {
    return parseFloat(amount).toLocaleString("en-US", { minimumFractionDigits: 2, });
}

const groupItemsByCategory = (items) => {
      const categories = {};
      items.forEach((item) => {
        if (!categories[item.category]) {
          categories[item.category] = [];
        }
        categories[item.category].push(item);
      });
      return Object.keys(categories).map((key) => ({
        name: key,
        items: categories[key],
      }));
}

</script>
<template>
    <div class="order-page max-w-screen-xl mx-auto">
      <!-- Header Section -->
      <header class="order-header">
        <h1>Order #{{ order.id }}</h1>
        <h2>{{ order.name }}</h2>
        <span class="status">{{ order.status.replace('_', ' ') }}</span>
      </header>
  
      <!-- Order Summary -->
      <section class="order-summary">
        <h3>Order Summary</h3>
        <div>
          <p><strong>Event Date:</strong> {{ formatDate(order.event_date, 'PPP') }}</p>
          <p><strong>Event Type:</strong> {{ order.event_type }}</p>
          <p><strong>Venue:</strong> {{ order.venue }}</p>
          <p><strong>Total Amount:</strong> ₱{{ formatCurrency(order.total_amount) }}</p>
          <p><strong>Reservation Fee:</strong> ₱{{ formatCurrency(order.reservation_fee) }}</p>
          <p><strong>Payment Method:</strong> {{ order.payment_method }}</p>
          <p><strong>Message:</strong> {{ order.message }}</p>
        </div>
      </section>
  
      <!-- Rate Details -->
      <section class="rate-details">
        <h3>Rate Details</h3>
        <p><strong>Pax:</strong> {{ order.rate.pax }}</p>
        <p><strong>Price:</strong> ₱{{ formatCurrency(order.rate.price) }}</p>
        <p>{{ order.rate.instructions }}</p>
      </section>
  
      <!-- Ordered Items -->
      <section class="ordered-items">
        <h3>Menu Items</h3>
        <div v-for="(category, index) in groupItemsByCategory(order.order_items)" :key="index">
          <h4>{{ category.name }}</h4>
          <div class="item" v-for="item in category.items" :key="item.id">
            <img :src="item.product.image_path" alt="Product Image" />
            <div>
              <h5>{{ item.product.name }}</h5>
              <p>{{ item.product.description }}</p>
            </div>
          </div>
        </div>
      </section>
    </div>
  </template>