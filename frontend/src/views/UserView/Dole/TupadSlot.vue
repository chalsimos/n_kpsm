<template>
<div class="flex flex-col min-h-screen">

    <Head />
    <div class="flex-grow p-4 mt-[5vh]">
        <div class="flex">
            <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14 w-1/3">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                    New Tupad Slot Available: <span class=" bg-orange-100 text-orange-600 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">{{ totalNoCodeSlots }}</span>
                    <Flex v-show="totalNoCodeSlots !== 0 " gap="small" wrap="wrap">
                        <Button @click="generateCodes" class="bg-orange-400 hover:bg-orange-600 text-white border border-orange-900">Generate {{ totalNoCodeSlots }} Code</Button>
                    </Flex>
                </h2>
                <div class="p-2 border-2 border-orange-200 border-solid rounded-lg dark:border-gray-700 mt-5">
                    <v-card flat>
                        <v-card-title class="d-flex align-center pe-2 bg-orange-200">
                            <img src="../../../assets/tupad.jpg" class="h-8 me-3" alt="KPSM Logo" />&nbsp; Manage Tupad Slot
                            <v-spacer></v-spacer>
                            <v-text-field v-model="search" density="compact" label="Search" prepend-inner-icon="mdi-magnify" variant="solo-filled" flat hide-details single-line></v-text-field>
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-data-table v-model:search="search" :items="items" :items-per-page="5">
                            <template #headers="{ headers }">
                                <tr>
                                    <th class="text-center whitespace-nowrap">Slot Number</th>
                                    <th class="text-center whitespace-nowrap">Slot Code</th>
                                    <th class="text-center whitespace-nowrap">Slot Available At</th>
                                    <th class="text-center whitespace-nowrap">Slot Status</th>
                                </tr>
                            </template>
                            <template v-slot:item="{ item }">
                                <tr class="h-[7vh]">
                                    <td class="whitespace-nowrap text-center ">{{ item.id }}</td>
                                    <td class="whitespace-nowrap text-center ">
                                        {{ item.code_generated }}
                                    </td>
                                    <td class="whitespace-nowrap text-center ">
                                        {{ item.month_year_available }}
                                    </td>
                                    <td class="whitespace-nowrap text-center ">{{ item.status }}</td>
                                </tr>
                            </template>
                        </v-data-table>
                    </v-card>
                </div>
            </div>
            <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14 w-2/3">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                    Tupad Invited: <span class=" bg-orange-100 text-orange-600 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">{{ totalInvites }}</span>
                </h2>
                <div class="p-2 border-2 border-orange-200 border-solid rounded-lg dark:border-gray-700 mt-5">
                    <v-card flat>
                        <v-card-title class="d-flex align-center pe-2 bg-orange-200">
                            <img src="../../../assets/tupad.jpg" class="h-8 me-3" alt="KPSM Logo" />&nbsp; Manage Tupad Invites
                            <v-spacer></v-spacer>
                            <v-text-field v-model="search" density="compact" label="Search" prepend-inner-icon="mdi-magnify" variant="solo-filled" flat hide-details single-line></v-text-field>
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-data-table v-model:search="search" :items="tupad_invites" :items-per-page="5">
                            <template #headers="{ headers }">
                                <tr class="text-center whitespace-nowrap">
                                    <th class="text-center whitespace-nowrap">Fullname</th>
                                    <th class="text-center whitespace-nowrap">Age & Birthday</th>
                                    <th class="text-center whitespace-nowrap">Gender</th>
                                    <th class="text-center whitespace-nowrap">Address</th>
                                    <th class="text-center whitespace-nowrap">Civil Status</th>
                                    <th class="text-center whitespace-nowrap">Contanct Number</th>
                                    <th class="text-center whitespace-nowrap">Benificiary Name</th>
                                    <th class="text-center whitespace-nowrap">Id & Id Number</th>
                                    <th class="text-center whitespace-nowrap">Used Code</th>
                                    <th class="text-center whitespace-nowrap">Status</th>
                                    <th class="text-center whitespace-nowrap">Action</th>
                                </tr>
                            </template>
                            <template v-slot:item="{ item }">
                                <tr class="h-[2vh]">
                                    <td class="whitespace-nowrap text-center">{{ item.firstname }} {{ item.middlename }} {{ item.lastname }}</td>
                                    <td class="whitespace-nowrap text-center">{{ item.age }}years old, {{ item.birthday }}</td>
                                    <td class="whitespace-nowrap text-center">{{ item.gender }}</td>
                                    <td class="whitespace-nowrap text-center">{{ item.province }},{{ item.municipality }},{{ item.barangay }},{{ item.sitio }}</td>
                                    <td class="whitespace-nowrap text-center">{{ item.civil_status }}</td>
                                    <td class="whitespace-nowrap text-center">{{ item.contact_number }}</td>
                                    <td class="whitespace-nowrap text-center">{{ item.benificiary_name }}</td>
                                    <td class="whitespace-nowrap text-center">({{ item.id_type }}) {{ item.id_number }}</td>
                                    <td class="whitespace-nowrap text-center">{{ item.code_generated }}</td>
                                    <td class="whitespace-nowrap text-center">{{ item.status }}</td>
                                    <td class="whitespace-nowrap text-center">
                                        <button @click="AcceptRequest(item.id)" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm  px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button" v-show="item.status === 'pending'">
                                            Accept
                                        </button>
                                        <button @click="DeclineModal(item.id)" class="block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm mt-1 px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" type="button" v-show="item.status === 'pending'">
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
    </div>
    <div>
        <Foot />
    </div>
