<template>
<<<<<<< Updated upstream
  <Head />
<div class="p-4 mt-[5vh]">
    <div
      class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14"
    >
=======
  <div class="flex flex-col min-h-screen">
    <Head />
    <div class="flex-grow p-4 mt-[5vh]">
>>>>>>> Stashed changes
      <div class="grid grid-cols-3 gap-4 mb-4">
        <div class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
          <div v-for="(headline, index) in headlines" :key="index" class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
            <p class="text-lg text-gray-700 dark:text-gray-300">{{ headline.title }}</p>

          </div>
        </div>
        <div class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
          <p class="text-2xl text-gray-400 dark:text-gray-500">Featured News</p>
        </div>
        <div class="flex items-center justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
          <p class="text-2xl text-gray-400 dark:text-gray-500">More News</p>
        </div>
      </div>
      <div class="flex items-center justify-center h-48 mb-4 rounded bg-gray-50 dark:bg-gray-800">
        <p class="text-2xl text-gray-400 dark:text-gray-500">Featured Article</p>
      </div>
      <div class="grid grid-cols-2 gap-4 mb-4">
        <div v-for="(article, index) in articles" :key="index" class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
          <div>
            <p class="text-lg text-gray-700 dark:text-gray-300">{{ article.title }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">By {{ article.author }} | {{ article.date }}</p>
          </div>
        </div>
      </div>
    </div>
    <Foot />
  </div>
<<<<<<< Updated upstream
  <div class="inset-x-0 bottom-0 py-4">
        <Foot />
    </div>
=======
>>>>>>> Stashed changes
</template>


<script>
import {
    Modal,
    Tooltip,
    initTWE
} from "tw-elements";
import {
    initFlowbite
} from 'flowbite'
import Head from "@/views/UserView/Home/Header.vue";
import Foot from "@/views/UserView/Home/Footer.vue";
import axios from 'axios';
export default {
  components: {
    Head,
    Foot
  },
  data() {
    return {
      articles: [],
      headlines: []
    };
  },
  mounted() {
    initTWE({
        Modal,
        Tooltip
    });
    initFlowbite();
    document.title = "KPSM - Kongreso para sa Mamamayan";
    this.getNews();
    this.getHeadLine();
  },
 
 
  methods:{
    async getHeadLine(){
      try {
        const response = await axios.get("/api/headline");
        this.headlines = response.data;
      }catch (error){
        console.log("error retrieving headline", error);
      }
    },
    async getNews() {
    try {
      const response = await axios.get("/api/news");
      const ne = response.data;
      // console.log("Fetched news data:", ne); // Log fetched data
      this.articles = ne.data; 
    } catch (error) {
      console.error("Error fetching news:", error);
    }
  },
  }
};
</script>

