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
                  <div v-if="headerImageUrl" class="container mx-auto mt-4 px-4">
                    <img :src="headerImageUrl" alt="Top Image" class="w-full h-64 object-cover">
                  </div>
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
                  <div class="p-4">
                    <h2 class="mt-2 text-2xl font-bold text-gray-800 animated-text">{{ article.title }}</h2>
                    <div class="mt-2 text-gray-600 animated-text" v-html="formattedContent"></div>
                    <div v-if="bottomImageUrl" class="container mx-auto mt-4 px-4">
                      <img :src="bottomImageUrl" alt="Top Image" class="w-full h-64 object-cover">
                    </div>
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
      topImageUrl: '',
      headerImageUrl: '',
      middleImageUrl: '',
      bottomImageUrl: '',
      middleImageCaption: '',
    };
  },
  watch: {
    '$route.params.id': 'getArticle'
  },
  mounted() {
    this.getArticle();
    this.getNewsArticles();
    this.fetchArticleViews();
    this.fetchImages();
  },
  computed: {
    formattedContent() {
      if (!this.article || !this.article.content) return '';
      
      let content = this.article.content;
      
      // Extract and remove <figure> tags with YouTube iframes
      const figureTags = [];
      const figureRegex = /<figure class="media"><iframe.*?<\/iframe><\/figure>/g;
      content = content.replace(figureRegex, (match) => {
        figureTags.push(match);
        return '[FIGURE_PLACEHOLDER]';
      });
      
      const middleImageTag = this.middleImageUrl ? `<div style="text-align: center; margin: 20px 0;"><img src="${this.middleImageUrl}" alt="${this.middleImageCaption}"  style="max-width: 100%; height: auto;" /><p>${this.middleImageCaption}</p></div>` : '';

      // Calculate the middle point
      const middlePoint = Math.floor(content.length / 2);
      
      // Find the last space before the middle point to avoid breaking words
      const splitPoint = content.lastIndexOf(' ', middlePoint);
      
      // Split the content and insert the image
      const beforeImage = content.slice(0, splitPoint);
      const afterImage = content.slice(splitPoint);
      
      let formattedContent = `${beforeImage}${middleImageTag}${afterImage}`;
      
      // Reinsert <figure> tags at their original positions
      figureTags.forEach(tag => {
        formattedContent = formattedContent.replace('[FIGURE_PLACEHOLDER]', tag);
      });
      
      return formattedContent;
    }
  },
  methods: {
    fetchImages() {
      const encryptedId = this.$route.params.id;
      axios.get(`/api/news-portal/findimage/${encryptedId}`)
        .then(response => {
          const images = response.data;
          const topImage = images.find(image => image.position === 'top');
          const headerImage = images.find(image => image.position === 'header');
          const middleImage = images.find(image => image.position === 'middle');
          const bottomImage = images.find(image => image.position === 'bottom');
          if (topImage) {
            this.topImageUrl = this.getImageUrl(topImage.location);
          }
          if (headerImage) {
            this.headerImageUrl = this.getImageUrl(headerImage.location);
          }
          if (middleImage) {
            this.middleImageUrl = this.getImageUrl(middleImage.location);
            this.middleImageCaption = middleImage.caption || ''; 
          }
          if (bottomImage) {
            this.bottomImageUrl = this.getImageUrl(bottomImage.location);
            this.bottomImageCaption = bottomImage.caption || '';
          }
        })
        .catch(error => {
          console.error('Error fetching images:', error);
        });
    },
    fetchArticleViews() {
      const encryptedId = this.$route.params.id;
      axios.get(`/api/news-portal/count-article-views/${encryptedId}`)
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
    getImageUrl(url) {
      return url.startsWith('http://') || url.startsWith('https://') ? url : `http://localhost:8000/storage/${url}`;
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
