<template>
<Side />
<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <v-card class="bg-orange-200" flat>
            <v-card-title class="d-flex align-center pe-2 bg-orange-200">
                <v-icon icon="mdi-hospital-box-outline"></v-icon> &nbsp; 
                <v-spacer></v-spacer>
                <Button type="primary" @click="AddHospital" style="background-color: #ffd666">
                    Add Hospital
                </Button>
            </v-card-title>
            <v-divider></v-divider>
            <v-data-table v-model:search="search" :items="items" :items-per-page="5">
                <template #headers="{ headers }">
                    <tr class="text-center whitespace-nowrap">
                        <th class="text-center">Hospital Name</th>
                        <th class="text-center">Acronym</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Address</th>
                        <th class="text-center">Action</th>
                    </tr>
                </template>
                <template v-slot:item="{ item } " class="bg-orange-200">
                    <tr class="h-[5vh] text-center" elevation="2">
                        <td class="whitespace-nowrap uppercase">{{ item.hospital_name }}</td>
                        <td class="whitespace-nowrap uppercase">{{ item.hospital_acronym }}</td>
                        <td class="whitespace-nowrap uppercase">
                            <v-chip :color="item.status === 'active' ? 'green' : 'red'" :text="item.status === 'active' ? 'Active' : 'Inactive'" class="text-uppercase" size="small" label></v-chip>
                        </td>
                        <td class="whitespace-nowrap uppercase">{{ item.hospital_address }}</td>
                        <td class="whitespace-nowrap uppercase">
                            <div class="mb-1 mt-1">
                                <Button type="primary" class="px-5" danger @click="deleteHospital(item.id)" v-show="item.status === 'inactive'">
                                    Delete
                                </Button>
                            </div>
                            <div class="mb-1">
                                <Button type="primary" primary @click="ActivateHospital(item.id)" v-show="item.status === 'inactive'">
                                    Activate
                                </Button>
                            </div>
                            <div class="mb-1">
                                <Button @click="DeactivateHospital(item.id)" v-show="item.status === 'active'">
                                    Deactivate
                                </Button>
                            </div>
                        </td>
                    </tr>
                </template>
            </v-data-table>
        </v-card>
    </div>
