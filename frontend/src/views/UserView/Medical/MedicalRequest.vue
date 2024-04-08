<template>
<Head />

<div class="p-4  mt-[50px]">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">

        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Personal Information</h2>
        <form class="max-w-md mx-auto w-5/6 ml-0">
            <div class="grid md:grid-cols-3 md:gap-3 whitespace-nowrap">
                <div class="mb-5">
                    <label for="FirstName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First Name</label>
                    <input type="text" id="FirstName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Juan" required />
                </div>
                <div class="mb-5">
                    <label for="MiddleName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Middle Name</label>
                    <input type="text" id="MiddleName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Martinez" required />
                </div>
                <div class="mb-5">
                    <label for="LastName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last Name</label>
                    <input type="text" id="LastName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Dela Cruz" required />
                </div>
            </div>
            <div class="grid md:grid-cols-3 md:gap-3 whitespace-nowrap">
                <div class="mb-5">
                    <label for="Age" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Age</label>
                    <input type="text" id="Age" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="21" required />
                </div>
                <div class="mb-5">
                    <label for="Birthday" class=" block mb-2 text-sm font-medium text-gray-900 dark:text-white">Birthday</label>
                    <input type="text" id="Birthday" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="2000/01/01" required />
                </div>
                <div class="mb-5">
                    <label for="Gender" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gender</label>
                    <select id="Gender" class=" text-white bg-orange-600 hover:bg-orange-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-small rounded-lg text-sm pl-1 py-2.5 text-center inline-flex items-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">
                        <option disabled selected>Choose Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
            </div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Address</h2>
            <div class="grid md:grid-cols-3 md:gap-3 whitespace-nowrap">
                <div class="mb-5">
                    <label for="Province" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Province</label>
                    <input type="text" id="Province" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Oriental Mindoro" required />
                </div>
                <div class="mb-5">
                    <label for="Municipality" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Municipality</label>
                    <input type="text" id="Municipality" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Bongabong" required />
                </div>
                <div class="mb-5">
                    <label for="Barangey" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Barangey</label>
                    <input type="text" id="Barangey" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Ipil" required />
                </div>
            </div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Representative Information</h2>
            <div class="grid md:grid-cols-2 md:gap-2 whitespace-nowrap">
                <div class="mb-5">
                    <label for="FullName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Representative Fullname</label>
                    <input type="text" id="FullName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Juan M. Dela Cruz" required />
                </div>
                <div class="mb-5">
                    <label for="ContactNumber" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contact Number</label>
                    <input type="number" id="ContactNumber" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="09123456789" required />
                </div>
            </div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Request Information</h2>
            <div class="grid md:grid-cols-3 md:gap-3 whitespace-nowrap">
                <div class="mb-5">
                    <label for="Diagnosis" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Diagnosis</label>
                    <input type="text" id="Diagnosis" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Heart Disease" required />
                </div>
                <div class="mb-5">
                    <label for="Hospital" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hospital</label>
                    <select id="Gender" class=" text-white bg-orange-600 hover:bg-orange-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-small rounded-lg text-sm pl-1 py-2.5 text-center inline-flex items-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">
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
                    <select id="Gender" class=" text-white bg-orange-600 hover:bg-orange-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-small rounded-lg text-sm pl-1 py-2.5 text-center inline-flex items-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">
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
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
        </form>

    </div>
</div>
<Foot />
</template>

<script>
import Head from "@/views/UserView/Home/Header.vue";
import Foot from "@/views/UserView/Home/Footer.vue";

export default {
    components: {
        Head,
        Foot,
    },
    mounted() {
        document.title = "Medical Request";
    },
};
</script>
