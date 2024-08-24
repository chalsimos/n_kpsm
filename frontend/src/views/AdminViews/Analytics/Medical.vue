<template>
<div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-4">
        <div class="flex items-center justify-center w-full h-full">
            <div class="w-full h-[50vh] py-10 bg-gray-50 dark:bg-gray-800 rounded">
                <apexchart type="bar" :options="hospital_options" :series="hospital_count"></apexchart>
            </div>
        </div>
        <div class="flex items-center justify-center w-full h-full">
            <div class="w-full h-[50vh] py-10 bg-gray-50 dark:bg-gray-800 rounded">
                <apexchart type="bar" :options="hospital_offer" :series="offer_count"></apexchart>
            </div>
        </div>
        <div class="flex items-center justify-center w-full h-full">
            <div class="w-full h-[50vh] py-10 bg-gray-50 dark:bg-gray-800 rounded">
                <apexchart type="pie" :options="genderOptions" :series="genderSeries"></apexchart>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
        <div class="flex items-center justify-center w-full h-full col-span-1">
            <div class="w-full h-[60vh] py-10 bg-gray-50 dark:bg-gray-800 rounded">
                <apexchart type="bar" :options="barangay_per_municipality" :series="municipality_count"></apexchart>
            </div>
        </div>
        <div class="flex items-center justify-center w-full h-full col-span-1">
            <div class="w-full h-[60vh] py-10 bg-gray-50 dark:bg-gray-800 rounded">
                <apexchart type="bar" :options="ageOptions" :series="ageSeries"></apexchart>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 mb-4">
        <div class="flex items-center justify-center w-full h-full">
            <div class="w-full h-[50vh] py-10 bg-gray-50 dark:bg-gray-800 rounded">

            </div>
        </div>
        <div class="flex items-center justify-center w-full h-full">
            <div class="w-full h-[50vh] py-10 bg-gray-50 dark:bg-gray-800 rounded">

            </div>
        </div>
        <div class="flex items-center justify-center w-full h-full">
            <div class="w-full h-[50vh] py-10 bg-gray-50 dark:bg-gray-800 rounded">

            </div>
        </div>
        <div class="flex items-center justify-center w-full h-full">
            <div class="w-full h-[50vh] py-10 bg-gray-50 dark:bg-gray-800 rounded">

            </div>
        </div>
    </div>
    <div class="flex items-center justify-center h-[50vh] mb-4 rounded bg-gray-50 dark:bg-gray-800">

    </div>
    <div class="grid grid-cols-2 gap-4">
        <div class="flex items-center justify-center w-full h-full">
            <div class="w-full h-[50vh] py-10 bg-gray-50 dark:bg-gray-800 rounded">

            </div>
        </div>
        <div class="flex items-center justify-center w-full h-full">
            <div class="w-full h-[50vh] py-10 bg-gray-50 dark:bg-gray-800 rounded">

            </div>
        </div>
        <div class="flex items-center justify-center w-full h-full">
            <div class="w-full h-[50vh] py-10 bg-gray-50 dark:bg-gray-800 rounded">

            </div>
        </div>
        <div class="flex items-center justify-center w-full h-full">
            <div class="w-full h-[50vh] py-10 bg-gray-50 dark:bg-gray-800 rounded">

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
            ageOptions: {
                chart: {
                    type: 'bar',
                    height: '100%',
                    width: '100%',
                    toolbar: {
                        show: true
                    },
                    id: 'ageOptions'
                },
                dataLabels: {
                    enabled: true,
                    formatter: (val) => val ? val.toFixed(0) : '0',
                    style: {
                        fontSize: '12px',
                        fontFamily: 'Helvetica, Arial, sans-serif',
                        colors: ["#000000"]
                    },
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        endingShape: 'rounded'
                    },
                },
                title: {
                    text: 'Number of Patients by Age Bracket',
                    align: 'left',
                },
                xaxis: {
                    categories: ['Newborn', 'Baby', 'Child', 'Young Adult', 'Middle Aged Adult', 'Old Adult'],
                    title: {
                        text: 'Age Bracket',
                    },
                },
                yaxis: {
                    labels: {
                        formatter: (val) => val ? val.toFixed(0) : '0',
                    }
                },
                tooltip: {
                    shared: false,
                    intersect: true, 
                    custom: ({
                        series,
                        seriesIndex,
                        dataPointIndex,
                        w
                    }) => {
                        const ageBracket = w.config.xaxis.categories[dataPointIndex];
                        const municipalities = this.detailedMunicipalityData[ageBracket] || [];
                        let tooltipContent = `<div class="p-4 bg-orange-300">`;
                        tooltipContent += `<div class="font-bold text-lg mb-2">${ageBracket}</div>`;
                        if (municipalities.length) {
                            municipalities.forEach((item) => {
                                tooltipContent += `<div>${item.age} - ${item.municipality}: ${item.count}</div>`;
                            });
                        } else {
                            tooltipContent += `<div>No data available</div>`;
                        }
                        tooltipContent += `</div>`;
                        return tooltipContent;
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                },
                fill: {
                    opacity: 1
                }
            },

            ageSeries: [],
            detailedMunicipalityData: {},
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
                    categories: ['Total', 'Active', 'Inactive'],
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
                            offset: -10,
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
        this.fetchAgeBracketMedicalRequests();
    },
    methods: {
        fetchAgeBracketMedicalRequests(startDate, endDate) {
            axios.get('/api/dashboard/age-bracket-medical-requests', {
                    params: {
                        start_date: startDate,
                        end_date: endDate
                    },
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    console.log('Fetched Data:', data);
                    this.processAgeBracketData(data);
                })
                .catch(error => {
                    console.error(error);
                });
        },
        processAgeBracketData(data) {
            const ageBrackets = ['Newborn', 'Baby', 'Child', 'Young Adult', 'Middle Aged Adult', 'Old Adult'];
            const series = [{
                name: 'Number of Patients',
                data: []
            }];
            const detailedMunicipalityData = {};
            ageBrackets.forEach((ageBracket) => {
                let totalCount = 0;
                const municipalities = [];
                if (data[ageBracket] && data[ageBracket].length) {
                    data[ageBracket].forEach(item => {
                        totalCount += item.count;
                        municipalities.push({
                            age: item.age,
                            municipality: item.municipality,
                            count: item.count
                        });
                    });
                }
                series[0].data.push(totalCount); 
                detailedMunicipalityData[ageBracket] = municipalities;
            });
            this.ageSeries = series;
            this.detailedMunicipalityData = detailedMunicipalityData;
            ApexCharts.exec('ageOptions', 'updateOptions', {
                xaxis: {
                    categories: ageBrackets,
                },
                series: this.ageSeries,
            });
        },
        fetchGenderMedicalRequests(startDate, endDate) {
            axios.get('/api/dashboard/gender-medical-requests', {
                    params: {
                        start_date: startDate,
                        end_date: endDate
                    },
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
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
        fetchMunicipalityBarangay(startDate, endDate) {
            axios.get('/api/dashboard/municipality-barangay', {
                    params: {
                        start_date: startDate,
                        end_date: endDate
                    },
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
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
