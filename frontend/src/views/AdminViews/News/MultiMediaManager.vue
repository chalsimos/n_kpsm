<template>
    <Side />
    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
            <h1 class="text-2xl font-bold text-center mt-4 mb-6">Multimedia Manager</h1>
            <div ref="dropzone" class="dropzone mb-4"></div>
            <div class="image-list mt-4">
                <h2 class="text-lg font-semibold mb-2">Uploaded Images</h2>
                <div class="tabs">
                    <button :class="{'active': activeTab === 'all'}" @click="activeTab = 'all'">All Images</button>
                    <!-- <button :class="{'active': activeTab === 'albums'}" @click="activeTab = 'albums'">Albums</button> -->
                </div>
                <div v-if="activeTab === 'all'" class="grid grid-cols-4 gap-4 mt-4">
                    <div v-for="image in images" :key="image.id" class="image-item">
                        <img :src="getImageUrl(image.url)" alt="Uploaded Image" class="w-full h-auto rounded-lg shadow-md cursor-pointer" @click="showImageModal(image)"/>
                        <div v-if="image.caption" class="mt-2 text-sm text-gray-700">{{ image.caption }}</div>
                    </div>
                </div>
                <div v-else-if="activeTab === 'albums'" class="mt-4">
                    <!-- Albums content goes here -->
                    <p>No albums available.</p>
                </div>
            </div>
        </div>
        <div v-if="isModalVisible" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-4 rounded-lg shadow-lg relative max-w-md w-full">
                <span class="absolute top-2 right-2 text-xl cursor-pointer" @click="isModalVisible = false">&times;</span>
                <img :src="modalImageUrl" alt="Modal Image" class="max-w-full max-h-full mb-4"/>
                <div>
                    <label for="caption" class="block text-sm font-medium text-gray-700">Caption</label>
                    <input v-model="modalImage.caption" type="text" id="caption" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"/>
                </div>
                <div class="mt-4">
                    <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
                    <select v-model="modalImage.position" id="position" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="header">Header</option>
                        <option value="top">Top</option>
                        <option value="middle">Middle</option>
                        <option value="bottom">Bottom</option>
                    </select>
                </div>
                <div class="mt-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select v-model="modalImage.status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="mt-4">
                    <label for="news_id" class="block text-sm font-medium text-gray-700">News</label>
                    <select v-model="modalImage.news_id" id="news_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option v-for="news in newsList" :key="news.id" :value="news.id">{{ news.title }}</option>
                    </select>
                </div>
                <div class="mt-4">
                    <button @click="updateImage" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Update</button>
                </div>
            </div>
        </div>
        <div v-if="isUpdateModalVisible" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-4 rounded-lg shadow-lg relative max-w-md w-full">
                <span class="absolute top-2 right-2 text-xl cursor-pointer" @click="isUpdateModalVisible = false">&times;</span>
                <p class="mb-4">Image updated successfully!</p>
                <button @click="previewNews" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Preview News</button>
            </div>
        </div>
    </div>
</template>

<script>
import Side from '@/views/AdminViews/Home/Sidebar.vue';
import Dropzone from 'dropzone';
import 'dropzone/dist/dropzone.css';
import axios from 'axios';

export default {
    name: 'MultiMediaManager',
    components: {
        Side,
    },
    data() {
        return {
            images: [],
            newsList: [],
            activeTab: 'all',
            isModalVisible: false,
            isUpdateModalVisible: false,
            modalImageUrl: '',
            modalImage: {
                id: null,
                url: '',
                caption: '',
                position: '',
                status: 'active',
                news_id: null,
            },
        };
    },
    mounted() {
        this.initDropzone();
        this.fetchImages();
        this.fetchNews();
    },
    methods: {
        initDropzone() {
            const dropzoneElement = this.$refs.dropzone;
            const defaultOptions = {
                url: 'https://congress.kpsm.online/api/news-portal/upload-file',
                maxFilesize: 2,
                acceptedFiles: 'image/*',
            };
            this.dropzone = new Dropzone(dropzoneElement, defaultOptions);
            this.dropzone.on('success', this.onSuccess);
            this.dropzone.on('error', this.onError);
            this.dropzone.on('addedfile', this.onAddedFile);
        },
        onSuccess(file, response) {
            console.log('File uploaded successfully:', file, response);
            this.fetchImages(); // Refresh the image list after a successful upload
        },
        onError(file, errorMessage) {
            console.error('Error uploading file:', file, errorMessage);
        },
        onAddedFile(file) {
            console.log('File added:', file);
        },
        fetchImages() {
            axios.get('https://congress.kpsm.online/api/news-portal/images')
                .then(response => {
                    this.images = response.data;
                })
                .catch(error => {
                    console.error('Error fetching images:', error);
                });
        },
        fetchNews() {
            axios.get('https://congress.kpsm.online/api/getnews')
                .then(response => {
                    this.newsList = response.data.data;
                    console.log('News List:', this.newsList);
                })
                .catch(error => {
                    console.error('Error fetching news:', error);
                });
        },
        getImageUrl(url) {
            return url.startsWith('http://') ? url : `https://congress.kpsm.online${url}`;
        },
        showImageModal(image) {
            this.modalImageUrl = this.getImageUrl(image.url);
            this.modalImage = { ...image }; 
            this.isModalVisible = true;
        },
        updateImage() {
            axios.put(`https://congress.kpsm.online/api/news-portal/images/${this.modalImage.id}`, this.modalImage)
                .then(response => {
                    console.log('Image updated successfully:', response);
                    this.isModalVisible = false;
                    this.isUpdateModalVisible = true;
                    this.fetchImages(); 
                })
                .catch(error => {
                    console.error('Error updating image:', error);
                });
        },
        previewNews() {
            if (this.modalImage.news_id) {
                window.open(`http://localhost:8080/arts/${this.modalImage.news_id}`, '_blank');
            } else {
                console.error('No news associated with this image');
            }
        },
    }
}
</script>

<style>
.image-list {
    margin-top: 20px;
}
.tabs {
    display: flex;
    border-bottom: 2px solid #e5e7eb;
}
.tabs button {
    padding: 10px 20px;
    cursor: pointer;
    border: none;
    outline: none;
    background-color: transparent;
    font-weight: 600;
    color: #6b7280;
}
.tabs button.active {
    border-bottom: 2px solid #4f46e5;
    color: #4f46e5;
}
.image-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}
.image-item img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
.cursor-pointer {
    cursor: pointer;
}
.fixed {
    position: fixed;
}
.inset-0 {
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
}
.z-50 {
    z-index: 50;
}
.flex {
    display: flex;
}
.items-center {
    align-items: center;
}
.justify-center {
    justify-content: center;
}
.bg-black {
    background-color: black;
}
.bg-opacity-50 {
    background-opacity: 0.5;
}
.bg-white {
    background-color: white;
}
.p-4 {
    padding: 1rem;
}
.rounded-lg {
    border-radius: 0.5rem;
}
.shadow-lg {
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
}
.relative {
    position: relative;
}
.absolute {
    position: absolute;
}
.top-2 {
    top: 0.5rem;
}
.right-2 {
    right: 0.5rem;
}
.text-xl {
    font-size: 1.25rem;
}
</style>
