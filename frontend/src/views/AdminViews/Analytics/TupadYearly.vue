<template>
    <div>
      <div class="flex justify-center">
        <div class="w-full py-10 bg-gray-50 dark:bg-gray-800 rounded px-4">
          <!-- Year Pie Chart -->
          <apexchart
            v-if="yearsData.length"
            type="pie"
            :options="yearOptions"
            :series="yearSeries"
            @dataPointSelection="(event, chartContext, config) => openYearModal(yearsData[config.dataPointIndex])"
            class="w-full sm:w-4/5 md:w-3/4 lg:w-2/3 xl:w-1/2 mx-auto"
          />
  
          <!-- Year Modal -->
          <a-modal
            v-if="selectedYear"
            v-model:visible="isYearModalVisible"
            title="Monthly Data"
            @ok="handleYearOk"
            @cancel="handleYearCancel"
          >
            <apexchart
              type="pie"
              :options="monthOptions"
              :series="monthSeries"
              @dataPointSelection="(event, chartContext, config) => openMonthModal(selectedYear.months[config.dataPointIndex])"
            />
          </a-modal>
  
          <!-- Month Modal -->
          <a-modal
            v-if="selectedMonth"
            v-model:visible="isMonthModalVisible"
            title="Municipality Data"
            @ok="handleMonthOk"
            @cancel="handleMonthCancel"
          >
            <apexchart
              type="pie"
              :options="municipalityOptions"
              :series="municipalitySeries"
              @dataPointSelection="(event, chartContext, config) => openMunicipalityModal(selectedMonth.municipalities[config.dataPointIndex])"
            />
          </a-modal>
  
          <!-- Municipality Modal -->
          <a-modal
            v-if="selectedMunicipality"
            v-model:visible="isMunicipalityModalVisible"
            title="Barangay Data"
            @ok="handleMunicipalityOk"
            @cancel="handleMunicipalityCancel"
          >
            <apexchart
              type="pie"
              :options="barangayOptions"
              :series="barangaySeries"
              @dataPointSelection="(event, chartContext, config) => openBarangayModal(selectedMunicipality.barangays[config.dataPointIndex])"
            />
          </a-modal>
  
          <!-- Barangay Modal -->
          <a-modal
            v-if="selectedBarangay"
            v-model:visible="isBarangayModalVisible"
            title="Barangay Details"
            @ok="handleBarangayOk"
            @cancel="handleBarangayCancel"
          >
            <a-table
              v-if="columns.length && selectedBarangay.details.length"
              :columns="columns"
              :dataSource="selectedBarangay.details"
              rowKey="id"
              :scroll="{ x: 'max-content' }"
            />
            <div v-else>No data available</div>
          </a-modal>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import VueApexCharts from 'vue3-apexcharts';
  import { defineComponent } from 'vue';
  import { Modal, Table } from 'ant-design-vue';
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
        selectedMunicipality: null,
        selectedBarangay: null,
        isYearModalVisible: false,
        isMonthModalVisible: false,
        isMunicipalityModalVisible: false,
        isBarangayModalVisible: false,
        columns: [],
      };
    },
    computed: {
      yearOptions() {
        return {
          chart: { type: 'pie' },
          labels: this.yearsData.map(year => `Year: ${year.year} - Total: ${year.total_per_year}`),
        };
      },
      yearSeries() {
        return this.yearsData.map(year => year.total_per_year);
      },
      monthOptions() {
        return {
          chart: { type: 'pie' },
          labels: this.selectedYear ? this.selectedYear.months.map(month => `Month: ${month.month} - Total: ${month.total_per_month}`) : [],
        };
      },
      monthSeries() {
        return this.selectedYear ? this.selectedYear.months.map(month => month.total_per_month) : [];
      },
      municipalityOptions() {
        return {
          chart: { type: 'pie' },
          labels: this.selectedMonth ? this.selectedMonth.municipalities.map(municipality => `Municipality: ${municipality.municipality} - Total: ${municipality.total_per_municipality}`) : [],
        };
      },
      municipalitySeries() {
        return this.selectedMonth ? this.selectedMonth.municipalities.map(municipality => municipality.total_per_municipality) : [];
      },
      barangayOptions() {
        return {
          chart: { type: 'pie' },
          labels: this.selectedMunicipality ? this.selectedMunicipality.barangays.map(barangay => `Barangay: ${barangay.barangay} - Total: ${barangay.total_per_barangay}`) : [],
        };
      },
      barangaySeries() {
        return this.selectedMunicipality ? this.selectedMunicipality.barangays.map(barangay => barangay.total_per_barangay) : [];
      },
    },
    mounted() {
      this.fetchTupadYearlyData();
      this.fetchActiveHeaders().then(keys => {
        this.columns = keys.map(key => ({
          title: key.charAt(0).toUpperCase() + key.slice(1),
          dataIndex: key,
          key: key,
        }));
      });
    },
    methods: {
      async fetchActiveHeaders() {
        try {
          const response = await axios.get('/api/dole/get-active-header');
          if (response.status === 200) {
            return response.data.headers.map(item => item.key);
          } else {
            throw new Error('Failed to fetch active headers');
          }
        } catch (error) {
          console.error('Error fetching active headers:', error);
          toastr.error('Failed to fetch active headers');
          return [];
        }
      },
      async fetchTupadYearlyData(startDate, endDate) {
        try {
          const response = await axios.get('/api/dashboard/getData', {
            params: { start_date: startDate, end_date: endDate },
            headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
          });
          this.yearsData = response.data;
        } catch (error) {
          console.error("Error fetching data:", error);
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
  