</div>
<div id="declineModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-screen md:inset-0">
    <div class="relative p-4 w-[30vw] max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Decline Tupad Request
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
                <input type="text" id="Reason" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="eg. 1000">
                <div class="flex justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="declineModal" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Approved</button>
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
    Button,
    Flex
} from "ant-design-vue";
import {
    initFlowbite
} from "flowbite";
import Head from "@/views/UserView/Home/Header.vue";
import {
    useToast
} from "vue-toastification";
import Foot from "@/views/UserView/Home/Footer.vue";
const toastr = useToast();
import axios from "../../../main.js";
export default {
    components: {
        Head,
        Foot,
        Button,
        Flex
    },
    data() {
        return {
            search: "",
            totalNoCodeSlots: '',
            totalInvites: '',
            items: [],
            tupad_invites: []
        };
    },
    mounted() {
        initTWE({
            Modal,
            Tooltip,
        });
        initFlowbite();
        document.title = "KPSM - Tupad Slot";
        this.fetchTupadCode();
        this.fetchTupadSlot();
        this.fetchTupadInvites();
    },
    methods: {
        AcceptRequest(id) {
            axios.put(`/api/dole/accept-tupad-request/${id}`, null, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    toastr.success("Request Accepted");
                    this.fetchTupadInvites();
                })
                .catch(error => {
                    console.error(error.response.data);
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
            const decline_reason = document.getElementById('Reason').value;
            axios.put(`/api/dole/decline-tupad-request/${itemId}`, {
                    decline_reason
                }, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    toastr.success("Request Decline")
                    this.fetchTupadInvites();
                })
                .catch(error => {
                    console.error(error.response.data);
                });
        },
        fetchTupadInvites() {
            axios.get('/api/dole/captain-tupad-invited', {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    this.tupad_invites = response.data;
                    this.totalInvites = this.calculatetotalInvites(this.tupad_invites);
                })
                .catch(error => {
                    console.error('Error fetching tupad slot:', error);
                });
        },
        calculatetotalInvites(invites) {
            let total = 0;
            invites.forEach(tupad_invites => {
                if (tupad_invites.use_code_id !== '') {
                    total++;
                }
            });
            return total;
        },
        fetchTupadCode() {
            axios
                .get("/api/dole/tupad-code-list", {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem("token")}`,
                    },
                })
                .then((response) => {
                    this.items = response.data;
                })
                .catch((error) => {
                    console.error("Error fetching tupad slot:", error);
                });
        },
        fetchTupadSlot() {
            axios.get('/api/dole/captain-slot-list', {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    this.slots = response.data.data;
                    this.totalNoCodeSlots = this.calculateTotalNoCodeSlots(this.slots);
                })
                .catch(error => {
                    console.error('Error fetching tupad slot:', error);
                });
        },
        calculateTotalNoCodeSlots(slots) {
            let total = 0;
            slots.forEach(slot => {
                if (slot.status === 'No Code') {
                    total += slot.slot_get;
                }
            });
            return total;
        },
        generateCodes() {
            axios.post('/api/dole/generate-code', {}, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    toastr.success("Generated Code Successfully!");
                    this.fetchTupadCode();
                    this.fetchTupadSlot();
                })
                .catch(error => {
                    console.error('Error generating codes:', error);
                });
        }

    },
    watch: {},

    computed: {},
};
</script>
