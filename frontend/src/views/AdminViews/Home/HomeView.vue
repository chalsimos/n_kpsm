<template>
<Side />
<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-4">
            <div class="flex items-center justify-center w-full h-full">
                <div class="w-full h-[50vh] py-20 bg-gray-50 dark:bg-gray-800 rounded">
                    <apexchart type="bar" :options="hospital_options" :series="hospital_count"></apexchart>
                </div>
            </div>
            <div class="flex items-center justify-center w-full h-full">
                <div class="w-full h-[50vh] py-20 bg-gray-50 dark:bg-gray-800 rounded">
                    <apexchart type="bar" :options="hospital_offer" :series="offer_count"></apexchart>
                </div>
            </div>
            <div class="flex items-center justify-center w-full h-full">
                <div class="w-full h-[50vh] py-20 bg-gray-50 dark:bg-gray-800 rounded">

                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-4">
            <div class="flex items-center justify-center w-full h-full">
                <div class="w-full h-[50vh] py-20 bg-gray-50 dark:bg-gray-800 rounded">

                </div>
            </div>
            <div class="flex items-center justify-center w-full h-full">
                <div class="w-full h-[50vh] py-20 bg-gray-50 dark:bg-gray-800 rounded">

                </div>
            </div>
            <div class="flex items-center justify-center w-full h-full">
                <div class="w-full h-[50vh] py-20 bg-gray-50 dark:bg-gray-800 rounded">

                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div class="flex items-center justify-center w-full h-full">
                <div class="w-full h-[50vh] py-20 bg-gray-50 dark:bg-gray-800 rounded">

                </div>
            </div>
            <div class="flex items-center justify-center w-full h-full">
                <div class="w-full h-[50vh] py-20 bg-gray-50 dark:bg-gray-800 rounded">

                </div>
            </div>
            <div class="flex items-center justify-center w-full h-full">
                <div class="w-full h-[50vh] py-20 bg-gray-50 dark:bg-gray-800 rounded">

                </div>
            </div>
            <div class="flex items-center justify-center w-full h-full">
                <div class="w-full h-[50vh] py-20 bg-gray-50 dark:bg-gray-800 rounded">

                </div>
            </div>
        </div>
        <div class="flex items-center justify-center h-[50vh] mb-4 rounded bg-gray-50 dark:bg-gray-800">

        </div>
        <div class="grid grid-cols-2 gap-4">
            <div class="flex items-center justify-center w-full h-full">
                <div class="w-full h-[50vh] py-20 bg-gray-50 dark:bg-gray-800 rounded">

                </div>
            </div>
            <div class="flex items-center justify-center w-full h-full">
                <div class="w-full h-[50vh] py-20 bg-gray-50 dark:bg-gray-800 rounded">

                </div>
            </div>
            <div class="flex items-center justify-center w-full h-full">
                <div class="w-full h-[50vh] py-20 bg-gray-50 dark:bg-gray-800 rounded">

                </div>
            </div>
            <div class="flex items-center justify-center w-full h-full">
                <div class="w-full h-[50vh] py-20 bg-gray-50 dark:bg-gray-800 rounded">

                </div>
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
            hospital_options: {
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
            offer_count: [],
            hospital_offer: {
                chart: {
                    type: 'bar',
                    height: '100%',
                    width: '100%',
                    toolbar: {
                        show: true
                    },
                    id: 'hospital_offer' // Add an ID to the chart for dynamic updates
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
                    categories: [], // Initialize with empty categories, will be set after data is fetched
                },
                title: {
                    text: 'Hospital Service Offers',
                    align: 'left',
                },
                tooltip: {
                    custom: ({
                        series,
                        seriesIndex,
                        dataPointIndex,
                        w
                    }) => {
                        if (!this.offer_data) {
                            console.log('Data is not available');
                            return '';
                        }

                        const hospital = this.offer_data.hospitals[dataPointIndex];
                        const activeOffers = hospital.active_offers.join('<br>');
                        const inactiveOffers = hospital.inactive_offers.join('<br>');
                        return `
                            <div class="p-4 bg-orange-300">
                                <div class="font-bold text-lg mb-2">${hospital.hospital_name}</div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <div class="font-bold">Active Offers:</div>
                                        <div>${activeOffers}</div>
                                    </div>
                                    <div>
                                        <div class="font-bold">Inactive Offers:</div>
                                        <div>${inactiveOffers}</div>
                                    </div>
                                </div>
                            </div>
                        `;
                    },
                },
            },
            offer_data: null,
        };
    },
    mounted() {
        initFlowbite();
        this.fetchHospitalCounts();
        this.fetchServiceOfferCounts();
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
                    this.updateHospitalCountChart();
                })
                .catch(error => {
                    console.error('Error fetching medical requests:', error);
                });
        },
        updateHospitalCountChart() {
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
            this.hospital_options.xaxis.categories = [
                'Total Hospitals',
                'Active Hospitals',
                'Inactive Hospitals'
            ];
        },
        fetchServiceOfferCounts() {
            axios.get('/api/dashboard/get-hospital-service-offer-count', {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('token')}`
                }
            })
            .then(response => {
                this.offer_data = response.data;
                this.updateHospitalServiceOfferCountChart();
            })
            .catch(error => {
                console.error('Error fetching Service Offer requests:', error);
            });
        },
        updateHospitalServiceOfferCountChart() {
            if (!this.offer_data) {
                console.log('Data is not available');
                return;
            }

            const hospitalNames = this.offer_data.hospitals.map(hospital => hospital.hospital_name);
            const hospitalAcronym = this.offer_data.hospitals.map(hospital => hospital.hospital_acronym);
            const offerCounts = this.offer_data.hospitals.map(hospital => ({
                active: hospital.active_offers.length,
                inactive: hospital.inactive_offers.length
            }));

            this.offer_count = [{
                name: 'Active Offers',
                data: offerCounts.map(offer => offer.active)
            }, {
                name: 'Inactive Offers',
                data: offerCounts.map(offer => offer.inactive)
            }];
            this.hospital_offer.xaxis.categories = hospitalAcronym;
            ApexCharts.exec('hospital_offer', 'updateOptions', {
                xaxis: {
                    categories: hospitalAcronym
                },
                series: this.offer_count
            });
        },
    },
};
</script>
