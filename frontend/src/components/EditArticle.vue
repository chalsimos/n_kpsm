<template>
  <v-container>
    <v-card>
      <v-card-title>
        <span class="headline">Edit Article</span>
      </v-card-title>
      <v-card-text>
        <v-text-field
          v-model="article.title"
          label="Title"
          solo
        ></v-text-field>
        <ckeditor :editor="editor" v-model="article.content" />

        <v-select
          v-model="article.category"
          :items="newsCategories"
          label="Category"
          solo
        ></v-select>
        <v-select
          v-model="article.status"
          :items="statusOptions"
          label="Status"
          solo
        ></v-select>
        <v-radio-group
          v-model="article.ntype"
          row
          label="Type"
        >
          <v-radio label="Trending" value="trending"></v-radio>
          <v-radio label="Article" value="article"></v-radio>
        </v-radio-group>
        <v-file-input
          v-model="selectedImage"
          label="Upload Image"
          solo
          @change="previewImage"
        ></v-file-input>
        <v-img v-if="imagePreview" :src="imagePreview" alt="Preview" max-width="500"></v-img>
      </v-card-text>
      <v-alert
        v-if="alertMessage"
        :type="alertType"
        dismissible
        @input="alertMessage = ''"
      >
        {{ alertMessage }}
      </v-alert>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1" text @click="cancelEdit">Cancel</v-btn>
        <v-btn color="blue darken-1" text @click="saveEdit">Save</v-btn>
      </v-card-actions>
    </v-card>
  </v-container>
</template>

<script>
import axios from 'axios';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

export default {
  data() {
    return {
      editor: ClassicEditor,
      article: {
        title: '',
        content: '',
        category: '',
        status: '',
        ntype: 'article', // default value
      },
      newsCategories: ['News', 'Events', 'Announcement', 'Updates'],
      statusOptions: ['published', 'draft'],
      selectedImage: null,
      imagePreview: null,
      alertMessage: '',
      alertType: '',
    };
  },
  created() {
    this.fetchArticle();
  },
  methods: {
    async fetchArticle() {
      try {
        const response = await axios.get(`/api/news-portal/getArticle/${this.$route.params.id}`);
        this.article = response.data.data;
        this.article.content = this.transformIframeToOembed(this.article.content); // Convert iframes to oembed
        this.imagePreview = this.article.imageUrl;
      } catch (error) {
        console.error('Error fetching article:', error);
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
    async previewImage(event) {
      const file = event.target.files[0];
      this.selectedImage = file;

      this.imagePreview = URL.createObjectURL(file);
    },
    async saveEdit() {
      if (!this.article) return;

      try {
        const formData = new FormData();
        formData.append('title', this.article.title);
        formData.append('content', this.transformOembedToIframe(this.article.content)); // Transform back before saving
        formData.append('category', this.article.category);
        formData.append('status', this.article.status);
        formData.append('ntype', this.article.ntype);

        if (this.selectedImage) {
          formData.append('imageUrl', this.selectedImage);
        }

        const response = await axios.post(`/api/news-portal/news/${this.article.id}`, formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });

        this.alertMessage = 'Article saved successfully!';
        this.alertType = 'success';

        setTimeout(() => {
          this.$router.go(-1);
        }, 2000);
      } catch (error) {
        console.error('Error updating article:', error);
        this.alertMessage = 'Failed to save the article.';
        this.alertType = 'error';
      }
    },
    cancelEdit() {
      this.$router.go(-1);
    },
  },
};
</script>
