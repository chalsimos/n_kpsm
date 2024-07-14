<!-- src/components/NewsArticle.vue -->
<template>
    <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200">
      <div class="md:flex">
        <div class="md:shrink-0">
          <img class="h-48 w-full object-cover md:h-full md:w-48" :src="article.imageUrl" alt="Article Image">
        </div>
        <div class="p-8">
          <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">{{ article.category }}</div>
          <a href="#" class="block mt-1 text-lg leading-tight font-medium text-black hover:underline">{{ article.title }}</a>
          <p class="mt-2 text-gray-500">{{ article.description }}</p>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'NewsArticle',
    props: {
      article: {
        type: Object,
        required: true
      }
    }
  }
  </script>
  
  <style scoped>
  /* Scoped styles for NewsArticle.vue can go here */
  </style>
  