<template>
  <div>
    <Header />
    <div class="pt-16">
      <TrendingSection />
      <div class="container mx-auto mt-4 px-4">
        <transition name="fade" mode="out-in">
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-4" v-if="article">
            <!-- Left Column -->
            <div class="lg:col-span-2">
              <transition name="fade-slide">
                <div v-if="article" class="bg-white rounded-lg shadow-md overflow-hidden">
                  <div class="text-sm text-indigo-600 font-semibold animated-text">{{ article.category }}</div>
                  <h2 class="mt-1 text-6xl font-bold text-gray-800 animated-text">{{ article.title }}</h2>
                  
                  <h2 class="animated-text">Article Views Count: {{ articleViewsCount }}</h2>

                  <!-- Social Sharing Buttons -->
                  <div class="mt-2 flex space-x-4 animated-text">
                    <a :href="`https://www.facebook.com/sharer/sharer.php?u=http://localhost:9000/articles/1`" target="_blank" rel="noopener noreferrer">
                      <img src="@/assets/icons/facebook.png" alt="Facebook" class="w-6 h-6">
                    </a>
                    <a :href="`https://twitter.com/intent/tweet?text=${encodeURIComponent(article.title)}&url=${encodeURIComponent(currentUrl)}`" target="_blank" rel="noopener noreferrer">
                      <img src="@/assets/icons/twitter.png" alt="twitter" class="w-6 h-6">
                    </a>
                    <a :href="`https://www.linkedin.com/shareArticle?mini=true&url=${encodeURIComponent(currentUrl)}&title=${encodeURIComponent(article.title)}`" target="_blank" rel="noopener noreferrer">
                      <img src="@/assets/icons/linkedin.png" alt="linkedin" class="w-6 h-6">
                    </a>
                  </div>
                  <div class="mt-4 text-sm text-gray-500 animated-text">{{ formatDate(article.created_at) }}</div>
                  <br>
                  <img class="w-full h-64 object-cover article-image" :src="article.imageUrl || 'https://via.placeholder.com/800x400'" alt="Article Image">
                  <div class="p-4">
                    <h2 class="mt-2 text-2xl font-bold text-gray-800 animated-text">{{ article.title }}</h2>
                    <p class="mt-2 text-gray-600 animated-text" v-html="article.content"></p>
                    <!-- <div v-html="article.content"></div> -->
                    <div class="mt-4 text-sm text-gray-500 animated-text">{{ formatDate(article.created_at) }}</div>
                  </div>
                </div>
              </transition>
              
            </div>
            <!-- Right Column for Clickable News List -->
            <div class="lg:col-span-1">
              <transition name="fade-slide">
                <div class="bg-white rounded-lg shadow-md p-4">
                  <h3 class="text-lg font-semibold text-gray-800 animated-text">Other Articles</h3>
                  <br>
                  <ul class="mt-2 space-y-2">
                    <li v-for="newsArticle in newsArticles" :key="newsArticle.id">
                      <router-link :to="{ name: 'Article', params: { id: newsArticle.id } }" class="text-indigo-600 hover:underline animated-text">
                        {{ newsArticle.title }}
                      </router-link>
                      <p class="text-sm text-gray-600 animated-text">{{ formatDate(newsArticle.created_at) }}</p>
                    </li>
                  </ul>
                </div>
              </transition>
            </div>
          </div>
        </transition>
      </div>
    </div>
    <ModalImage v-if="showModal" :imageSrc="modalImageSrc" @close="showModal = false" />

  </div>
</template>
<script>
import axios from '../main.js';
import Header from './Header.vue';
import TrendingSection from './TrendingSection.vue';
import CryptoJS from 'crypto-js';

export default {
  name: 'Article',
  components: {
    Header,
    TrendingSection,
  },
  data() {
    return {
      articleViewsCount: 0,
      article: null,
      newsArticles: [],
      currentUrl: window.location.href,
    };
  },
  watch: {
    '$route.params.id': 'getArticle'
  },
  mounted() {
    this.getArticle();
    this.getNewsArticles();
    this.fetchArticleViews();
  },
  methods: {
    fetchArticleViews() {
      const encryptedId = this.$route.params.id;
      //const articleId = this.decrypt(encryptedId);
      axios.get(`/api/count-article-views/${encryptedId}`)
        .then(response => {
          this.articleViewsCount = response.data.count;
        })
        .catch(error => {
          console.error('Error fetching article views count:', error);
        });
    },
    async getArticle() {
      try {
        const articleId = this.$route.params.id;
        const response = await axios.get(`/api/news-portal/getArticle/${articleId}`);
        this.article = response.data.data;
        this.currentUrl = window.location.href;
        this.articlecounter(articleId);
      } catch (error) {
        console.error('Error fetching article:', error);
      }
    },
    async getNewsArticles() {
      try {
        const response = await axios.get('/api/news-portal/getTrendingArticles');
        this.newsArticles = response.data.data;
      } catch (error) {
        console.error('Error fetching news articles:', error);
      }
    },
    async articlecounter(articleId) {
      try {
        await axios.post('/api/news-portal/articlecounter', { id: articleId });
      } catch (error) {
        console.error('Error posting decrypted ID:', error);
      }
    },
    formatDate(date) {
      if (!date) return '';
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(date).toLocaleDateString(undefined, options);
    },
    decrypt(encryptedId) {
      const secretKey = '08004220700'; // Use a secure key and manage it properly
      const bytes = CryptoJS.AES.decrypt(encryptedId, secretKey);
      return bytes.toString(CryptoJS.enc.Utf8);
    },
    encrypt(id) {
      const secretKey = '08004220700'; // Use a secure key and manage it properly
      return CryptoJS.AES.encrypt(id.toString(), secretKey).toString();
    }
  },
};
</script>
<style scoped>
/* Scoped styles for ArticlePage.vue can go here */

.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
  opacity: 0;
}

.fade-slide-enter-active, .fade-slide-leave-active {
  transition: all 0.5s ease;
}
.fade-slide-enter, .fade-slide-leave-to {
  opacity: 0;
  transform: translateY(10px);
}

.article-image {
  animation: imageLoadAnimation 1s ease forwards;
  transition: transform 0.3s ease;
}
.article-image:hover {
  transform: scale(1.05);
}

@keyframes imageLoadAnimation {
  from {
    opacity: 0;
    transform: scale(0.95);
  }
  to {
    opacity: 1;
    transform: scale(1);
  }
}

.animated-text {
  opacity: 0;
  animation: textLoadAnimation 1s ease forwards;
}
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
  opacity: 0;
}

@keyframes textLoadAnimation {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
