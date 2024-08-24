<template>
  <div class="container mx-auto mt-4 px-4">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
      <!-- Left Column -->
      <transition-group name="fade">
      <div class="lg:col-span-2" v-if="mainArticle">
        <div class="bg-white rounded-lg shadow-md overflow-hidden" ref="mainArticleContainer">
          <router-link :to="`/arts/${mainArticle.id}`">
            <img class="w-full h-64 object-cover img-hover" :src="mainArticle.imageUrl || 'https://via.placeholder.com/800x400'" alt="Main Article Image">
          </router-link>
          <div class="p-4 animate-on-load" v-if="mainArticleVisible">
            <div class="text-sm text-indigo-600 font-semibold">{{ mainArticle.category }}</div>
            <router-link :to="`/arts/${mainArticle.id}`">
              <h2 class="mt-2 text-2xl font-bold text-gray-800">{{ mainArticle.title }}</h2>
            </router-link>
            <p class="mt-2 text-gray-600">{{ truncatedContent }}</p>
            <router-link :to="`/arts/${mainArticle.id}`" class="mt-4 inline-block text-indigo-600 hover:underline">Read more</router-link>
          </div>
        </div>
      </div>
    </transition-group>
      <!-- Right Column -->
      <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-md p-4">
          <h3 class="text-lg font-semibold text-gray-800">Trending</h3>
          <ul class="mt-2 space-y-2">
            <li v-for="trendingArticle in trendingArticles" :key="trendingArticle.id">
              <router-link :to="`/arts/${trendingArticle.id}`" class="text-indigo-600 hover:underline">{{ trendingArticle.title }}</router-link>
              <p class="text-sm text-gray-600">{{ formatDate(trendingArticle.created_at) }}</p>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Trending News Section -->
    <h2 class="text-2xl font-bold mt-8 mb-4">Trending News</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div v-for="trendingArticle in moreTrendingArticles" :key="trendingArticle.id" class="bg-white rounded-lg shadow-md overflow-hidden">
        <router-link :to="`/arts/${trendingArticle.id}`">
          <img class="w-full h-48 object-cover" :src="trendingArticle.imageUrl || 'https://via.placeholder.com/400x200'" alt="Article Image">
        </router-link>
        <div class="p-4">
          <div class="text-sm text-indigo-600 font-semibold">{{ trendingArticle.category }}</div>
          <router-link :to="`/arts/${trendingArticle.id}`" class="block mt-2 text-lg leading-tight font-medium text-black hover:underline">{{ trendingArticle.title }}</router-link>
          <p class="mt-2 text-gray-500">{{ formatDate(trendingArticle.created_at) }}</p>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from '../main.js';
import CryptoJS from 'crypto-js';

export default {
  name: 'MainArticle',
  data() {
    return {
      mainArticle: null,
      trendingArticles: [],
      moreTrendingArticles: [],
      mainArticleVisible: false,
    };
  },
  mounted() {
    this.getMainArticle();
    this.getTrendingArticles();
  },
  updated() {
    // Initialize IntersectionObserver after the DOM has been updated and the mainArticleContainer ref is available
    if (this.mainArticle && this.$refs.mainArticleContainer instanceof HTMLElement) {
      const observer = new IntersectionObserver(this.handleIntersection, {
        root: null,
        rootMargin: '0px',
        threshold: 0.3,
      });
      observer.observe(this.$refs.mainArticleContainer);
    } else {
      console.error('Ref mainArticleContainer is not an HTMLElement');
    }
  },
  methods: {
    async getMainArticle() {
      try {
        const response = await axios.get('/api/news-portal/getMainArticle');
        this.mainArticle = response.data.data;
      } catch (error) {
        console.error('Error fetching main article:', error);
      }
    },
    async getTrendingArticles() {
      try {
        const response = await axios.get('/api/news-portal/getTrendingArticles');
        const articles = response.data.data;
        this.trendingArticles = articles.slice(0, 4);
        this.moreTrendingArticles = articles.slice(4, 6); // Adjust the slice range as needed
      } catch (error) {
        console.error('Error fetching trending articles:', error);
      }
    },
    formatDate(date) {
      if (!date) return '';
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(date).toLocaleDateString(undefined, options);
    },
    stripHtmlTags(html) {
      const div = document.createElement('div');
      div.innerHTML = html;
      return div.textContent || div.innerText || '';
    },
    handleIntersection(entries) {
      // Trigger animation when the main article container comes into view
      const entry = entries[0];
      if (entry.isIntersecting && !this.mainArticleVisible) {
        this.mainArticleVisible = true;
      }
    },
  },
  computed: {
    truncatedContent() {
      if (!this.mainArticle || !this.mainArticle.content) return '';
      const textContent = this.stripHtmlTags(this.mainArticle.content);
      return textContent.length > 272 ? textContent.substring(0, 272) + '...' : textContent;
    }
  },
};
</script>
<style scoped>
.animate-on-load {
  animation: fadeInAnimation 5s ease forwards;
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

.img-hover {
  transition: transform 0.3s ease;
}

.img-hover:hover {
  transform: scale(1.05);
}

.article-image {
  transition: transform 0.3s ease;
}

.img-hover:hover .article-image {
  transform: scale(1.1);
}
</style>
