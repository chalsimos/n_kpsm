<!-- src/components/TrendingSection.vue -->
<template>
  <div class="bg-gray-100 py-2">
    <div class="container mx-auto flex items-center justify-between">
      <div class="text-red-600 font-semibold">Trending</div>
      <ul class="flex space-x-4 overflow-hidden">
        <li v-for="newsArticle in newsArticles" :key="newsArticle.id">
          <router-link :to="{ name: 'Article', params: { id: newsArticle.id } }" class="hover:underline">
            {{ truncateTitle(newsArticle.title) }}
          </router-link>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import axios from 'axios'; // Import axios

export default {
  name: 'TrendingSection',
  data() {
    return {
      newsArticles: [], // Initialize the array
    };
  },
  mounted() {
    this.getTrendingArticles();
  },
  methods: {
    async getTrendingArticles() {
      try {
        const response = await axios.get('/api/news-portal/getmviewed');
        console.log('API Response:', response.data); // Log the response for debugging
        this.newsArticles = response.data; // Directly assign the array to newsArticles
      } catch (error) {
        console.error('Error fetching news articles:', error);
      }
    },
    truncateTitle(title) {
      // Truncate the title to 10 characters
      return title.length > 20 ? title.substring(0, 20) + '...' : title;
    }
  },
};
</script>

<style scoped>
/* Scoped styles for TrendingSection.vue can go here */
</style>
