<template>
<Side />
<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <div class="flex justify-end">
            <Button type="primary" @click="addBudget" class="text-white">Add Budget</Button>
        </div>
        <a-tabs v-model:activeKey="activeKey" @change="onChange">
            <a-tab-pane v-for="(hospital, index) in hospitals" :key="index" :tab="hospital.name">
                <div>
                    <div class="flex justify-center mb-4">
                        <Tag bordered={false} color="yellow">
                            <h1 class="text-2xl ">{{ hospital.name }}</h1>
                        </Tag>
                    </div>
                    <template v-if="hospital.current_year">
                        <a-row :gutter="[16, 16]">
                            <a-col :span="24" :sm="12" :md="8">
                                <a-badge-ribbon :text="hospital.current_year.year">
                                    <a-card bordered={false}>
                                        <a-statistic title="Total Budget" :value="hospital.current_year.total_budget" />
                                    </a-card>
                                </a-badge-ribbon>
                            </a-col>
                            <a-col :span="24" :sm="12" :md="8">
                                <a-badge-ribbon :text="hospital.current_year.year">
                                    <a-card bordered={false}>
                                        <a-statistic title="Budget Left" :value="hospital.current_year.budget_left" :valueStyle="{ color: hospital.current_year.budget_left >= hospital.current_year.total_budget ? '#3f8600' : '#cf1322' }" :prefix="hospital.current_year.budget_left >= hospital.current_year.total_budget ? '↑' : '↓'" />
                                    </a-card>
                                </a-badge-ribbon>
                            </a-col>
                            <a-col :span="24" :sm="12" :md="8">
                                <a-badge-ribbon :text="hospital.current_year.year">
                                    <a-card bordered={false}>
                                        <a-statistic title="Total Expenses" :value="hospital.current_year.total_expenses" />
                                    </a-card>
                                </a-badge-ribbon>
                            </a-col>
                        </a-row>
                    </template>
                    <template v-if="hospital.current_year.budget_left === '0' && hospital.next_year">
                        <a-row :gutter="[16, 16]" class="mt-4">
                            <a-col :span="24" :sm="12" :md="8">
                                <a-badge-ribbon :text="hospital.next_year.year">
                                    <a-card class="bg-gray-400" bordered={false}>
                                        <a-statistic title="Total Budget" :value="hospital.next_year.total_budget" />
                                    </a-card>
                                </a-badge-ribbon>
                            </a-col>
                            <a-col :span="24" :sm="12" :md="8">
                                <a-badge-ribbon :text="hospital.next_year.year">
                                    <a-card class="bg-gray-400" bordered={false}>
                                        <a-statistic title="Budget Left" :value="hospital.next_year.budget_left" :valueStyle="{ color: hospital.next_year.budget_left > 0 ? '#3f8600' : '#cf1322' }" :prefix="hospital.next_year.budget_left > 0 ? '↑' : '↓'" />
                                    </a-card>
                                </a-badge-ribbon>
                            </a-col>
                            <a-col :span="24" :sm="12" :md="8">
                                <a-badge-ribbon :text="hospital.next_year.year">
                                    <a-card class="bg-gray-400" bordered={false}>
                                        <a-statistic title="Total Expenses" :value="hospital.next_year.total_expenses" />
                                    </a-card>
                                </a-badge-ribbon>
                            </a-col>
                        </a-row>
                    </template>
                    <a-table :columns="columns" :dataSource="hospital.requests" :pagination="pagination" :rowKey="(record, index) => index" class="min-w-full divide-y divide-gray-200 mt-4" />
                </div>
            </a-tab-pane>
        </a-tabs>
    </div>
</div>
<div id="addBudget" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-screen md:inset-0">
    <div class="relative p-4 sm:px-6 sm:py-8 lg:px-8 lg:py-10 w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Add Budget
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="addBudget">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form @submit.prevent="insertBudget" class="w-full px-4 py-6 sm:px-6 sm:py-8 lg:px-8 lg:py-10">
                <div class="mb-5">
                    <label for="total_budget" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Budget</label>
                    <input v-model="total_budget" type="number" id="total_budget" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="1000" required />
                </div>
                <div class="mb-5">
                    <label for="Hospital" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hospital</label>
                    <select v-model="budget_to_hospital" id="Hospital" class="text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-small rounded-lg text-sm w-full py-2.5 text-center inline-flex items-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">
                        <option value="" disabled selected>Choose Hospital</option>
                        <option v-for="hospital in budget_hospital" :key="hospital.id" :value="hospital.hospital_acronym">
                            {{ hospital.hospital_name }} ({{ hospital.hospital_acronym }})
                        </option>
                    </select>
                </div>
                <a-date-picker v-model="year" picker="year" :format="yearFormat" :disabledDate="disabledDate" @change="dateChange" />
                <div class="flex justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="addBudget" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Budget</button>
                </div>
            </form>
        </div>
    </div>
