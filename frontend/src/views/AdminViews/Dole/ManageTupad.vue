<template>
<Side />
<div>
    <div class="p-4 sm:ml-64 flex-grow overflow-y-auto ">
        <div class="p-2 border-2 border-orange-200 border-solid rounded-lg dark:border-gray-700 mt-14 ">
            <div class="flex items-center justify-between mb-4">
                <a-button class="text-white bg-blue-500 hover:bg-blue-600" type="primary" @click="generateExcelFiles">Generate Tupad Excel</a-button>
                <a-range-picker class="w-64" v-model="monthYearRange" format="MM/YYYY" picker="month" @change="handleRangeMonthChange" />
            </div>
            <a-tabs default-active-key="1" @change="handleTabChange">
                <a-tab-pane key="1" tab="Captain List">
                    <v-card flat>
                        <!-- Main table -->
                        <v-card-title class="d-flex align-center pe-2 bg-orange-200">
                            <img src="../../../assets/tupad.jpg" class="h-8 me-3" alt="KPSM Logo" /> &nbsp; Captain List
                            <v-spacer></v-spacer>
                            <v-text-field v-model="captain_search" density="compact" label="Search" prepend-inner-icon="mdi-magnify" variant="solo-filled" flat hide-details single-line></v-text-field>
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-data-table v-model:search="captain_search" :items="items" :items-per-page="5">
                            <template #headers="{ headers }">
                                <tr class="text-center whitespace-nowrap">
                                    <th> <input @change="checkAllForApproved" :checked="isCheckedAllForApproved" id="check-all-for-approved" type="checkbox" value="" class="w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"></th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </template>
                            <template v-slot:item="{ item }">
                                <tr class="h-[2vh]">
                                    <td class="whitespace-nowrap uppercase">
                                        <input @change="toggleCheckedForApproved(item.id)" :checked="checkedIdsForApproved.includes(item.id)" id="single-check" type="checkbox" value="" class="single-check w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    </td>
                                    <td class="whitespace-nowrap uppercase">{{ item.firstname + ' ' + item.middlename + ' ' + item.lastname }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.municipality + ' ' + item.barangay }}</td>
                                    <td class="whitespace-nowrap uppercase">
                                        <div class="flex space-x-4">
                                            <button @click.stop="giveSlot(checkedIdsForApproved.length > 0 ? checkedIdsForApproved : item.id)" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                                Give slot
                                            </button>
                                            <button @click.stop="checkSlot(item.id)" class="text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800" type="button">
                                                Tupad Slot History
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </v-data-table>
                    </v-card>
                </a-tab-pane>
                <a-tab-pane key="2" tab="Tupad Beneficiaries">
                    <v-card flat>
                        <v-card-title class="d-flex align-center pe-2 bg-orange-200">
                            <img src="../../../assets/tupad.jpg" class="h-8 me-3" alt="KPSM Logo" />&nbsp; Tupad Member
                            <v-spacer></v-spacer>
                            <v-text-field v-model="tupad_memberSearch" density="compact" label="Search" prepend-inner-icon="mdi-magnify" variant="solo-filled" flat hide-details single-line></v-text-field>
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-data-table v-model:search="tupad_memberSearch" :items="tupad_member" :items-per-page="5">
                            <template #headers="{ headers }">
                                <tr class="text-center whitespace-nowrap">
                                    <th v-for="header in dynamicHeaders" :key="header.key" class="text-center whitespace-nowrap">
                                        {{ header.header }}
                                    </th>
                                    <th class="text-center whitespace-nowrap">Invited by</th>
                                    <th class="text-center whitespace-nowrap">Captain Address</th>
                                </tr>
                            </template>
                            <template v-slot:item="{ item }">
                                <tr class="h-[2vh]">
                                    <td v-for="header in dynamicHeaders" :key="header.key" class="whitespace-nowrap text-center">
                                        {{ item[header.key] }}
                                    </td>
                                    <td class="whitespace-nowrap text-center">{{ item.captain_name }}</td>
                                    <td class="whitespace-nowrap text-center">{{ item.captain_address }}</td>
                                </tr>
                            </template>
                        </v-data-table>
                    </v-card>
                </a-tab-pane>
            </a-tabs>
        </div>
    </div>
</div>

