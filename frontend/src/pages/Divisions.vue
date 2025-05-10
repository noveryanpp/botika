<script setup>
import { ref, onMounted } from 'vue';
import Modal from '@/components/Modal.vue';
import Table from '@/components/Table.vue';
import DivisionDataService from '@/services/DivisionDataService';

const divisions = ref([]);

const showModal = ref(false);

const retrieveTutorials = async () => {
    DivisionDataService.getAll()
        .then(response => {
            divisions.value = response.data.data;
            console.log(response.data.data);
            console.log(divisions.value[0])
        })
        .catch(e => {
            console.log(e);
        });
};

function handleFilter() {
  alert('Open filter modal or panel!');
}

function handleAdd() {
  alert('Open add form modal!');
}

onMounted(() => {
  retrieveTutorials();
});

</script>

<template>
    <div>
        <h1 class="text-gray-100 text-3xl font-semibold">Divisions</h1>

        <Table 
            :rows="divisions" 
            @filter="handleFilter"
        />

        <Modal v-if="showModal" @close="showModal = false">
        <h2 class="text-xl font-bold mb-4">Add New Division</h2>
        <!-- Your form content here -->
        </Modal>
    </div>
</template>