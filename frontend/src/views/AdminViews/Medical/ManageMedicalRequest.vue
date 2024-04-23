<template>
<Side />
<div>
    <div class="p-4 sm:ml-64 flex-grow overflow-y-auto ">
        <div class="p-4 border-2 border-orange-200  border-solid rounded-lg dark:border-gray-700 mt-14 ">
            <v-card flat>
                <v-card-title class="d-flex align-center pe-2 bg-orange-200">
                    <v-icon icon="mdi-hospital-box-outline"></v-icon> &nbsp; Manage Medical Requests
                    <v-spacer></v-spacer>
                    <v-text-field v-model="search" density="compact" label="Search" prepend-inner-icon="mdi-magnify" variant="solo-filled" flat hide-details single-line></v-text-field>
                </v-card-title>
                <v-divider></v-divider>
                <v-data-table v-model:search="search" :items="items" :items-per-page="5">
                    <template v-slot:item="{ item }">
                        <tr>
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
                            <td class="whitespace-nowrap uppercase">{{ item.amount ? '₱   ' + parseFloat(item.amount).toFixed(2) : '' }}</td>
                        </tr>
                    </template>
                </v-data-table>
            </v-card>
        </div>
    </div>
</div>
</template>

<script>
import Side from '@/views/AdminViews/Home/Sidebar.vue'
import axios from '../../../main.js'

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
        }
    }
};
</script>
