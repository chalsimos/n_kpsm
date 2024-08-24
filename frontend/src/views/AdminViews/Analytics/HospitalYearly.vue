<template>
<div>
    <div class="flex justify-center">
        <div class="w-full py-10 bg-gray-50 dark:bg-gray-800 rounded px-4">
            <apexchart type="pie" :options="yearOptions" :series="yearSeries" @dataPointSelection="(event, chartContext, config) => openYearModal(yearsData[config.dataPointIndex])" class="w-full sm:w-4/5 md:w-3/4 lg:w-2/3 xl:w-1/2 mx-auto" />

            <a-modal v-if="selectedYear" v-model:visible="isYearModalVisible" title="Monthly Data" @ok="handleYearOk" @cancel="handleYearCancel">
                <apexchart type="pie" :options="monthOptions" :series="monthSeries" @dataPointSelection="(event, chartContext, config) => openMonthModal(selectedYear.months[config.dataPointIndex])" />
            </a-modal>

            <a-modal v-if="selectedMonth" v-model:visible="isMonthModalVisible" title="Hospital Data" @ok="handleMonthOk" @cancel="handleMonthCancel">
                <apexchart type="pie" :options="hospitalOptions" :series="hospitalSeries" @dataPointSelection="(event, chartContext, config) => openHospitalModal(selectedMonth.hospitals[config.dataPointIndex])" />
            </a-modal>

            <a-modal v-if="selectedHospital" v-model:visible="isHospitalModalVisible" title="Municipality Data" @ok="handleHospitalOk" @cancel="handleHospitalCancel">
                <apexchart type="pie" :options="municipalityOptions" :series="municipalitySeries" @dataPointSelection="(event, chartContext, config) => openMunicipalityModal(selectedHospital.municipalities[config.dataPointIndex])" />
            </a-modal>

            <a-modal v-if="selectedMunicipality" v-model:visible="isMunicipalityModalVisible" title="Barangay Data" @ok="handleMunicipalityOk" @cancel="handleMunicipalityCancel">
                <apexchart type="pie" :options="barangayOptions" :series="barangaySeries" @dataPointSelection="(event, chartContext, config) => openBarangayModal(selectedMunicipality.barangays[config.dataPointIndex])" />
            </a-modal>

            <a-modal v-if="selectedBarangay" v-model:visible="isBarangayModalVisible" title="Barangay Details" @ok="handleBarangayOk" @cancel="handleBarangayCancel">
                <a-table :columns="columns" :dataSource="selectedBarangay.details" rowKey="id" :scroll="{ x: 'max-content' }" />
            </a-modal>
        </div>
    </div>
</div>
</template>

<script>
import VueApexCharts from 'vue3-apexcharts';
import {
    defineComponent
} from 'vue';
import {
    Modal,
    Table
} from 'ant-design-vue';
import axios from '../../../main.js';

