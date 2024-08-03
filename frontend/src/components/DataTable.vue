<template>
  <v-container>
    <b>Article Manager</b>
    <v-text-field
      v-model="searchQuery"
      @input="filterRows"
      label="Search..."
      solo
    ></v-text-field>

    <v-data-table
      :headers="tableHeaders"
      :items="filteredRows"
      class="elevation-1"
    >
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
        <v-img :src="item.imageUrl" alt="Image" max-width="100" contain></v-img>
      </template>
      <template v-slot:item.preview="{ item }">
        <v-btn :href="generatePreviewLink(item.id)" target="_blank" text>Preview</v-btn>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-btn @click="navigateToEditPage(item)" text>Edit</v-btn>
      </template>
    </v-data-table>
  </v-container>
</template>
<script>
import axios from 'axios';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

export default {
  name: 'ManageArticle',
  data() {
    return {
      editor: ClassicEditor,
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
    };
  },
  created() {
    this.fetchData();
  },
  methods: {
    async fetchData() {
      try {
        const response = await axios.get('/api/news-portal/news-all');
        this.rows = response.data.data.map(item => ({
          ...item,
          showFullContent: false,
          content: this.transformIframeToOembed(item.content), // Convert iframes to oembed
        }));
        this.filteredRows = this.rows;
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    },
    transformIframeToOembed(content) {
      const parser = new DOMParser();
      const doc = parser.parseFromString(content, 'text/html');
      const iframes = doc.querySelectorAll('iframe');

      iframes.forEach(iframe => {
        const url = iframe.getAttribute('src');
        if (url) {
          const oembed = document.createElement('oembed');
          oembed.setAttribute('url', url);

          const figure = document.createElement('figure');
          figure.classList.add('media');
          figure.appendChild(oembed);

          iframe.replaceWith(figure);
        }
      });

      return doc.body.innerHTML;
    },
    transformOembedToIframe(content) {
      const parser = new DOMParser();
      const doc = parser.parseFromString(content, 'text/html');
      const figures = doc.querySelectorAll('figure.media');

      figures.forEach(figure => {
        const oembed = figure.querySelector('oembed');
        if (oembed) {
          const url = oembed.getAttribute('url');
          if (url) {
            const iframe = document.createElement('iframe');
            iframe.width = '560';
            iframe.height = '315';
            iframe.src = url;
            iframe.frameBorder = '0';
            iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
            iframe.allowFullscreen = true;

            figure.replaceWith(iframe);
          }
        }
      });

      return doc.body.innerHTML;
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
    navigateToEditPage(item) {
      this.$router.push({ name: 'EditArticle', params: { id: item.id } });
    },
  },
};

</script>