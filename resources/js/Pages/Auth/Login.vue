<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
import { ref, computed } from 'vue'

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <!-- Header -->
        <header class="bg-gray-800 text-white py-4 shadow">
            <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <h1 class="text-2xl font-bold">🎬 Movie Library</h1>
                </div>
                <nav class="flex space-x-4 items-center">
                    <Link href="/movies" class="hover:underline">Browse Movies</Link>
                    <Link href="/register" class="hover:underline">Create Account</Link>
                </nav>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex items-center justify-center min-h-[calc(100vh-80px)] py-12 px-4 ">
            <div class="w-full max-w-md ">
                <!-- Status Message -->
                <div v-if="status" class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm">
                    {{ status }}
                </div>

                <!-- Login Card -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <!-- Card Header -->
                    <div class="px-6 py-8 bg-gray-800">
                        <h2 class="text-2xl font-bold text-white mb-2">Welcome Back</h2>
                        <p class="text-blue-100">Sign in to manage your movies</p>
                    </div>

                    <!-- Form -->
                    <form @submit.prevent="submit" class="p-6 space-y-6">
                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Address
                            </label>
                            <input
                                id="email"
                                type="email"
                                v-model="form.email"
                                required
                                autofocus
                                autocomplete="username"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                                placeholder="you@example.com"
                            />
                            <p v-if="form.errors.email" class="mt-2 text-sm text-red-600">
                                {{ form.errors.email }}
                            </p>
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password
                            </label>
                            <input
                                id="password"
                                type="password"
                                v-model="form.password"
                                required
                                autocomplete="current-password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                                placeholder="••••••••"
                            />
                            <p v-if="form.errors.password" class="mt-2 text-sm text-red-600">
                                {{ form.errors.password }}
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="w-full bg-blue-600 hover:bg-blue-700 disabled:opacity-50 text-white font-semibold py-2 px-4 rounded-lg transition duration-200"
                        >
                            {{ form.processing ? 'Signing in...' : 'Sign In' }}
                        </button>
                    </form>

                    <!-- Footer Links -->
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                        <p class="text-center text-sm text-gray-600">
                            Don't have an account?
                            <Link href="/register" class="text-blue-600 hover:text-blue-700 font-medium">
                                Create one
                            </Link>
                        </p>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="mt-6 text-center text-sm text-gray-600">
                    <p>Test credentials: <strong>test@example.com</strong> / <strong>password</strong></p>
                </div>
            </div>
        </main>
    </div>
</template>
