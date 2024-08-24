<template>
<div>
    <div class="flex justify-center">
        <div class="w-full py-10 bg-gray-50 dark:bg-gray-800 rounded px-4">
            <apexchart type="pie" :options="yearOptions" :series="yearSeries" @dataPointSelection="(event, chartContext, config) => openYearModal(yearsData[config.dataPointIndex])" class="w-full sm:w-4/5 md:w-3/4 lg:w-2/3 xl:w-1/2 mx-auto" />

            <a-modal v-if="selectedYear" v-model:visible="isYearModalVisible" title="Monthly Data" @ok="handleYearOk" @cancel="handleYearCancel">
                <apexchart type="pie" :options="monthOptions" :series="monthSeries" @dataPointSelection="(event, chartContext, config) => openMonthModal(selectedYear.months[config.dataPointIndex])" />
            </a-modal>

            <a-modal v-if="selectedMonth" v-model:visible="isMonthModalVisible" title="School Data" @ok="handleMonthOk" @cancel="handleMonthCancel">
                <apexchart type="pie" :options="schoolOptions" :series="schoolSeries" @dataPointSelection="(event, chartContext, config) => openSchoolModal(selectedMonth.school[config.dataPointIndex])" />
            </a-modal>

            <a-modal v-if="selectedSchool" v-model:visible="isSchoolModalVisible" title="Municipality Data" @ok="handleSchoolOk" @cancel="handleSchoolCancel">
                <apexchart type="pie" :options="municipalityOptions" :series="municipalitySeries" @dataPointSelection="(event, chartContext, config) => openMunicipalityModal(selectedSchool.municipalities[config.dataPointIndex])" />
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
            selectedSchool: null,
            selectedMunicipality: null,
            selectedBarangay: null,
            isYearModalVisible: false,
            isMonthModalVisible: false,
            isSchoolModalVisible: false,
            isMunicipalityModalVisible: false,
            isBarangayModalVisible: false,
            columns: [{
                    title: 'Representative Last Name',
                    dataIndex: 'representative_lastname',
                    key: 'representative_lastname'
                },
                {
                    title: 'Representative First Name',
                    dataIndex: 'representative_firstname',
                    key: 'representative_firstname'
                },
                {
                    title: 'Representative Middle Name',
                    dataIndex: 'representative_middlename',
                    key: 'representative_middlename'
                },
                {
                    title: 'Representative Age',
                    dataIndex: 'representative_age',
                    key: 'representative_age'
                },
                {
                    title: 'Representative Birthday',
                    dataIndex: 'representative_birthday',
                    key: 'representative_birthday'
                },
                {
                    title: 'Representative Gender',
                    dataIndex: 'representative_gender',
                    key: 'representative_gender'
                },
                {
                    title: 'Beneficiary Last Name',
                    dataIndex: 'beneficiary_lastname',
                    key: 'beneficiary_lastname'
                },
                {
                    title: 'Beneficiary First Name',
                    dataIndex: 'beneficiary_firstname',
                    key: 'beneficiary_firstname'
                },
                {
                    title: 'Beneficiary Middle Name',
                    dataIndex: 'beneficiary_middlename',
                    key: 'beneficiary_middlename'
                },
                {
                    title: 'Beneficiary Age',
                    dataIndex: 'beneficiary_age',
                    key: 'beneficiary_age'
                },
                {
                    title: 'Beneficiary Birthday',
                    dataIndex: 'beneficiary_birthday',
                    key: 'beneficiary_birthday'
                },
                {
                    title: 'Beneficiary Gender',
                    dataIndex: 'beneficiary_gender',
                    key: 'beneficiary_gender'
                },
                {
                    title: 'Relationship to Beneficiary',
                    dataIndex: 'relationship_to_beneficiary',
                    key: 'relationship_to_beneficiary'
                },
                {
                    title: 'Contact Number',
                    dataIndex: 'contact_number',
                    key: 'contact_number'
                },
                {
                    title: 'School Level',
                    dataIndex: 'school_level',
                    key: 'school_level'
                },
                {
                    title: 'Year Level',
                    dataIndex: 'year_level',
                    key: 'year_level'
                },
                {
                    title: 'Academic Year Stage',
                    dataIndex: 'academic_year_stage',
                    key: 'academic_year_stage'
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
        schoolOptions() {
            return {
                chart: {
                    type: 'pie',
                },
                labels: this.selectedMonth ? this.selectedMonth.school.map((school) => `School: ${school.school} - Total: ${school.total_per_school}`) : [],
            };
        },
        schoolSeries() {
            return this.selectedMonth ? this.selectedMonth.school.map((school) => school.total_per_school) : [];
        },
        municipalityOptions() {
            return {
                chart: {
                    type: 'pie',
                },
                labels: this.selectedSchool ? this.selectedSchool.municipalities.map((municipality) => `Municipality: ${municipality.municipality} - Total: ${municipality.total_per_municipality}`) : [],
            };
        },
        municipalitySeries() {
            return this.selectedSchool ? this.selectedSchool.municipalities.map((municipality) => municipality.total_per_municipality) : [];
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
        this.fetchEducationalYearlyData();
    },
    methods: {
        async fetchEducationalYearlyData(startDate, endDate) {
            try {
                const response = await axios.get('/api/dashboard/educational-requests-data', {
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
        openSchoolModal(school) {
            this.selectedSchool = school;
            this.isSchoolModalVisible = true;
        },
        handleSchoolOk() {
            this.isSchoolModalVisible = false;
            this.selectedSchool = null;
        },
        handleSchoolCancel() {
            this.isSchoolModalVisible = false;
            this.selectedSchool = null;
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
