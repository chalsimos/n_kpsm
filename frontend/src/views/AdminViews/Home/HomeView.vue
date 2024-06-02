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
                    <apexchart type="bar" :options="barangay_per_municipality" :series="municipality_count"></apexchart>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-4">
            <div class="flex items-center justify-center w-full h-full">
                <div class="w-full h-[50vh] py-20 bg-gray-50 dark:bg-gray-800 rounded">
                    <apexchart type="pie" :options="genderOptions" :series="genderSeries"></apexchart>
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
import {
    barangays
} from "select-philippines-address";
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
                        let names = [];
                        if (this.data && this.data[label] && this.data[label].names) {
                            names = this.data[label].names;
                        }
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
                    id: 'hospital_offer'
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
                                    <div class="bg-red-600 py-2 px-5">
                                        <div class="font-bold ">Inactive Offers:</div>
                                        <div>${inactiveOffers}</div>
                                    </div>
                                </div>
                            </div>
                        `;
                    },
                },
            },
            offer_data: null,
            barangay_per_municipality: {
                chart: {
                    type: 'bar',
                    height: '100%',
                    width: '100%',
                    toolbar: {
                        show: true
                    },
                    id: 'barangay_per_municipality'
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
                    text: 'Patient per Municipality and Barangay',
                    align: 'left',
                },
                tooltip: {
                    custom: ({
                        series,
                        seriesIndex,
                        dataPointIndex,
                        w
                    }) => {
                        const municipalityData = this.municipality_count[dataPointIndex];
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
            municipality_count: [],
            detailedMunicipalityData: {},
            genderOptions: {
                chart: {
                    type: 'pie',
                    height: '100%',
                    width: '100%',
                    toolbar: {
                        show: true
                    },
                    id: 'genderOptions'
                },
                dataLabels: {
                    enabled: true,
                    formatter: (val, opts) => {
                        const seriesIndex = opts.seriesIndex;
                        const detailedMunicipalityData = this.detailedMunicipalityData;
                        const seriesLabel = opts.w.config.labels && opts.w.config.labels[seriesIndex];
                        if (seriesLabel && detailedMunicipalityData && detailedMunicipalityData[seriesLabel]) {
                            const count = detailedMunicipalityData[seriesLabel].count;
                            const totalCount = Object.values(detailedMunicipalityData).reduce((acc, data) => acc + data.count, 0);
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
                        offsetY: 10,
                        dataLabels: {
                            offset: -20,
                        }
                    }
                },
                labels: [],
                title: {
                    text: 'Patients Gender per Municipality',
                    align: 'left',
                },
                tooltip: {
                    custom: ({
                        series,
                        seriesIndex,
                        dataPointIndex,
                        w
                    }) => {
                        const detailedMunicipalityData = this.detailedMunicipalityData;
                        if (!detailedMunicipalityData) {
                            return '';
                        }
                        const gender = w.config.labels[seriesIndex];
                        const genderData = detailedMunicipalityData[gender];
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
            genderSeries: [],
        };
    },
    mounted() {
        initFlowbite();
        this.fetchGenderMedicalRequests();
        this.fetchMunicipalityBarangay();
        this.fetchHospitalCounts();
        this.fetchServiceOfferCounts();
    },
    methods: {
        fetchGenderMedicalRequests() {
            axios.get('/api/dashboard/gender-medical-requests')
                .then(response => {
                    const data = response.data;
                    this.genderProcessData(data);
                })
                .catch(error => {
                    console.error(error);
                });
        },
        genderProcessData(data) {
            const labels = [];
            const series = [];
            this.detailedMunicipalityData = {};
            for (const [gender, info] of Object.entries(data)) {
                labels.push(gender);
                series.push(info.count);
                this.detailedMunicipalityData[gender] = {
                    count: info.count,
                    municipality: info.municipality
                };
            }
            this.genderOptions.labels = labels;
            this.genderSeries = series;
            ApexCharts.exec('genderOptions', 'updateOptions', {
                labels: labels,
            });
        },
        fetchMunicipalityBarangay() {
            axios.get('/api/dashboard/municipality-barangay')
                .then(response => {
                    const data = response.data;
                    this.processData(data);
                })
                .catch(error => {
                    console.error(error);
                });
        },
        processData(data) {
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
                    this.municipality_count.push({
                        municipality: municipality.municipality,
                        totalCount: totalCount,
                        barangays: barangays
                    });
                }
            });
            if (categories.length > 0 && seriesData.length > 0) {
                this.municipality_count = this.municipality_count;
            } else {
                this.municipality_count = [];
            }
            if (categories.length > 0) {
                this.barangay_per_municipality.xaxis.categories = categories;
                this.barangay_per_municipality.series = [{
                    name: 'Total Count',
                    data: seriesData
                }];
            }
            ApexCharts.exec('barangay_per_municipality', 'updateOptions', {
                xaxis: {
                    categories: categories
                },
                series: [{
                    name: 'Total Count',
                    data: seriesData
                }]
            });
        },
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
                // name: 'Inactive Offers',
                // data: offerCounts.map(offer => offer.inactive)
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
