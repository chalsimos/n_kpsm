<template>
<Side />
<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
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
                        <th class="text-center">Image</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </template>
                <template v-slot:item="{ item }">
                    <tr class="h-[10vh] text-center">
                        <td class="whitespace-nowrap uppercase"> <img :src="getImageUrl(item.image_path)" alt="Image" style="max-width: 100px; max-height: 100px;">
                        </td>
                        <td class="whitespace-nowrap uppercase">{{ item.status === 1 ? 'Active' : 'Inactive' }}</td>
                        <td class="whitespace-nowrap uppercase">
                            <button @click="acceptApplication(item.id)" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                Accept
                            </button>
                            <button @click="DeclineModal(item.id)" class="block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm mt-1 px-6 py-2 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" type="button">
                                Decline
                            </button>
                        </td>
                    </tr>
                </template>
            </v-data-table>
        </v-card>
    </div>
</div>
</template>

<script>
import {
    Modal,
    Tooltip,
    initTWE
} from "tw-elements";
import {} from "ant-design-vue";

import {
    initFlowbite
} from 'flowbite'
import Side from '@/views/AdminViews/Home/Sidebar.vue'
import axios from '../../../main.js'
import {
    useToast
} from 'vue-toastification'
export default {
    data() {
        return {
            search: '',
            items: [],
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
        document.title = "Manage Logo";
        this.fetchLogo();
    },
    methods: {
        fetchLogo() {
            axios.get('/api/utility/get-logos', {
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
        getImageUrl(imagePath) {
            console.log(imagePath)
            // Assuming axios.defaults.baseURL already contains the base URL
            return `${axios.defaults.baseURL}/${imagePath}`;
        },
        formatDateToWords(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        },

    },
    computed: {

    },
    watch: {

    }
};
</script>
