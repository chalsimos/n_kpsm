<!-- src/components/FollowUs.vue -->
<template>
    <div class="bg-white rounded-lg shadow-md p-4 mt-8">
      <h3 class="text-lg font-semibold text-gray-800 mb-4">Follow Us</h3>
      <div class="grid grid-cols-2 gap-4">
        <div class="flex items-center justify-center bg-blue-600 text-white py-2 rounded-lg">
          <i class="fab fa-facebook-f mr-2"></i> 34,456 Fans
        </div>
        <div class="flex items-center justify-center bg-blue-400 text-white py-2 rounded-lg">
          <i class="fab fa-twitter mr-2"></i> 34,456 Followers
        </div>
        <div class="flex items-center justify-center bg-red-600 text-white py-2 rounded-lg">
          <i class="fab fa-youtube mr-2"></i> 34,456 Subscribers
        </div>
        <div class="flex items-center justify-center bg-purple-600 text-white py-2 rounded-lg">
          <i class="fab fa-instagram mr-2"></i> 34,456 Followers
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'FollowUs'
  }
  </script>
  
  <style scoped>
  /* Scoped styles for FollowUs.vue can go here */
  </style>
  