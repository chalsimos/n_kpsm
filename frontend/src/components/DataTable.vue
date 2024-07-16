<template>
  <v-container>
    <!-- Search input -->
    <p>News Management</p>
    <v-text-field
      v-model="searchQuery"
      @input="filterRows"
      label="Search..."
      solo
    ></v-text-field>

    <!-- Data Table -->
    <v-data-table
      :headers="tableHeaders"
      :items="filteredRows"
      class="elevation-1"
    >
      <!-- Custom slots for columns -->
      <template v-slot:item.content="{ item }">
        <div>
          <div v-if="!item.showFullContent">
            <div v-html="truncateHtml(item.content, 200)"></div>
            <v-btn v-if="item.content.length > 200" text @click="toggleContent(item)">More</v-btn>
          </div>
          <div v-else>
            <div v-html="item.content"></div>
            <v-btn text @click="toggleContent(item)">Less</v-btn>
          </div>
        </div>
      </template>
      <template v-slot:item.imageUrl="{ item }">
        <!-- Display image as Vuetify image component -->
        <v-img :src="item.imageUrl" alt="Image" max-width="100" contain></v-img>
      </template>
      <template v-slot:item.preview="{ item }">
        <!-- Button to preview link -->
        <v-btn :href="generatePreviewLink(item.id)" target="_blank" text>Preview</v-btn>
      </template>
      <template v-slot:item.actions="{ item }">
        <!-- Button to open edit modal -->
        <v-btn @click="openEditModal(item)" text>Edit</v-btn>
      </template>
    </v-data-table>

    <!-- Edit Modal Dialog -->
    <v-dialog v-model="editDialog" persistent max-width="1000px">
      <v-card>
        <v-card-title>
          <span class="headline">Edit Article</span>
        </v-card-title>
        <v-card-text>
          <v-text-field
            v-model="selectedItem.title"
            label="Title"
            solo
          ></v-text-field>
          <ckeditor :editor="editor" v-model="editorData" />
          <br>
          <div v-html="safeContent"></div>
          <v-select
            v-model="selectedItem.category"
            :items="newsCategories"
            label="Category"
            solo
          ></v-select>
          <v-select
            v-model="selectedItem.status"
            :items="statusOptions"
            label="Status"
            solo
          ></v-select>
          <v-file-input
            v-model="selectedImage"
            label="Upload Image"
            solo
            @change="previewImage"
          ></v-file-input>
          <div ref="dropzone" class="dropzone mb-4" v-if="editDialog"></div>
          <!-- Image preview -->
          <v-img v-if="imagePreview" :src="imagePreview" alt="Preview" max-width="500"></v-img>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="closeEditModal">Cancel</v-btn>
          <v-btn color="blue darken-1" text @click="saveEdit">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
import axios from 'axios';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import Dropzone from 'dropzone';
import 'dropzone/dist/dropzone.css';

export default {
  name: 'AllNews',
  data() {
    return {
      editor: ClassicEditor,
      editorData: '',
      searchQuery: '',
      rows: [],
      filteredRows: [],
      tableHeaders: [
        { text: 'Title', value: 'title' },
        { text: 'Content', value: 'content' },
        { text: 'Category', value: 'category' },
        { text: 'Status', value: 'status' },
        { text: 'Image', value: 'imageUrl' },
        { text: 'Preview', value: 'preview', sortable: false },
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      newsCategories: ['News', 'Events', 'Announcement', 'Updates'],
      statusOptions: ['published', 'draft'],
      editDialog: false,
      selectedItem: null,
      selectedImage: null,
      imagePreview: null,
      imageUrl: '',
    };
  },
  created() {
    this.fetchData();
  },
  watch: {
    editDialog(val) {
      if (val) {
        this.$nextTick(() => {
          this.initDropzone();
        });
      }
    }
  },
  methods: {
    async fetchData() {
      try {
        const response = await axios.get('/api/news-portal/news-all');
        this.rows = response.data.data.map(item => ({ ...item, showFullContent: false }));
        this.filteredRows = this.rows;
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    },
    filterRows() {
      const query = this.searchQuery.toLowerCase();
      this.filteredRows = this.rows.filter((row) =>
        Object.values(row).some((value) => String(value).toLowerCase().includes(query))
      );
    },
    generatePreviewLink(id) {
      return `/arts/${id}`;
    },
    truncateHtml(html, length) {
      if (html.length > length) {
        return html.substring(0, length) + '...';
      }
      return html;
    },
    toggleContent(item) {
      item.showFullContent = !item.showFullContent;
    },
    openEditModal(item) {
      this.selectedItem = { ...item };
      this.editorData = this.selectedItem.content;
      this.editDialog = true;
      this.imagePreview = this.selectedItem.imageUrl;
    },
    closeEditModal() {
      this.editDialog = false;
      this.selectedItem = null;
      this.selectedImage = null;
      this.imagePreview = null;
    },
    async previewImage(event) {
      const file = event.target.files[0];
      this.selectedImage = file;
      this.imagePreview = URL.createObjectURL(file);
    },
    initDropzone() {
      const dropzoneElement = this.$refs.dropzone;
      const defaultOptions = {
        url: 'http://localhost:8000/api/upload-file',
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
    async saveEdit() {
      if (!this.selectedItem) return;
      try {
        const formData = new FormData();
        formData.append('title', this.selectedItem.title);
        formData.append('content', this.editorData);
        formData.append('category', this.selectedItem.category);
        formData.append('status', this.selectedItem.status);
        if (this.selectedImage) {
          formData.append('imageUrl', this.selectedImage);
        }
        const response = await axios.post(`/api/news-portal/news/${this.selectedItem.id}`, formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });
        const updatedItem = response.data.data;
        const index = this.rows.findIndex(row => row.id === updatedItem.id);
        if (index !== -1) {
          this.$set(this.rows, index, updatedItem);
          this.filteredRows = [...this.rows];
        }
        this.fetchData();
        this.closeEditModal();
      } catch (error) {
        console.log('Error posting data to backend:', error);
      }
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
