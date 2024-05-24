<template>
    <div class="flex flex-col min-h-screen">
    
        <Head />
        <div class="flex-grow p-4 mt-[5vh]" :class="{ 'blur': showModal }">
            <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
                <form @submit.prevent="saveToDatabase" class="max-w-full mx-auto w-full ml-0">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        Representative Information
                    </h2>
                    <div class="grid md:grid-cols-3 md:gap-3 whitespace-nowrap">
                        <div class="mb-5">
                            <label for="representative_FirstName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Representative Firstname</label>
                            <input v-model="representative_firstname" type="text" id="representative_FirstName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Juan" required />
                        </div>
                        <div class="mb-5">
                            <label for="representative_MiddleName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Representative Middlename</label>
                            <input v-model="representative_middlename" type="text" id="representative_MiddleName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Martinez" required />
                        </div>
                        <div class="mb-5">
                            <label for="representative_LastName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Representative Lastname</label>
                            <input v-model="representative_lastname" type="text" id="representative_LastName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Dela Cruz" required />
                        </div>
                        <div class="mb-5">
                            <label for="representative_birthday" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Representative Birthday</label>
                            <div class="relative max-w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                    </svg>
                                </div>
                                <input v-model="representative_birthday" @input="calculateRepresentativeAge" id="representative_birthday" type="text" class="bg-gray-50 border  border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Select date">
                            </div>
                        </div>
                        <div class="mb-5">
                            <label for="representative_Age" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Representative Age</label>
                            <input v-model="representative_age" readonly type="number" id="representative_Age" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" required />
                        </div>
                        <div class="mb-5">
                            <label for="representative_Gender" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Representative Gender</label>
                            <select v-model="representative_gender " id="representative_Gender" class="text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 w-full font-small rounded-lg text-sm py-2.5 text-center inline-flex items-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">
                                <option value="" disabled selected>Choose Representative Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="mb-5">
                            <label for="relationship_to_Benificiary" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Relationship to Beneficiary</label>
                            <input v-model="relationship_to_beneficiary" type="text" id="relationship_to_Benificiary" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Juan M. Dela Cruz" required />
                        </div>
                        <div class="mb-5">
                            <label for="ContactNumber" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contact Number</label>
                            <input v-model="contact_number" type="number" id="ContactNumber" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="09123456789" required />
                        </div>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        Student Information
                    </h2>
                    <div class="grid md:grid-cols-3 md:gap-3 whitespace-nowrap">
                        <div class="mb-5">
                            <label for="beneficiary_FirstName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Beneficiary Firstname</label>
                            <input v-model="beneficiary_firstname" type="text" id="beneficiary_FirstName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Juan" required />
                        </div>
                        <div class="mb-5">
                            <label for="beneficiary_MiddleName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Beneficiary Middlename</label>
                            <input v-model="beneficiary_middlename" type="text" id="beneficiary_MiddleName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Martinez" required />
                        </div>
                        <div class="mb-5">
                            <label for="beneficiary_LastName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Beneficiary Lastname</label>
                            <input v-model="beneficiary_lastname" type="text" id="beneficiary_LastName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Dela Cruz" required />
                        </div>
                    </div>
                    <div class="grid md:grid-cols-4 md:gap-4 whitespace-nowrap">
                        <div class="mb-5">
                            <label for="beneficiary_birthday" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Beneficiary Birthday</label>
                            <div class="relative max-w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                    </svg>
                                </div>
                                <input v-model="beneficiary_birthday" @input="calculateBeneficiaryAge" id="beneficiary_birthday" type="text" class="bg-gray-50 border  border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Select date">
                            </div>
                        </div>
                        <div class="mb-5">
                            <label for="beneficiary_Age" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Beneficiary Age</label>
                            <input v-model="beneficiary_age" readonly type="number" id="beneficiary_Age" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" required />
                        </div>
                        <div class="mb-5">
                            <label for="beneficiary_Gender" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Beneficiary Gender</label>
                            <select v-model="beneficiary_gender " id="beneficiary_Gender" class="text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 w-full font-small rounded-lg text-sm py-2.5 text-center inline-flex items-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">
                                <option value="" disabled selected>Choose Beneficiary Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="mb-5">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Beneficiary Email</label>
                            <input type="email" id="email" v-model="email" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" placeholder="name@gmail.com" required />
                            <p id="helper-text-explanation" class="whitespace-normal mt-1 text-sm text-red-500 dark:text-red-400">Must be your valid email for the code that will send and for other updates.</p>
                        </div>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        Address
                    </h2>
                    <div class="grid md:grid-cols-4 md:gap-4 whitespace-nowrap">
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
                        School Information
                    </h2>
                    <div class="grid md:grid-cols-4 md:gap-4 whitespace-nowrap">
                        <div class="mb-5">
                            <label for="School" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">School Name</label>
                            <input v-model="school" type="text" id="School" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="MinSu" required />
                        </div>
                        <div class="mb-5">
                            <label for="school_level" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Year Level</label>
                            <select v-model="school_level " id="representative_Gender" class="text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 w-full font-small rounded-lg text-sm py-2.5 text-center inline-flex items-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">
                                <option value="" disabled selected>Choose School Level</option>
                                <option value="Elementary">Elementary</option>
                                <option value="High School">High School</option>
                                <option value="Senior High School">Senior High School</option>
                                <option value="College">College</option>
                                <option value="Vocational">Vocational</option>
                            </select>
                        </div>
                        <div class="mb-5">
                            <label for="year_level" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Year Level</label>
                            <input v-model="year_level" type="text" id="year_level" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="1st year" required />
                        </div>
                        <div class="mb-5">
                            <label for="academic_year" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Academic Year</label>
                            <input v-model="academic_year_stage" type="text" id="academic_year" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="2024-2025" required />
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
        <div>
            <Foot />
        </div>
    </div>
    <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 bottom-0 left-0 z-50 flex justify-center items-center">
        <div class="relative p-4 sm:px-6 sm:py-8 lg:px-8 lg:py-10 w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Smart Grant Educational Assitance
                    </h3>
                </div>
                <form @submit.prevent="submitForm" class="max-w-sm mx-auto mt-5 mb-5 ml-10">
                    <label for="Code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Input confirm to proceed</label>
                    <input required v-model="accessCode" type="text" id="Code" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="CONFIRM">
                    <div class="flex items-center mt-4">
                        <input id="status-checker" type="checkbox" v-model="statusChecked" @change="handleStatusChange" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="status-checker" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Check this box if you want to check your application status and put the code that sent to your email.</label>
                    </div>
                    <div class="flex justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </template>
    
    <script>
    import {
        onMounted,
        ref
    } from "vue";
    import {
        initFlowbite
    } from 'flowbite'
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
    import {
        saveRequest,
        getRequests,
        clearRequests
    } from '@/utils/smartGrantDB.js';
    
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
                school: '',
                school_level: '',
                year_level: '',
                academic_year_stage: '',
                representative_lastname: '',
                representative_firstname: '',
                representative_middlename: '',
                beneficiary_lastname: '',
                beneficiary_firstname: '',
                beneficiary_middlename: '',
                representative_age: null,
                representative_birthday: '',
                representative_gender: '',
                beneficiary_age: null,
                beneficiary_birthday: '',
                beneficiary_gender: '',
                relationship_to_beneficiary: '',
                province: "Oriental Mindoro",
                contact_number: '',
                sitio: '',
                email: '',
                selectedMunicipality: '',
                selectedBarangay: '',
                inputed_code: '',
                showModal: true,
                accessCode: '',
                scholarGranted: false,
                statusChecked: false
            };
        },
        mounted() {
            Flatpickr('#representative_birthday', {});
            Flatpickr('#beneficiary_birthday', {});
            this.fetchCities();
            initFlowbite();
            const scholarGranted = localStorage.getItem('scholarGranted');
            if (scholarGranted === 'true') {
                this.scholarGranted = true;
                this.showModal = false;
                this.hideModal();
                document.querySelector('.flex-grow').classList.remove('blur');
            }
            setTimeout(() => {
                localStorage.removeItem('scholarGranted');
            }, 1800000);
            setInterval(this.sendStoredData, 5000);
        },
        methods: {
            submitForm() {
                if (this.statusChecked) {
                    this.checkStatus();
                } else {
                    this.submitCode();
                }
            },
            checkStatus() {
                axios.post('/api/educational-assistance/check-application-status', {
                        code: this.accessCode
                    })
                    .then(response => {
                        if (response.status === 200) {
                            this.accessCode = '';
                            this.statusChecked = false;
                            toastr.success('Application Status: ' + response.data.status);
                        }
                    })
                    .catch(error => {
                        if (error.response) {
                            if (error.response.status === 404) {
                                this.accessCode = '';
                                this.statusChecked = false;
                                toastr.error('Application not found.');
                            }
                        } else {
                            this.accessCode = '';
                            this.statusChecked = false;
                            console.error('Error setting up the request:', error.message);
                            toastr.error('An error occurred. Please try again later.');
                        }
                    });
            },
            submitCode() {
                if (this.accessCode !== 'CONFIRM') {
                    this.accessCode = '';
                    toastr.error("Please type 'CONFIRM' in all uppercase letters to proceed.");
                    return;
                }
                this.accessCode = '';
                this.scholarGranted = true;
                this.showModal = false;
                document.querySelector('.flex-grow').classList.remove('blur');
                toastr.success("You can now fill up the form");
                localStorage.setItem('scholarGranted', 'true');
                this.hideModal();
            },
            hideModal() {
                document.getElementById('static-modal').classList.add('hidden');
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
                        const selectedCity = this.cities.find(city => city.city_code === this.municipality);
                        this.selectedMunicipality = selectedCity ? selectedCity.city_name : '';
                        this.selectedBarangay = this.barangays.length > 0 ? this.barangays[0].brgy_name : '';
                    })
                    .catch(error => {
                        console.error('Error fetching barangays:', error);
                    });
            },
            async checkInternetConnection() {
                if (!navigator.onLine) {
                    return false;
                }
                try {
                    await fetch("https://www.google.com", {
                        mode: 'no-cors'
                    });
                    return true;
                } catch (error) {
                    return false;
                }
            },
            async saveToDatabase() {
                const formattedRepresentativeBirthday = this.representative_birthday.split('/').reverse().join('-');
                const formattedBeneficiaryBirthday = this.beneficiary_birthday.split('/').reverse().join('-');
                const formData = {
                    representative_lastname: this.representative_lastname,
                    representative_firstname: this.representative_firstname,
                    representative_middlename: this.representative_middlename,
                    representative_age: this.representative_age,
                    representative_birthday: formattedRepresentativeBirthday,
                    representative_gender: this.representative_gender,
                    beneficiary_lastname: this.beneficiary_lastname,
                    beneficiary_firstname: this.beneficiary_firstname,
                    beneficiary_middlename: this.beneficiary_middlename,
                    beneficiary_age: this.beneficiary_age,
                    beneficiary_birthday: formattedBeneficiaryBirthday,
                    beneficiary_gender: this.beneficiary_gender,
                    province: this.province,
                    municipality: this.selectedMunicipality,
                    barangay: this.selectedBarangay,
                    relationship_to_beneficiary: this.relationship_to_beneficiary,
                    contact_number: this.contact_number,
                    school: this.school,
                    school_level: this.school_level,
                    year_level: this.year_level,
                    email: this.email,
                    academic_year_stage: this.academic_year_stage,
                    sitio: this.sitio,
                };
    
                const isConnected = await this.checkInternetConnection();
                if (!isConnected) {
                    await saveRequest(formData);
                    toastr.warning("No internet connection. Data saved locally and will be sent once connected.");
                } else {
                    axios.post('/api/educational-assistance/submit-educational-assistance-smart-grant', formData)
                        .then(response => {
                            this.clearForm();
                            toastr.success('Educational Assistance Request Successfully Sent');
                            localStorage.removeItem('scholarGranted');
                        })
                        .catch(error => {
                            console.error(error.response.data);
                            toastr.error(error.response.data);
                        });
                }
            },
            async sendStoredData() {
                const isConnected = await this.checkInternetConnection();
                if (isConnected) {
                    const unsentData = await getRequests();
                    if (unsentData.length > 0) {
                        for (const data of unsentData) {
                            try {
                                await axios.post('/api/educational-assistance/submit-educational-assistance-smart-grant', data);
                                toastr.success("Uploaded Educational Assistance Request Successfully");
                                localStorage.removeItem('scholarGranted');
                            } catch (error) {
                                toastr.error('Error uploading Educational Assistance Request:', error);
                            }
                        }
                        await clearRequests();
                    }
                }
            },
            calculateRepresentativeAge() {
                if (!this.representative_birthday) return;
                const today = new Date();
                const birthDate = new Date(this.representative_birthday);
                let representative_age = today.getFullYear() - birthDate.getFullYear();
                const monthDiff = today.getMonth() - birthDate.getMonth();
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    representative_age--;
                }
                this.representative_age = representative_age;
            },
            calculateBeneficiaryAge() {
                if (!this.beneficiary_birthday) return;
                const today = new Date();
                const birthDate = new Date(this.beneficiary_birthday);
                let beneficiary_age = today.getFullYear() - birthDate.getFullYear();
                const monthDiff = today.getMonth() - birthDate.getMonth();
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    beneficiary_age--;
                }
                this.beneficiary_age = beneficiary_age;
            },
            clearForm() {
                this.representative_lastname = '';
                this.representative_firstname = '';
                this.representative_middlename = '';
                this.representative_age = '';
                this.representative_birthday = '';
                this.representative_gender = '';
                this.beneficiary_lastname = '';
                this.beneficiary_firstname = '';
                this.beneficiary_middlename = '';
                this.beneficiary_age = '';
                this.beneficiary_birthday = '';
                this.beneficiary_gender = '';
                this.province = '';
                this.selectedMunicipality = '';
                this.selectedBarangay = '';
                this.relationship_to_beneficiary = '';
                this.contact_number = '';
                this.school = '';
                this.school_level = '';
                this.year_level = '';
                this.email = '';
                this.academic_year_stage = '';
                this.sitio = '';
            }
        },
        watch: {
            barangay(newBarangay) {
                const selectedBarangayObject = this.barangays.find(barangay => barangay.brgy_code === newBarangay);
                this.selectedBarangay = selectedBarangayObject ? selectedBarangayObject.brgy_name : '';
            }
        },
    
        computed: {}
    };
    </script>
    