<template>
  <header class="fixed top-0 left-0 w-full bg-white shadow-md z-50">
    <div class="container mx-auto flex items-center justify-between py-4 px-4">
      <div class="text-2xl font-bold">KPSM</div>
      <nav class="space-x-4">
        <router-link to="/" class="text-gray-600 hover:text-gray-900">Home</router-link>
        <router-link to="/pages" class="text-gray-600 hover:text-gray-900">Pages</router-link>
        <router-link to="/posts" class="text-gray-600 hover:text-gray-900">Posts</router-link>
        <router-link to="/categories" class="text-gray-600 hover:text-gray-900">Categories</router-link>
        <router-link to="/world" class="text-gray-600 hover:text-gray-900">World</router-link>
        <router-link to="/sports" class="text-gray-600 hover:text-gray-900">Sports</router-link>
        <router-link to="/contact" class="text-gray-600 hover:text-gray-900">Contact</router-link>
      </nav>
      <div class="relative">
        <input
          type="text"
          v-model="searchQuery"
          @keydown.enter="performSearch"
          placeholder="Search..."
          class="border rounded py-1 px-2 pl-8"
        />
        <font-awesome-icon icon="search" class="absolute top-1/2 left-2 transform -translate-y-1/2 text-gray-600" />
      </div>
    </div>
  </header>
</template>

<script>

export default {
  name: 'Header',
  components: {
  },
  data() {
    return {
      searchQuery: ''
    };
  },
  methods: {
    performSearch() {
      // Navigate to a search results page or perform the search directly
      this.$router.push({ name: 'SearchResults', query: { q: this.searchQuery } });
    }
  }
};
</script>

<style scoped>
/* Scoped styles for Header.vue can go here */
</style>