<div id="giveSlot" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-screen md:inset-0">
    <div class="relative p-4 sm:px-6 sm:py-8 lg:px-8 lg:py-10 w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Tupad Slot
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="giveSlot">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form @submit.prevent="slotRequest" class="max-w-sm mx-auto mt-5 mb-5 ml-10">
                <label for="Amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">How Many Slot</label>
                <input v-model="slot_get" type="number" id="Amount" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="eg. 1000">
                <label for="slotDate" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Slot Available</label>
                <div class="relative max-w-full">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                        </svg>
                    </div>
                    <a-space direction="vertical">
                        <a-date-picker v-model="month_year_available" format="MM/YYYY" picker="month" @change="handleMonthChange" :disabledDate="disabledPastDates" />

                    </a-space>
                </div>
                <div class="flex justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Approved</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="checkSlot" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-screen md:inset-0">
    <div class="relative p-4 sm:px-6 sm:py-8 lg:px-8 lg:py-10 w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-2xl max-h-full">
        <div class="relative bg-orange-200 rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Tupad Member Slot History
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="checkSlot">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <v-card flat>
                <v-card-title class="d-flex align-center pe-2 bg-orange-200">
                    <img src="../../../assets/tupad.jpg" class="h-8 me-3" alt="KPSM Logo" />&nbsp; Tupad Captain
                    <v-spacer></v-spacer>
                    <v-text-field v-model="captain_slotSearch" density="compact" label="Search" prepend-inner-icon="mdi-magnify" variant="solo-filled" flat hide-details single-line></v-text-field>
                </v-card-title>
                <v-divider></v-divider>
                <v-data-table v-model:search="captain_slotSearch" :items="captain_slot" :items-per-page="5">
                    <template #headers="{ headers }">
                        <tr class="text-center whitespace-nowrap">
                            <th class="text-center whitespace-nowrap">Captain Name</th>
                            <th class="text-center whitespace-nowrap">Captain Address</th>
                            <th class="text-center whitespace-nowrap">Slot Get</th>
                            <th class="text-center whitespace-nowrap">Slot Left</th>
                            <th class="text-center whitespace-nowrap">Excel File</th>
                            <th class="text-center whitespace-nowrap">Check IDs</th>
                            <th class="text-center whitespace-nowrap">Slot Available At</th>
                            <th class="text-center whitespace-nowrap">Slot Obtained</th>
                        </tr>
                    </template>
                    <template v-slot:item="{ item }">
                        <tr class="h-[2vh] w-[5vw]">
                            <td class="whitespace-nowrap text-center">{{ item.firstname + ' ' + item.middlename + ' ' + item.lastname }}</td>
                            <td class="whitespace-nowrap text-center">{{ item.municipality + ' ' + item.barangay }}</td>
                            <td class="whitespace-nowrap text-center">{{ item.slot_get }}</td>
                            <td class="whitespace-nowrap text-center">{{ item.slot_left }}</td>
                            <td class="whitespace-nowrap text-center">
                                <template v-if="item.slot_left === 0">
                                    <button @click="viewExcel(item.tupad_excel_form_id)" class="block text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm mt-1 px-2 py-2 text-center dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">View Excel</button>
                                </template>
                                <template v-else>
                                    <span class="whitespace-normal text-red-900 w-[5vw]">Captain still not passing the form.</span>
                                </template>
                            </td>
                            <td class="whitespace-nowrap text-center">
                                <template v-if="item.slot_left === 0">
                                    <button @click="checkIDS(item.tupad_excel_form_id)" class="block text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm mt-1 px-2 py-2 text-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800" type="button">
                                        Check Ids
                                    </button>
                                </template>
                                <template v-else>
                                    <span class="whitespace-normal text-red-900 w-[5vw]">Captain still not passing the id.</span>
                                </template>
                            </td>
                            <td class="whitespace-nowrap text-center">{{ formatMonthYearToWords(item.month_year_available) }}</td>
                            <td class="whitespace-nowrap text-center">{{ formatDateToWords(item.date_obtained) }}</td>
                        </tr>
                    </template>
                </v-data-table>

            </v-card>
        </div>
    </div>
