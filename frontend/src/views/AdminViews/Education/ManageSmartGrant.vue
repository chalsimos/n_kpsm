<template>
<Side />
<div>
    <div class="p-4 sm:ml-64 flex-grow overflow-y-auto ">
        <div class="p-2 border-2 border-orange-200 border-solid rounded-lg dark:border-gray-700 mt-14 ">
            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-styled-tab" data-tabs-toggle="#default-styled-tab-content" data-tabs-active-classes="text-purple-600 hover:text-purple-600 dark:text-purple-500 dark:hover:text-purple-500 border-purple-600 dark:border-purple-500" data-tabs-inactive-classes="dark:border-transparent text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300" role="tablist">
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="Pending-List-styled-tab" data-tabs-target="#styled-Pending-List" type="button" role="tab" aria-controls="Pending-List" aria-selected="false">Pending List</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="Approve-List-styled-tab" data-tabs-target="#styled-Approve-List" type="button" role="tab" aria-controls="Approve-List" aria-selected="false">Approve List</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="Decline-List-styled-tab" data-tabs-target="#styled-Decline-List" type="button" role="tab" aria-controls="Decline-List" aria-selected="false">Decline List</button>
                    </li>
                </ul>
            </div>
            <div id="default-styled-tab-content">
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-Pending-List" role="tabpanel" aria-labelledby="Pending-List-tab">
                    <v-card flat>
                        <v-card-title class="d-flex align-center pe-2 bg-orange-200">
                            <v-icon icon="mdi-hospital-box-outline"></v-icon> &nbsp; Pending Educational Assistance Requests
                            <v-spacer></v-spacer>
                            <v-text-field v-model="search" density="compact" label="Search" prepend-inner-icon="mdi-magnify" variant="solo-filled" flat hide-details single-line></v-text-field>
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-data-table v-model:search="search" :items="items" :items-per-page="5">
                            <template #headers="{ headers }">
                                <tr class="text-center whitespace-nowrap">
                                    <th class="text-center check-column"> <input @change="checkAll" :checked="isCheckedAll" id="check-all" type="checkbox" value="" class="w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"></th>
                                    <th class="text-center">Beneficiary Fullname</th>
                                    <th class="text-center">Beneficiary Birthday</th>
                                    <th class="text-center">Beneficiary Age</th>
                                    <th class="text-center">Beneficiary Gender</th>
                                    <th class="text-center">Representative Fullname</th>
                                    <th class="text-center">Representative Birthday</th>
                                    <th class="text-center">Representative Age</th>
                                    <th class="text-center">Representative Gender</th>
                                    <th class="text-center">Relationship to Beneficiary</th>
                                    <th class="text-center">Contact Number</th>
                                    <th class="text-center">Province</th>
                                    <th class="text-center">Municipality</th>
                                    <th class="text-center">Barangay</th>
                                    <th class="text-center">Sitio</th>
                                    <th class="text-center">School</th>
                                    <th class="text-center">School Level</th>
                                    <th class="text-center">Year Level</th>
                                    <th class="text-center">Academic Year</th>
                                    <th class="text-center">Amount Budget</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center action-column">Action</th>
                                </tr>
                            </template>
                            <template v-slot:item="{ item }">
                                <tr class="h-[10vh] text-center">
                                    <td class="whitespace-nowrap uppercase check-column">
                                        <input @change="toggleChecked(item.id)" :checked="checkedIds.includes(item.id)" id="single-check" type="checkbox" value="" class="single-check w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    </td>
                                    <td class="whitespace-nowrap uppercase">{{ item.beneficiary_lastname + ' ' + item.beneficiary_firstname + ' ' + item.beneficiary_middlename }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ formatDateToWords(item.beneficiary_birthday) }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.beneficiary_age }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.beneficiary_gender }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.representative_lastname + ' ' + item.representative_firstname + ' ' + item.representative_middlename}}</td>
                                    <td class="whitespace-nowrap uppercase">{{ formatDateToWords(item.representative_birthday) }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.representative_age }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.representative_gender }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.relationship_to_beneficiary }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.contact_number }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.province }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.municipality }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.barangay }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.sitio }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.school }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.school_level }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.year_level }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.academic_year_stage }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.amount ? '₱ ' + parseFloat(item.amount).toFixed(2) : '' }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.status }}</td>
                                    <td class="whitespace-nowrap uppercase action-column">
                                        <button @click="acceptApplication(checkedIds.length > 0 ? checkedIds : item.id)" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                            Accept
                                        </button>
                                        <button @click="DeclineModal(checkedIds.length > 0 ? checkedIds : item.id)" class="block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm mt-1 px-6 py-2 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" type="button">
                                            Decline
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </v-data-table>
                    </v-card>
                </div>
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-Approve-List" role="tabpanel" aria-labelledby="Approve-List-tab">
                    <v-card flat>
                        <v-card-title class="d-flex align-center pe-2 bg-orange-200">
                            <v-icon icon="mdi-hospital-box-outline"></v-icon> &nbsp; Approve Educational Assistance Requests
                            <v-spacer></v-spacer>
                            <v-text-field v-model="Approvesearch" density="compact" label="Search" prepend-inner-icon="mdi-magnify" variant="solo-filled" flat hide-details single-line></v-text-field>
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-data-table v-model:search="Approvesearch" :items="Approveitems" :items-per-page="5">
                            <template #headers="{ headers }">
                                <tr class="text-center whitespace-nowrap">
                                    <th class="text-center check-column"> <input @change="checkAllForApproved" :checked="isCheckedAllForApproved" id="check-all-for-approved" type="checkbox" value="" class="w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"></th>
                                    <th class="text-center">Beneficiary Fullname</th>
                                    <th class="text-center">Beneficiary Birthday</th>
                                    <th class="text-center">Beneficiary Age</th>
                                    <th class="text-center">Beneficiary Gender</th>
                                    <th class="text-center">Representative Fullname</th>
                                    <th class="text-center">Representative Birthday</th>
                                    <th class="text-center">Representative Age</th>
                                    <th class="text-center">Representative Gender</th>
                                    <th class="text-center">Relationship to Beneficiary</th>
                                    <th class="text-center">Contact Number</th>
                                    <th class="text-center">Province</th>
                                    <th class="text-center">Municipality</th>
                                    <th class="text-center">Barangay</th>
                                    <th class="text-center">Sitio</th>
                                    <th class="text-center">School</th>
                                    <th class="text-center">School Level</th>
                                    <th class="text-center">Year Level</th>
                                    <th class="text-center">Academic Year</th>
                                    <th class="text-center">Amount Budget</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center action-column">Action</th>
                                </tr>
                            </template>
                            <template v-slot:item="{ item }">
                                <tr class="h-[10vh] text-center">
                                    <td class="whitespace-nowrap uppercase check-column">
                                        <input @change="toggleCheckedForApproved(item.id)" :checked="checkedIdsForApproved.includes(item.id)" id="single-check" type="checkbox" value="" class="single-check w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    </td>
                                    <td class="whitespace-nowrap uppercase">{{ item.beneficiary_lastname + ' ' + item.beneficiary_firstname + ' ' + item.beneficiary_middlename }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ formatDateToWords(item.beneficiary_birthday) }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.beneficiary_age }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.beneficiary_gender }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.representative_lastname + ' ' + item.representative_firstname + ' ' + item.representative_middlename}}</td>
                                    <td class="whitespace-nowrap uppercase">{{ formatDateToWords(item.representative_birthday) }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.representative_age }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.representative_gender }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.relationship_to_beneficiary }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.contact_number }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.province }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.municipality }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.barangay }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.sitio }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.school }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.school_level }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.year_level }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.academic_year_stage }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.status }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.amount ? '₱ ' + parseFloat(item.amount).toFixed(2) : '' }}</td>
                                    <td class="whitespace-nowrap uppercase action-column">
                                        <button @click="emailModal(checkedIdsForApproved.length > 0 ? checkedIdsForApproved : item.id)" class="block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm mt-1 px-3 py-2 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" type="button">
                                            Send Email
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </v-data-table>
                    </v-card>
                </div>
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="styled-Decline-List" role="tabpanel" aria-labelledby="Decline-List-tab">
                    <v-card flat>
                        <v-card-title class="d-flex align-center pe-2 bg-orange-200">
                            <v-icon icon="mdi-hospital-box-outline"></v-icon> &nbsp; Decline Educational Assistance Requests
                            <v-spacer></v-spacer>
                            <v-text-field v-model="Declinesearch" density="compact" label="Search" prepend-inner-icon="mdi-magnify" variant="solo-filled" flat hide-details single-line></v-text-field>
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-data-table v-model:search="Declinesearch" :items="Declineitems" :items-per-page="5">
                            <template #headers="{ headers }">
                                <tr class="text-center whitespace-nowrap">
                                    <th class="text-center check-column"> <input @change="checkAllForDecline" :checked="isCheckedAllForDecline" id="check-all-for-Decline" type="checkbox" value="" class="w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"></th>
                                    <th class="text-center">Beneficiary Fullname</th>
                                    <th class="text-center">Beneficiary Birthday</th>
                                    <th class="text-center">Beneficiary Age</th>
                                    <th class="text-center">Beneficiary Gender</th>
                                    <th class="text-center">Representative Fullname</th>
                                    <th class="text-center">Representative Birthday</th>
                                    <th class="text-center">Representative Age</th>
                                    <th class="text-center">Representative Gender</th>
                                    <th class="text-center">Relationship to Beneficiary</th>
                                    <th class="text-center">Contact Number</th>
                                    <th class="text-center">Province</th>
                                    <th class="text-center">Municipality</th>
                                    <th class="text-center">Barangay</th>
                                    <th class="text-center">Sitio</th>
                                    <th class="text-center">School</th>
                                    <th class="text-center">School Level</th>
                                    <th class="text-center">Year Level</th>
                                    <th class="text-center">Academic Year</th>
                                    <th class="text-center">Amount Budget</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center action-column">Action</th>
                                </tr>
                            </template>
                            <template v-slot:item="{ item }">
                                <tr class="h-[10vh] text-center">
                                    <td class="whitespace-nowrap uppercase check-column">
                                        <input @change="toggleCheckedForDecline(item.id)" :checked="checkedIdsForDecline.includes(item.id)" id="single-check" type="checkbox" value="" class="single-check w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    </td>
                                    <td class="whitespace-nowrap uppercase">{{ item.beneficiary_lastname + ' ' + item.beneficiary_firstname + ' ' + item.beneficiary_middlename }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ formatDateToWords(item.beneficiary_birthday) }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.beneficiary_age }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.beneficiary_gender }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.representative_lastname + ' ' + item.representative_firstname + ' ' + item.representative_middlename}}</td>
                                    <td class="whitespace-nowrap uppercase">{{ formatDateToWords(item.representative_birthday) }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.representative_age }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.representative_gender }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.relationship_to_beneficiary }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.contact_number }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.province }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.municipality }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.barangay }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.sitio }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.school }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.school_level }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.year_level }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.academic_year_stage }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.status }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.amount ? '₱ ' + parseFloat(item.amount).toFixed(2) : '' }}</td>
                                    <td class="whitespace-nowrap uppercase action-column">
                                        <button @click="emailModal(checkedIdsForDecline.length > 0 ? checkedIdsForDecline : item.id)" class="block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm mt-1 px-3 py-2 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" type="button">
                                            Send Email
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </v-data-table>
                    </v-card>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="declineModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-screen md:inset-0">
    <div class="relative p-4 sm:px-6 sm:py-8 lg:px-8 lg:py-10 w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Decline Educational Assitance Request
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="declineModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form @submit.prevent="DeclineRequest" class="max-w-sm mx-auto mt-5 mb-5">
                <label for="Reason" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Decline Reason</label>
                <input type="text" id="Reason" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Reason here.">
                <div class="flex justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="declineModal" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Approved</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="emailModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-screen md:inset-0">
    <div class="relative p-4 sm:px-6 sm:py-8 lg:px-8 lg:py-10 w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Send an Email Message
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="emailModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="my-6 mx-auto max-w-xl bg-white font-[sans-serif]">
                <h1 class="text-3xl text-[#333] font-extrabold text-center">Message</h1>
                <form class="mt-8 space-y-4" @submit.prevent="sendEmail">
                    <input type="email" :value="emailList" placeholder="Email" disabled class="w-full rounded-md py-3 px-4 bg-gray-100 text-sm outline-blue-500" readonly />
                    <input type="text" placeholder="Subject" id="subject" class="w-full rounded-md py-3 px-4 bg-gray-100 text-sm outline-blue-500" />
                    <textarea placeholder="Message" rows="6" id="message" class="w-full rounded-md px-4 bg-gray-100 text-sm pt-3 outline-blue-500"></textarea>
                    <div class="flex justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button data-modal-hide="emailModal" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Send</button>
                    </div>
                </form>
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
            Approvesearch: '',
            Declinesearch: '',
            items: [],
            Approveitems: [],
            Declineitems: [],
            checkedIds: [],
            checkedIdsForApproved: [],
            checkedIdsForDecline: [],
            emailList: '',
            contentStyle: {
                margin: 0,
                height: '160px',
                color: '#fff',
                lineHeight: '160px',
                textAlign: 'center',
                background: '#364d79',
            },
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
        this.fetchEducationalAssistance();
        this.fetchDeclineEducationalAssistance();
        this.fetchApprovedEducationalAssistance();
    },
    methods: {
        formatDateToWords(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        },
        fetchDeclineEducationalAssistance() {
            axios.get('/api/educational-assistance/get-all-decline_shcolarship-request-smart-grant', {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    this.Declineitems = response.data;
                })
                .catch(error => {
                    console.error('Error fetching medical requests:', error);
                });
        },
        fetchApprovedEducationalAssistance() {
            axios.get('/api/educational-assistance/get-all-approved_shcolarship-request-smart-grant', {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    this.Approveitems = response.data;
                })
                .catch(error => {
                    console.error('Error fetching medical requests:', error);
                });
        },
        fetchEducationalAssistance() {
            axios.get('/api/educational-assistance/get-all-pending_shcolarship-request-smart-grant', {
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
        emailModal(itemId) {
            this.itemId = itemId;
            let emails = [];
            if (Array.isArray(itemId)) {
                itemId.forEach(id => {
                    const item = this.Approveitems.find(item => item.id === id);
                    if (item) {
                        emails.push(item.student_email);
                    }
                });
            } else {
                const item = this.Approveitems.find(item => item.id === itemId);
                if (item) {
                    emails.push(item.student_email);
                }
            }
            this.emailList = emails.join(', ');
            const modal = document.getElementById('emailModal');
            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');
            modal.addEventListener('click', function (e) {
                if (e.target && e.target.closest('[data-modal-hide="emailModal"]')) {
                    modal.classList.add('hidden');
                    modal.setAttribute('aria-hidden', 'true');
                }
            });
        },
        sendEmail() {
            const itemId = this.itemId;
            if (itemId instanceof Event) {
                console.error("Invalid itemId:", itemId);
                return;
            }
            if (Array.isArray(itemId)) {
                itemId.forEach(id => {
                    this.sendEmailRequest(id);
                });
            } else {
                this.sendEmailRequest(itemId);
            }
        },
        sendEmailRequest(id) {
            const subject = document.getElementById('subject').value;
            const message = document.getElementById('message').value;
            axios.post(`/api/educational-assistance/send-email-to-student/${id}`, {
                    subject,
                    message
                }, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    toastr.success('Email Sent!');
                    this.checkedIds = [];
                    document.getElementById('subject').value = '';
                    document.getElementById('message').value = '';

                })
                .catch(error => {
                    console.error('Error sending email:', error);
                });
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
            if (itemId instanceof Event) {
                console.error("Invalid itemId:", itemId);
                return;
            }
            if (Array.isArray(itemId)) {
                itemId.forEach(id => {
                    this.sendDeclineRequest(id);
                });
            } else {
                this.sendDeclineRequest(itemId);
            }
        },
        sendDeclineRequest(itemId) {
            const decline_reason = document.getElementById('Reason').value;
            axios.put(`/api/educational-assistance/decline-scholarship-request/${itemId}`, {
                    decline_reason
                }, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    toastr.success("Request Decline");
                    this.fetchEducationalAssistance();
                    this.checkedIds = [];
                })
                .catch(error => {
                    console.error(error.response.data);
                    toastr.error("Failed to decline request.");
                });
        },
        acceptApplication(itemId) {
            if (Array.isArray(itemId)) {
                itemId.forEach(id => {
                    const item = this.items.find(item => item.id === id);
                    if (item) {
                        this.sendApprovalRequest(id, item.amount);
                    }
                });
            } else {
                const item = this.items.find(item => item.id === itemId);
                if (item) {
                    this.sendApprovalRequest(itemId, item.amount);
                }
            }
        },
        sendApprovalRequest(id, amount) {
            axios.put(`/api/educational-assistance/approve-scholarship-request/${id}`, {
                    amount
                }, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    toastr.success("Application Approved");
                    this.fetchEducationalAssistance();
                    this.checkedIds = [];
                })
                .catch(error => {
                    console.error(error.response.data);
                    toastr.error("Failed to approve application.");
                });
        },
        checkAll(event) {
            const isChecked = event.target.checked;
            if (isChecked) {
                this.checkedIds = this.items.map((item) => item.id);
            } else {
                this.checkedIds = [];
            }
            this.$nextTick(() => {
                document.getElementById("check-all").checked = isChecked;
            });
        },
        toggleChecked(id) {
            if (this.checkedIds.includes(id)) {
                this.checkedIds = this.checkedIds.filter((checkedId) => checkedId !== id);
            } else {
                this.checkedIds.push(id);
            }
        },
        checkAllForApproved(event) {
            const isChecked = event.target.checked;
            if (isChecked) {
                this.checkedIdsForApproved = this.Approveitems.map((item) => item.id);
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
        checkAllForDecline(event) {
            const isChecked = event.target.checked;
            if (isChecked) {
                this.checkedIdsForDecline = this.Declineitems.map((item) => item.id);
            } else {
                this.checkedIdsForDecline = [];
            }
            this.$nextTick(() => {
                document.getElementById("check-all-for-Decline").checked = isChecked;
            });
        },
        toggleCheckedForDecline(id) {
            if (this.checkedIdsForDecline.includes(id)) {
                this.checkedIdsForDecline = this.checkedIdsForDecline.filter((checkedId) => checkedId !== id);
            } else {
                this.checkedIdsForDecline.push(id);
            }
        },
    },
    computed: {
        isCheckedAll() {
            return this.checkedIds.length === this.items.length && this.checkedIds.length > 0;
        },
        isCheckedAllForApproved() {
            return this.checkedIdsForApproved.length === this.Approveitems.length && this.checkedIdsForApproved.length > 0;
        },
        isCheckedAllForDecline() {
            return this.checkedIdsForDecline.length === this.Declineitems.length && this.checkedIdsForDecline.length > 0;
        },
    },
};
</script>

<style>
@media screen and (min-width: 1024px) {
    .action-column {
        position: sticky;
        right: -0.01vw;
        background-color: rgb(240, 176, 134);
        z-index: 1;
    }

    .requirements-column {
        position: sticky;
        right: 7vw;
        background-color: rgb(240, 176, 134);
        z-index: 0;
    }

    .check-column {
        position: sticky;
        left: 0vw;
        background-color: rgb(240, 176, 134);
        z-index: 0;
    }
}
</style>
