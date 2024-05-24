<template>
<div class="flex flex-col min-h-screen">

    <Head />
    <div class="flex-grow p-4 mt-[5vh]">
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
                </div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                    Representative Information
                </h2>
                <div class="grid md:grid-cols-2 md:gap-2 whitespace-nowrap">
                    <div class="mb-5">
                        <label for="FullName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Representative Fullname</label>
                        <input v-model="representativefullname" type="text" id="FullName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Juan M. Dela Cruz" required />
                    </div>
                    <div class="mb-5">
                        <label for="ContactNumber" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contact Number</label>
                        <input v-model="contactnumber" type="number" id="ContactNumber" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="09123456789" required />
                    </div>
                </div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                    Request Information
                </h2>
                <div class="grid md:grid-cols-3 md:gap-3 whitespace-nowrap">
                    <div class="mb-5">
                        <label for="Diagnosis" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Diagnosis</label>
                        <input v-model="diagnosis" type="text" id="Diagnosis" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Heart Disease" required />
                    </div>
                    <div class="mb-5">
                        <label for="Hospital" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hospital</label>
                        <select v-model="hospital" id="Hospital" class="text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-small rounded-lg text-sm w-full py-2.5 text-center inline-flex items-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">
                            <option value="" disabled selected>Choose Hospital</option>
                            <option v-for="hospital in hospitals" :key="hospital.id" :value="hospital.hospital_acronym">
                                {{ hospital.hospital_name }} ({{ hospital.hospital_acronym }})
                            </option>
                        </select>
                    </div>

                    <div class="mb-5">
                        <label for="TypeOfRequest" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type of Request</label>
                        <select v-model="typeOfRequest" @change="handleTypeOfRequestChange" id="TypeOfRequest" class="text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-small rounded-lg text-sm w-full py-2.5 text-center inline-flex items-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">
                            <option value="" disabled selected>Choose Request</option>
                            <option v-for="offer in selectedHospitalOffers" :key="offer" :value="offer">
                                {{ offer }}
                            </option>
                            <option value="OTHERS">Others</option>
                        </select>
                    </div>
                    <div class="mb-4" v-if="typeOfRequest === 'OTHERS'">
                        <label for="OtherRequest" class="block text-sm font-medium text-gray-900 dark:text-white">Other Type of Request</label>
                        <input v-model="otherRequestValue" type="text" id="OtherRequest" :disabled="isOtherRequestDisabled" class="bg-orange-300 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Flu" required />
                    </div>

                </div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                    Requirements Upload (Image Only)
                </h2>
                <div class="grid md:grid-cols-4 md:gap-4 whitespace-nowrap">
                    <div class="mb-5">
                        <label for="brgyClearance" class="block text-sm font-medium text-gray-900 dark:text-white">Upload Brgy. Clearance</label>
                        <input type="file" required id="brgyClearance" ref="fileInput" accept="image/*" multiple @change="handleClearanceUpload">
                    </div>
                    <div class="mb-5">
                        <label for="validID" class="block text-sm font-medium text-gray-900 dark:text-white">Upload Valid ID</label>
                        <input type="file" required id="validID" ref="fileInput" accept="image/*" multiple @change="handleIDUpload">
                    </div>
                    <div class="mb-5">
                        <label for="hospitalDocuments" class="block text-sm font-medium text-gray-900 dark:text-white">Upload Hospital Document</label>
                        <input type="file" required id="hospitalDocuments" ref="fileInput" accept="image/*" multiple @change="handleHospitalUpload">
                    </div>
                    <div class="mb-5">
                        <label for="manageImage" class="block text-sm font-medium text-gray-900 dark:text-white">Manage Upload Image</label>
                        <button id="manageImage" data-modal-target="preview-image" data-modal-toggle="preview-image" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                            Image Preview
                        </button>
                    </div>
                </div>
                <div class="mb-5">
                    <span class="text-red-500">Requirements needed to be brought and submitted to the office.</span>
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
<div id="preview-image" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0">
    <div class="relative p-4 sm:px-6 sm:py-8 lg:px-8 lg:py-10 w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="preview-image">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="p-4 md:p-5 space-y-4">
                <div class="max-h-[60vh] overflow-y-auto">
                    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div v-for="(image, index) in allImages" :key="index" class="flex flex-col items-center">
                            <img :src="image.url" @click="previewImage(image)" class="w-full h-full object-cover" style="max-width: 100px; max-height: 100px; cursor: pointer;">
                            <button @click="removeImage(index)" class="mt-1 relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-pink-500 to-orange-400 group-hover:from-pink-500 group-hover:to-orange-400 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800">
                                <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                    Remove
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="preview-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 bottom-0 left-0 z-50 flex justify-center items-center">
    <div class="relative p-4 sm:px-6 sm:py-8 lg:px-8 lg:py-10 w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <button data-modal-hide="preview-modal" @click="closePreviewModal" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="p-4 md:p-5 space-y-4">
                <img :src="previewedImage.url" class="w-full h-auto" style="max-width: 100%; max-height: 80vh;">
            </div>
        </div>
    </div>