</div>
<div id="AddHospital" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-screen md:inset-0">
    <div class="relative p-4 sm:px-6 sm:py-8 lg:px-8 lg:py-10 w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Add New Hospital
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="AddHospital">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form @submit.prevent="insertHospital" class="w-full px-4 py-6 sm:px-6 sm:py-8 lg:px-8 lg:py-10">
                <div class="mb-5">
                    <label for="hospital_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hospital Name</label>
                    <input v-model="hospital_name" type="text" id="hospital_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Hospital Name" required />
                </div>
                <div class="mb-5">
                    <label for="hospital_acronym" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Acronym</label>
                    <input v-model="hospital_acronym" type="text" id="hospital_acronym" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Acronym" required />
                </div>
                <div class="mb-5">
                    <label for="hospital_district" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hospital District</label>
                    <input v-model="hospital_district" type="text" id="hospital_district" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="District" required />
                </div>
                <div class="mb-5">
                    <label for="Province" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Province</label>
                    <select @change="handleCity" id="Province" v-model="provinceto" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" required>
                        <option value="1752">Oriental Mindoro</option>
                    </select>
                </div>
                <div class="mb-5">
                    <label for="Municipality" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Municipality</label>
                    <select @change="handleBarangay" id="Municipality" v-model="municipality" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" required>
                        <option disabled selected value="">Select City</option>
                        <option v-for="city in cities" :value="city.city_code" :key="city.city_code">{{ city.city_name }}</option>
                    </select>
                </div>
                <input type="hidden" v-model="selectedMunicipality" id="SelectedMunicipality" readonly>
                <input type="hidden" v-model="selectedBarangay" id="SelectedBarangay" readonly>
                <div class="mb-5">
                    <label for="Barangay" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Barangay</label>
                    <select id="Barangay" v-model="barangay" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" required>
                        <option disabled>Select Barangay</option>
                        <option v-for="barangay in barangays" :value="barangay.brgy_code" :key="barangay.brgy_code">{{ barangay.brgy_name }}</option>
                    </select>
                </div>
                <div class="flex justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="AddHospital" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Logo</button>
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
import SelectPhilippinesAddress from 'select-philippines-address';
import {
    cities,
    barangays
} from 'select-philippines-address';
import {
    useToast
} from 'vue-toastification'
const toastr = useToast()
export default {
    data() {
        return {
            items: [],
            logoImages: [],
            previewedImage: {},
            provinces: [],
            cities: [],
            barangays: [],
            provinceto: '1752',
            municipality: null,
            barangay: null,
            province: "Oriental Mindoro",
            hospital_name: '',
            hospital_acronym: '',
            hospital_address: '',
            hospital_district: '',
        };
    },
    components: {
        Side,
        Button,
        Upload,
        SelectPhilippinesAddress,
    },
    mounted() {
        initTWE({
            Modal,
            Tooltip
        });
        initFlowbite(); 
        this.fetchData();
        this.fetchCities();
    },
    methods: {
        insertHospital() {
            const formData = new FormData();
            formData.append('hospital_name', this.hospital_name);
            formData.append('hospital_acronym', this.hospital_acronym);
            const fullAddress = `${this.province}, ${this.selectedMunicipality}, ${this.selectedBarangay}`;
            formData.append('hospital_address', fullAddress);
            formData.append('hospital_district', this.hospital_district);
            axios.post('/api/utility/save-hospital', formData, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    this.hospital_name = '';
                    this.hospital_acronym = '';
                    this.hospital_address = '';
                    this.hospital_district = '';
                    this.province = '';
                    this.selectedMunicipality = '';
                    this.selectedBarangay = '';
                    toastr.success('Medical Request Successfully Sent');
                    this.fetchData();
                })
                .catch(error => {
                    console.error(error.response.data);
                    toastr.error(error.response.data);
                });
        },
        AddHospital() {
            const modal = document.getElementById('AddHospital');
            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');
            // Add event listener to close modal on close button click
            modal.addEventListener('click', function (e) {
                if (e.target && e.target.closest('[data-modal-hide="AddHospital"]')) {
                    modal.classList.add('hidden');
                    modal.setAttribute('aria-hidden', 'true');
                }
            });
        },
        deleteHospital(id) {
            axios.delete(`/api/utility/delete-hospital/${id}`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    toastr.success("Hospital Deleted");
                    this.fetchData();
                })
                .catch(error => {
                    toastr.error("Cant Delete Active Hospital")
                    console.error(error.response.data);
                });
        },
        ActivateHospital(id) {
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
        DeactivateHospital(id) {
            axios.put(`/api/utility/deactivate-hospital/${id}`, {}, {
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
            axios.get('/api/utility/get-hospitals', {
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
        fetchCities() {
            cities(this.provinceto)
                .then(response => {
                    if (response && response.length > 0) {
                        this.cities = response;
                        this.municipality = null;
                        this.handleBarangay();
                    } else {
                        console.error('Empty response received for cities.');
                    }
                })
                .catch(error => {
                    console.error('Error fetching cities:', error);
                });
        },
        handleBarangay() {
            if (!this.municipality) return;
            barangays(this.municipality)
                .then(response => {
                    this.barangays = response;
                    this.selectedMunicipality = this.cities.find(city => city.city_code === this.municipality) ?.city_name || ''; // magkadikit lagi yang ?. error pag ? . naghihiwalay pag nag vue-format
                    this.selectedBarangay = this.barangays.length > 0 ? this.barangays[0].brgy_name : '';
                })
                .catch(error => {
                    console.error('Error fetching barangays:', error);
                });
        },
    },
    computed: {},
    watch: {
        barangay(newBarangay) {
            const selectedBarangayObject = this.barangays.find(barangay => barangay.brgy_code === newBarangay);
            this.selectedBarangay = selectedBarangayObject ? selectedBarangayObject.brgy_name : '';
        }
    }
};
</script>