export default defineComponent({
    components: {
        apexchart: VueApexCharts,
        'a-modal': Modal,
        'a-table': Table,
    },
    data() {
        return {
            yearsData: [],
            selectedYear: null,
            selectedMonth: null,
            selectedHospital: null,
            selectedMunicipality: null,
            selectedBarangay: null,
            isYearModalVisible: false,
            isMonthModalVisible: false,
            isHospitalModalVisible: false,
            isMunicipalityModalVisible: false,
            isBarangayModalVisible: false,
            columns: [{
                    title: 'Hor Code',
                    dataIndex: 'Hor_code',
                    key: 'Hor_code'
                },
                {
                    title: 'First Name',
                    dataIndex: 'firstname',
                    key: 'firstname'
                },
                {
                    title: 'Middle Name',
                    dataIndex: 'middlename',
                    key: 'middlename'
                },
                {
                    title: 'Last Name',
                    dataIndex: 'lastname',
                    key: 'lastname'
                },
                {
                    title: 'Age',
                    dataIndex: 'age',
                    key: 'age'
                },
                {
                    title: 'Birthday',
                    dataIndex: 'birthday',
                    key: 'birthday'
                },
                {
                    title: 'Gender',
                    dataIndex: 'gender',
                    key: 'gender'
                },
                {
                    title: 'Representative Full Name',
                    dataIndex: 'representativefullname',
                    key: 'representativefullname'
                },
                {
                    title: 'Contact Number',
                    dataIndex: 'contactnumber',
                    key: 'contactnumber'
                },
                {
                    title: 'Diagnosis',
                    dataIndex: 'diagnosis',
                    key: 'diagnosis'
                },
                {
                    title: 'Hospital',
                    dataIndex: 'hospital',
                    key: 'hospital'
                },
                {
                    title: 'Request',
                    dataIndex: 'request',
                    key: 'request'
                },
            ],
        };
    },
    computed: {
        yearOptions() {
            return {
                chart: {
                    type: 'pie',
                },
                labels: this.yearsData.map((year) => `Year: ${year.year} - Total: ${year.total_per_year}`),
            };
        },
        yearSeries() {
            return this.yearsData.map((year) => year.total_per_year);
        },
        monthOptions() {
            return {
                chart: {
                    type: 'pie',
                },
                labels: this.selectedYear ? this.selectedYear.months.map((month) => `Month: ${month.month} - Total: ${month.total_per_month}`) : [],
            };
        },
        monthSeries() {
            return this.selectedYear ? this.selectedYear.months.map((month) => month.total_per_month) : [];
        },
        hospitalOptions() {
            return {
                chart: {
                    type: 'pie',
                },
                labels: this.selectedMonth ? this.selectedMonth.hospitals.map((hospital) => `Hospital: ${hospital.hospital} - Total: ${hospital.total_per_hospital}`) : [],
            };
        },
        hospitalSeries() {
            return this.selectedMonth ? this.selectedMonth.hospitals.map((hospital) => hospital.total_per_hospital) : [];
        },
        municipalityOptions() {
            return {
                chart: {
                    type: 'pie',
                },
                labels: this.selectedHospital ? this.selectedHospital.municipalities.map((municipality) => `Municipality: ${municipality.municipality} - Total: ${municipality.total_per_municipality}`) : [],
            };
        },
        municipalitySeries() {
            return this.selectedHospital ? this.selectedHospital.municipalities.map((municipality) => municipality.total_per_municipality) : [];
        },
        barangayOptions() {
            return {
                chart: {
                    type: 'pie',
                },
                labels: this.selectedMunicipality ? this.selectedMunicipality.barangays.map((barangay) => `Barangay: ${barangay.barangay} - Total: ${barangay.total_per_barangay}`) : [],
            };
        },
        barangaySeries() {
            return this.selectedMunicipality ? this.selectedMunicipality.barangays.map((barangay) => barangay.total_per_barangay) : [];
        },
    },
    mounted() {
        this.fetchDataHospitalYearly();
    },
    methods: {
        async fetchDataHospitalYearly(startDate, endDate) {
            try {
                const response = await axios.get('/api/dashboard/medical-requests-data', {
                    params: {
                        start_date: startDate,
                        end_date: endDate,
                    },
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`,
                    },
                });
                this.yearsData = response.data;
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        },
        openYearModal(year) {
            this.selectedYear = year;
            this.isYearModalVisible = true;
        },
        handleYearOk() {
            this.isYearModalVisible = false;
            this.selectedYear = null;
        },
        handleYearCancel() {
            this.isYearModalVisible = false;
            this.selectedYear = null;
        },
        openMonthModal(month) {
            this.selectedMonth = month;
            this.isMonthModalVisible = true;
        },
        handleMonthOk() {
            this.isMonthModalVisible = false;
            this.selectedMonth = null;
        },
        handleMonthCancel() {
            this.isMonthModalVisible = false;
            this.selectedMonth = null;
        },
        openHospitalModal(hospital) {
            this.selectedHospital = hospital;
            this.isHospitalModalVisible = true;
        },
        handleHospitalOk() {
            this.isHospitalModalVisible = false;
            this.selectedHospital = null;
        },
        handleHospitalCancel() {
            this.isHospitalModalVisible = false;
            this.selectedHospital = null;
        },
        openMunicipalityModal(municipality) {
            this.selectedMunicipality = municipality;
            this.isMunicipalityModalVisible = true;
        },
        handleMunicipalityOk() {
            this.isMunicipalityModalVisible = false;
            this.selectedMunicipality = null;
        },
        handleMunicipalityCancel() {
            this.isMunicipalityModalVisible = false;
            this.selectedMunicipality = null;
        },
        openBarangayModal(barangay) {
            this.selectedBarangay = barangay;
            this.isBarangayModalVisible = true;
        },
        handleBarangayOk() {
            this.isBarangayModalVisible = false;
            this.selectedBarangay = null;
        },
        handleBarangayCancel() {
            this.isBarangayModalVisible = false;
            this.selectedBarangay = null;
        },
    },
});
</script>

<style scoped>
.custom-content {
    margin-bottom: 10px;
}
</style>