</div>
</template>

<script>
import {
    Tabs,
    TabPane,
    Row,
    Col,
    Card,
    Statistic,
    Badge,
    Tag,
    Button,
    DatePicker,
    Table
} from 'ant-design-vue';
import {
    ArrowUpOutlined,
    ArrowDownOutlined
} from '@ant-design/icons-vue';
import {
    initFlowbite
} from 'flowbite';
import Side from '@/views/AdminViews/Home/Sidebar.vue';
import axios from '../../../main.js';
import {
    useToast
} from 'vue-toastification';
const toastr = useToast();
export default {
    data() {
        return {
            hospitals: [],
            budget_hospital: [],
            year: '',
            yearFormat: 'YYYY',
            total_budget: '',
            budget_to_hospital: '',
            columns: [
        {
          title: 'Firstname',
          dataIndex: 'firstname',
          key: 'firstname',
          sorter: (a, b) => a.firstname.localeCompare(b.firstname),
          sortDirections: ['descend', 'ascend']
        },
        {
          title: 'Middlename',
          dataIndex: 'middlename',
          key: 'middlename',
          sorter: (a, b) => a.middlename.localeCompare(b.middlename),
          sortDirections: ['descend', 'ascend']
        },
        {
          title: 'Lastname',
          dataIndex: 'lastname',
          key: 'lastname',
          sorter: (a, b) => a.lastname.localeCompare(b.lastname),
          sortDirections: ['descend', 'ascend']
        },
        {
          title: 'Diagnosis',
          dataIndex: 'diagnosis',
          key: 'diagnosis',
          sorter: (a, b) => a.diagnosis.localeCompare(b.diagnosis),
          sortDirections: ['descend', 'ascend']
        },
        {
          title: 'Amount',
          dataIndex: 'amount',
          key: 'amount',
          sorter: (a, b) => a.amount - b.amount,
          sortDirections: ['descend', 'ascend']
        },
        {
          title: 'Request',
          dataIndex: 'request',
          key: 'request',
          sorter: (a, b) => a.request.localeCompare(b.request),
          sortDirections: ['descend', 'ascend']
        }
      ],
            pagination: {
                defaultPageSize: 5,
                pageSizeOptions: ['5', '10', '15'],
                showSizeChanger: true,
                showQuickJumper: true,
                showTotal: total => `Total ${total} items`
            }
        };
    },
    components: {
        Side,
        Tabs,
        TabPane,
        Row,
        Col,
        Card,
        Statistic,
        Badge,
        'a-badge-ribbon': Badge.Ribbon,
        ArrowUpOutlined,
        ArrowDownOutlined,
        Tag,
        Button,
        DatePicker,
        Table
    },
    mounted() {
        this.fetchHospitals();
        initFlowbite();
        this.fetchHospitalforBudget();
    },
    methods: {
        dateChange(date, dateString) {
            console.log('Selected Year:', dateString);
            this.year = dateString;
        },
        disabledDate(current) {
            return current && current.year() < new Date().getFullYear();
        },
        fetchHospitalforBudget() {
            axios.get('/api/medical-requests/get-hospital-and-offer', {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    this.budget_hospital = response.data;
                })
                .catch(error => {
                    console.error('Error fetching hospitals:', error);
                });
        },
        addBudget() {
            const modal = document.getElementById('addBudget');
            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');
            // Add event listener to close modal on close button click
            modal.addEventListener('click', function (e) {
                if (e.target && e.target.closest('[data-modal-hide="addBudget"]')) {
                    modal.classList.add('hidden');
                    modal.setAttribute('aria-hidden', 'true');
                }
            });
        },
        insertBudget() {
            const formData = new FormData();
            formData.append('total_budget', this.total_budget);
            formData.append('budget_to_hospital', this.budget_to_hospital);
            formData.append('year', this.year);
            axios.post('/api/budget/budget-allocations', formData, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    this.total_budget = '';
                    this.budget_to_hospital = '';
                    this.year = '';
                    toastr.success('Budget Save Successfully');
                    this.fetchHospitals();
                })
                .catch(error => {
                    console.error(error.response.data);
                    toastr.error(error.response.data);
                });
        },
        fetchHospitals() {
            axios.get('/api/budget/budget-allocations-hospital', {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    this.hospitals = response.data.data.map(hospital => ({
                        name: hospital.hospital,
                        current_year: hospital.current_year,
                        next_year: hospital.next_year,
                        requests: hospital.requests
                    }));
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    toastr.error('Error fetching hospitals data');
                });
        },
        onChange(key) {
            this.activeKey = key;
        }
    }
};
</script>

<style scoped>
</style>
