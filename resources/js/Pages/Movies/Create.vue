<template>
    <AppLayout>
        <div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Add New Movie</h1>

            <form @submit.prevent="submit">
            <!-- Title -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Title</label>
                <input
                v-model="form.title"
                type="text"
                class="border border-gray-300 rounded-lg p-2 w-full focus:ring-2 focus:ring-blue-500 focus:outline-none"
                />
                <p v-if="errors.title" class="text-red-500 text-sm mt-1">{{ errors.title }}</p>
            </div>

            <!-- Director -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Director</label>
                <input
                v-model="form.director"
                type="text"
                class="border border-gray-300 rounded-lg p-2 w-full focus:ring-2 focus:ring-blue-500 focus:outline-none"
                />
                <p v-if="errors.director" class="text-red-500 text-sm mt-1">{{ errors.director }}</p>
            </div>

            <!-- Duration -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Duration (mins)</label>
                <input
                v-model="form.duration"
                type="number"
                class="border border-gray-300 rounded-lg p-2 w-full focus:ring-2 focus:ring-blue-500 focus:outline-none"
                />
                <p v-if="errors.duration" class="text-red-500 text-sm mt-1">{{ errors.duration }}</p>
            </div>

            <!-- Release Date -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Release Date</label>
                <input
                v-model="form.release_date"
                type="date"
                class="border border-gray-300 rounded-lg p-2 w-full focus:ring-2 focus:ring-blue-500 focus:outline-none"
                />
                <p v-if="errors.release_date" class="text-red-500 text-sm mt-1">{{ errors.release_date }}</p>
            </div>

            <!-- Tags -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Tags</label>
                <input
                v-model="form.tags"
                type="text"
                placeholder="Comma separated tags"
                class="border border-gray-300 rounded-lg p-2 w-full focus:ring-2 focus:ring-blue-500 focus:outline-none"
                />
                <p v-if="errors.tags" class="text-red-500 text-sm mt-1">{{ errors.tags }}</p>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Description</label>
                <textarea
                v-model="form.description"
                class="border border-gray-300 rounded-lg p-2 w-full focus:ring-2 focus:ring-blue-500 focus:outline-none"
                rows="4"
                ></textarea>
                <p v-if="errors.description" class="text-red-500 text-sm mt-1">{{ errors.description }}</p>
            </div>

            <!-- Buttons -->
            <div class="flex space-x-3 mt-6">
                <button
                type="submit"
                class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition"
                >
                Create
                </button>
                <InertiaLink
                :href="route('movies.index')"
                class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 transition"
                >
                Cancel
                </InertiaLink>
            </div>
            </form>
        </div>
    </AppLayout>
</template>

<script setup>
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { Link as InertiaLink, usePage } from '@inertiajs/inertia-vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

// Page props (for validation errors)
const page = usePage()
const errors = reactive({ ...page.props.value.errors })

// Form state
const form = reactive({
  title: '',
  director: '',
  duration: '',
  release_date: '',
  tags: '',
  description: '',
})

// Submit handler
const submit = () => {
  Inertia.post('/movies', form, {
    onError: (err) => {
      Object.assign(errors, err)
    },
    onSuccess: () => {
      console.log('Movie created!')
    },
  })
}
</script>