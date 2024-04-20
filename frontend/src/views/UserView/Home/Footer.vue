<template>
	<footer class="bg-white bottom-0 left-0 w-full">
		<div class="w-full max-w-screen-xl mx-auto p-10 md:py-8">
			<div class="sm:flex sm:items-center sm:justify-between">
				<a href="/" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
					<img :src="logoUrl" class="h-8" alt="Flowbite Logo" />
					<span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white hover:text-orange-500">KPSM</span>
				</a>
				<ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
					<li>
						<a href="#" class="hover:text-orange-500 me-4 md:me-6 cursor-help">About</a>
					</li>
					<li>
						<a href="#" class="hover:text-orange-500 me-4 md:me-6 cursor-help">Privacy Policy</a>
					</li>
					<li>
						<a href="#" class="hover:text-orange-500 me-4 md:me-6 cursor-help">Licensing</a>
					</li>
					<li>
						<a href="#" class="hover:text-orange-500 me-4 md:me-6  cursor-help">Contact</a>
					</li>
				</ul>
			</div>
			<hr class="my-4 border-orange-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
			<span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400 hover:text-orange-500 cursor-pointer">© 2024 <a href="/" class="hover:text-orange-500">KPSM™</a>. All Rights Reserved.</span>
		</div>
	</footer>
</template>


<script>
import axios from '../../../main.js';

export default {
  data() {
    return {
      logoUrl: '' 
    };
  },
  mounted() {
    this.fetchActiveLogos();
  },
  methods: {
    fetchActiveLogos() {
      axios.get('/api/active-logos')
        .then(response => {
          if (response.data && response.data.image_url) {
            this.logoUrl = axios.defaults.baseURL + response.data.image_url;
          } else {
            console.error('Invalid response data:', response.data);
          }
        })
        .catch(error => {
          console.error('Error fetching active logos:', error);
        });
    }
  }
};
</script>
