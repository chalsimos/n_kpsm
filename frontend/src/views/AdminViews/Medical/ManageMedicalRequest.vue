<template>
    <Side />
    <div>
        <div class="p-4 sm:ml-64 flex-grow overflow-y-auto ">
            <div class="p-2 border-2 border-orange-200 border-solid rounded-lg dark:border-gray-700 mt-14 ">
                <div class="flex items-center justify-between mb-4">
                    <a-button class="text-white bg-blue-500 hover:bg-blue-600" type="primary" @click="generateExcelFiles">Generate Approve Excel</a-button>
                    <a-range-picker class="w-64" v-model="monthYearRange" format="MM/YYYY" picker="month" @change="handleMonthChange" />
                </div>
                <a-tabs default-active-key="1" @change="handleTabChange">
                    <a-tab-pane key="1" tab="Pending List">
                        <v-card flat>
                            <v-card-title class="d-flex align-center pe-2 bg-orange-200">
                                <v-icon icon="mdi-hospital-box-outline"></v-icon> &nbsp; Pending Medical Requests
                                <v-spacer></v-spacer>
                                <v-text-field v-model="search" density="compact" label="Search" prepend-inner-icon="mdi-magnify" variant="solo-filled" flat hide-details single-line></v-text-field>
                            </v-card-title>
                            <v-divider></v-divider>
                            <v-data-table v-model:search="search" :items="items" :items-per-page="5">
                                <template #headers="{ headers }">
                                    <tr class="text-center whitespace-nowrap">
                                        <th>Hor Code</th>
                                        <th>Firstname</th>
                                        <th>Middlename</th>
                                        <th>Lastname</th>
                                        <th>Age</th>
                                        <th>Birthday</th>
                                        <th>Gender</th>
                                        <th>Province</th>
                                        <th>Municipality</th>
                                        <th>Barangay</th>
                                        <th>Representative Fullname</th>
                                        <th>Contact Number</th>
                                        <th>Diagnosis</th>
                                        <th>Hospital</th>
                                        <th>Request</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th>Check Requirements</th>
                                        <th>Action</th>
                                    </tr>
                                </template>
                                <template v-slot:item="{ item }">
                                    <tr class="h-[12vh] text-center">
                                        <td class="whitespace-nowrap uppercase">{{ item.Hor_code }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.firstname }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.middlename }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.lastname }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.age }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.birthday }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.gender }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.province }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.municipality }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.barangay }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.representativefullname }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.contactnumber }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.diagnosis }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.hospital }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.request }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.status }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.amount ? '₱' + parseFloat(item.amount).toFixed(2) : '' }}</td>
                                        <td style="margin-left: .8vw;" class="whitespace-nowrap uppercase ">
                                            <button @click="RequirementsModal(item.id)" class="block text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm mt-1 px-2 py-2 text-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800" type="button">
                                                Requiements
                                            </button>
                                        </td>
                                        <td class="whitespace-nowrap uppercase ">
                                            <button @click="amountModal(item.id)" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button" v-show="!item.amount">
                                                Input Amount
                                            </button>
                                            <button @click="DeclineModal(item.id)" class="block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm mt-1 px-7 py-2 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" type="button" v-show="!item.amount">
                                                Decline
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </v-data-table>
                        </v-card>
                    </a-tab-pane>
                    <a-tab-pane key="2" tab="Approve List">
                        <v-card flat>
                            <v-card-title class="d-flex align-center pe-2 bg-orange-200">
                                <v-icon icon="mdi-hospital-box-outline"></v-icon> &nbsp; Approve Medical Requests
                                <v-spacer></v-spacer>
                                <v-text-field v-model="Approvesearch" density="compact" label="Search" prepend-inner-icon="mdi-magnify" variant="solo-filled" flat hide-details single-line></v-text-field>
                            </v-card-title>
                            <v-divider></v-divider>
                            <v-data-table v-model:search="Approvesearch" :items="Approveitems" :items-per-page="5">
                                <template #headers="{ headers }">
                                    <tr class="text-center whitespace-nowrap">
                                        <th>Hor Code</th>
                                        <th>Firstname</th>
                                        <th>Middlename</th>
                                        <th>Lastname</th>
                                        <th>Age</th>
                                        <th>Birthday</th>
                                        <th>Gender</th>
                                        <th>Province</th>
                                        <th>Municipality</th>
                                        <th>Barangay</th>
                                        <th>Representative Fullname</th>
                                        <th>Contact Number</th>
                                        <th>Diagnosis</th>
                                        <th>Hospital</th>
                                        <th>Request</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th>Check Requirements</th>
                                    </tr>
                                </template>
                                <template v-slot:item="{ item }">
                                    <tr class="h-[12vh] text-center">
                                        <td class="whitespace-nowrap uppercase">{{ item.Hor_code }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.firstname }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.middlename }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.lastname }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.age }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.birthday }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.gender }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.province }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.municipality }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.barangay }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.representativefullname }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.contactnumber }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.diagnosis }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.hospital }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.request }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.status }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.amount ? '₱' + parseFloat(item.amount).toFixed(2) : '' }}</td>
                                        <td style="margin-left: .8vw;" class="whitespace-nowrap uppercase ">
                                            <button @click="RequirementsModal(item.id)" class="block text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm mt-1 px-2 py-2 text-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800" type="button">
                                                Requiements
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </v-data-table>
                        </v-card>
                    </a-tab-pane>
                    <a-tab-pane key="3" tab="Decline List">
                        <v-card flat>
                            <v-card-title class="d-flex align-center pe-2 bg-orange-200">
                                <v-icon icon="mdi-hospital-box-outline"></v-icon> &nbsp; Decline Medical Requests
                                <v-spacer></v-spacer>
                                <v-text-field v-model="Declinesearch" density="compact" label="Search" prepend-inner-icon="mdi-magnify" variant="solo-filled" flat hide-details single-line></v-text-field>
                            </v-card-title>
                            <v-divider></v-divider>
                            <v-data-table v-model:search="Declinesearch" :items="Declineitems" :items-per-page="5">
                                <template #headers="{ headers }">
                                    <tr class="text-center whitespace-nowrap">
                                        <th>Hor Code</th>
                                        <th>Firstname</th>
                                        <th>Middlename</th>
                                        <th>Lastname</th>
                                        <th>Age</th>
                                        <th>Birthday</th>
                                        <th>Gender</th>
                                        <th>Province</th>
                                        <th>Municipality</th>
                                        <th>Barangay</th>
                                        <th>Representative Fullname</th>
                                        <th>Contact Number</th>
                                        <th>Diagnosis</th>
                                        <th>Hospital</th>
                                        <th>Request</th>
                                        <th>Status</th>
                                        <th>Decline Reason</th>
                                        <th>Check Requirements</th>
                                        <th>Decline Reason</th>
                                    </tr>
                                </template>
                                <template v-slot:item="{ item }">
                                    <tr class="h-[12vh] text-center">
                                        <td class="whitespace-nowrap uppercase">{{ item.Hor_code }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.firstname }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.middlename }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.lastname }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.age }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.birthday }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.gender }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.province }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.municipality }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.barangay }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.representativefullname }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.contactnumber }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.diagnosis }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.hospital }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.request }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.status }}</td>
                                        <td class="whitespace-nowrap uppercase">{{ item.decline_reason || '' }}</td>
                                        <td style="margin-left: .8vw;" class="whitespace-nowrap uppercase ">
                                            <button @click="RequirementsModal(item.id)" class="block text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm mt-1 px-2 py-2 text-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800" type="button">
                                                Requiements
                                            </button>
                                        </td>
                                        <td class="whitespace-nowrap uppercase">{{ item.decline_reason }}</td>
                                    </tr>
                                </template>
                            </v-data-table>
                        </v-card>
                    </a-tab-pane>
                </a-tabs>
            </div>
        </div>
    </div>
    <div id="declineModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-screen md:inset-0">
        <div class="relative p-4 sm:px-6 sm:py-8 lg:px-8 lg:py-10 w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Decline Medical Request
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="declineModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form @submit.prevent="DeclineRequest" class="max-w-sm mx-auto mt-5 mb-5 ml-10">
                    <label for="Reason" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Decline Reason</label>
                    <input type="text" id="Reason" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Reason here.">
                    <div class="flex justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button data-modal-hide="declineModal" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Approved</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="amountModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-screen md:inset-0">
        <div class="relative p-4 sm:px-6 sm:py-8 lg:px-8 lg:py-10 w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Medical Assistance Amount
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="amountModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form @submit.prevent="updateAmount" class="max-w-sm mx-auto mt-5 mb-5 ml-10">
                    <label for="Amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Input Amount</label>
                    <input type="number" id="AmountInput" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="eg. 1000">
                    <div class="flex justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button data-modal-hide="amountModal" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Approved</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="RequirementsModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-screen md:inset-0">
        <div class="relative p-4 sm:px-6 sm:py-8 lg:px-8 lg:py-10 w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        {{ medicalRequest.firstname }} {{ medicalRequest.middlename }} {{ medicalRequest.lastname }} Requirements
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="RequirementsModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4">
                    <div v-if="medicalRequest.valid_id_imagepath && medicalRequest.valid_id_imagepath.length">
                        <h4 class="text-lg font-semibold mb-2">Valid ID Image</h4>
                        <carousel :arrows="true">
                            <div v-for="(imagePath, index) in medicalRequest.valid_id_imagepath" :key="'valid_id_' + index">
                                <img v-bind:style="contentStyle" :src="imagePath" :alt="'Valid ID Image ' + (index + 1)" class="w-full cursor-pointer mb-2" @click="previewImage(imagePath)">
                            </div>
                        </carousel>
                    </div>
                    <div v-if="medicalRequest.hospital_document_imagepath && medicalRequest.hospital_document_imagepath.length">
                        <h4 class="text-lg font-semibold mb-2">Hospital Documents Image</h4>
                        <carousel :arrows="true">
                            <div v-for="(imagePath, index) in medicalRequest.hospital_document_imagepath" :key="'hospital_document_' + index">
                                <img v-bind:style="contentStyle" :src="imagePath" :alt="'Hospital Documents Image ' + (index + 1)" class="w-full cursor-pointer mb-2" @click="previewImage(imagePath)">
                            </div>
                        </carousel>
                    </div>
                    <div v-if="medicalRequest.barangay_clearance_imagepath && medicalRequest.barangay_clearance_imagepath.length">
                        <h4 class="text-lg font-semibold mb-2">Barangay Clearance Image</h4>
                        <carousel :arrows="true">
                            <div v-for="(imagePath, index) in medicalRequest.barangay_clearance_imagepath" :key="'barangay_clearance_' + index">
                                <img v-bind:style="contentStyle" :src="imagePath" :alt="'Barangay Clearance Image ' + (index + 1)" class="w-full cursor-pointer mb-2" @click="previewImage(imagePath)">
                            </div>
                        </carousel>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="preview-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 bottom-0 left-0 z-50 flex justify-center items-center">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <button data-modal-hide="preview-modal" @click="closePreviewModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4 md:p-5 space-y-4">
                    <img :src="previewedImage.url" class="w-full h-auto" style="max-width: 100%; max-height: 80vh;">
                </div>
            </div>
        </div>
    </div>
    </template>
    
    <script>
    import {
        Carousel,
        ConfigProvider,
        Popover
    } from "ant-design-vue";
    import {
        Modal,
        Tooltip,
        initTWE
    } from "tw-elements";
    import ExcelJS from 'exceljs';
    import {
        initFlowbite
    } from 'flowbite'
    import Side from '@/views/AdminViews/Home/Sidebar.vue'
    import axios from '../../../main.js'
    import {
        useToast
    } from 'vue-toastification'
    const toastr = useToast()
    import moment from 'moment';
    export default {
        data() {
            return {
                monthYearRange: [],
                imagePath: '',
                search: '',
                Declinesearch: '',
                Approvesearch: '',
                items: [],
                medicalRequest: [],
                Approveitems: [],
                Declineitems: [],
                contentStyle: {
                    margin: 0,
                    height: '160px',
                    color: '#fff',
                    lineHeight: '160px',
                    textAlign: 'center',
                    background: '#364d79',
                },
                previewedImage: {
                    url: ''
                }
            };
        },
        components: {
            Side,
            Carousel,
            ConfigProvider,
            Popover
        },
        mounted() {
            initTWE({
                Modal,
                Tooltip,
    
            });
            initFlowbite();
            this.fetchMedicalRequests();
            this.fetchDeclineMedicalRequests();
            this.fetchApproveMedicalRequests();
        },
        methods: {
            handleMonthChange(dates, dateStrings) {
                let startDate = null;
                let endDate = null;
    
                if (dates && dates.length === 2) {
                    startDate = dates[0].startOf('month').format('YYYY-MM-DD');
                    endDate = dates[1].endOf('month').format('YYYY-MM-DD');
                }
    
                this.fetchMedicalRequests(startDate, endDate);
                this.fetchDeclineMedicalRequests(startDate, endDate);
                this.fetchApproveMedicalRequests(startDate, endDate);
            },
            fetchMedicalRequests(startDate, endDate) {
                axios.get('/api/medical-requests/get-all', {
                        params: {
                            start_date: startDate,
                            end_date: endDate
                        },
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem('token')}`
                        }
                    })
                    .then(response => {
                        this.items = Array.isArray(response.data) ? response.data : [];
                    })
                    .catch(error => {
                        console.error('Error fetching medical requests:', error);
                    });
            },
            fetchDeclineMedicalRequests(startDate, endDate) {
                axios.get('/api/medical-requests/get-all-decline', {
                        params: {
                            start_date: startDate,
                            end_date: endDate
                        },
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem('token')}`
                        }
                    })
                    .then(response => {
                        this.Declineitems = Array.isArray(response.data) ? response.data : [];
                    })
                    .catch(error => {
                        console.error('Error fetching declined medical requests:', error);
                    });
            },
            fetchApproveMedicalRequests(startDate, endDate) {
                axios.get('/api/medical-requests/get-all-approve', {
                        params: {
                            start_date: startDate,
                            end_date: endDate
                        },
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem('token')}`
                        }
                    })
                    .then(response => {
                        this.Approveitems = Array.isArray(response.data) ? response.data : [];
                    })
                    .catch(error => {
                        console.error('Error fetching approved medical requests:', error);
                    });
            },
            generateExcelFiles() {
                axios.get('/api/medical-requests/generate-all-approve', {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem('token')}`
                        }
                    })
                    .then(response => {
                        const data = response.data;
                        const workbook = new ExcelJS.Workbook();
                        let earliestDate = new Date();
                        const customSort = (a, b) => {
                            const aParts = a.Hor_code.split('-');
                            const bParts = b.Hor_code.split('-');
                            const aNumeric = parseInt(aParts[3]);
                            const bNumeric = parseInt(bParts[3]);
                            return aNumeric - bNumeric;
                        };
                        Object.entries(data).forEach(([hospitalName, hospitalData]) => {
                            hospitalData.sort(customSort);
                            const worksheet = workbook.addWorksheet(hospitalName);
                            const medicalAssistanceHeaderRow = worksheet.addRow(['MEDICAL ASSISTANCE']);
                            medicalAssistanceHeaderRow.eachCell(cell => {
                                cell.fill = {
                                    type: 'pattern',
                                    pattern: 'solid',
                                    fgColor: {
                                        argb: '808080'
                                    }
                                };
                                cell.alignment = {
                                    vertical: 'middle',
                                    horizontal: 'center'
                                };
                            });
                            worksheet.mergeCells('A1:T1');
                            const addressHeaderRow = worksheet.getRow(2);
                            addressHeaderRow.getCell('O').value = 'ADDRESS';
                            addressHeaderRow.eachCell(cell => {
                                cell.fill = {
                                    type: 'pattern',
                                    pattern: 'solid',
                                    fgColor: {
                                        argb: 'FFFF00'
                                    }
                                };
                                cell.alignment = {
                                    vertical: 'middle',
                                    horizontal: 'center'
                                };
                            });
                            worksheet.mergeCells('O2:R2');
                            const columnHeaderRow = worksheet.addRow([
                                'HOR CODE', 'DATE RECEIVED', 'REQUEST DATE TO DOH', 'GL RELEASE DATE',
                                'STATUS', 'REPRESENTATIVE', 'CONTACT NO.', 'SURNAME', 'FIRST NAME',
                                'MIDDLE NAME', 'DIAGNOSIS', 'HOSPITAL', 'BIRTHDATE', 'AGE',
                                'STREET', 'BRGY.', 'TOWN', 'PROVINCE', 'TYPE OF REQUEST', 'AMOUNT'
                            ]);
                            columnHeaderRow.eachCell(cell => {
                                cell.fill = {
                                    type: 'pattern',
                                    pattern: 'solid',
                                    fgColor: {
                                        argb: 'FFFF00'
                                    }
                                };
                                cell.alignment = {
                                    vertical: 'middle',
                                    horizontal: 'center',
                                    wrapText: true
                                };
                                cell.height = 60;
                                cell.font = {
                                    bold: true
                                };
                            });
                            worksheet.columns = [{
                                    width: 25
                                }, {
                                    width: 18
                                }, {
                                    width: 10
                                }, {
                                    width: 18
                                },
                                {
                                    width: 18
                                }, {
                                    width: 45
                                }, {
                                    width: 40
                                }, {
                                    width: 25
                                },
                                {
                                    width: 30
                                }, {
                                    width: 25
                                }, {
                                    width: 40
                                }, {
                                    width: 15
                                },
                                {
                                    width: 20
                                }, {
                                    width: 10
                                }, {
                                    width: 13
                                }, {
                                    width: 20
                                },
                                {
                                    width: 20
                                }, {
                                    width: 25
                                }, {
                                    width: 25
                                }, {
                                    width: 25
                                }, {
                                    width: 25
                                }
                            ];
                            worksheet.eachRow(row => {
                                row.eachCell(cell => {
                                    cell.border = {
                                        top: {
                                            style: 'thin'
                                        },
                                        left: {
                                            style: 'thin'
                                        },
                                        bottom: {
                                            style: 'thin'
                                        },
                                        right: {
                                            style: 'thin'
                                        }
                                    };
                                });
                            });
                            let rowIndex = 4;
                            let totalAmount = 0;
                            hospitalData.forEach(item => {
                                const formattedAmount = parseFloat(item.amount).toLocaleString();
                                const rowData = [
                                    item.Hor_code, item.created_at.split(' ')[0], '', item.created_at.split(' ')[0], '', item.representativefullname,
                                    item.contactnumber, item.lastname, item.firstname, item.middlename,
                                    item.diagnosis, item.hospital, item.birthday, item.age,
                                    '', item.barangay, item.municipality, item.province,
                                    item.request, formattedAmount
                                ];
                                const row = worksheet.getRow(rowIndex++);
                                row.values = rowData;
                                row.eachCell(cell => {
                                    cell.border = {
                                        top: {
                                            style: 'thin'
                                        },
                                        left: {
                                            style: 'thin'
                                        },
                                        bottom: {
                                            style: 'thin'
                                        },
                                        right: {
                                            style: 'thin'
                                        }
                                    };
                                    cell.alignment = {
                                        vertical: 'middle',
                                        horizontal: 'center'
                                    };
                                });
                                row.height = 20;
                                totalAmount += Number(item.amount);
                                const earliestItemDate = new Date(hospitalData[0].created_at);
                                if (earliestItemDate < earliestDate) {
                                    earliestDate = earliestItemDate;
                                }
                            });
                            const formattedTotalAmount = totalAmount.toLocaleString();
                            const totalAmountRow = worksheet.getRow(rowIndex);
                            totalAmountRow.getCell('T').value = `Total Amount: ${formattedTotalAmount}`;
                            totalAmountRow.getCell('T').font = {
                                bold: true
                            };
                            totalAmountRow.getCell('T').fill = {
                                type: 'pattern',
                                pattern: 'solid',
                                fgColor: {
                                    argb: 'FFFF00'
                                }
                            };
                            totalAmountRow.getCell('T').border = {
                                top: {
                                    style: 'thin'
                                },
                                left: {
                                    style: 'thin'
                                },
                                bottom: {
                                    style: 'thin'
                                },
                                right: {
                                    style: 'thin'
                                }
                            };
                        });
                        workbook.xlsx.writeBuffer().then((buffer) => {
                            const blob = new Blob([buffer], {
                                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                            });
                            const url = window.URL.createObjectURL(blob);
                            const a = document.createElement('a');
                            a.href = url;
                            const monthName = earliestDate.toLocaleString('en-us', {
                                month: 'long'
                            });
                            const filename = `MAIP month of ${monthName}.xlsx`;
                            a.download = filename;
                            a.click();
                            window.URL.revokeObjectURL(url);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching medical requests:', error);
                    });
            },
            amountModal(itemId) {
                this.itemId = itemId;
                const modal = document.getElementById('amountModal');
                modal.classList.remove('hidden');
                modal.setAttribute('aria-hidden', 'false');
                // Add event listener to close modal on close button click
                modal.addEventListener('click', function (e) {
                    if (e.target && e.target.closest('[data-modal-hide="amountModal"]')) {
                        modal.classList.add('hidden');
                        modal.setAttribute('aria-hidden', 'true');
                    }
                });
            },
            updateAmount() {
                const itemId = this.itemId;
                const amount = document.getElementById('AmountInput').value;
                axios.put(`/api/medical-requests/approve-amount/${itemId}`, {
                        amount
                    }, {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem('token')}`
                        }
                    })
                    .then(response => {
                        toastr.success("Amount Approved");
                        this.fetchMedicalRequests();
                        this.fetchDeclineMedicalRequests();
                        this.fetchApproveMedicalRequests();
                    })
                    .catch(error => {
                        if (error.response && error.response.data && error.response.data.error) {
                            toastr.error(error.response.data.error);
                        } else {
                            toastr.error("Please input the amount value.");
                        }
                        console.error(error.response ? error.response.data : error);
                    });
            },
    
            previewImage(imagePath) {
                this.previewedImage.url = imagePath;
                document.getElementById('RequirementsModal').classList.add('hidden');
                document.getElementById('preview-modal').classList.remove('hidden');
                document.getElementById('preview-modal').focus();
    
            },
            closePreviewModal() {
                document.getElementById('preview-modal').classList.add('hidden');
                document.getElementById('RequirementsModal').classList.remove('hidden');
                this.previewedImage.url = '';
            },
            DeclineModal(itemId) {
                this.itemId = itemId;
                const modal = document.getElementById('declineModal');
                modal.classList.remove('hidden');
                modal.setAttribute('aria-hidden', 'false');
                // Add event listener to close modal on close button click
                modal.addEventListener('click', function (e) {
                    if (e.target && e.target.closest('[data-modal-hide="declineModal"]')) {
                        modal.classList.add('hidden');
                        modal.setAttribute('aria-hidden', 'true');
                    }
                });
            },
            DeclineRequest() {
                const itemId = this.itemId;
                const decline_reason = document.getElementById('Reason').value;
                axios.put(`/api/medical-requests/decline/${itemId}`, {
                        decline_reason
                    }, {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem('token')}`
                        }
                    })
                    .then(response => {
                        toastr.success("Request Decline")
                        this.fetchMedicalRequests();
                        this.fetchDeclineMedicalRequests();
                        this.fetchApproveMedicalRequests();
                    })
                    .catch(error => {
                        console.error(error.response.data);
                    });
            },
            RequirementsModal(itemId) {
                axios.get(`/api/medical-requests/requirements-path/${itemId}`, {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem('token')}`
                        }
                    })
                    .then(response => {
                        this.medicalRequest = response.data;
                        const modal = document.getElementById('RequirementsModal');
                        modal.classList.remove('hidden');
                        modal.setAttribute('aria-hidden', 'false');
                        // Add event listener to close modal on close button click
                        modal.addEventListener('click', function (e) {
                            if (e.target && e.target.closest('[data-modal-hide="RequirementsModal"]')) {
                                modal.classList.add('hidden');
                                modal.setAttribute('aria-hidden', 'true');
                            }
                        });
                        this.medicalRequest.valid_id_imagepath = this.medicalRequest.valid_id_imagepath.map(imagePath => axios.defaults.baseURL + imagePath);
                        this.medicalRequest.hospital_document_imagepath = this.medicalRequest.hospital_document_imagepath.map(imagePath => axios.defaults.baseURL + imagePath);
                        this.medicalRequest.barangay_clearance_imagepath = this.medicalRequest.barangay_clearance_imagepath.map(imagePath => axios.defaults.baseURL + imagePath);
                    })
                    .catch(error => {
                        console.error('Error fetching medical request data:', error);
                    });
            },
            created() {
                this.handleMonthChange();
            }
        }
    };
    </script>
    
    <style>
    @media screen and (min-width: 1024px) {
        .action-column {
            position: sticky;
            right: -0.01vw;
            background-color: rgb(226, 178, 88);
            z-index: 1;
        }
    
        .requirements-column {
            position: sticky;
            right: 7vw;
            background-color: rgb(226, 178, 88);
            z-index: 0;
        }
    }
    </style>
    