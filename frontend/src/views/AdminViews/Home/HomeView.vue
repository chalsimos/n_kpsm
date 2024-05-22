<template>
<Side />
<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-4">
            <div class="flex items-center justify-center w-full h-full">
                <div class="w-full h-[50vh] py-20 bg-gray-50 dark:bg-gray-800 rounded">
                    <apexchart type="bar" :options="chartOptions" :series="hospital_count"></apexchart>
                </div>
            </div>
            <div class="flex items-center justify-center w-full h-[50vh] bg-gray-50 dark:bg-gray-800 rounded">
                <!-- Content for the second div -->
            </div>
            <div class="flex items-center justify-center w-full h-[50vh] bg-gray-50 dark:bg-gray-800 rounded">
                <!-- Content for the third div -->
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-4">
            <div class="flex items-center justify-center h-[20vh] rounded bg-gray-50 dark:bg-gray-800">

            </div>
            <div class="flex items-center justify-center h-[20vh] rounded bg-gray-50 dark:bg-gray-800">

            </div>
            <div class="flex items-center justify-center h-[20vh] rounded bg-gray-50 dark:bg-gray-800">

            </div>
        </div>
     
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div class="flex items-center justify-center rounded bg-gray-50 h-[50vh] dark:bg-gray-800">

            </div>
            <div class="flex items-center justify-center rounded bg-gray-50 h-[50vh] dark:bg-gray-800">

            </div>
            <div class="flex items-center justify-center rounded bg-gray-50 h-[50vh] dark:bg-gray-800">

            </div>
            <div class="flex items-center justify-center rounded bg-gray-50 h-[50vh] dark:bg-gray-800">

            </div>
        </div>
        <div class="flex items-center justify-center h-[50vh] mb-4 rounded bg-gray-50 dark:bg-gray-800">

        </div>
        <div class="grid grid-cols-2 gap-4">
            <div class="flex items-center justify-center rounded bg-gray-50 h-[50vh] dark:bg-gray-800">

            </div>
            <div class="flex items-center justify-center rounded bg-gray-50 h-[50vh] dark:bg-gray-800">

            </div>
            <div class="flex items-center justify-center rounded bg-gray-50 h-[50vh] dark:bg-gray-800">

            </div>
            <div class="flex items-center justify-center rounded bg-gray-50 h-[50vh] dark:bg-gray-800">

            </div>
        </div>
    </div>
</div>
</template>

<script>
import {
    Tag
} from "ant-design-vue";
import {
    initFlowbite
} from 'flowbite'
import Side from '@/views/AdminViews/Home/Sidebar.vue'
import Foot from "@/views/AdminViews/Home/Footer.vue";
import VueApexCharts from 'vue3-apexcharts';
import axios from "../../../main.js";
export default {
    components: {
        Side,
        Foot,
        Tag,
        apexchart: VueApexCharts
    },
    data() {
        return {
            hospital_count: [],
            data: null,
            chartOptions: {
                chart: {
                    type: 'bar',
                    height: '100%',
                    width: '100%',
                    toolbar: {
                        show: true 
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                xaxis: {
                    categories: ['Total Hospitals', 'Active Hospitals', 'Inactive Hospitals'],
                },
                title: {
                    text: 'Hospital Counts',
                    align: 'left',
                },
                tooltip: {
                    custom: ({
                        series,
                        seriesIndex,
                        dataPointIndex,
                        w
                    }) => {
                        const labels = ['total', 'active', 'inactive'];
                        const label = labels[dataPointIndex];
                        const count = series[seriesIndex][dataPointIndex];
                        const names = this.data[label] ?.names || [];
                        const hospitalNames = names.join('<br>');
                        return `
                        <div class="p-4 bg-orange-300">
                                <div class="font-bold text-lg mb-2">${count} ${label.charAt(0).toUpperCase() + label.slice(1)} Hospitals:</div>
                                <div class="space-y-1">${hospitalNames}</div>
                            </div>
                        `;
                    },
                },
            },
        };
    },
    mounted() {
        initFlowbite(); 
        this.fetchHospitalCounts();
    },
    methods: {
        fetchHospitalCounts() {
            axios.get('/api/dashboard/get-hospital-count', {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    this.data = response.data;
                    this.updateChart();
                })
                .catch(error => {
                    console.error('Error fetching medical requests:', error);
                });
        },
        updateChart() {
            if (!this.data) {
                console.log('Data is not available');
                return;
            }
            this.hospital_count = [{
                name: 'Hospitals',
                data: [
                    this.data.total.count,
                    this.data.active.count,
                    this.data.inactive.count
                ],
            }];
            this.chartOptions.xaxis.categories = [
                'Total Hospitals',
                'Active Hospitals',
                'Inactive Hospitals'
            ];
        },
    },
};
</script>
