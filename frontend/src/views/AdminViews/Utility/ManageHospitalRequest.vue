<template>
<Side />
<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <v-card class="bg-orange-200" flat>
            <v-card-title class="d-flex align-center pe-2 bg-orange-200">
                <v-icon icon="mdi-hospital-box-outline"></v-icon> &nbsp; Manage Hospitals Offer
                <v-spacer></v-spacer>
            </v-card-title>
            <v-divider></v-divider>
            <v-data-table v-model:search="search" :items="items" :items-per-page="5">
                <template #headers="{ headers }">
                    <tr class="text-center whitespace-nowrap">
                        <th class="text-center">Hospital Name</th>
                        <th class="text-center">Address</th>
                        <th class="text-center">Hospital District</th>
                        <th class="text-center">Available Service Offer</th>
                        <th class="text-center">Action</th>
                    </tr>
                </template>
                <template v-slot:item="{ item } " class="bg-orange-200">
                    <tr class="h-[5vh] text-center" elevation="2">
                        <td class="whitespace-nowrap uppercase">{{ item.hospital_name + ' (' + item.hospital_acronym + ')' }}</td>
                        <td class="whitespace-nowrap uppercase">{{ item.hospital_address }}</td>
                        <td class="whitespace-nowrap uppercase">{{ item.hospital_district }}</td>
                        <td class="whitespace-normal uppercase">
                            <div class="grid grid-cols-2 gap-2">
                                <template v-for="(offer, index) in item.offer">
                                    <span class="inline-flex items-center justify-center px-2 py-1 rounded-full text-xs font-medium bg-blue-400 text-white" :style="offerStyle(item.offer)">
                                        {{ offer }}
                                    </span>
                                </template>
                            </div>
                        </td>
                        <td class="whitespace-nowrap uppercase">
                            <div class="mb-1 mt-1">
                                <Button type="primary" class="px-7" danger @click="ServiceModal(item.id)" v-show="item.status === 'inactive'">
                                    Add Service
                                </Button>
                            </div>
                            <div class="mb-1">
                                <Button type="primary" primary @click="modifyOffer(item.id)" v-show="item.status === 'inactive'">
                                    Modify Service
                                </Button>
                            </div>
                        </td>
                    </tr>
                </template>
            </v-data-table>
        </v-card>
    </div>
