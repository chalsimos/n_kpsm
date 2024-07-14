import { createApp } from 'vue'
import App from './App.vue'
import './registerServiceWorker'
import router from './router'
import store from './store';
import './assets/index.css'
import 'flowbite'
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";
import VueCameraLib from 'vue-camera-lib'
import Antd from 'ant-design-vue';
import axios from 'axios'
import CKEditor from '@ckeditor/ckeditor5-vue';
import './assets/tailwind.css';

import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faFacebookF, faTwitter, faLinkedinIn } from '@fortawesome/free-brands-svg-icons';

// Add the icons to the library
library.add(faFacebookF, faTwitter, faLinkedinIn);
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
.component('font-awesome-icon', FontAwesomeIcon)
.use(router)
.use(Antd)
.use(VueCameraLib)
.use(CKEditor)
.use(Toast, {
  transition: "Vue-Toastification__bounce",
  maxToasts: 20,
  newestOnTop: true
})
.use(vuetify)
.mount('#app')
