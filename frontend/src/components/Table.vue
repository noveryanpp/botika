<script setup>
import { computed } from 'vue';
import { DocumentPlusIcon, FunnelIcon, DocumentMagnifyingGlassIcon } from '@heroicons/vue/24/outline';
const emit = defineEmits(['filter', 'create', 'edit']);

const props = defineProps({
    rows: {
        type: Array,
        required: true
    },
    title: {
        type: String,
        required: true
    }
});

const headers = computed(() => {
    return props.rows.length > 0 ? Object.keys(props.rows[0]) : [];
});

function formatHeader(key) {
    return key.replace(/_/g, ' ').replace(/([a-z])([A-Z])/g, '$1 $2').replace(/\b\w/g, l => l.toUpperCase());
}

function triggerFilter() {
    emit('filter');
}

function triggerCreate() {
    emit('create');
}

function triggerEdit(row) {
    emit('edit', row);
}
</script>

<template>
    <div class="relative overflow-x-auto flex flex-col bg-gray-800 rounded-lg h-full mt-8">
        <div class="flex">
            <div class="m-4 ">
                <h2 class="text-xl text-white font-semibold">{{ props.title }}</h2>
            </div>
            <div class="ml-auto m-2 flex flex-row gap-2">
                <button @click="triggerCreate" class="bg-gray-900 text-gray-100 font-semibold text-sm px-4 py-2 rounded-md flex items-center cursor-pointer hover:bg-gray-950">
                    <DocumentPlusIcon class="w-6 mr-2"/>
                    Create New Data
                </button>
                <button @click="triggerFilter" class="bg-gray-900 text-gray-100 font-semibold text-sm px-4 py-2 rounded-md flex items-center cursor-pointer hover:bg-gray-950">
                    <FunnelIcon class="w-6 mr-2"/>
                    Filter
                </button>
            </div>
        </div>
        <table class="w-full text-sm text-left text-gray-100 ">
            <thead class="text-sm text-gray-100 uppercase bg-gray-900">
                <tr>
                    <th scope="col"
                        class="px-6 py-4"
                        v-for="(key, index) in headers"
                        :key="index"
                    >
                        {{ formatHeader(key) }}
                    </th>
                    <th scope="col"
                        class="px-6 py-4"
                    >
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    class="border-b border-gray-900"
                    v-for="(row, rowIndex) in rows"
                    :key="rowIndex"
                >
                    <!-- <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Apple MacBook Pro 17"
                    </th> -->
                    <td
                        class="px-6 py-4"
                        v-for="(key, colIndex) in headers"
                        :key="colIndex"
                    >
                        {{ row[key] }}
                    </td>
                    <td
                        class="px-6 py-4"
                    >
                        <DocumentMagnifyingGlassIcon @click="triggerEdit(row)" class="w-6"/>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>