</div>
<div id="ServiceModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-screen md:inset-0">
    <div class="relative p-4 w-[30vw] max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Add Service
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="ServiceModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form @submit.prevent="addService" class="max-w-sm mx-auto mt-5 mb-5">
                <label for="Offer" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Input Service Offer</label>
                <input type="text" id="Offer" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="CT-Scan">
                <div class="flex justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="ServiceModal" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Approved</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="modifyOffer" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-screen md:inset-0">
    <div class="relative p-4 w-[30vw] max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Modify a Service
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="modifyOffer">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <v-card flat>
                <v-card-title class="d-flex align-center pe-2 bg-orange-200">
                    <v-icon icon="mdi-hospital-box-outline"></v-icon> &nbsp; Manage Hospitals Offer
                    <v-spacer></v-spacer>
                </v-card-title>
                <v-divider></v-divider>
                <v-data-table :items="offers" :items-per-page="5">
                    <template #headers="{ headers }">
                        <tr class="text-center whitespace-nowrap">
                            <th class="text-center whitespace-nowrap">Service Offer</th>
                            <th class="text-center whitespace-nowrap">Status</th>
                            <th class="text-center whitespace-nowrap">Action</th>
                        </tr>
                    </template>
                    <template v-slot:item="{ item }">
                        <tr class="h-[2vh]">
                            <td class="whitespace-nowrap text-center">{{ item.service_offer }}</td>
                            <td class="whitespace-nowrap text-center">{{ item.status }}</td>
                            <td class="whitespace-nowrap text-center">
                                <div class="mb-1 mt-1">
                                    <Button @click="activateOffer(item.id)" v-show="item.status === 'inactive'">
                                        Activate
                                    </Button>
                                </div>
                                <div class="mb-1 mt-1">
                                    <Button type="primary" class="px-7" @click="inactiveOffer(item.id)" v-show="item.status === 'active'">
                                        Inactive
                                    </Button>
                                </div>
                                <div class="mb-1">
                                    <Button type="primary" primary danger @click="deleteOffer(item.id)" v-show="item.status === 'inactive'">
                                        Delete Offer
                                    </Button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </v-data-table>
            </v-card>
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
            offers: [],
        };
    },
    components: {
        Side,
        Button,
        Upload,
    },
    mounted() {
        initTWE({
            Modal,
            Tooltip
        });
        initFlowbite();
        this.fetchData();
        this.fetchOffer(this.itemId);
    },
    methods: {
        ServiceModal(itemId) {
            this.itemId = itemId;
            const modal = document.getElementById('ServiceModal');
            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');
            // Add event listener to close modal on close button click
            modal.addEventListener('click', function (e) {
                if (e.target && e.target.closest('[data-modal-hide="ServiceModal"]')) {
                    modal.classList.add('hidden');
                    modal.setAttribute('aria-hidden', 'true');
                }
            });
        },
        addService() {
            const itemId = this.itemId;
            const service_offer = document.getElementById('Offer').value;
            axios.post(`/api/utility/create-hospital-offer/${itemId}`, {
                    service_offer
                }, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    document.getElementById('Offer').value = '';
                    toastr.success("Offer Successfully Created");
                    this.fetchData();
                })
                .catch(error => {
                    console.error(error.response.data);
                    toastr.error("Please input the offer value.");
                });
        },
        modifyOffer(itemId) {
            this.itemId = itemId;
            const modal = document.getElementById('modifyOffer');
            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');
            this.fetchOffer(itemId);
            modal.addEventListener('click', function (e) {
                if (e.target && e.target.closest('[data-modal-hide="modifyOffer"]')) {
                    modal.classList.add('hidden');
                    modal.setAttribute('aria-hidden', 'true');
                }
            });
        },
        fetchOffer(itemId) {
            axios.get(`/api/utility/get-hospital-service-offer/${itemId}`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    this.offers = response.data.service_offers;
                    console.log(response.data.service_offers);
                })
                .catch(error => {
                    console.error(error.response.data);
                });
        },
        deleteService() {
            axios.put(`/api/utility/active-hospital/${id}`, {}, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    toastr.success("Hospital Updated");
                    this.fetchData();
                })
                .catch(error => {
                    if (error.response && error.response.data && error.response.data.error) {
                        toastr.error(error.response.data.error);
                    } else {
                        toastr.error("Can't Activate This Hospital");
                    }
                    console.error(error.response ? error.response.data : error);
                });
        },
        fetchData() {
            axios.get('/api/utility/get-hospital-with-offer', {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    this.items = response.data.map(item => {
                        return {
                            ...item,
                            offer: item.service_offers
                        };
                    });
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        },
        offerStyle(offers) {
            let maxLength = 0;
            for (let i = 0; i < offers.length; i++) {
                if (offers[i].length > maxLength) {
                    maxLength = offers[i].length;
                }
            }
            let width = maxLength * 10;
            return {
                width: `${width}px`,
            };
        },
        inactiveOffer(id) {
            axios.put(`/api/utility/deactivate-offer/${id}`, {}, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    toastr.success("Offer Updated");
                    this.fetchOffer(this.itemId);
                })
                .catch(error => {
                    if (error.response && error.response.data && error.response.data.error) {
                        toastr.error(error.response.data.error);
                    } else {
                        toastr.error("Can't Activate This Offer");
                    }
                    console.error(error.response ? error.response.data : error);
                });
        },
        activateOffer(id) {
            axios.put(`/api/utility/active-offer/${id}`, {}, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    toastr.success("Offer Updated");
                    this.fetchOffer(this.itemId);
                })
                .catch(error => {
                    if (error.response && error.response.data && error.response.data.error) {
                        toastr.error(error.response.data.error);
                    } else {
                        toastr.error("Can't Activate This Offer");
                    }
                    console.error(error.response ? error.response.data : error);
                });
        },
        deleteOffer(id) {
            axios.delete(`/api/utility/delete-offer/${id}`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    toastr.success("Offer Deleted");
                    this.fetchOffer(this.itemId);
                })
                .catch(error => {
                    toastr.error("Cant Delete Active Offer")
                    console.error(error.response.data);
                });
        },
    },
    computed: {},
    watch: {}
};
</script>
