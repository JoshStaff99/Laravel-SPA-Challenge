<template>
  <div>
    <!-- Header -->
    <header class="bg-gray-800 text-white py-4 shadow">
      <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
        <div class="flex items-center space-x-3">
          <h1 class="text-xl font-semibold">🎬 Movie Library</h1>

          <!-- ✅ Show user's name if logged in -->
          <span v-if="auth?.user" class="text-gray-300 text-sm">
            (Welcome, <strong>{{ auth.user.name }}</strong>)
          </span>
        </div>

        <!-- Desktop Navigation -->
        <nav class="hidden sm:flex space-x-4 items-center">
          <Link :href="route('movies.index')" class="hover:underline">Home</Link>

          <!-- Only visible if logged in -->
          <template v-if="auth?.user">
            <Link :href="route('movies.create')" class="hover:underline">Add Movie</Link>
            <button @click="logout" class="hover:underline text-red-400">
              Logout
            </button>
          </template>

          <!-- Visible if NOT logged in -->
          <template v-else>
            <Link v-if="canLogin" :href="route('login')" class="hover:underline">Login</Link>
            <Link v-if="canRegister" :href="route('register')" class="hover:underline">Register</Link>
          </template>
        </nav>

        <!-- Mobile toggle -->
        <div class="sm:hidden">
          <button @click="showMobile = !showMobile" aria-label="Toggle menu" class="p-2 rounded-md hover:bg-gray-700">
            <svg v-if="!showMobile" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>

      <!-- Mobile menu panel -->
      <div v-show="showMobile" class="sm:hidden bg-gray-800 border-t border-gray-700">
        <div class="max-w-7xl mx-auto px-4 py-3 flex flex-col space-y-2">
          <Link :href="route('movies.index')" class="text-white">Home</Link>

          <template v-if="auth?.user">
            <Link :href="route('movies.create')" class="text-white">Add Movie</Link>
            <button @click="logout" class="text-red-400 text-left">Logout</button>
          </template>

          <template v-else>
            <Link v-if="canLogin" :href="route('login')" class="text-white">Login</Link>
            <Link v-if="canRegister" :href="route('register')" class="text-white">Register</Link>
          </template>
        </div>
      </div>
    </header>

    <!-- Main content -->
    <main class="min-h-screen bg-gray-50 py-8">
      <slot />
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-4 text-center">
      <p class="text-sm">© {{ new Date().getFullYear() }} Movie Library Joshua Stafford. All rights reserved.</p>
    </footer>
  </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import { reactive, computed, ref } from 'vue'

// Access global Inertia props
const page = usePage()

// Make auth reactive so we can modify it after logout
const auth = reactive(page.props.value?.auth ?? {})

const canLogin = computed(() => page.props.value?.canLogin ?? false)
const canRegister = computed(() => page.props.value?.canRegister ?? false)

// Mobile menu state
const showMobile = ref(false)

// SPA logout
const logout = () => {
  Inertia.post('/logout', {}, {
    preserveScroll: true,
    preserveState: true,
    onSuccess: () => {
      // Clear user info so the header updates immediately
      auth.user = null
    }
  })
}
</script>

<style scoped>
header {
  backdrop-filter: blur(5px);
}
</style>
