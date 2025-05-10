<script setup>
import { ref, onMounted } from 'vue';
import Modal from '@/components/Modal.vue';
import Table from '@/components/Table.vue';
import PositionDataService from '@/services/PositionDataService';

const positions = ref([]);

const showModal = ref(false);

const retrieveTutorials = async () => {
    PositionDataService.getAll()
        .then(response => {
            positions.value = response.data.data;
            console.log(response.data.data);
            console.log(positions.value[0])
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
        <h1 class="text-gray-100 text-3xl font-semibold">Positions</h1>

        <Table 
            :rows="positions" 
            @filter="handleFilter"
        />

        <Modal v-if="showModal" @close="showModal = false">
        <h2 class="text-xl font-bold mb-4">Add New Position</h2>
        <!-- Your form content here -->
        </Modal>
    </div>
</template>