</div>
<div id="checkIDS" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-screen md:inset-0">
    <div class="relative p-4 sm:px-6 sm:py-8 lg:px-8 lg:py-10 w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="checkIDS">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="p-4">
                <div v-if="tupadRequest.image_urls && tupadRequest.image_urls.length">
                    <h4 class="text-lg font-semibold mb-2">Valid ID Image</h4>
                    <carousel :arrows="true">
                        <div v-for="(imagePath, index) in tupadRequest.image_urls" :key="'valid_id_' + index">
                            <img v-bind:style="contentStyle" :src="imagePath" :alt="'Valid ID Image ' + (index + 1)" class="w-full cursor-pointer mb-2" @click="previewImage(imagePath)">
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
<div id="excel-modal" tabindex="-1" aria-hidden="true" :class="{ 'hidden': !isModalOpen }" class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-screen md:inset-0">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Excel Data</h3>
                <button @click="closeExcelModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="p-4 overflow-x-auto">
                <table class="table-auto w-full border-collapse border border-gray-300">
                    <thead>
                        <tr>
                            <th v-for="(header, index) in excelHeaders" :key="index" class="p-2 bg-gray-100 border border-gray-300 text-left text-gray-800 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-700">
                                {{ header }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row, rowIndex) in excelRows" :key="rowIndex" class="border border-gray-300">
                            <td v-for="(cell, cellIndex) in row" :key="cellIndex" class="p-2 border border-gray-300 text-left text-gray-800 dark:text-gray-100 dark:border-gray-700">
                                {{ cell }}
                            </td>
                        </tr>
                    </tbody>
                </table>
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
    Popover,
    Tabs
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
import {
    computed
} from "vue";
export default {
    data() {
        return {
            monthYearRange: [],
            ApproveForGenerate: [],
            captain_search: '',
            captain_slotSearch: '',
            tupad_memberSearch: '',
            month_year_available: '',
            slot_get: '',
            tupadRequest: [],
            tupad_member: [],
            dynamicHeaders: [],
            checkedIdsForApproved: [],
            items: [],
            captain_slot: [],
            previewedImage: {
                url: ''
            },
            excelHeaders: [],
            excelRows: [],
            excelUrl: '',
            isModalOpen: false,
        };
    },
    components: {
        Side,
        Tag,
        Carousel,
        ConfigProvider,
        Popover,
        Tabs
    },
    async mounted() {
        initTWE({
            Modal,
            Tooltip
        });
        initFlowbite();
        this.fetchCaptainList();
        this.fetchTupadMember();
        this.fetchSlotlist();
        this.fetchApproveForGenerate();
        try {
            this.dynamicHeaders = await this.fetchActiveHeaders();
        } catch (error) {
            console.error('Error fetching headers:', error);
        }
    },
    methods: {
        handleRangeMonthChange(dates, dateStrings) {
            if (dates && dates.length === 2) {
                this.startDate = dates[0].startOf('month').format('YYYY-MM-DD');
                this.endDate = dates[1].endOf('month').format('YYYY-MM-DD');
            } else {
                this.startDate = null;
                this.endDate = null;
            }
            this.fetchApproveForGenerate(this.startDate, this.endDate);
            this.fetchSlotlist(this.startDate, this.endDate);
            this.fetchTupadMember(this.startDate, this.endDate);
        },
        viewExcel(itemId) {
            axios.get(`/api/dole/get-excel-path/${itemId}`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`,
                    },
                    responseType: 'arraybuffer',
                })
                .then(response => {
                    this.parseExcelData(response.data);
                    this.openExcelModal();
                })
                .catch(error => {
                    console.error('Error fetching Excel URL:', error);
                });
        },
        openExcelModal() {
            this.isModalOpen = true;
        },
        closeExcelModal() {
            this.isModalOpen = false;
            this.excelHeaders = [];
            this.excelRows = [];
        },
        async parseExcelData(excelData) {
            try {
                const workbook = new ExcelJS.Workbook();
                await workbook.xlsx.load(excelData);
                const worksheet = workbook.getWorksheet(1);
                this.excelHeaders = worksheet.getRow(2).values.map(header => header.toString());
                this.excelRows = [];
                worksheet.eachRow((row, rowIndex) => {
                    if (rowIndex > 2) {
                        const rowData = row.values.map(cell => {
                            if (cell instanceof Date) {
                                return this.formatDate(cell);
                            }
                            return cell;
                        });
                        this.excelRows.push(rowData);
                    }
                });
                worksheet.columns.forEach(column => {
                    column.width = 25;
                });
            } catch (error) {
                console.error('Error parsing Excel data:', error);
            }
        },
        formatDate(date) {
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            return new Intl.DateTimeFormat('en-US', options).format(date);
        },
        fetchApproveForGenerate(startDate, endDate) {
            return new Promise((resolve, reject) => {
                axios.get('/api/dole/get-invites-per-captain', {
                        params: {
                            start_date: startDate,
                            end_date: endDate
                        },
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem('token')}`
                        }
                    })
                    .then(response => {
                        console.log(response.data.data)
                        this.ApproveForGenerate = response.data.data;
                        resolve();
                    })
                    .catch(error => {
                        console.error('Error fetching approved educational assistance:', error);
                        reject(error);
                    });
            });
        },
        async generateExcelFiles() {
            try {
                if (!this.ApproveForGenerate || Object.keys(this.ApproveForGenerate).length === 0) {
                    toastr.error('No data available to generate Excel file.');
                    return;
                }
                const workbook = new ExcelJS.Workbook();
                const createdAtDates = [];
                Object.keys(this.ApproveForGenerate).forEach(municipality => {
                    const municipalitiesData = this.ApproveForGenerate[municipality];
                    const worksheet = workbook.addWorksheet(municipality);
                    let rowIndex = 1;
                    Object.keys(municipalitiesData).forEach(barangay => {
                        const captainsData = municipalitiesData[barangay];
                        Object.values(captainsData).forEach(captainData => {
                            captainData.tupads.forEach(tupad => {
                                if (tupad.created_at) {
                                    createdAtDates.push(new Date(tupad.created_at));
                                }
                            });
                        });
                        worksheet.getCell(`A${rowIndex}`).value = 'BARANGAY';
                        worksheet.getCell(`A${rowIndex}`).fill = {
                            type: 'pattern',
                            pattern: 'solid',
                            fgColor: {
                                argb: 'FFFF00'
                            }
                        };
                        worksheet.getCell(`A${rowIndex}`).font = {
                            bold: true
                        };
                        worksheet.getCell(`A${rowIndex}`).border = {
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
                        worksheet.getCell(`B${rowIndex}`).value = barangay.toUpperCase();
                        worksheet.getCell(`B${rowIndex}`).border = {
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
                        worksheet.getCell(`B${rowIndex}`).fill = {
                            type: 'pattern',
                            pattern: 'solid',
                            fgColor: {
                                argb: 'FFFF00'
                            }
                        };
                        worksheet.getCell(`B${rowIndex}`).font = {
                            bold: true
                        };
                        worksheet.getCell(`B${rowIndex}`).border = {
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
                        rowIndex++;
                        worksheet.addRow([]);
                        rowIndex++;
                        Object.keys(captainsData).forEach(captainId => {
                            const captainDetails = captainsData[captainId].captain_details;
                            const tupads = captainsData[captainId].tupads;
                            worksheet.getCell(`A${rowIndex}`).value = 'CAPTAIN NAME';
                            worksheet.getCell(`A${rowIndex}`).fill = {
                                type: 'pattern',
                                pattern: 'solid',
                                fgColor: {
                                    argb: 'FFFF00'
                                }
                            };
                            worksheet.getCell(`A${rowIndex}`).font = {
                                bold: true
                            };
                            worksheet.getCell(`A${rowIndex}`).border = {
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
                            worksheet.getCell(`B${rowIndex}`).value = captainDetails.captain_name.toUpperCase();
                            worksheet.getCell(`B${rowIndex}`).border = {
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
                            worksheet.getCell(`B${rowIndex}`).fill = {
                                type: 'pattern',
                                pattern: 'solid',
                                fgColor: {
                                    argb: 'FFFF00'
                                }
                            };
                            worksheet.getCell(`B${rowIndex}`).font = {
                                bold: true
                            };
                            worksheet.getCell(`B${rowIndex}`).border = {
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
                            rowIndex++;
                            const headers = Object.keys(tupads[0]).filter(header => header !== 'created_at');
                            headers.forEach((header, columnIndex) => {
                                worksheet.getCell(`${this.getColumnLetter(columnIndex + 1)}${rowIndex}`).value = header.replace(/_/g, ' ').toUpperCase();
                                worksheet.getCell(`${this.getColumnLetter(columnIndex + 1)}${rowIndex}`).border = {
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
                                worksheet.getCell(`${this.getColumnLetter(columnIndex + 1)}${rowIndex}`).fill = {
                                    type: 'pattern',
                                    pattern: 'solid',
                                    fgColor: {
                                        argb: 'FFFF00'
                                    }
                                };
                                worksheet.getCell(`${this.getColumnLetter(columnIndex + 1)}${rowIndex}`).font = {
                                    bold: true
                                };
                                worksheet.getColumn(columnIndex + 1).width = (header === 'barangay' || header === 'captain_name') ? 20 : 25; // Set different column width
                            });
                            rowIndex++;
                            tupads.forEach((tupad, dataIndex) => {
                                headers.forEach((header, columnIndex) => {
                                    worksheet.getCell(`${this.getColumnLetter(columnIndex + 1)}${rowIndex}`).value = tupad[header].toUpperCase();
                                    worksheet.getCell(`${this.getColumnLetter(columnIndex + 1)}${rowIndex}`).border = {
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
                                rowIndex++;
                            });
                            rowIndex++;
                        });
                        rowIndex++;
                    });
                    worksheet.views = [{
                        state: 'frozen',
                        xSplit: 0,
                        ySplit: 1,
                        activeCell: 'A1'
                    }];
                });
                const buffer = await workbook.xlsx.writeBuffer();
                const blob = new Blob([buffer], {
                    type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                });
                if (createdAtDates.length > 0) {
                    const earliestDate = new Date(Math.min(...createdAtDates));
                    const latestDate = new Date(Math.max(...createdAtDates));
                    const earliestMonth = earliestDate.toLocaleString('default', {
                        month: 'long'
                    });
                    const latestMonth = latestDate.toLocaleString('default', {
                        month: 'long'
                    });
                    const earliestYear = earliestDate.getFullYear();
                    const latestYear = latestDate.getFullYear();
                    let filename;
                    if (earliestMonth === latestMonth && earliestYear === latestYear) {
                        filename = `TUPAD month of ${earliestMonth} ${earliestYear}.xlsx`;
                    } else if (earliestYear === latestYear) {
                        filename = `TUPAD month of ${earliestMonth}-${latestMonth} ${earliestYear}.xlsx`;
                    } else {
                        filename = `TUPAD month of ${earliestMonth} ${earliestYear} - ${latestMonth} ${latestYear}.xlsx`;
                    }
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = filename;
                    a.click();
                    window.URL.revokeObjectURL(url);
                } else {
                    toastr.error('No valid created_at dates found for generating filename.');
                }
            } catch (error) {
                console.error('Error generating Excel file:', error);
                toastr.error('Error generating Excel file. Please try again.');
            }
        },
        getColumnLetter(index) {
            let dividend = index;
            let columnName = '';
            let modulo;
            while (dividend > 0) {
                modulo = (dividend - 1) % 26;
                columnName = String.fromCharCode(65 + modulo) + columnName;
                dividend = parseInt((dividend - modulo) / 26, 10);
            }
            return columnName;
        },
        async fetchActiveHeaders() {
            try {
                const response = await axios.get('/api/dole/get-active-header');
                if (response.status === 200) {
                    return response.data.headers;
                } else {
                    throw new Error('Failed to fetch active headers');
                }
            } catch (error) {
                console.error('Error fetching active headers:', error);
                toastr.error('Failed to fetch active headers');
                return [];
            }
        },
        checkSlot(itemId) {
            this.itemId = itemId;
            this.fetchSlotlist(itemId, this.startDate, this.endDate);
            const modal = document.getElementById('checkSlot');
            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');
            // Add event listener to close modal on close button click
            modal.addEventListener('click', function (e) {
                if (e.target && e.target.closest('[data-modal-hide="checkSlot"]')) {
                    modal.classList.add('hidden');
                    modal.setAttribute('aria-hidden', 'true');
                }
            });
        },
        fetchSlotlist(itemId, startDate, endDate) {
            axios.get(`/api/dole/all-captain-slot/${itemId}`, {
                    params: {
                        start_date: startDate,
                        end_date: endDate
                    },
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    this.captain_slot = response.data;
                })
                .catch(error => {
                    console.error('Error fetching captain slot details:', error);
                });
        },
        checkIDS(itemId) {
            axios.get(`/api/dole/get-file-path/${itemId}`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    this.tupadRequest = response.data;
                    const modal = document.getElementById('checkIDS');
                    modal.classList.remove('hidden');
                    modal.setAttribute('aria-hidden', 'false');
                    // Add event listener to close modal on close button click
                    modal.addEventListener('click', function (e) {
                        if (e.target && e.target.closest('[data-modal-hide="checkIDS"]')) {
                            modal.classList.add('hidden');
                            modal.setAttribute('aria-hidden', 'true');
                        }
                    });
                    this.tupadRequest.image_urls = this.tupadRequest.image_urls.map(imagePath => axios.defaults.baseURL + imagePath);
                })
                .catch(error => {
                    console.error('Error fetching medical request data:', error);
                });
        },
        previewImage(imagePath) {
            this.previewedImage.url = imagePath;
            document.getElementById('checkIDS').classList.add('hidden');
            document.getElementById('preview-modal').classList.remove('hidden');
            document.getElementById('preview-modal').focus();
        },
        closePreviewModal() {
            document.getElementById('preview-modal').classList.add('hidden');
            document.getElementById('checkIDS').classList.remove('hidden');
            this.previewedImage.url = '';
        },
        handleTabChange(key) {},

        fetchTupadMember(startDate, endDate) {
            axios.get('/api/dole/getAll-captains-tupad-invites', {
                    params: {
                        start_date: startDate,
                        end_date: endDate
                    },
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    this.tupad_member = response.data.data;
                })
                .catch(error => {
                    console.error('Error fetching tupad slot:', error);
                });
        },
        handleMonthChange(date, dateString) {
            const formattedDate = moment(dateString, "MM/YYYY").format("YYYY-MM");
            console.log(date, formattedDate);
            this.month_year_available = formattedDate;
        },
        disabledPastDates(current) {
            // Disable all dates before today
            const now = new Date();
            const currentYear = now.getFullYear();
            const currentMonth = now.getMonth();
            if (!current) {
                return false;
            }
            const dateYear = current.year();
            const dateMonth = current.month();
            if (dateYear < currentYear) {
                return true;
            }
            if (dateYear === currentYear && dateMonth < currentMonth) {
                return true;
            }

            return false;
        },
        giveSlot(itemId) {
            this.itemId = itemId;
            const modal = document.getElementById('giveSlot');
            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');
            // Add event listener to close modal on close button click
            modal.addEventListener('click', function (e) {
                if (e.target && e.target.closest('[data-modal-hide="giveSlot"]')) {
                    modal.classList.add('hidden');
                    modal.setAttribute('aria-hidden', 'true');
                }
            });
        },
        slotRequest() {
            const itemId = this.itemId;
            if (itemId instanceof Event) {
                console.error("Invalid itemId:", itemId);
                return;
            }
            if (Array.isArray(itemId)) {
                itemId.forEach(id => {
                    this.updateSlot(id);
                });
            } else {
                this.updateSlot(itemId);
            }
        },
        updateSlot(itemId) {
            const formData = {
                slot_get: this.slot_get,
                month_year_available: this.month_year_available
            };
            axios.post(`/api/dole/give-slot/${itemId}`, formData, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    this.slot_get = '',
                        this.month_year_available = ''
                    toastr.success("Slot Approved");
                    document.getElementById('giveSlot').classList.add('hidden');
                    this.fetchCaptainList();
                    this.checkedIdsForApproved = [];
                })
                .catch(error => {
                    console.error(error.response.data);
                    toastr.error("Please input the amount value.");
                });
        },
        fetchCaptainList() {
            axios.get('/api/dole/captain-list', {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    this.items = response.data;
                })
                .catch(error => {
                    console.error('Error fetching medical requests:', error);
                });
        },
        formatDateToWords(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        },
        formatMonthYearToWords(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long'
            });
        },
        checkAllForApproved(event) {
            const isChecked = event.target.checked;
            if (isChecked) {
                this.checkedIdsForApproved = this.items.map((item) => item.id);
            } else {
                this.checkedIdsForApproved = [];
            }
            this.$nextTick(() => {
                document.getElementById("check-all-for-approved").checked = isChecked;
            });
        },
        toggleCheckedForApproved(id) {
            if (this.checkedIdsForApproved.includes(id)) {
                this.checkedIdsForApproved = this.checkedIdsForApproved.filter((checkedId) => checkedId !== id);
            } else {
                this.checkedIdsForApproved.push(id);
            }
        },
        computed: {
            isCheckedAllForApproved() {
                return this.checkedIdsForApproved.length === this.items.length && this.checkedIdsForApproved.length > 0;
            },
        },
        created() {
            this.handleMonthChange();
        }
    }
};
</script>

<style scoped>
#excel-modal {
    background-color: rgba(0, 0, 0, 0.5);
}

#excel-modal>.max-w-2xl {
    width: 100%;
    max-width: 100%;
}

#excel-modal td,
#excel-modal th {
    min-width: 100px;
}

@media (max-width: 768px) {
    #excel-modal>.max-w-2xl {
        max-width: 95%;
    }
}
</style>
