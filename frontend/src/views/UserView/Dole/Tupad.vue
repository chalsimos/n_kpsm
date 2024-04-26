<script setup>

</script>
<template>
<Head />

<div class="p-4 mt-[5vh]">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
            Patient Information
        </h2>
        <form @submit.prevent="saveToDatabase" class="max-w-full mx-auto w-full ml-0">
            <div class="grid md:grid-cols-3 md:gap-3 whitespace-nowrap">
                <div class="mb-5">
                    <label for="FirstName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First Name</label>
                    <input v-model="firstname" type="text" id="FirstName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Juan" required />
                </div>
                <div class="mb-5">
                    <label for="MiddleName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Middle Name</label>
                    <input v-model="middlename" type="text" id="MiddleName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Martinez" required />
                </div>
                <div class="mb-5">
                    <label for="LastName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last Name</label>
                    <input v-model="lastname" type="text" id="LastName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Dela Cruz" required />
                </div>
            </div>
            <div class="grid md:grid-cols-3 md:gap-3 whitespace-nowrap">
                <div class="mb-5">
                    <label for="Age" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Age</label>
                    <input v-model="age" type="number" id="Age" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="21" required />
                </div>
                <div class="mb-5">
                    <label for="Birthday" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Birthday</label>

                    <div class="relative max-w-full">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                            </svg>
                        </div>
                        <input v-model="birthday" id="Birthday" type="text" class="bg-gray-50 border  border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Select date">
                    </div>

                </div>
                <div class="mb-5">
                    <label for="Gender" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                    <select v-model="gender " id="Gender" class="text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 w-full font-small rounded-lg text-sm py-2.5 text-center inline-flex items-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">
                        <option value="" disabled selected>Choose Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="mb-5">
                    <label for="FullName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Benificiary Fullname</label>
                    <input v-model="benificiaryfullname" type="text" id="FullName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Juan M. Dela Cruz" required />
                </div>
                <div class="mb-5">
                    <label for="ContactNumber" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contact Number</label>
                    <input v-model="contactnumber" type="number" id="ContactNumber" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="09123456789" required />
                </div>
            </div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                Address
            </h2>
            <div class="grid md:grid-cols-3 md:gap-3 whitespace-nowrap">
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
                <div class="mb-5">
                    <label for="Sitio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sitio</label>
                    <input v-model="sitio" type="text" id="Sitio" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Sitio" required />
                </div>
            </div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                ID Information
            </h2>
            <div class="grid md:grid-cols-3 md:gap-3 whitespace-nowrap">
                <div class="mb-5">
                    <label for="IDNO" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ID Number</label>
                    <input v-model="idNum" type="text" id="IDNO" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Heart Disease" required />
                </div>
                <div class="mb-5">
                    <label for="TypeOfRequest" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type of ID</label>
                    <select v-model="typeOfRequest" @change="handleTypeOfRequestChange" id="TypeOfRequest" class="text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-small rounded-lg text-sm w-full py-2.5 text-center inline-flex items-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">
                        <option value="" disabled selected>Choose Type of ID</option>
                        <option value="LABORATORY">Pag-Ibig</option>
                        <option value="HOSPITAL BILL">Postal</option>
                        <option value="CHEMOTHERAPY">Driver's License</option>
                        <option value="ENDOSCOPY">Philhealth</option>
                        <option value="CT-SCAN">Passport ID</option>
                        <option value="2D ECHO">Umid ID</option>
                        <option value="OTHERS">Others</option>
                    </select>
                </div>
                <div class="mb-4" v-if="typeOfRequest === 'OTHERS'">
                    <label for="OtherRequest" class="block text-sm font-medium text-gray-900 dark:text-white">Other Type of ID</label>
                    <input v-model="otherRequestValue" type="text" id="OtherRequest" :disabled="isOtherRequestDisabled" class="bg-orange-300 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="SSS" required />
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="text-white bg-orange-900 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm w-full py-2.5 text-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800 lg:w-40 lg:ml-auto">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>
<div class="inset-x-0 bottom-0 py-4">
    <Foot />
</div>
</template>

    <script>
    import { onMounted,ref } from "vue";
  import { Modal,Tooltip, initTWE } from "tw-elements";
  import { initFlowbite } from 'flowbite'
    import Head from "@/views/UserView/Home/Header.vue";
    import {
        useToast
    } from 'vue-toastification'
    import Foot from "@/views/UserView/Home/Footer.vue";
    import Flatpickr from 'flatpickr';
    import 'flatpickr/dist/flatpickr.min.css';
    import SelectPhilippinesAddress from 'select-philippines-address';
    const toastr = useToast()
    import {
        cities,
        barangays
    } from 'select-philippines-address';
    import axios from '../../../main.js'

    export default {
        components: {
            Head,
            Foot,
            SelectPhilippinesAddress
        },
        data() {
            return {
                provinces: [],
                cities: [],
                barangays: [],
                provinceto: '1752',
                municipality: null,
                barangay: null,
                typeOfRequest: '',
                otherRequestValue: '',
                firstname: '',
                middlename: '',
                lastname: '',
                age: null,
                birthday: '',
                gender: '',
                province: "Oriental Mindoro",
                benificiaryfullname: '',
                contactnumber: '',
                idNum: '',
                sitio: '',
                selectedMunicipality: '',
                selectedBarangay: '',
            };
        },
        mounted() {
            Flatpickr('#Birthday', {});
            document.title = "KPSM - GIP";
            this.fetchCities();
            initFlowbite();
            initTWE({ Modal,Tooltip });

        },
        methods: {
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
            handleTypeOfRequestChange() {
                if (this.typeOfRequest !== 'OTHERS') {
                    this.otherRequestValue = '';
                }
            },
            saveToDatabase() {
                const formattedBirthday = this.birthday.split('/').reverse().join('-');
                const formData = {
                    firstname: this.firstname,
                    middlename: this.middlename,
                    lastname: this.lastname,
                    age: this.age,
                    birthday: formattedBirthday,
                    gender: this.gender,
                    province: this.province,
                    municipality: this.selectedMunicipality,
                    barangay: this.selectedBarangay,
                    benificiaryfullname: this.benificiaryfullname,
                    contactnumber: this.contactnumber,
                    idNum: this.this.idNum,
                    sitio: this.sitio,
                    idType: this.typeOfRequest === 'OTHERS' ? this.otherRequestValue : this.typeOfRequest,
                };
                axios.post('/api/dole/add-tupad', formData)
                    .then(response => {
                        this.firstname = '';
                        this.middlename = '';
                        this.lastname = '';
                        this.age = null;
                        this.birthday = '';
                        this.gender = '';
                        this.province = '';
                        this.selectedMunicipality = '';
                        this.selectedBarangay = '';
                        this.benificiaryfullname = '';
                        this.contactnumber = '';
                        this.idNum = '';
                        this.sitio = '';
                        this.typeOfRequest = '';
                        toastr.success('Tupad Successfully Send');

                    })
                    .catch(error => {
                        console.error(error.response.data);
                        toastr.error(error.response.data)
                    });
            }
        },
        watch: {
            barangay(newBarangay) {
                const selectedBarangayObject = this.barangays.find(barangay => barangay.brgy_code === newBarangay);
                this.selectedBarangay = selectedBarangayObject ? selectedBarangayObject.brgy_name : '';
            }
        },

        computed: {
            isOtherRequestDisabled() {
                return this.typeOfRequest !== 'OTHERS';
            }
        }
    };
    </script>
