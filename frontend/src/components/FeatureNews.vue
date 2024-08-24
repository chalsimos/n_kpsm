<template>
  <div class="container mx-auto mt-8">
    <h2 class="text-2xl font-bold mb-4">Featured News</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
      <transition-group name="fade">
        <div v-for="article in articles" :key="article.id" class="article-card bg-white rounded-lg shadow-md overflow-hidden animate-on-load">
          <router-link :to="`/arts/${article.id}`">
            <img class="w-full h-48 object-cover article-image" :src="article.imageUrl || fallbackImage" alt="Featured Image">
          </router-link>
          <div class="p-4">
            <router-link :to="`/arts/${article.id}`">
              <div class="text-sm text-indigo-600 font-semibold">{{ article.title }}</div>
            </router-link>
            <router-link :to="`/arts/${article.id}`">
              <h3 class="mt-2 text-lg font-bold text-gray-800">{{ article.category }}</h3>
            </router-link>
            <p class="text-sm text-gray-600">{{ formatDate(article.created_at) }}</p>
          </div>
        </div>
      </transition-group>
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-between">
      <button @click="loadPreviousPage" :disabled="currentPage === 1">Previous</button>
      <button @click="loadNextPage" :disabled="currentPage === totalPages">Next</button>
    </div>
  </div>
</template>

<script>
import axios from '../main.js'; 
import CryptoJS from 'crypto-js';

export default {
  name: 'FeaturedNews',
  data() {
    return {
      articles: [],
      fallbackImage: 'https://via.placeholder.com/300',
      currentPage: 1,
      totalPages: 1
    };
  },
  mounted() {
    this.getFeatured();
  },
  methods: {
    async getFeatured() {
      try {
        const response = await axios.get(`/api/news-portal/featured-article?page=${this.currentPage}`);
        console.log('API response:', response.data);
        this.articles = response.data.articles;
        this.totalPages = response.data.totalPages;
        window.scrollTo(0, 0); // Scroll to the top of the page
      } catch (error) {
        console.log('Error fetching data:', error);
      }
    },
    loadPreviousPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
        this.getFeatured();
      }
    },
    loadNextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
        this.getFeatured();
      }
    },
    formatDate(date) {
      if (!date) return '';
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(date).toLocaleDateString(undefined, options);
    },
  }
};
</script>

<style scoped>
.animate-on-load {
  animation: fadeInAnimation 1.3s ease forwards;
  opacity: 0;
}

@keyframes fadeInAnimation {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.article-card {
  transition: transform 0.3s ease;
}

.article-card:hover {
  transform: scale(1.05);
}

.article-image {
  transition: transform 0.3s ease;
}

.article-card:hover .article-image {
  transform: scale(1.1);
}
</style>
