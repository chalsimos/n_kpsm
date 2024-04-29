<template>
<Side />
<div>
    <div class="p-4 sm:ml-64 flex-grow overflow-y-auto ">
        <div class="p-2 border-2 border-orange-200 border-solid rounded-lg dark:border-gray-700 mt-14 ">
            <v-card flat>
                <v-card-title class="d-flex align-center pe-2 bg-orange-200">
                    <v-icon icon="mdi-hospital-box-outline"></v-icon> &nbsp; Manage Medical Requests
                    <v-spacer></v-spacer>
                    <v-text-field v-model="search" density="compact" label="Search" prepend-inner-icon="mdi-magnify" variant="solo-filled" flat hide-details single-line></v-text-field>
                </v-card-title>
                <v-divider></v-divider>
                <v-data-table v-model:search="search" :items="items" :items-per-page="5">
                    <template #headers="{ headers }">
                        <tr class="text-center whitespace-nowrap">
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
                            <th>Action</th>
                        </tr>
                    </template>
                    <template v-slot:item="{ item }">
                        <tr class="h-[12vh]">
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
                            <td class="whitespace-nowrap uppercase">
                                <button @click="amountModal(item.id)" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button" v-show="!item.amount">
                                    Input Amount
                                </button>
                                <button @click="DeclineModal(item.id)" data-modal-target="declineModal" data-modal-toggle="declineModal" class="block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm mt-1 px-10 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" type="button" v-show="!item.amount">
                                    Decline
                                </button>
                            </td>
                        </tr>
                    </template>
                </v-data-table>
            </v-card>
        </div>
    </div>
</div>

<div id="amountModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-screen md:inset-0">
    <div class="relative p-4 w-[30vw] max-w-2xl max-h-full">
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
            <form @submit.prevent="updateAmount" class="max-w-sm mx-auto mt-5 mb-5">
                <label for="Amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Input Amount</label>
                <input type="number" id="Amount" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="eg. 1000">
                <div class="flex justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="amountModal" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Approved</button>
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
export default {
    data() {
        return {
            search: '',
            items: []
        };
    },
    components: {
        Side,
    },
    mounted() {

        initTWE({
            Modal,
            Tooltip
        });
        initFlowbite();
        document.title = "Manage Medical Request";
        this.fetchMedicalRequests();
    },
    methods: {
        fetchMedicalRequests() {
            axios.get('/api/medical-requests/get-all')
                .then(response => {
                    this.items = response.data;
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
            const amount = parseFloat(document.getElementById('Amount').value);
            axios.put(`/api/medical-requests/approve-amount/${itemId}`, {
                    amount
                })
                .then(response => {
                    toastr.success("Amount Approve")
                    this.fetchMedicalRequests();
                })
                .catch(error => {
                    console.error(error.response.data);
                    toastr.error("Please input the amount value.")
                });
        }
    }
};
</script>
