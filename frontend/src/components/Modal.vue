<script setup>
const emit = defineEmits(['close']);
function closeModal() {
  emit("close");
}
</script>

<template>
    <Teleport to="body">
        <div class="fixed inset-0 bg-black/30 z-40 flex items-center justify-center" @click="closeModal">
            <div class="bg-gray-800 rounded-xl w-full max-w-lg p-6 relative shadow-xl z-50" @click.stop>
                <button
                    @click="closeModal"
                    class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-xl"
                >
                    &times;
                </button>
                <slot />
            </div>
        </div>
    </Teleport>
</template>

