<template>
<Side />
<div>
    <div class="p-4 sm:ml-64 flex-grow overflow-y-auto ">
        <div class="p-2 border-2 border-orange-200 border-solid rounded-lg dark:border-gray-700 mt-14 ">
            <v-card flat>
                <v-card-title class="d-flex align-center pe-2 bg-orange-200">
                    <img src="../../../assets/tupad.jpg" class="h-8 me-3" alt="KPSM Logo" /> &nbsp; Manage Medical Requests
                    <v-spacer></v-spacer>
                    <v-text-field v-model="search" density="compact" label="Search" prepend-inner-icon="mdi-magnify" variant="solo-filled" flat hide-details single-line></v-text-field>
                </v-card-title>
                <v-divider></v-divider>
                <v-data-table v-model:search="search" :items="items" :items-per-page="5">
                    <template #headers="{ headers }">
                        <tr class="text-center whitespace-nowrap">
                            <th>Name</th>
                            <th>Slot Have</th>
                            <th>Slot Left</th>
                            <th>Slot Available At</th>
                            <th>Slot Obtained</th>
                            <th>Action</th>
                        </tr>
                    </template>
                    <template v-slot:item="{ item }">
                        <tr class="h-[2vh]">
                            <td class="whitespace-nowrap uppercase">{{ item.name }}</td>
                            <td class="whitespace-nowrap uppercase">{{ item.slot_get ?? 'No slot given' }}</td>
                            <td class="whitespace-nowrap uppercase">{{ item.slot_left ?? 'No slot given' }}</td>
                            <td class="whitespace-nowrap uppercase">{{ item.month_year_available ?? 'No slot given' }}</td>
                            <td class="whitespace-nowrap uppercase">{{ item.date_obtained ?? 'No slot given' }}</td>
                            <td class="whitespace-nowrap uppercase">
                                <button @click="giveSlot(item.id)" v-show="item.slot_left === null" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                    Input number of slot
                                </button>
                            </td>
                        </tr>
                    </template>
                </v-data-table>
            </v-card>
        </div>
    </div>
</div>

<div id="giveSlot" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-screen md:inset-0">
    <div class="relative p-4 w-[30vw] max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Medical Assistance Amount
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="giveSlot">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form @submit.prevent="updateSlot" class="max-w-sm mx-auto mt-5 mb-5">
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
                        <a-date-picker v-model="month_year_available" format="MM/YYYY" picker="month" @change="handleMonthChange" />
                    </a-space>
                </div>
                <div class="flex justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Approved</button>
                </div>
            </form>
        </div>
    </div>
</div>
</template>

<script>
import {
    Modal,
    Tooltip,
    initTWE
} from "tw-elements";

import {
    initFlowbite
} from 'flowbite'
import Side from '@/views/AdminViews/Home/Sidebar.vue'
import axios from '../../../main.js'
import {
    useToast
} from 'vue-toastification'
const toastr = useToast()
import {
    ADatePicker,
    ASpace
} from 'ant-design-vue';
import moment from 'moment';

export default {
    data() {
        return {
            search: '',
            items: [],
            month_year_available: '',
            slot_get: '',
        };
    },
    components: {
        Side,
        ADatePicker,
        ASpace
    },
    mounted() {
        initTWE({
            Modal,
            Tooltip
        });
        initFlowbite();
        document.title = "Manage Medical Request";
        this.fetchCaptainList();
    },
    methods: {
        handleMonthChange(date, dateString) {
            const formattedDate = moment(dateString, "MM/YYYY").format("YYYY-MM");
            console.log(date, formattedDate);
            this.month_year_available = formattedDate;
        },
        updateSlot() {
            const itemId = this.itemId;
            const formData = {
                slot_get: this.slot_get,
                month_year_available: this.month_year_available
            };
            axios.post(`/api/dole/give-slot/${itemId}`, formData)
                .then(response => {
                    this.slot_get = '',
                    this.month_year_available = ''
                    toastr.success("Slot Approved");
                    document.getElementById('giveSlot').classList.add('hidden');
                    this.fetchCaptainList();
                })
                .catch(error => {
                    console.error(error.response.data);
                    toastr.error("Please input the amount value.");
                });
        },

        fetchCaptainList() {
            axios.get('/api/dole/captain-list')
                .then(response => {
                    this.items = response.data;
                })
                .catch(error => {
                    console.error('Error fetching medical requests:', error);
                });
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
    }
};
</script>
