<template>
  <AppLayout>
    <div class="max-w-4xl mx-auto p-6">
      <!-- Back Link -->
      <div class="mb-6">
        <InertiaLink
          :href="route('movies.index')"
          class="text-blue-500 hover:text-blue-700 flex items-center"
        >
          ← Back to Movies
        </InertiaLink>
      </div>

      <!-- Movie Detail Card -->
      <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-8">
          <!-- Title -->
          <h1 class="text-4xl font-bold text-gray-800 mb-2">{{ movie.title }}</h1>

          <!-- Director & Release Info -->
          <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-6 text-gray-600 mb-6 border-b pb-4">
            <p><strong>Director:</strong> {{ movie.director }}</p>
            <p><strong>Release Date:</strong> {{ formatDate(movie.release_date) }}</p>
            <p><strong>Duration:</strong> {{ movie.duration }} mins</p>
          </div>

          <!-- Tags -->
          <div v-if="movie.tags" class="mb-6">
            <p class="font-semibold text-gray-700 mb-2">Tags:</p>
            <div class="flex flex-wrap gap-2">
              <span
                v-for="tag in parseTags(movie.tags)"
                :key="tag"
                class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium"
              >
                {{ tag }}
              </span>
            </div>
          </div>

          <!-- Description -->
          <div class="mb-8">
            <p class="font-semibold text-gray-700 mb-2">Description:</p>
            <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ movie.description || 'No description provided.' }}</p>
          </div>

                  <!-- Action Buttons -->
                  <div class="flex flex-col sm:flex-row sm:space-x-4 border-t pt-6">
                    <template v-if="isAuth">
                      <InertiaLink
                        :href="route('movies.edit', movie.id)"
                        class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition text-center"
                      >
                        Edit Movie
                      </InertiaLink>
                      <button
                        @click="deleteMovie"
                        class="bg-red-500 text-white px-6 py-2 rounded hover:bg-red-600 transition mt-3 sm:mt-0"
                      >
                        Delete Movie
                      </button>
                    </template>
                    <template v-else>
                      <InertiaLink :href="route('login')" class="bg-gray-300 text-gray-800 px-6 py-2 rounded hover:bg-gray-400 transition text-center">Login to edit</InertiaLink>
                    </template>
                  </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { usePage, Link as InertiaLink } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import AppLayout from '@/Layouts/AppLayout.vue'

const page = usePage()
const movie = ref(page.props.value.movie)

// Format date
const formatDate = (dateStr) => {
  return dateStr ? new Date(dateStr).toLocaleDateString() : 'N/A'
}

// Parse comma-separated tags
const parseTags = (tagsStr) => {
  return tagsStr
    ? tagsStr.split(',').map(tag => tag.trim()).filter(tag => tag)
    : []
}

// Auth state
const isAuth = computed(() => !!page.props.value.auth?.user)

// Delete movie with confirmation (only for authenticated users)
const deleteMovie = () => {
  if (!isAuth.value) {
    Inertia.get('/login')
    return
  }

  if (!confirm('Are you sure you want to delete this movie?')) return

  Inertia.delete(route('movies.destroy', movie.value.id), {}, {
    onSuccess: () => {
      Inertia.visit(route('movies.index'))
    },
    onError: (err) => {
      console.error('Delete failed', err)
    }
  })
}
</script>
