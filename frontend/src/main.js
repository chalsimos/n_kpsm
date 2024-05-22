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
axios.defaults.baseURL="http://127.0.0.1:8000";
export default axios;
import VueApexCharts from "vue3-apexcharts";
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
.use(Antd)
.use(VueCameraLib)
.use(Toast, {
  transition: "Vue-Toastification__bounce",
  maxToasts: 20,
  newestOnTop: true
})
.use(VueApexCharts)
.use(vuetify)
.mount('#app')
