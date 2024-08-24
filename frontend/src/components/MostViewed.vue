<!-- src/components/MostViewed.vue -->
<template>
  <div class="container mx-auto mt-8 px-4">
    <h2 class="text-2xl font-bold mb-4">Most Viewed</h2>
    <div class="bg-white rounded-lg shadow-md p-4">
      <ul class="space-y-4">
        <li v-for="article in articles" :key="article.title" class="flex items-center space-x-4">
          <div class="text-lg font-bold text-gray-800">{{ article.rank }}</div>
          <div>
            <router-link :to="`/arts/${article.id}`" class="text-lg leading-tight font-medium text-indigo-600 hover:underline">{{ article.title }}</router-link>
            <!-- <a href="#" class="text-lg leading-tight font-medium text-indigo-600 hover:underline">{{ article.title }}</a> -->
            
            <p class="text-sm text-gray-600">{{ article.category }} / {{ formatDate(article.created_at) }} Views {{article.article_count}}</p>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>
<script>
import axios from '../main.js';
import CryptoJS from 'crypto-js';
export default {
  name: 'MostViewed',
  data() {
    return {
      articles: []
    }
  },
  mounted() {
    this.getMostViewed();
  },
  methods: {
    getMostViewed(){
      axios.get('/api/news-portal/most-viewed')
      .then(response => {
        this.articles = response.data;
      })
      .catch(error => {
        console.error('Error fetching articles:', error);
      });
    },
    encrypt(id) {
      const secretKey = 'your-secret-key'; // Use a secure key and manage it properly
      return CryptoJS.AES.encrypt(id.toString(), secretKey).toString();
    },
    formatDate(datetime) {
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(datetime).toLocaleDateString(undefined, options);
    }
  }
}
</script>