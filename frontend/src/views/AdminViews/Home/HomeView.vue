<template>
<Side />
<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <a-range-picker class="w-64" v-model="monthYearRange" format="MM/YYYY" picker="month" @change="handleMonthChange" />
        <a-tabs default-active-key="1" @change="handleTabChange">
            <a-tab-pane key="1" tab="Medical Assistance">
                <Medical ref="medicalChartComponent" />
            </a-tab-pane>
            <a-tab-pane key="2" tab="Educational Assistance">
                <Educational ref="educationalChartComponent" />
            </a-tab-pane>
            <a-tab-pane key="3" tab="Tupad">
            </a-tab-pane>
            <a-tab-pane v-if="information.type === 'superadmin'" key="4" tab="Tupad Yearly">
                <TupadYearly ref="tupadYearlyComponent" />
            </a-tab-pane>
            <a-tab-pane v-if="information.type === 'superadmin'" key="5" tab="Educational Yearly">
                <EducationalYearly ref="educationalYearlyComponent" />
            </a-tab-pane>
            <a-tab-pane v-if="information.type === 'superadmin'" key="6" tab="Hospital Yearly">
                <HospitalYearly ref="hospitalYearlyComponent" />
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
import moment from 'moment';
import {
    nextTick
} from 'vue';

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
            monthYearRange: [],
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
        async handleMonthChange(dates, dateStrings) {
            let startDate = null;
            let endDate = null;
            if (dates && dates.length === 2) {
                startDate = dates[0].startOf('month').format('YYYY-MM-DD');
                endDate = dates[1].endOf('month').format('YYYY-MM-DD');
            }
            const refNames = [
                'educationalYearlyComponent',
                'hospitalYearlyComponent',
                'tupadYearlyComponent',
                'educationalChartComponent',
                'medicalChartComponent'
            ];
            await this.ensureRefsAvailable(refNames);
            refNames.forEach(refName => {
                if (this.$refs[refName]) {
                    switch (refName) {
                        case 'educationalYearlyComponent':
                            this.$refs[refName].fetchEducationalYearlyData(startDate, endDate);
                            break;
                        case 'hospitalYearlyComponent':
                            this.$refs[refName].fetchDataHospitalYearly(startDate, endDate);
                            break;
                        case 'tupadYearlyComponent':
                            this.$refs[refName].fetchTupadYearlyData(startDate, endDate);
                            break;
                        case 'educationalChartComponent':
                            this.$refs[refName].fetchGenderEducationalRequests(startDate, endDate);
                            this.$refs[refName].fetchEducationalMunicipalityBarangay(startDate, endDate);
                            break;
                        case 'medicalChartComponent':
                            this.$refs[refName].fetchGenderMedicalRequests(startDate, endDate);
                            this.$refs[refName].fetchMunicipalityBarangay(startDate, endDate);
                            break;
                        default:
                            break;
                    }
                }
            });
        },
        async ensureRefsAvailable(refNames) {
            for (let i = 0; i < 10; i++) {
                await this.$nextTick();
                const missingRefs = refNames.filter(ref => !this.$refs[ref]);
                if (missingRefs.length === 0) {
                    return true;
                }
                await new Promise(resolve => setTimeout(resolve, 50));
            }
            console.error('Some components are not available after waiting:', refNames.filter(ref => !this.$refs[ref]));
            return false;
        },

        handleTabChange(key) {},
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
        created() {
            this.handleMonthChange();
        }
    },
};
</script>
