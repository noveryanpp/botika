<script setup>
import { ref, onMounted, computed, watch } from 'vue';
import Modal from '@/components/Modal.vue';
import Table from '@/components/Table.vue';
import EmployeeDataService from '@/services/EmployeeDataService';
import DivisionDataService from '@/services/DivisionDataService';
import PositionDataService from '@/services/PositionDataService';
import { TrashIcon, DocumentTextIcon } from '@heroicons/vue/24/outline';

const employees = ref([]);
const divisions = ref([]);
const positions = ref([]);
const filteredEmployees = ref([]);
const tableTitle = ref('')
const selectedDivisions = ref([]);
const selectedEmployee = ref(null);

const showCreateModal = ref(false);
const showEditModal = ref(false);
const showFilterModal = ref(false);

const fetchEmployees = async () => {
    EmployeeDataService.getAll()
        .then(response => {
            employees.value = response.data.data;
            filteredEmployees.value = [...employees.value];
        })
        .catch(e => {
            console.log(e);
        });
};

const totalActive = computed(() =>
  filteredEmployees.value.filter(emp => emp.status === 'active').length
);

const totalInactive = computed(() =>
  filteredEmployees.value.filter(emp => emp.status === 'inactive').length
);

function setTitle(){
    tableTitle.value = `Total Employee = ${filteredEmployees.value.length} | Total Active = ${totalActive.value} | Total Inactive = ${totalInactive.value}`;
}

watch(filteredEmployees, () => {
    setTitle();
});

const fetchDivisions = async () => {
    DivisionDataService.getAll()
        .then(response => {
            divisions.value = response.data.data.map(item => item.name);
        })
        .catch(e => {
            console.log(e);
        });
}

const fetchPositions = async () => {
    PositionDataService.getAll()
        .then(response => {
            positions.value = response.data.data;
            console.log(positions.value)
        })
        .catch(e => {
            console.log(e);
        });
}

function handleFilter() {
  showFilterModal.value = true;
}

function handleDivisionFilter() {
  if (selectedDivisions.value.length === 0) {
    filteredEmployees.value = [...employees.value]; // no filters selected
    return;
  }

  filteredEmployees.value = employees.value.filter(emp =>
    selectedDivisions.value.some(div =>
      emp.divisions.includes(div)
    )
  );
}

function handleCreate() {
  showCreateModal.value = true;
}

function handleEdit(row) {
    selectedEmployee.value = row;
    employee.value = {
        name: row.name,
        email: row.email,
        phone: row.phone,
        status: row.status
    };
    showEditModal.value = true;
}

const submitEmployee = async () => {
    EmployeeDataService.create(newEmployee.value)
        .then(response => {
            alert(response.data.message);
            showCreateModal.value = false;
            fetchEmployees();
        })
        .catch(e => {
            alert(e.response.data.message);
        });
}

const submitEmployeeEdit = async () => {
    EmployeeDataService.update(selectedEmployee.value.id, employee.value)
        .then(response => {
            alert(response.data.message);
            showEditModal.value = false;
            fetchEmployees();
        })
        .catch(e => {
            alert(e.response.data.message);
        });
}

const deleteEmployee = async () => {
    EmployeeDataService.delete(selectedEmployee.value.id)
        .then(response => {
            alert(response.data.message);
            showEditModal.value = false;
            fetchEmployees();
        })
        .catch(e => {
            alert(e.response.data.message);
        });
}

const employee = ref({
  name: '',
  email: '',
  phone: '',
  status: ''
});

const newEmployee = ref({
  name: '',
  email: '',
  phone: '',
  status: 'active'
});

onMounted(() => {
  fetchEmployees();
  fetchDivisions();
  fetchPositions();
});

</script>

<template>
    <div>
        <h1 class="text-gray-100 text-3xl font-semibold">Employees</h1>

        <Table 
            :title="tableTitle"
            :rows="filteredEmployees"
            @filter="handleFilter"
            @create="handleCreate"
            @edit="handleEdit"
        />

        <Modal v-if="showFilterModal" @close="showFilterModal = false">
            <div class="flex flex-col">
                <h2 class="text-white text-xl font-bold mb-4">Filter By</h2>
                <div class="flex flex-col">
                    <h3 class="text-gray-100 text-md font-semibold">Divisions</h3>
                    <label
                        v-for="division in divisions"
                        :key="division"
                        class="text-white"
                    >
                        <input
                        type="checkbox"
                        :value="division"
                        v-model="selectedDivisions"
                        @change="handleDivisionFilter"
                        />
                        {{ division }}
                    </label>
                </div>
            </div>
        </Modal>
        <Modal v-if="showCreateModal" @close="showCreateModal = false">
            <h2 class="text-white text-xl font-bold mb-4">Add New Employee</h2>
            <form @submit.prevent="submitEmployee">
                <div class="flex flex-col gap-2">
                    <input v-model="newEmployee.name" type="text" class="text-white py-2 px-4 text-sm bg-gray-900 rounded-md hover:bg-gray-950 w-full" placeholder="Name" />
                    <input v-model="newEmployee.email" type="text" class="text-white py-2 px-4 text-sm bg-gray-900 rounded-md hover:bg-gray-950 w-full" placeholder="Email" />
                    <input v-model="newEmployee.phone" type="text" class="text-white py-2 px-4 text-sm bg-gray-900 rounded-md hover:bg-gray-950 w-full" placeholder="Phone" />
                    <select v-model="newEmployee.status" class="text-white py-2 px-4 text-sm bg-gray-900 rounded-md hover:bg-gray-950 w-full">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    <button
                        type="submit"
                        class="mt-2 bg-yellow-500 text-white font-bold text-sm px-4 py-2 rounded-md hover:bg-yellow-600"
                    >
                        Submit
                    </button>
                </div>
            </form>
        </Modal>
        <Modal v-if="showEditModal" @close="showEditModal = false">
            <h2 class="text-white text-xl font-bold mb-4">Edit Employee</h2>
            <form @submit.prevent="submitEmployeeEdit">
                <div class="flex flex-col gap-2">
                    <input v-model="employee.name" type="text" class="text-white py-2 px-4 text-sm bg-gray-900 rounded-md hover:bg-gray-950 w-full" placeholder="Name" />
                    <input v-model="employee.email" type="text" class="text-white py-2 px-4 text-sm bg-gray-900 rounded-md hover:bg-gray-950 w-full" placeholder="Email" />
                    <input v-model="employee.phone" type="text" class="text-white py-2 px-4 text-sm bg-gray-900 rounded-md hover:bg-gray-950 w-full" placeholder="Phone" />
                    <select v-model="employee.status" class="text-white py-2 px-4 text-sm bg-gray-900 rounded-md hover:bg-gray-950 w-full">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    <button
                        type="submit"
                        class="mt-2 bg-yellow-500 text-white font-bold flex text-sm px-4 py-2 rounded-md hover:bg-yellow-600"
                    >
                        <div class="mx-auto flex items-center">
                            <DocumentTextIcon class="w-6 mr-2"/>
                            Submit
                        </div>
                    </button>
                </div>
            </form>
            <button
                @click="deleteEmployee"
                class="mt-2 bg-gray-900 text-red-600 font-bold flex text-sm px-4 py-2 rounded-md hover:bg-red-600/50 w-full"
            >
                <div class="mx-auto flex items-center">
                    <TrashIcon class="w-6 mr-2"/>
                    Delete This Employee
                </div>
            </button>
        </Modal>
    </div>
</template>