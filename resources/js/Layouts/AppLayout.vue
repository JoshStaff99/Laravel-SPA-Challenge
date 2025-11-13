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

        <!-- Navigation -->
        <nav class="flex space-x-4 items-center">
          <Link href="/movies" class="hover:underline">Home</Link>

          <!-- Only visible if logged in -->
          <template v-if="auth?.user">
            <Link href="/movies/create" class="hover:underline">Add Movie</Link>
            <button @click="logout" class="hover:underline text-red-400">
              Logout
            </button>
          </template>

          <!-- Visible if NOT logged in -->
          <template v-else>
            <Link v-if="canLogin" href="/login" class="hover:underline">Login</Link>
            <Link v-if="canRegister" href="/register" class="hover:underline">Register</Link>
          </template>
        </nav>
      </div>
    </header>

    <!-- Main content -->
    <main class="min-h-screen bg-gray-50 py-8">
      <slot />
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-4 text-center">
      <p class="text-sm">© {{ new Date().getFullYear() }} Movie Library. All rights reserved.</p>
    </footer>
  </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import { reactive, computed } from 'vue'

// Access global Inertia props
const page = usePage()

// Make auth reactive so we can modify it after logout
const auth = reactive(page.props.value?.auth ?? {})

const canLogin = computed(() => page.props.value?.canLogin ?? false)
const canRegister = computed(() => page.props.value?.canRegister ?? false)

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
