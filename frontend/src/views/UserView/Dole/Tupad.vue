<template>
<div class="flex flex-col min-h-screen">

    <Head />
    <div class="flex-grow p-4 mt-[5vh]" :class="{ 'blur': showModal }">
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
                        <label for="Birthday" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Birthday</label>
                        <div class="relative max-w-full">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input v-model="birthday" @input="calculateAge" id="Birthday" type="text" class="bg-gray-50 border  border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Select date">
                        </div>
                    </div>
                    <div class="mb-5">
                        <label for="Age" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Age</label>
                        <input v-model="age" readonly type="number" id="Age" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" required />
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
                        <label for="Civil Status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Civil Status</label>
                        <select v-model="civil_status " id="Civil Status" class="text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 w-full font-small rounded-lg text-sm py-2.5 text-center inline-flex items-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">
                            <option value="" disabled selected>Civil Status</option>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Separated or Divorced">Separated or Divorced</option>
                            <option value="Widowed">Widowed</option>
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
                        <input v-model="otherRequestValue" type="text" id="OtherRequest" :disabled="isOtherRequestDisabled" class="bg-orange-300 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full mt-2 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="SSS" required />
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
                    Tupad Code
                </h3>
            </div>
            <form @submit.prevent="submitForm" class="max-w-sm mx-auto mt-5 mb-5">
                <label for="Code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Input Code</label>
                <input required v-model="accessCode" type="text" id="Code" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Code Here">
                <div class="flex items-center mt-4">
                    <input id="status-checker" type="checkbox" v-model="statusChecked" @change="handleStatusChange" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="status-checker" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Check Your Request Status</label>
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
    saveTupadRequest,
    getTupadRequests,
    clearTupadRequests
} from '@/utils/tupadDB.js';
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
            civil_status: '',
            selectedMunicipality: '',
            selectedBarangay: '',
            inputed_code: '',
            showModal: true,
            accessCode: '',
            accessGranted: false,
            statusChecked: false
        };
    },
    mounted() {
        Flatpickr('#Birthday', {});
        this.fetchCities();
        initFlowbite();
        const accessGranted = localStorage.getItem('accessGranted');
        if (accessGranted === 'true') {
            this.accessGranted = true;
            this.showModal = false;
            this.hideModal();
            document.querySelector('.flex-grow').classList.remove('blur');
        }
        setTimeout(() => {
            localStorage.removeItem('accessGranted');
            localStorage.removeItem('tupad_codeId');
            localStorage.removeItem('captain_id');
        }, 600000);
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
            axios.post('/api/dole/tupad-request-status-checker', {
                    code: this.accessCode
                })
                .then(response => {
                    if (response.status === 200) {
                        this.accessCode = '';
                        this.statusChecked = false
                        toastr.success(response.data);
                    }
                })
                .catch(error => {
                    if (error.response) {
                        if (error.response.status === 404) {
                            this.accessCode = '';
                            this.statusChecked = false
                            toastr.error('Invalid Tupad code');
                        }
                    } else {
                        this.accessCode = '';
                        this.statusChecked = false
                        console.error('Error setting up the request:', error.message);
                        toastr.error('An error occurred. Please try again later.');
                    }
                });
        },
        submitCode() {
            axios.post('/api/dole/code-checker', {
                    code: this.accessCode
                })
                .then(response => {
                    if (response.status === 200) {
                        this.accessCode = '';
                        this.accessGranted = true;
                        this.showModal = false;
                        document.querySelector('.flex-grow').classList.remove('blur');
                        toastr.success("Code Accepted")
                        localStorage.setItem('tupad_codeId', response.data.encrypted_id.tupad_codeId);
                        localStorage.setItem('captain_id', response.data.encrypted_id.captain_id);
                        localStorage.setItem('accessGranted', 'true');
                        this.hideModal();
                    }
                })
                .catch(error => {
                    if (error.response) {
                        if (error.response.status === 404) {
                            this.accessCode = '';
                            toastr.error('Code not found');
                        } else if (error.response.status === 400) {
                            this.accessCode = '';
                            toastr.error('Code is inactive');
                        } else {
                            this.accessCode = '';
                            toastr.error('An error occurred. Please try again later.');
                        }
                    } else if (error.request) {
                        this.accessCode = '';
                        console.error('No response received:', error.request);
                        toastr.error('An error occurred. Please try again later.');
                    } else {
                        this.accessCode = '';
                        console.error('Error setting up the request:', error.message);
                        toastr.error('An error occurred. Please try again later.');
                    }
                });
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
        handleTypeOfRequestChange() {
            if (this.typeOfRequest !== 'OTHERS') {
                this.otherRequestValue = '';
            }
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
                civilstatus: this.civil_status,
                idNum: this.idNum,
                sitio: this.sitio,
                idType: this.typeOfRequest === 'OTHERS' ? this.otherRequestValue : this.typeOfRequest,
                used_code_id: localStorage.getItem('tupad_codeId'),
                given_by_captainID: localStorage.getItem('captain_id')
            };
            const isConnected = await this.checkInternetConnection();
            if (!isConnected) {
                await saveTupadRequest(formData);
                toastr.warning("No internet connection. Data saved locally and will be sent once connected.");
            } else {
                axios.post('/api/dole/add-tupad', formData)
                    .then(response => {
                        this.clearForm();
                        toastr.success('Tupad Successfully Send');
                        localStorage.removeItem('accessGranted');
                        localStorage.removeItem('tupad_codeId');
                        localStorage.removeItem('captain_id');
                    })
                    .catch(error => {
                        console.error(error.response.data);
                        toastr.error(error.response.data)
                    });
            }
        },
        async sendStoredData() {
            const isConnected = await this.checkInternetConnection();
            if (isConnected) {
                const unsentData = await getTupadRequests();
                if (unsentData.length > 0) {
                    for (const data of unsentData) {
                        try {
                            await axios.post('/api/dole/add-tupad', data);
                            this.clearForm();
                            toastr.success("Upload Tupad Request Successfully");
                            localStorage.removeItem('accessGranted');
                            localStorage.removeItem('tupad_codeId');
                            localStorage.removeItem('captain_id');
                        } catch (error) {
                            toastr.error('Error uploading Tupad Request:', error);
                        }
                    }
                    await clearTupadRequests();
                }
            }
        },
        clearForm() {
            this.firstname = '';
            this.middlename = '';
            this.lastname = '';
            this.age = null;
            this.birthday = '';
            this.gender = '';
            this.province = '';
            this.civil_status = '';
            this.selectedMunicipality = '';
            this.selectedBarangay = '';
            this.benificiaryfullname = '';
            this.contactnumber = '';
            this.idNum = '';
            this.sitio = '';
            this.typeOfRequest = '';
        },
        calculateAge() {
            if (!this.birthday) return;
            const today = new Date();
            const birthDate = new Date(this.birthday);
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            this.age = age;
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
