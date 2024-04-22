import { createApp } from 'vue'
import App from './App.vue'
import './registerServiceWorker'
import router from './router'
import store from './store';
import './assets/index.css'
import 'flowbite'
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

import axios from 'axios'
axios.defaults.baseURL="http://127.0.0.1:8000";
export default axios;

import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

const vuetify = createVuetify({
  components,
  directives,
})

createApp(App)
.use(router)
.use(store)
.use(Toast, {
  transition: "Vue-Toastification__bounce",
  maxToasts: 20,
  newestOnTop: true
})
.use(vuetify)
.mount('#app')
