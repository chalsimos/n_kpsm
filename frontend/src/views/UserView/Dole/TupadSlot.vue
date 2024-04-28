<template>
<div class="flex flex-col min-h-screen">

    <Head />
    <div class="flex-grow p-4 mt-[5vh]">
        <div class="flex">
            <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14 w-1/3">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                    Tupad Slot Available: <span class=" bg-orange-100 text-orange-600 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">{{ totalNoCodeSlots }}</span>
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
                                <tr class="text-center whitespace-nowrap">
                                    <th>Slot Number</th>
                                    <th>Slot Code</th>
                                    <th>Slot Active At</th>
                                    <th>Slot Status</th>
                                </tr>
                            </template>
                            <template v-slot:item="{ item }">
                                <tr class="h-[2vh]">
                                    <td class="whitespace-nowrap uppercase">{{ item.id }}</td>
                                    <td class="whitespace-nowrap uppercase">
                                        {{ item.code_generated }}
                                    </td>
                                    <td class="whitespace-nowrap uppercase">
                                        {{ item.month_year_available }}
                                    </td>
                                    <td class="whitespace-nowrap uppercase">{{ item.status }}</td>
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
                                    <th>Fullname</th>
                                    <th>Age & Birthday</th>
                                    <th>Gender</th>
                                    <th>Address</th>
                                    <th>Civil Status</th>
                                    <th>Contanct Number</th>
                                    <th>Benificiary Name</th>
                                    <th>Id & Id Number</th>
                                    <th>Used Code</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </template>
                            <template v-slot:item="{ item }">
                                <tr class="h-[2vh]">
                                    <td class="whitespace-nowrap">{{ item.firstname }} {{ item.middlename }} {{ item.lastname }}</td>
                                    <td class="whitespace-nowrap">{{ item.age }}years old, {{ item.birthday }}</td>
                                    <td class="whitespace-nowrap">{{ item.gender }}</td>
                                    <td class="whitespace-nowrap">{{ item.province }},{{ item.municipality }},{{ item.barangay }},{{ item.sitio }}</td>
                                    <td class="whitespace-nowrap">{{ item.civil_status }}</td>
                                    <td class="whitespace-nowrap">{{ item.contact_number }}</td>
                                    <td class="whitespace-nowrap">{{ item.benificiary_name }}</td>
                                    <td class="whitespace-nowrap">({{ item.id_type }}) {{ item.id_number }}</td>
                                    <td class="whitespace-nowrap">{{ item.code_generated }}</td>
                                    <td class="whitespace-nowrap">{{ item.status }}</td>
                                    <td class="whitespace-nowrap">{{ item.action }}</td>
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
                    total ++;
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
