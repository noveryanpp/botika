<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import AuthService from '@/services/AuthService';

const router = useRouter();
const email = ref('');
const password = ref('');
const error = ref('');

const submitLogin = async () => {
  try {
    error.value = '';
    const response = await AuthService.login({ email: email.value, password: password.value });
    
    localStorage.setItem('token', response.data.token);

    router.push('/');
  } catch (err) {
    error.value = err.response?.data?.message || 'Login failed';
    console.log(error.value)
  }
};
</script>

<template>
    <div class="fixed inset-0 bg-black/30 z-40 flex items-center justify-center">
        <div class="bg-gray-800 rounded-xl w-full max-w-lg p-6 relative shadow-xl z-50">
            <form @submit.prevent="submitLogin" class="flex flex-col gap-4">
                <h2 class="text-white text-xl font-semibold">Login</h2>

                <input
                v-model="email"
                type="text"
                placeholder="Email"
                class="text-white py-2 px-4 text-sm bg-gray-900 rounded-md hover:bg-gray-950 w-full"
                />
                <input
                v-model="password"
                type="password"
                placeholder="Password"
                class="text-white py-2 px-4 text-sm bg-gray-900 rounded-md hover:bg-gray-950 w-full"
                />

                <p v-if="error" class="text-red-400 text-sm">{{ error }}</p>

                <button
                type="submit"
                class="bg-gray-900 text-white font-bold text-sm px-4 py-2 rounded-md hover:bg-gray-950"
                >
                Login
                </button>
            </form>
        </div>
    </div>
</template>