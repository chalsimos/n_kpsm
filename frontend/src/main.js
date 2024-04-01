import { createApp } from 'vue'
import App from './App.vue'
import './registerServiceWorker'
import router from './router'
import store from './store';

import axios from 'axios'
axios.defaults.baseURL="http://n_kpsm.test/api/";
export default axios;

createApp(App)
.use(router)
.use(store)
.mount('#app')
