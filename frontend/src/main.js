import { createApp } from 'vue'
import App from './App.vue'
import './registerServiceWorker'
import router from './router'
import store from './store';
import './assets/index.css'
import 'flowbite'

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
.use(vuetify)
.mount('#app')
