<template>
<Side />
<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <v-card class="bg-orange-200" flat>
            <v-card-title class="d-flex align-center pe-2 bg-orange-200">
                <v-icon icon="mdi-hospital-box-outline"></v-icon> &nbsp; Tupad Excel Header
                <v-spacer></v-spacer>
                <Button type="primary" @click="AddHeader" style="background-color: #ffd666">
                    Add Header
                </Button>
            </v-card-title>
            <v-divider></v-divider>
            <v-data-table v-model:search="search" :items="items" :items-per-page="10">
                <template #headers="{ headers }">
                    <tr class="text-center whitespace-nowrap">
                        <th class="text-center">Header</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </template>
                <template v-slot:item="{ item } " class="bg-orange-200">
                    <tr class="h-[5vh] text-center" elevation="2">
                        <td class="whitespace-nowrap uppercase">{{ item.header }}</td>
                        <td class="whitespace-nowrap uppercase">{{ getStatusDisplay(item) }}</td>
                        <td class="whitespace-nowrap uppercase">
                            <!-- <div class="mt-1 mb-1">
                                    <Button type="primary" class="px-6" danger @click="deleteHeader(item.id)" v-show="item.status === 'active'">
                                        Delete
                                    </Button>
                                </div> -->
                            <div v-show="item.key !== 'province' && item.key !== 'municipality' && item.key !== 'barangay' && item.key !== 'sex' && item.key !== 'birthday' && item.key !== 'age'">
                                <Button type="primary" primary @click="activateHeader(item.id)" v-show="item.status === 'active'">
                                    Dectivate
                                </Button>
                            </div>
                            <div class="mb-1">
                                <Button type="primary" primary @click="activateHeader(item.id)" v-show="item.status === 'inactive'">
                                    Activate
                                </Button>
                            </div>
                        </td>
                    </tr>
                </template>
            </v-data-table>
        </v-card>
    </div>
</div>
<div id="AddHeader" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-screen md:inset-0">
    <div class="relative p-4 sm:px-6 sm:py-8 lg:px-8 lg:py-10 w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Add Header
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="AddHeader">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form @submit.prevent="insertHeader" class="w-full px-4 py-6 sm:px-6 sm:py-8 lg:px-8 lg:py-10">
                <div class="mb-5">
                    <label for="header" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Header Name</label>
                    <input v-model="header" type="text" id="header" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Firstname" required />
                </div>
                <div class="flex justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="AddHospital" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Header</button>
                </div>
            </form>
        </div>
    </div>
</div>
</template>

    
<script>
import {
    Button,
    Upload
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
            items: [],
            header: ''
        };
    },
    components: {
        Side,
        Button,
        Upload
    },
    mounted() {
        initTWE({
            Modal,
            Tooltip
        });
        initFlowbite();
        this.fetchData();
    },
    methods: {
        getStatusDisplay(item) {
            const protectedKeys = ['province', 'municipality', 'barangay', 'gender', 'age', 'birthday', 'sex'];
            if (protectedKeys.includes(item.key)) {
                return 'protected';
            } else {
                return item.status;
            }
        },
        insertHeader() {
            const formData = new FormData();
            formData.append('header', this.header);
            axios.post('/api/utility/save-tupad-header', formData, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    this.header = '';
                    toastr.success('Header Successfully Sent');
                    this.fetchData();
                })
                .catch(error => {
                    if (error.response && error.response.data && error.response.data.error) {
                        toastr.error(error.response.data.error);
                    } else {
                        toastr.error("Can't Add New Header");
                    }
                    console.error(error.response ? error.response.data : error);
                });
        },
        AddHeader() {
            const modal = document.getElementById('AddHeader');
            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');
            // Add event listener to close modal on close button click
            modal.addEventListener('click', function (e) {
                if (e.target && e.target.closest('[data-modal-hide="AddHeader"]')) {
                    modal.classList.add('hidden');
                    modal.setAttribute('aria-hidden', 'true');
                }
            });
        },
        deleteHeader(id) {
            axios.delete(`/api/utility/delete-tupad-header/${id}`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    toastr.success("Header Deleted");
                    this.fetchData();
                })
                .catch(error => {
                    toastr.error("Cant Delete Active Header")
                    console.error(error.response.data);
                });
        },
        activateHeader(id) {
            axios.put(`/api/utility/update-tupad-header-status/${id}`, {}, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    toastr.success("Header Updated");
                    this.fetchData();
                })
                .catch(error => {
                    if (error.response && error.response.data && error.response.data.error) {
                        toastr.error(error.response.data.error);
                    } else {
                        toastr.error("Can't Activate This Header");
                    }
                    console.error(error.response ? error.response.data : error);
                });
        },
        fetchData() {
            axios.get('/api/utility/get-tupad-header', {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    this.items = response.data;
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        },
    },
    computed: {}
};
</script>
