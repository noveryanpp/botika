<script setup>
import Sidebar from './components/Sidebar.vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const hideSidebarOnRoutes = ['/login'];
</script>

<template>
  <div class="bg-black">
    <Sidebar v-if="!hideSidebarOnRoutes.includes(route.path)" />
    <div class="ml-64 min-h-screen">
      <router-view class="p-8"/>
    </div>
  </div>
</template>
