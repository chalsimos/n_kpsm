<template>
    <Side />
    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
            <form @submit.prevent="postDataToBackend" class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
                <input type="text" v-model="title" placeholder="Title" class="flowbite-input mb-4" />
                <ckeditor :editor="editor" v-model="editorData" />
                <select v-model="category" class="flowbite-input mb-4">
                    <option value="" disabled>Select a category</option>
                    <option v-for="category in categories" :key="category" :value="category">
                        {{ category }}
                    </option>
                </select>
                <select v-model="type" class="flowbite-input mb-4">
                    <option value="" disabled>Select a type</option>
                    <option value="news">News</option>
                    <option value="event">Event</option>
                </select>
                <select v-model="ntype" class="flowbite-input mb-4">
                    <option value="" disabled>Select a news type</option>
                    <option value="article">Article</option>
                    <option value="breaking">Breaking</option>
                    <option value="regular">Regular</option>
                </select>
                <select v-model="status" class="flowbite-input mb-4">
                    <option value="" disabled>Select status</option>
                    <option value="draft">Draft</option>
                    <option value="published">Published</option>
                </select>
                <div ref="dropzone" class="dropzone mb-4"></div>
                <button type="submit" class="flowbite-button">Submit</button>
            </form>
            <div v-if="message" class="text-green-600">{{ message }}</div>
        </div>
    </div>
</template>

<script>
import Side from '@/views/AdminViews/Home/Sidebar.vue';
import Dropzone from 'dropzone';
import 'dropzone/dist/dropzone.css';
import axios from 'axios';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

export default {
    name: 'AddNews',
    components: {
        Side,
    },
    data() {
        return {
            editor: ClassicEditor,
            editorData: '',
            title: '',
            content: '',
            category: '',
            type: '',
            ntype: '',
            status: '',
            categories: ['News', 'Events', 'Announcements', 'Updates'],
            message: '', 
            imageUrl: '', 

        };
    },
    mounted() {
        this.initDropzone();
        this.fetchAuthor();
    },
    methods: {
        async fetchAuthor() {
            try {
                const response = await axios.get('/api/news-portal/get-author');
                this.author = response.data.author;
            } catch (error) {
                console.log('Error fetching author:', error);
            }
        },
        async postDataToBackend() {
            try {
                const formData = new FormData()
                formData.append('title', this.title);
                const transformedContent = this.transformOembedToIframe(this.editorData);
                formData.append('content', transformedContent);
                formData.append('category', this.category);
                formData.append('type', this.type);
                formData.append('ntype', this.ntype);
                formData.append('status', this.status);
                formData.append('imageUrl', this.imageUrl); 
                const response = await axios.post('/api/news-portal/post-news', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                this.message = response.data.message; 
                console.log(response);
            } catch (error) {
                console.log('Error posting data to backend:', error);
            }
        },
        transformOembedToIframe(content) {
            const parser = new DOMParser();
            const doc = parser.parseFromString(content, 'text/html');
            const oembeds = doc.querySelectorAll('oembed');

            oembeds.forEach(oembed => {
                const url = oembed.getAttribute('url');
                if (url) {
                    const videoId = new URL(url).searchParams.get('v');
                    if (videoId) {
                        const iframe = document.createElement('iframe');

                        iframe.width = '560';
                        iframe.height = '315';
                        iframe.src = `https://www.youtube.com/embed/${videoId}`;
                        iframe.frameBorder = '0';
                        iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
                        iframe.allowFullscreen = true;

                        oembed.replaceWith(iframe);
                    }
                }
            });

            return doc.body.innerHTML;
        },
        initDropzone() {
            const dropzoneElement = this.$refs.dropzone;
            const defaultOptions = {
                url: 'http://127.0.0.1:8000/api/news-portal/upload-file',
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
            this.imageUrl = response.path; 
        },
        onError(file, errorMessage) {
            console.error('Error uploading file:', file, errorMessage);
        },
        onAddedFile(file) {
            console.log('File added:', file);
        },
    },
    beforeUnmount() {
        if (this.dropzone) {
            this.dropzone.destroy();
        }
    },
};
</script>

<style scoped>
.flowbite-input {
  border: 2px solid #007bff;
  border-radius: 5px;
  padding: 10px;
  width: 100%;
}
.flowbite-textarea {
  border: 2px solid #007bff;
  border-radius: 5px;
  padding: 10px;
  width: 100%;
  height: 150px;
}
.flowbite-button {
  background-color: #007bff;
  color: white;
  padding: 10px 20px;
  border-radius: 5px;
  border: none;
  cursor: pointer;
}
.dropzone {
  border: 2px dashed #007bff;
  border-radius: 5px;
  background: white;
  padding: 20px;
  margin-top: 20px;
}
</style>