</div>
</template>

<script>
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
} from '@/utils/indexedDB';

export default {
    components: {
        Head,
        Foot,
        SelectPhilippinesAddress,
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
            representativefullname: '',
            contactnumber: '',
            diagnosis: '',
            hospital: '',
            selectedMunicipality: '',
            selectedBarangay: '',
            showCamera: false,
            brgy_ClearanceImages: [],
            valid_IdImages: [],
            hospital_DocumentImages: [],
            previewedImage: {},
            hospitals: [],
            selectedHospitalOffers: []
        };
    },
    mounted() {
        initFlowbite();
        Flatpickr('#Birthday', {});
        this.fetchCities();
        setInterval(this.sendStoredData, 5000);
        this.fetchHospitals();
    },
    methods: {
        fetchHospitals() {
            axios.get('/api/medical-requests/get-hospital-and-offer', {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    this.hospitals = response.data;
                })
                .catch(error => {
                    console.error('Error fetching hospitals:', error);
                });
        },
        updateSelectedHospitalOffers(hospitalAcronym) {
            const selectedHospital = this.hospitals.find(h => h.hospital_acronym === hospitalAcronym);
            this.selectedHospitalOffers = selectedHospital ? selectedHospital.service_offers : [];
            this.typeOfRequest = '';
        },
        handleTypeOfRequestChange() {
            if (this.typeOfRequest !== 'OTHERS') {
                this.otherRequestValue = '';
            }
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

        handleClearanceUpload(event) {
            const files = event.target.files;
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (!file.type.startsWith('image/')) {
                    toastr.error('Only image files are accepted.');
                    continue;
                }
                const reader = new FileReader();
                reader.onload = (e) => {
                    const imageUrl = e.target.result;
                    const originalFileName = file.name;
                    const fileExtension = originalFileName.split('.').pop();
                    const imageName = 'brgy_Clearance.' + fileExtension;
                    const blob = file.slice(0, file.size, file.type);
                    const newFile = new File([blob], imageName, {
                        type: file.type
                    });

                    this.brgy_ClearanceImages.push({
                        url: imageUrl,
                        brgy_Clearanceimage: newFile,
                        name: imageName
                    });
                };
                reader.readAsDataURL(file);
            }
        },
        handleIDUpload(event) {
            const files = event.target.files;
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (!file.type.startsWith('image/')) {
                    toastr.error('Only image files are accepted.');
                    continue;
                }
                const reader = new FileReader();
                reader.onload = (e) => {
                    const imageUrl = e.target.result;
                    const originalFileName = file.name;
                    const fileExtension = originalFileName.split('.').pop();
                    const imageName = 'valid_id.' + fileExtension;
                    const blob = file.slice(0, file.size, file.type);
                    const newFile = new File([blob], imageName, {
                        type: file.type
                    });

                    this.valid_IdImages.push({
                        url: imageUrl,
                        valid_IdImagesimage: newFile,
                        name: imageName
                    });
                };
                reader.readAsDataURL(file);
            }
        },
        handleHospitalUpload(event) {
            const files = event.target.files;
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                if (!file.type.startsWith('image/')) {
                    toastr.error('Only image files are accepted.');
                    continue;
                }
                const reader = new FileReader();
                reader.onload = (e) => {
                    const imageUrl = e.target.result;
                    const originalFileName = file.name;
                    const fileExtension = originalFileName.split('.').pop();
                    const imageName = 'hospital_documents.' + fileExtension;
                    const blob = file.slice(0, file.size, file.type);
                    const newFile = new File([blob], imageName, {
                        type: file.type
                    });

                    this.hospital_DocumentImages.push({
                        url: imageUrl,
                        hospital_DocumentImagesimage: newFile,
                        name: imageName
                    });
                };
                reader.readAsDataURL(file);
            }
        },
        removeImage(index) {
            this.hospital_DocumentImages.splice(index, 1);
            this.valid_IdImages.splice(index, 1);
            this.brgy_ClearanceImages.splice(index, 1);
        },
        previewImage(image) {
            if (image && image.url) {
                this.previewedImage = image;
                document.getElementById('preview-image').classList.add('hidden');
                document.getElementById('preview-modal').classList.remove('hidden');
            } else {
                console.error('Invalid image object:', image);
            }
        },
        closePreviewModal() {
            this.previewedImage = '';
            document.getElementById('preview-modal').classList.add('hidden');
            document.getElementById('preview-image').classList.remove('hidden');
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
        fileToBase64(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = () => resolve(reader.result);
                reader.onerror = error => reject(error);
            });
        },
        base64ToFile(base64, filename) {
            let arr = base64.split(','),
                mime = arr[0].match(/:(.*?);/)[1],
                bstr = atob(arr[1]),
                n = bstr.length,
                u8arr = new Uint8Array(n);
            while (n--) {
                u8arr[n] = bstr.charCodeAt(n);
            }
            return new File([u8arr], filename, {
                type: mime
            });
        },
        async saveToDatabase() {
            const brgy_ClearanceImagesBase64 = await Promise.all(this.brgy_ClearanceImages.map(image => this.fileToBase64(image.brgy_Clearanceimage)));
            const valid_IdImagesBase64 = await Promise.all(this.valid_IdImages.map(image => this.fileToBase64(image.valid_IdImagesimage)));
            const hospital_DocumentImagesBase64 = await Promise.all(this.hospital_DocumentImages.map(image => this.fileToBase64(image.hospital_DocumentImagesimage)));
            const formattedBirthday = this.birthday.split('/').reverse().join('-');
            const request = this.typeOfRequest === 'OTHERS' ? this.otherRequestValue : this.typeOfRequest || '';

            const data = {
                firstname: this.firstname,
                middlename: this.middlename,
                lastname: this.lastname,
                age: this.age,
                birthday: formattedBirthday,
                gender: this.gender,
                province: this.province,
                municipality: this.selectedMunicipality,
                barangay: this.selectedBarangay,
                representativefullname: this.representativefullname,
                contactnumber: this.contactnumber,
                diagnosis: this.diagnosis,
                hospital: this.hospital,
                request: request,
                brgy_ClearanceImages: brgy_ClearanceImagesBase64,
                valid_IdImages: valid_IdImagesBase64,
                hospital_DocumentImages: hospital_DocumentImagesBase64
            };
            const isConnected = await this.checkInternetConnection();
            if (!isConnected) {
                await saveRequest(data);
                toastr.warning("No internet connection. Data saved locally and will be sent once connected.");
            } else {
                const formData = new FormData();
                Object.keys(data).forEach(key => {
                    if (Array.isArray(data[key])) {
                        data[key].forEach((item, index) => {
                            formData.append(`${key}[]`, this.base64ToFile(item, `${key}_${index}.png`));
                        });
                    } else {
                        formData.append(key, data[key]);
                    }
                });
                axios.post('/api/medical-requests/request', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(response => {
                        this.clearForm();
                        toastr.success('Medical Request Successfully Sent');
                    })
                    .catch(error => {
                        console.error('Error in saving request:', error);
                        toastr.error('An error occurred while processing your request.');
                    });
            }
        },
        sendStoredData() {
            this.checkInternetConnection().then(async (isConnected) => {
                if (isConnected) {
                    const unsentData = await getRequests();
                    if (unsentData.length > 0) {
                        unsentData.forEach(data => {
                            const formData = new FormData();
                            Object.keys(data).forEach(key => {
                                if (Array.isArray(data[key])) {
                                    data[key].forEach((item, index) => {
                                        formData.append(`${key}[]`, this.base64ToFile(item, `${key}_${index}.png`));
                                    });
                                } else {
                                    formData.append(key, data[key]);
                                }
                            });
                            axios.post('/api/medical-requests/request', formData, {
                                    headers: {
                                        'Content-Type': 'multipart/form-data'
                                    }
                                })
                                .then(response => {
                                    this.clearForm();
                                    toastr.success("Uploaded Medical Request Successfully");
                                })
                                .catch(error => {
                                    toastr.error('Error uploading Medical Request:', error);
                                });
                        });
                        await clearRequests();
                    }
                }
            });
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
        },
        clearForm() {
            this.firstname = '';
            this.middlename = '';
            this.lastname = '';
            this.age = null;
            this.birthday = '';
            this.gender = '';
            this.province = '';
            this.selectedMunicipality = '';
            this.selectedBarangay = '';
            this.representativefullname = '';
            this.contactnumber = '';
            this.diagnosis = '';
            this.hospital = '';
            this.typeOfRequest = '';
            this.brgy_ClearanceImages = [];
            this.valid_IdImages = [];
            this.hospital_DocumentImages = [];
        },
    },

    watch: {
        barangay(newBarangay) {
            const selectedBarangayObject = this.barangays.find(barangay => barangay.brgy_code === newBarangay);
            this.selectedBarangay = selectedBarangayObject ? selectedBarangayObject.brgy_name : '';
        },
        hospital(newVal) {
            this.updateSelectedHospitalOffers(newVal);
            this.typeOfRequest = '';
        },
    },

    computed: {
        isOtherRequestDisabled() {
            return this.typeOfRequest !== 'OTHERS';
        },
        allImages() {
            return [
                ...this.brgy_ClearanceImages,
                ...this.valid_IdImages,
                ...this.hospital_DocumentImages
            ];
        }
    }
};
</script>
