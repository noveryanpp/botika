<script setup>
import { RouterLink } from 'vue-router';
import { UsersIcon, BriefcaseIcon, ChartPieIcon, DocumentIcon, ArrowRightStartOnRectangleIcon, SquaresPlusIcon } from '@heroicons/vue/24/outline'

const navigationMenu = [
    {
      "key" : 0,
      "icon": SquaresPlusIcon,
      "name": "Dashboard",
      "path": "/"
    },
    {
      "key" : 1,
      "icon": UsersIcon,
      "name": "Employees",
      "path": "/employees"
    },
    {
      "key" : 2,
      "icon": ChartPieIcon,
      "name": "Divisions",
      "path": "/divisions"
    },
    {
      "key" : 3,
      "icon": BriefcaseIcon,
      "name": "Positions",
      "path": "/positions"
    },
    {
      "key" : 4,
      "icon": DocumentIcon,
      "name": "Employee's Jobs",
      "path": "/employee-jobs"
    },
  ]
</script>

<template>
    <aside
    class="transform top-0 left-0 w-64 bg-gray-950 text-xs fixed h-full ease-in-out transition-all duration-300 z-30 shadow-2xl flex flex-col">
      <h3 class="text-lg font-extrabold text-left text-gray-100 px-4 pt-8 pb-8">Employee Management</h3>
      <div class="flex flex-col h-full">
        <div class="flex-1 m-2">
          <RouterLink v-for="item in navigationMenu" :key="item.key" :item="item" :to="item.path" custom v-slot="{ navigate, isActive }">
            <button @click="navigate" class="text-gray-100 w-full text-left font-semibold bg-none text-sm rounded-md p-2 mb-1" :class="isActive ? 'bg-gray-800 text-white' : 'hover:bg-gray-900 hover:text-white'">
                <component :is="item.icon" class="w-5 h-5 inline mr-2 text-slate-400" />
                {{ item.name }}
            </button>
          </RouterLink>
        </div>
        <div class="m-4 flex flex-row text-gray-100 items-center">
          <div class="h-10 w-10 bg-gray-800 rounded-full"></div>
          <div class="flex flex-col ml-2 flex-1">
            <h5 class="text-md font-semibold">Administrator</h5>
            <h6 class="text-xs">admin@example.com</h6>
          </div>
          <button>
            <ArrowRightStartOnRectangleIcon class="w-6 h-6 inline mr-2" />
          </button>
        </div>
      </div>
    </aside>
</template>