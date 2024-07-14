<template>
  <div id="app">
    <component :is="currentComponent"></component>
  </div>
</template>

<script>
import AllNews from '../../../components/DataTable.vue';;
import ManageArticle from '../../../components/ManageArticle.vue';
import Events from '../../../components/Events.vue';
import Announcement from '../../../components/Announcement.vue';
import Updates from '../../../components/Updates.vue';
import DraftPage from '../../../components/DraftPage.vue';

export default {
  name: 'App',
  components: {
    AllNews,
    ManageArticle,
    Events,
    Announcement,
    Updates,
    DraftPage,
  },
  computed: {
    currentRoute() {
      return this.$route.name;
    },
    currentComponent() {
      switch (this.currentRoute) {
        case 'NewsPage':
          return 'AllNews';
        case 'ArticlePage':
          return 'ManageArticle';
        case 'EventsPage':
          return 'Events';
        case 'AnnouncementPage':
          return 'Announcement';
        case 'UpdatesPage':
          return 'Updates';
        case 'DraftPage':
          return 'DraftPage';
        default:
          return 'AllNews'; 
      }
    }
  }
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  margin-top: 60px;
}
</style>
 