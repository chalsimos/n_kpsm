<template>
<Side />
<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <a-tabs default-active-key="1" @change="handleTabChange">
            <a-tab-pane key="1" tab="Medical Assistance">
                <Medical />
            </a-tab-pane>
            <a-tab-pane key="2" tab="Educational Assistance">
                <Educational />
            </a-tab-pane>
            <a-tab-pane key="3" tab="Tupad">
            </a-tab-pane>
            <a-tab-pane v-if="information.type === 'superadmin'" key="4" tab="Tupad Yearly">
                <TupadYearly />
            </a-tab-pane>
            <a-tab-pane v-if="information.type === 'superadmin'" key="5" tab="Educational Yearly">
                <EducationalYearly />
            </a-tab-pane>
            <a-tab-pane v-if="information.type === 'superadmin'" key="6" tab="Hospital Yearly">
                <HospitalYearly />
            </a-tab-pane>
        </a-tabs>
    </div>
</div>
</template>

<script>
import {
    Tag,
    Carousel,
    ConfigProvider,
    Popover,
    Tabs
} from "ant-design-vue";
import {
    initFlowbite
} from 'flowbite';
import Side from '@/views/AdminViews/Home/Sidebar.vue';
import Educational from '@/views/AdminViews/Analytics/Educational.vue';
import TupadYearly from '@/views/AdminViews/Analytics/TupadYearly.vue';
import HospitalYearly from '@/views/AdminViews/Analytics/HospitalYearly.vue';
import EducationalYearly from '@/views/AdminViews/Analytics/EducationalYearly.vue';
import Medical from '@/views/AdminViews/Analytics/Medical.vue';
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
        Tabs
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
        handleTabChange(key) {
            
        },
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
