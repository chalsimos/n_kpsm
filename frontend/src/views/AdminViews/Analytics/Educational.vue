<template>
    <div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-4">
            <div class="flex items-center justify-center w-full h-full">
                <div class="w-full h-[50vh] py-20 bg-gray-50 dark:bg-gray-800 rounded">
                    <apexchart type="pie" :options="genderEducationalOptions" :series="genderEducationalSeries"></apexchart>
                </div>
            </div>
            <div class="flex items-center justify-center w-full h-full">
                <div class="w-full h-[50vh] py-20 bg-gray-50 dark:bg-gray-800 rounded">
                    <apexchart type="bar" :options="Educationalbarangay_per_municipality" :series="Educationalmunicipality_count"></apexchart>
                </div>
            </div>
            <div class="flex items-center justify-center w-full h-full">
                <div class="w-full h-[50vh] py-20 bg-gray-50 dark:bg-gray-800 rounded">
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-4">
            <div class="flex items-center justify-center w-full h-full">
                <div class="w-full h-[60vh] py-20 bg-gray-50 dark:bg-gray-800 rounded">
                </div>
            </div>
            <div class="flex items-center justify-center w-full h-full">
                <div class="w-full h-[60vh] py-20 bg-gray-50 dark:bg-gray-800 rounded">
                </div>
            </div>
            <div class="flex items-center justify-center w-full h-full">
                <div class="w-full h-[60vh] py-20 bg-gray-50 dark:bg-gray-800 rounded">
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
import Tupad from '@/views/AdminViews/Analytics/TupadYearly.vue'
import Medical from '@/views/AdminViews/Analytics/Medical.vue'
import Foot from "@/views/AdminViews/Home/Footer.vue";
import VueApexCharts from 'vue3-apexcharts';
import axios from "../../../main.js";
import {
    barangays
} from "select-philippines-address";
export default {
    components: {
        Side,
        Medical,
        Educational,
        Tupad,
        Carousel,
        Popover,
        ConfigProvider,
        Foot,
        Tag,
        apexchart: VueApexCharts
    },
    data() {
        return {
            EducationaldetailedMunicipalityData: {},
            genderEducationalOptions: {
                chart: {
                    type: 'pie',
                    height: '100%',
                    width: '100%',
                    toolbar: {
                        show: true
                    },
                    id: 'genderEducationalOptions'
                },
                dataLabels: {
                    enabled: true,
                    formatter: (val, opts) => {
                        const seriesIndex = opts.seriesIndex;
                        const EducationaldetailedMunicipalityData = this.EducationaldetailedMunicipalityData;
                        const seriesLabel = opts.w.config.labels && opts.w.config.labels[seriesIndex];
                        if (seriesLabel && EducationaldetailedMunicipalityData && EducationaldetailedMunicipalityData[seriesLabel]) {
                            const count = EducationaldetailedMunicipalityData[seriesLabel].count;
                            const totalCount = Object.values(EducationaldetailedMunicipalityData).reduce((acc, data) => acc + data.count, 0);
                            const percentage = (count / totalCount) * 100;
                            return seriesLabel + ": " + percentage.toFixed(2) + "%";
                        } else {
                            return "";
                        }
                    },
                    textAnchor: 'middle',
                    offsetX: 0,
                    offsetY: 0,
                    style: {
                        fontSize: '15px',
                        fontFamily: 'Helvetica, Arial, sans-serif',
                        colors: ["#ffffff"]
                    },
                },
                plotOptions: {
                    pie: {
                        customScale: 1,
                        offsetY: 20,
                        dataLabels: {
                            offset: -20,
                        }
                    }
                },
                labels: [],
                title: {
                    text: 'Educational Assistance Gender per Municipality',
                    align: 'left',
                },
                tooltip: {
                    custom: ({
                        series,
                        seriesIndex,
                        dataPointIndex,
                        w
                    }) => {
                        const EducationaldetailedMunicipalityData = this.EducationaldetailedMunicipalityData;
                        if (!EducationaldetailedMunicipalityData) {
                            return '';
                        }
                        const gender = w.config.labels[seriesIndex];
                        const genderData = EducationaldetailedMunicipalityData[gender];
                        let tooltipContent = `<div class="p-4 bg-orange-300">`;
                        tooltipContent += `<div class="font-bold text-lg mb-2">${gender}</div>`;
                        if (genderData && genderData.municipality) {
                            Object.entries(genderData.municipality).forEach(([municipality, count]) => {
                                tooltipContent += `<div>${municipality}: ${count}</div>`;
                            });
                        } else {
                            tooltipContent += `<div>Municipality data unavailable</div>`;
                        }
                        tooltipContent += `</div>`;
                        return tooltipContent;
                    }
                },
            },
            genderEducationalSeries: [],
            Educationalbarangay_per_municipality: {
                chart: {
                    type: 'bar',
                    height: '100%',
                    width: '100%',
                    toolbar: {
                        show: true
                    },
                    id: 'Educationalbarangay_per_municipality'
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
                    categories: [],
                },
                title: {
                    text: 'Educational Assistance per Municipality and Barangay',
                    align: 'left',
                },
                tooltip: {
                    custom: ({
                        series,
                        seriesIndex,
                        dataPointIndex,
                        w
                    }) => {
                        const municipalityData = this.Educationalmunicipality_count[dataPointIndex];
                        if (!municipalityData || !municipalityData.barangays || municipalityData.barangays.length === 0) {
                            return '';
                        }
                        const municipality = municipalityData.municipality;
                        const barangays = municipalityData.barangays;
                        let tooltipContent = `<div class="font-bold text-lg mb-2">Barangay in ${municipality}</div>`;
                        barangays.forEach(({
                            barangay,
                            count
                        }) => {
                            tooltipContent += `<div>${barangay}: ${count}</div>`;
                        });
                        return `<div class="p-4 bg-orange-300">${tooltipContent}</div>`;
                    },
                },
            },
            Educationalmunicipality_count: [],
        };
    },
    mounted() {
        initFlowbite();
        this.fetchGenderEducationalRequests();
        this.fetchEducationalMunicipalityBarangay();
    },
    methods: {
        fetchEducationalMunicipalityBarangay() {
            axios.get('/api/dashboard/educational-municipality-barangay', {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    this.EducatiopMunicipalityBarangayprocessData(data);
                })
                .catch(error => {
                    console.error(error);
                });
        },
        EducatiopMunicipalityBarangayprocessData(data) {
            const categories = [];
            const seriesData = [];
            const detailedBarangayData = [];
            data.forEach(municipality => {
                let totalCount = 0;
                const barangays = municipality.barangays || [];
                barangays.forEach(barangay => {
                    totalCount += barangay.count;
                    detailedBarangayData.push({
                        municipality: municipality.municipality,
                        barangay: barangay.barangay,
                        count: barangay.count
                    });
                });
                if (totalCount > 0) {
                    categories.push(municipality.municipality);
                    seriesData.push(totalCount);
                    this.Educationalmunicipality_count.push({
                        municipality: municipality.municipality,
                        totalCount: totalCount,
                        barangays: barangays
                    });
                }
            });
            if (categories.length > 0 && seriesData.length > 0) {
                this.Educationalmunicipality_count = this.Educationalmunicipality_count;
            } else {
                this.Educationalmunicipality_count = [];
            }
            if (categories.length > 0) {
                this.Educationalbarangay_per_municipality.xaxis.categories = categories;
                this.Educationalbarangay_per_municipality.series = [{
                    name: 'Total Count',
                    data: seriesData
                }];
            }
            ApexCharts.exec('Educationalbarangay_per_municipality', 'updateOptions', {
                xaxis: {
                    categories: categories
                },
                series: [{
                    name: 'Total Count',
                    data: seriesData
                }]
            });
        },
        fetchGenderEducationalRequests() {
            axios.get('/api/dashboard/gender-educational-requests', {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    this.EducationalgenderProcessData(data);
                })
                .catch(error => {
                    console.error(error);
                });
        },
        EducationalgenderProcessData(data) {
            const labels = [];
            const series = [];
            this.EducationaldetailedMunicipalityData = {};
            for (const [gender, info] of Object.entries(data)) {
                labels.push(gender);
                series.push(info.count);
                this.EducationaldetailedMunicipalityData[gender] = {
                    count: info.count,
                    municipality: info.municipality
                };
            }
            this.genderEducationalOptions.labels = labels;
            this.genderEducationalSeries = series;
            ApexCharts.exec('genderEducationalOptions', 'updateOptions', {
                labels: labels,
            });
        },
    },
};
</script>
