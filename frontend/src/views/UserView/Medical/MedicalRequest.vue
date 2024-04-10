<template>
<Head />

<div class="p-4 mt-[50px]">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
            Personal Information
        </h2>
        <form class="max-w-full mx-auto w-full ml-0">
            <div class="grid md:grid-cols-3 md:gap-3 whitespace-nowrap">
                <div class="mb-5">
                    <label for="FirstName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First Name</label>
                    <input type="text" id="FirstName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Juan" required />
                </div>
                <div class="mb-5">
                    <label for="MiddleName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Middle Name</label>
                    <input type="text" id="MiddleName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Martinez" required />
                </div>
                <div class="mb-5">
                    <label for="LastName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last Name</label>
                    <input type="text" id="LastName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Dela Cruz" required />
                </div>
            </div>
            <div class="grid md:grid-cols-3 md:gap-3 whitespace-nowrap">
                <div class="mb-5">
                    <label for="Age" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Age</label>
                    <input type="number" id="Age" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="21" required />
                </div>
                <div class="mb-5">
                    <label for="Birthday" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Birthday</label>

                    <div class="relative max-w-full">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                            </svg>
                        </div>
                        <input id="datepicker" type="text" class="bg-gray-50 border  border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Select date">
                    </div>

                </div>
                <div class="mb-5">
                    <label for="Gender" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                    <select id="Gender" class="text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 w-full font-small rounded-lg text-sm py-2.5 text-center inline-flex items-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">
                        <option disabled selected>Choose Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
            </div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                Address
            </h2>
            <div class="grid md:grid-cols-3 md:gap-3 whitespace-nowrap">
                <div class="mb-5">
                    <label for="Province" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Province</label>
                    <select @change="handleCity" id="Province" v-model="province" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" required>
                        <option value="1752">Oriental Mindoro</option>
                    </select>
                </div>
                <div class="mb-5">
                    <label for="Municipality" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Municipality</label>
                    <select @change="handleBarangay" id="Municipality" v-model="city" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" required>
                        <option disabled selected value="">Select City</option>
                        <option v-for="city in cities" :value="city.city_code" :key="city.city_code">{{ city.city_name }}</option>
                    </select>
                </div>

                <div class="mb-5">
                    <label for="Barangay" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Barangay</label>
                    <select id="Barangay" v-model="barangay" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" required>
                        <option disabled>Select Barangay</option>
                        <option v-for="barangay in barangays" :value="barangay.brgy_code" :key="barangay.brgy_code">{{ barangay.brgy_name }}</option>
                    </select>
                </div>
            </div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                Representative Information
            </h2>
            <div class="grid md:grid-cols-2 md:gap-2 whitespace-nowrap">
                <div class="mb-5">
                    <label for="FullName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Representative Fullname</label>
                    <input type="text" id="FullName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Juan M. Dela Cruz" required />
                </div>
                <div class="mb-5">
                    <label for="ContactNumber" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contact Number</label>
                    <input type="number" id="ContactNumber" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="09123456789" required />
                </div>
            </div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                Request Information
            </h2>
            <div class="grid md:grid-cols-3 md:gap-3 whitespace-nowrap">
                <div class="mb-5">
                    <label for="Diagnosis" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Diagnosis</label>
                    <input type="text" id="Diagnosis" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Heart Disease" required />
                </div>
                <div class="mb-5">
                    <label for="Hospital" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hospital</label>
                    <select id="Gender" class="text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-small rounded-lg text-sm w-full py-2.5 text-center inline-flex items-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">
                        <option disabled selected>Choose Hospital</option>
                        <option value="Maes">Maes</option>
                        <option value="MMG">MMG</option>
                        <option value="OMPH">OMPH</option>
                        <option value="SMV">SMV</option>
                        <option value="Luna Goco">Luna Goco</option>
                    </select>
                </div>
                <div class="mb-5">
                    <label for="Type Of Request" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type Of Request</label>
                    <select id="Gender" class="text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-small rounded-lg text-sm w-full py-2.5 text-center inline-flex items-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">
                        <option disabled selected>Choose Request</option>
                        <option value="Laboratory">Laboratory</option>
                        <option value="Bone Marrow">Bone Marrow</option>
                        <option value="Medicine">Medicine</option>
                        <option value="Hostpital Bill">Hostpital Bill</option>
                        <option value="Chemotherapy">Chemotherapy</option>
                        <option value="Endoscopy">Endoscopy</option>
                        <option value="CT-Scan">CT-Scan</option>
                        <option value="2D Echo">2D Echo</option>
                        <option value="Scrotal Utz">Scrotal Utz</option>
                        <option value="MRI">MRI</option>
                        <option value="Blood Transfusion">Blood Transfusion</option>
                        <option value="Biopsy">Biopsy</option>
                        <option value="For EGD">For EGD</option>
                        <option value="Broncoscopy">Broncoscopy</option>
                        <option value="Laryngoscopy">Laryngoscopy</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="text-white bg-orange-900 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm w-full sm:w-auto px-15 py-2.5 text-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800 lg:w-auto lg:ml-auto">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>
<Foot />
</template>

<script>
import {
    ref
} from 'vue';
import Head from "@/views/UserView/Home/Header.vue";
import Foot from "@/views/UserView/Home/Footer.vue";
import Flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
import SelectPhilippinesAddress from 'select-philippines-address';
import {
    provinces,
    cities,
    barangays
} from 'select-philippines-address';

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
            province: '1752',
            city: null,
            barangay: null,
        };
    },
    setup() {

    },
    mounted() {
        Flatpickr('#datepicker', {});
        document.title = "Medical Request";
        this.fetchCities();
    },
    methods: {
        fetchCities() {
            cities(this.province)
                .then(response => {
                    if (response && response.length > 0) {
                        this.cities = response;
                        this.city = null;
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
            if (!this.city) return;
            barangays(this.city)
                .then(response => {
                    this.barangays = response;
                })
                .catch(error => {
                    console.error('Error fetching barangays:', error);
                });
        }
    }
};
</script>
