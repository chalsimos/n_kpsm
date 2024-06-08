<template>
<Side />
<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="admin-analytics" data-tabs-toggle="#admin-analytics-content" data-tabs-active-classes="text-purple-600 hover:text-purple-600 dark:text-purple-500 dark:hover:text-purple-500 border-purple-600 dark:border-purple-500" data-tabs-inactive-classes="dark:border-transparent text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300" role="tablist">
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="Medical-List-styled-tab" data-tabs-target="#styled-Medical-List" type="button" role="tab" aria-controls="Medical-List" aria-selected="false">Medical Assistance</button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="Educational-List-styled-tab" data-tabs-target="#styled-Educational-List" type="button" role="tab" aria-controls="Educational-List" aria-selected="false">Educational Assistance</button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="Tupad-List-styled-tab" data-tabs-target="#styled-Tupad-List" type="button" role="tab" aria-controls="Tupad-List" aria-selected="false">Tupad</button>
                </li>
                <li v-show="this.information.type === 'superadmin'" class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="Tupad-Yearly-List-styled-tab" data-tabs-target="#styled-Tupad-Yearly-List" type="button" role="tab" aria-controls="Tupad-Yearly-List" aria-selected="false">Tupad Yearly</button>
                </li>
                <li v-show="this.information.type === 'superadmin'" class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="Educational-Yearly-List-styled-tab" data-tabs-target="#styled-Educational-Yearly-List" type="button" role="tab" aria-controls="Educational-Yearly-List" aria-selected="false">Educational Yearly</button>
                </li>
                <li v-show="this.information.type === 'superadmin'" class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="Hospital-Yearly-List-styled-tab" data-tabs-target="#styled-Hospital-Yearly-List" type="button" role="tab" aria-controls="Hospital-Yearly-List" aria-selected="false">Hospital Yearly</button>
                </li>
            </ul>
        </div>
        <div id="admin-analytics-content">
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-Medical-List" role="tabpanel" aria-labelledby="Medical-List-tab">
                <Medical />
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-Educational-List" role="tabpanel" aria-labelledby="Educational-List-tab">
                <Educational />
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-Tupad-List" role="tabpanel" aria-labelledby="Tupad-List-tab">

            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-Tupad-Yearly-List" role="tabpanel" aria-labelledby="Tupad-Yearly-List-tab">
                <TupadYearly />
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-Educational-Yearly-List" role="tabpanel" aria-labelledby="Educational-Yearly-List-tab">
                <EducationalYearly />
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-Hospital-Yearly-List" role="tabpanel" aria-labelledby="Hospital-Yearly-List-tab">
                <HospitalYearly />
            </div>
        </div>

    </div>
</div>
</template>

<script>
import {
    Tag,
    Carousel,
    ConfigProvider,
    Popover
} from "ant-design-vue";
import {
    initFlowbite
} from 'flowbite'
import Side from '@/views/AdminViews/Home/Sidebar.vue'
import Educational from '@/views/AdminViews/Analytics/Educational.vue'
import TupadYearly from '@/views/AdminViews/Analytics/TupadYearly.vue'
import HospitalYearly from '@/views/AdminViews/Analytics/HospitalYearly.vue'
import EducationalYearly from '@/views/AdminViews/Analytics/EducationalYearly.vue'
import Medical from '@/views/AdminViews/Analytics/Medical.vue'
import Foot from "@/views/AdminViews/Home/Footer.vue";
import VueApexCharts from 'vue3-apexcharts';
import axios from '../../../main.js';
export default {
    components: {
        Side,
        Medical,
        Educational,
        TupadYearly,
        EducationalYearly,
        HospitalYearly,
        Carousel,
        Popover,
        ConfigProvider,
        Foot,
        Tag,
        apexchart: VueApexCharts
    },
    data() {
        return {
            information: [],
        };
    },
    mounted() {
        initFlowbite();
        this.token = localStorage.getItem('token');
        if (this.token) {
            this.isLoggedIn = true;
            this.getUser();
        }
    },
    methods: {

        getUser() {
            const config = {
                headers: {
                    Authorization: `Bearer ${this.token}`
                }
            };
            axios.get('/api/getuser', config)
                .then(response => {
                    this.information = response.data.user;
                })
                .catch(error => {
                    console.error('Error retrieving user data:', error);
                    if (error.response) {
                        console.error('Response status:', error.response.status);
                        console.error('Response data:', error.response.data);
                    } else if (error.request) {
                        console.error('Request made but no response received:', error.request);
                    } else {
                        console.error('Error setting up request:', error.message);
                    }
                });
        },
    },
};
</script>
