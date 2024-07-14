<!-- src/views/home/HomePage.vue -->
<template>
  <div>
    <Header />
    <div class="pt-16"> <!-- Add padding top to offset the fixed header height -->
      <TrendingSection /> 
      <FeatureNews />
      <MainArticle />
      <SocialMediaFollow />
      <MostViewed />
    </div>
  </div>
</template>

<script>
import Header from '../../../components/Header.vue';
import TrendingSection from '../../../components/TrendingSection.vue';
import FeatureNews from '../../../components/FeatureNews.vue';
import MainArticle from '../../../components/MainArticle.vue';
import SocialMediaFollow from '../../../components/SocialMediaFollow.vue';
import MostViewed from '../../../components/MostViewed.vue';

export default {
  name: 'HomePage',
  components: {
    Header,
    TrendingSection,
    FeatureNews,
    MainArticle,
    SocialMediaFollow,
    MostViewed
  }
}
</script>

<style scoped>
/* Scoped styles for HomePage.vue can go here */
</style>
