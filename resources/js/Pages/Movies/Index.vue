<template>
  <AppLayout>
    <div class="max-w-7xl mx-auto p-6">
      <!-- Header -->
      <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-gray-800">🎬 Movie Library</h1>
        <p class="text-gray-500 mt-2">Browse, search, and filter your favorite films</p>
      </div>

      <!-- Filters -->
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6 bg-white shadow p-4 rounded-lg">
        <input
          v-model="filters.search"
          type="text"
          placeholder="🔍 Search by title, director, or tags..."
          class="border border-gray-300 rounded-lg p-2 w-full sm:w-1/4 focus:ring-2 focus:ring-blue-500 focus:outline-none"
        />

        <input
          v-model="filters.tag"
          type="text"
          placeholder="# Tag (e.g. sci-fi)"
          class="border border-gray-300 rounded-lg p-2 w-full sm:w-1/4 focus:ring-2 focus:ring-blue-500 focus:outline-none"
        />

        <select
          v-model="filters.director"
          class="border border-gray-300 rounded-lg p-2 w-full sm:w-1/4 focus:ring-2 focus:ring-blue-500 focus:outline-none"
        >
          <option value="">All Directors</option>
          <option v-for="dir in directors" :key="dir" :value="dir">{{ dir }}</option>
        </select>

        <select
          v-model="filters.year"
          class="border border-gray-300 rounded-lg p-2 w-full sm:w-1/4 focus:ring-2 focus:ring-blue-500 focus:outline-none"
        >
          <option value="">All Years</option>
          <option v-for="y in years" :key="y" :value="y">{{ y }}</option>
        </select>
      </div>

      <!-- Movies Grid -->
      <div v-if="movies.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="movie in movies"
          :key="movie.id"
          class="bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-200 flex flex-col h-full"
        >
          <div class="p-5 flex-1">
            <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ movie.title }}</h2>
            <p class="text-gray-600 mb-1"><strong>Director:</strong> {{ movie.director }}</p>
            <p class="text-gray-600 mb-1"><strong>Duration:</strong> {{ movie.duration }} mins</p>
            <p class="text-gray-600 mb-1"><strong>Release:</strong> {{ formatDate(movie.release_date) }}</p>
            <p class="text-gray-700 mt-3 text-sm">{{ movie.description }}</p>
          </div>
          <div class="bg-gray-50 border-t p-3 flex justify-end space-x-3">
            <InertiaLink :href="route('movies.show', movie.id)" class="text-blue-500 hover:text-blue-700">View</InertiaLink>
            <template v-if="isAuth">
              <InertiaLink :href="route('movies.edit', movie.id)" class="text-blue-500 hover:text-blue-700">Edit</InertiaLink>
              <button @click="deleteMovie(movie.id)" class="text-red-500 hover:text-red-700">Delete</button>
            </template>
            <template v-else>
              <InertiaLink :href="route('login')" class="text-gray-500 hover:text-gray-700">Login to edit</InertiaLink>
            </template>
          </div>
        </div>
      </div>

      <!-- No movies found -->
      <div v-else class="text-center py-10 text-gray-500">
        <p class="text-lg font-medium">No movies found</p>
        <p class="text-sm">Try adjusting your filters or add a new movie.</p>
      </div>

      <!-- Pagination -->
      <div v-if="page.props.movies && page.props.movies.last_page > 1" class="flex justify-center mt-10 space-x-2">
        <button
          v-for="p in page.props.movies.last_page"
          :key="p"
          @click="goToPage(p)"
          :class="[
            'px-4 py-2 rounded-md border transition-colors duration-150',
            page.props.movies.current_page === p
              ? 'bg-blue-500 text-white border-blue-500'
              : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100'
          ]"
        >
          {{ p }}
        </button>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { usePage, Link as InertiaLink } from '@inertiajs/inertia-vue3'
import debounce from 'lodash/debounce'
import AppLayout from '@/Layouts/AppLayout.vue'

const page = usePage()

// Movies list
const movies = computed(() => page.props.value.movies?.data ?? [])

// Filters
const filters = ref({
  search: page.props.value.filters?.search ?? '',
  tag: page.props.value.filters?.tag ?? '',
  director: page.props.value.filters?.director ?? '',
  year: page.props.value.filters?.year ?? '',
})

// Unique directors & years
const directors = computed(() => [...new Set(movies.value.map(m => m.director))])
const years = computed(() =>
  [...new Set(movies.value.map(m => m.release_date ? new Date(m.release_date).getFullYear() : null))]
    .filter(Boolean)
    .sort((a, b) => b - a)
)

// Debounced filter application
const applyFilters = debounce(() => {
  Inertia.get('/movies', filters.value, { preserveState: true, replace: true })
}, 300)

watch(filters, applyFilters, { deep: true })

// Pagination
const goToPage = (pageNumber) => {
  Inertia.get('/movies', { ...filters.value, page: pageNumber }, { preserveState: true, replace: true })
}

// Format date
const formatDate = (dateStr) => {
  return dateStr ? new Date(dateStr).toLocaleDateString() : 'N/A'
}

// Auth state
const isAuth = computed(() => !!page.props.value.auth?.user)

// Delete movie (only for authenticated users)
const deleteMovie = (id) => {
  if (!isAuth.value) {
    // Redirect guests to login before attempting destructive actions
    Inertia.get('/login')
    return
  }

  if (!confirm('Are you sure you want to delete this movie?')) return

  Inertia.delete(`/movies/${id}`, {}, {
    preserveState: true,
    onSuccess: () => {
      // Immediately remove the movie from the list in the frontend
      movies.value = movies.value.filter(movie => movie.id !== id)
    },
    onError: (err) => {
      console.error('Delete failed', err)
    }
  })
}
</script>
