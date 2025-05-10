<script setup>
import AppModal from "@/components/Modal.vue";2
import ProfileEditForm from "@/features/employee/EmployeeCreateForm.vue";

const emit = defineEmits(["close"]);

function closeModal() {
  emit("close");
}
</script>
<template>
  <AppModal @close="closeModal">
    <template #title> Edit Profile </template>
    <template #body>
      <ProfileEditForm @submitted="closeModal" />
    </template>
  </AppModal>
</template>