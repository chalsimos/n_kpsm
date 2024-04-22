<template>
<Side />
<div>
    <div class="p-4 sm:ml-64 flex-grow overflow-y-auto ">
        <div class="p-4 border-2 border-orange-200  border-solid rounded-lg dark:border-gray-700 mt-14 ">
            <v-card flat>
                <v-card-title class="d-flex align-center pe-2 bg-orange-200">
                    <v-icon icon="mdi-video-input-component"></v-icon> &nbsp; Manage Medical Requests
                    <v-spacer></v-spacer>
                    <v-text-field v-model="search" density="compact" label="Search" prepend-inner-icon="mdi-magnify" variant="solo-filled" flat hide-details single-line></v-text-field>
                </v-card-title>
                <v-divider></v-divider>
                <v-data-table v-model:search="search" :items="items">
                    <template v-slot:item="{ item }">
                        <tr>
                            <td class="whitespace-nowrap">{{ item.firstname }}</td>
                            <td class="whitespace-nowrap">{{ item.middlename }}</td>
                            <td class="whitespace-nowrap">{{ item.lastname }}</td>
                            <td class="whitespace-nowrap">{{ item.age }}</td>
                            <td class="whitespace-nowrap">{{ item.birthday }}</td>
                            <td class="whitespace-nowrap">{{ item.gender }}</td>
                            <td class="whitespace-nowrap">{{ item.province }}</td>
                            <td class="whitespace-nowrap">{{ item.municipality }}</td>
                            <td class="whitespace-nowrap">{{ item.barangay }}</td>
                            <td class="whitespace-nowrap">{{ item.representativefullname }}</td>
                            <td class="whitespace-nowrap">{{ item.contactnumber }}</td>
                            <td class="whitespace-nowrap">{{ item.diagnosis }}</td>
                            <td class="whitespace-nowrap">{{ item.hospital }}</td>
                            <td class="whitespace-nowrap">{{ item.request }}</td>
                            <td class="whitespace-nowrap">{{ item.status }}</td>
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
