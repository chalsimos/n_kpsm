<template>
<Side />
<div>
    <div class="p-4 sm:ml-64 flex-grow overflow-y-auto ">
        <div class="p-2 border-2 border-orange-200 border-solid rounded-lg dark:border-gray-700 mt-14 ">
            <div class="flex items-center justify-between mb-4">
                <a-button class="text-white bg-blue-500 hover:bg-blue-600" type="primary" @click="generateExcelFiles">Generate Approve Excel</a-button>
                <a-range-picker class="w-64" v-model="monthYearRange" format="MM/YYYY" picker="month" @change="handleMonthChange" />
            </div>
            <a-tabs default-active-key="1" @change="handleTabChange">
                <a-tab-pane key="1" tab="Pending List">
                    <v-card flat>
                        <v-card-title class="d-flex align-center pe-2 bg-orange-200">
                            <v-icon icon="mdi-hospital-box-outline"></v-icon> &nbsp; Pending Smart Grant Requests
                            <v-spacer></v-spacer>
                            <v-text-field v-model="search" density="compact" label="Search" prepend-inner-icon="mdi-magnify" variant="solo-filled" flat hide-details single-line></v-text-field>
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-data-table v-model:search="search" :items="items" :items-per-page="5">
                            <template #headers="{ headers }">
                                <tr class="text-center whitespace-nowrap">
                                    <th class="text-center check-column"> <input @change="checkAll" :checked="isCheckedAll" id="check-all" type="checkbox" value="" class="w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"></th>
                                    <th class="text-center">Beneficiary Fullname</th>
                                    <th class="text-center">Beneficiary Birthday</th>
                                    <th class="text-center">Beneficiary Age</th>
                                    <th class="text-center">Beneficiary Gender</th>
                                    <th class="text-center">Representative Fullname</th>
                                    <th class="text-center">Representative Birthday</th>
                                    <th class="text-center">Representative Age</th>
                                    <th class="text-center">Representative Gender</th>
                                    <th class="text-center">Relationship to Beneficiary</th>
                                    <th class="text-center">Contact Number</th>
                                    <th class="text-center">Province</th>
                                    <th class="text-center">Municipality</th>
                                    <th class="text-center">Barangay</th>
                                    <th class="text-center">Sitio</th>
                                    <th class="text-center">School</th>
                                    <th class="text-center">School Level</th>
                                    <th class="text-center">Year Level</th>
                                    <th class="text-center">Academic Year</th>
                                    <th class="text-center">Amount Budget</th>
                                    <th class="text-center">Check Requirements</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center action-column">Action</th>
                                </tr>
                            </template>
                            <template v-slot:item="{ item }">
                                <tr class="h-[10vh] text-center">
                                    <td class="whitespace-nowrap uppercase check-column">
                                        <input @change="toggleChecked(item.id)" :checked="checkedIds.includes(item.id)" id="single-check" type="checkbox" value="" class="single-check w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    </td>
                                    <td class="whitespace-nowrap uppercase">{{ item.beneficiary_lastname + ' ' + item.beneficiary_firstname + ' ' + item.beneficiary_middlename }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ formatDateToWords(item.beneficiary_birthday) }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.beneficiary_age }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.beneficiary_gender }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.representative_lastname + ' ' + item.representative_firstname + ' ' + item.representative_middlename}}</td>
                                    <td class="whitespace-nowrap uppercase">{{ formatDateToWords(item.representative_birthday) }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.representative_age }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.representative_gender }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.relationship_to_beneficiary }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.contact_number }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.province }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.municipality }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.barangay }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.sitio }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.school }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.school_level }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.year_level }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.academic_year_stage }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.amount ? '₱ ' + parseFloat(item.amount).toFixed(2) : '' }}</td>
                                    <td style="margin-left: .8vw;" class="whitespace-nowrap uppercase ">
                                        <button @click="RequirementsModal(item.id)" class="block text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm mt-1 px-2 py-2 text-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800" type="button">
                                            Requiements
                                        </button>
                                    </td>
                                    <td class="whitespace-nowrap uppercase">{{ item.status }}</td>
                                    <td class="whitespace-nowrap uppercase action-column">
                                        <button @click="acceptApplication(checkedIds.length > 0 ? checkedIds : item.id)" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                            Accept
                                        </button>
                                        <button @click="DeclineModal(checkedIds.length > 0 ? checkedIds : item.id)" class="block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm mt-1 px-6 py-2 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" type="button">
                                            Decline
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </v-data-table>
                    </v-card>
                </a-tab-pane>
                <a-tab-pane key="2" tab="Approve List">
                    <v-card flat>
                        <v-card-title class="d-flex align-center pe-2 bg-orange-200">
                            <v-icon icon="mdi-hospital-box-outline"></v-icon> &nbsp; Approve Smart Grant Requests
                            <v-spacer></v-spacer>
                            <v-text-field v-model="Approvesearch" density="compact" label="Search" prepend-inner-icon="mdi-magnify" variant="solo-filled" flat hide-details single-line></v-text-field>
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-data-table v-model:search="Approvesearch" :items="Approveitems" :items-per-page="5">
                            <template #headers="{ headers }">
                                <tr class="text-center whitespace-nowrap">
                                    <th class="text-center check-column"> <input @change="checkAllForApproved" :checked="isCheckedAllForApproved" id="check-all-for-approved" type="checkbox" value="" class="w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"></th>
                                    <th class="text-center">Beneficiary Fullname</th>
                                    <th class="text-center">Beneficiary Birthday</th>
                                    <th class="text-center">Beneficiary Age</th>
                                    <th class="text-center">Beneficiary Gender</th>
                                    <th class="text-center">Representative Fullname</th>
                                    <th class="text-center">Representative Birthday</th>
                                    <th class="text-center">Representative Age</th>
                                    <th class="text-center">Representative Gender</th>
                                    <th class="text-center">Relationship to Beneficiary</th>
                                    <th class="text-center">Contact Number</th>
                                    <th class="text-center">Province</th>
                                    <th class="text-center">Municipality</th>
                                    <th class="text-center">Barangay</th>
                                    <th class="text-center">Sitio</th>
                                    <th class="text-center">School</th>
                                    <th class="text-center">School Level</th>
                                    <th class="text-center">Year Level</th>
                                    <th class="text-center">Academic Year</th>
                                    <th class="text-center">Amount Budget</th>
                                    <th class="text-center">Check Requirements</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center action-column">Action</th>
                                </tr>
                            </template>
                            <template v-slot:item="{ item }">
                                <tr class="h-[10vh] text-center">
                                    <td class="whitespace-nowrap uppercase check-column">
                                        <input @change="toggleCheckedForApproved(item.id)" :checked="checkedIdsForApproved.includes(item.id)" id="single-check" type="checkbox" value="" class="single-check w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    </td>
                                    <td class="whitespace-nowrap uppercase">{{ item.beneficiary_lastname + ' ' + item.beneficiary_firstname + ' ' + item.beneficiary_middlename }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ formatDateToWords(item.beneficiary_birthday) }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.beneficiary_age }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.beneficiary_gender }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.representative_lastname + ' ' + item.representative_firstname + ' ' + item.representative_middlename}}</td>
                                    <td class="whitespace-nowrap uppercase">{{ formatDateToWords(item.representative_birthday) }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.representative_age }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.representative_gender }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.relationship_to_beneficiary }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.contact_number }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.province }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.municipality }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.barangay }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.sitio }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.school }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.school_level }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.year_level }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.academic_year_stage }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.amount ? '₱ ' + parseFloat(item.amount).toFixed(2) : '' }}</td>
                                    <td style="margin-left: .8vw;" class="whitespace-nowrap uppercase ">
                                        <button @click="RequirementsModal(item.id)" class="block text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm mt-1 px-2 py-2 text-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800" type="button">
                                            Requiements
                                        </button>
                                    </td>
                                    <td class="whitespace-nowrap uppercase">{{ item.status }}</td>
                                    <td class="whitespace-nowrap uppercase action-column">
                                        <button @click="emailModal(checkedIdsForApproved.length > 0 ? checkedIdsForApproved : item.id)" class="block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm mt-1 px-3 py-2 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" type="button">
                                            Send Email
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </v-data-table>
                    </v-card>
                </a-tab-pane>
                <a-tab-pane key="3" tab="Decline List">
                    <v-card flat>
                        <v-card-title class="d-flex align-center pe-2 bg-orange-200">
                            <v-icon icon="mdi-hospital-box-outline"></v-icon> &nbsp; Decline Smart Grant Requests
                            <v-spacer></v-spacer>
                            <v-text-field v-model="Declinesearch" density="compact" label="Search" prepend-inner-icon="mdi-magnify" variant="solo-filled" flat hide-details single-line></v-text-field>
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-data-table v-model:search="Declinesearch" :items="Declineitems" :items-per-page="5">
                            <template #headers="{ headers }">
                                <tr class="text-center whitespace-nowrap">
                                    <th class="text-center check-column"> <input @change="checkAllForDecline" :checked="isCheckedAllForDecline" id="check-all-for-Decline" type="checkbox" value="" class="w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"></th>
                                    <th class="text-center">Beneficiary Fullname</th>
                                    <th class="text-center">Beneficiary Birthday</th>
                                    <th class="text-center">Beneficiary Age</th>
                                    <th class="text-center">Beneficiary Gender</th>
                                    <th class="text-center">Representative Fullname</th>
                                    <th class="text-center">Representative Birthday</th>
                                    <th class="text-center">Representative Age</th>
                                    <th class="text-center">Representative Gender</th>
                                    <th class="text-center">Relationship to Beneficiary</th>
                                    <th class="text-center">Contact Number</th>
                                    <th class="text-center">Province</th>
                                    <th class="text-center">Municipality</th>
                                    <th class="text-center">Barangay</th>
                                    <th class="text-center">Sitio</th>
                                    <th class="text-center">School</th>
                                    <th class="text-center">School Level</th>
                                    <th class="text-center">Year Level</th>
                                    <th class="text-center">Academic Year</th>
                                    <th class="text-center">Amount Budget</th>
                                    <th class="text-center">Check Requirements</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center action-column">Action</th>
                                </tr>
                            </template>
                            <template v-slot:item="{ item }">
                                <tr class="h-[10vh] text-center">
                                    <td class="whitespace-nowrap uppercase check-column">
                                        <input @change="toggleCheckedForDecline(item.id)" :checked="checkedIdsForDecline.includes(item.id)" id="single-check" type="checkbox" value="" class="single-check w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    </td>
                                    <td class="whitespace-nowrap uppercase">{{ item.beneficiary_lastname + ' ' + item.beneficiary_firstname + ' ' + item.beneficiary_middlename }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ formatDateToWords(item.beneficiary_birthday) }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.beneficiary_age }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.beneficiary_gender }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.representative_lastname + ' ' + item.representative_firstname + ' ' + item.representative_middlename}}</td>
                                    <td class="whitespace-nowrap uppercase">{{ formatDateToWords(item.representative_birthday) }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.representative_age }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.representative_gender }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.relationship_to_beneficiary }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.contact_number }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.province }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.municipality }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.barangay }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.sitio }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.school }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.school_level }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.year_level }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.academic_year_stage }}</td>
                                    <td class="whitespace-nowrap uppercase">{{ item.amount ? '₱ ' + parseFloat(item.amount).toFixed(2) : '' }}</td>
                                    <td style="margin-left: .8vw;" class="whitespace-nowrap uppercase ">
                                        <button @click="RequirementsModal(item.id)" class="block text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm mt-1 px-2 py-2 text-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800" type="button">
                                            Requiements
                                        </button>
                                    </td>
                                    <td class="whitespace-nowrap uppercase">{{ item.status }}</td>
                                    <td class="whitespace-nowrap uppercase action-column">
                                        <button @click="declineEmailModal(checkedIdsForDecline.length > 0 ? checkedIdsForDecline : item.id)" class="block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm mt-1 px-3 py-2 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" type="button">
                                            Send Email
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </v-data-table>
                    </v-card>
                </a-tab-pane>
            </a-tabs>
        </div>
    </div>
</div>
<div id="declineModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-screen md:inset-0">
    <div class="relative p-4 sm:px-6 sm:py-8 lg:px-8 lg:py-10 w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Decline Educational Assitance Request
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="declineModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form @submit.prevent="DeclineRequest" class="max-w-sm mx-auto mt-5 mb-5">
                <label for="Reason" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Decline Reason</label>
                <input type="text" id="Reason" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Reason here.">
                <div class="flex justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="declineModal" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Approved</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="emailModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-screen md:inset-0">
    <div class="relative p-4 sm:px-6 sm:py-8 lg:px-8 lg:py-10 w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Send an Email Message
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="emailModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="my-6 mx-auto max-w-xl bg-white font-[sans-serif]">
                <h1 class="text-3xl text-[#333] font-extrabold text-center">Message</h1>
                <form class="mt-8 space-y-4" @submit.prevent="sendEmail">
                    <input type="email" :value="emailList" placeholder="Email" disabled class="w-full rounded-md py-3 px-4 bg-gray-100 text-sm outline-blue-500" readonly />
                    <input type="text" placeholder="Subject" id="subject" class="w-full rounded-md py-3 px-4 bg-gray-100 text-sm outline-blue-500" />
                    <textarea placeholder="Message" rows="6" id="message" class="w-full rounded-md px-4 bg-gray-100 text-sm pt-3 outline-blue-500"></textarea>
                    <div class="flex justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button data-modal-hide="emailModal" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="RequirementsModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-screen md:inset-0">
    <div class="relative p-4 sm:px-6 sm:py-8 lg:px-8 lg:py-10 w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ educationalRequest.beneficiary_firstname }} {{ educationalRequest.beneficiary_middlename }} {{ educationalRequest.beneficiary_lastname }} Requirements
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="RequirementsModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="p-4">
                <div v-if="educationalRequest.valid_id_imagepath && educationalRequest.valid_id_imagepath.length">
                    <h4 class="text-lg font-semibold mb-2">Valid ID Image</h4>
                    <carousel :arrows="true">
                        <div v-for="(imagePath, index) in educationalRequest.valid_id_imagepath" :key="'valid_id_' + index">
                            <img v-bind:style="contentStyle" :src="imagePath" :alt="'Valid ID Image ' + (index + 1)" class="w-full cursor-pointer mb-2" @click="previewImage(imagePath)">
                        </div>
                    </carousel>
                </div>
                <div v-if="educationalRequest.barangay_indigency_imagepath && educationalRequest.barangay_indigency_imagepath.length">
                    <h4 class="text-lg font-semibold mb-2">Hospital Documents Image</h4>
                    <carousel :arrows="true">
                        <div v-for="(imagePath, index) in educationalRequest.barangay_indigency_imagepath" :key="'hospital_document_' + index">
                            <img v-bind:style="contentStyle" :src="imagePath" :alt="'Barangay Indigency Image ' + (index + 1)" class="w-full cursor-pointer mb-2" @click="previewImage(imagePath)">
                        </div>
                    </carousel>
                </div>
                <div v-if="educationalRequest.certificate_of_enrollment_imagepath && educationalRequest.certificate_of_enrollment_imagepath.length">
                    <h4 class="text-lg font-semibold mb-2">Barangay Clearance Image</h4>
                    <carousel :arrows="true">
                        <div v-for="(imagePath, index) in educationalRequest.certificate_of_enrollment_imagepath" :key="'barangay_clearance_' + index">
                            <img v-bind:style="contentStyle" :src="imagePath" :alt="'Coe ' + (index + 1)" class="w-full cursor-pointer mb-2" @click="previewImage(imagePath)">
                        </div>
                    </carousel>
                </div>
                <div v-if="educationalRequest.certificate_of_registration_imagepath && educationalRequest.certificate_of_registration_imagepath.length">
                    <h4 class="text-lg font-semibold mb-2">Barangay Clearance Image</h4>
                    <carousel :arrows="true">
                        <div v-for="(imagePath, index) in educationalRequest.certificate_of_registration_imagepath" :key="'barangay_clearance_' + index">
                            <img v-bind:style="contentStyle" :src="imagePath" :alt="'Cor ' + (index + 1)" class="w-full cursor-pointer mb-2" @click="previewImage(imagePath)">
                        </div>
                    </carousel>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="preview-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 bottom-0 left-0 z-50 flex justify-center items-center">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
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
    Carousel,
    ConfigProvider,
    Popover,
    Tabs
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
import {
    useToast
} from 'vue-toastification'
const toastr = useToast()
import ExcelJS from 'exceljs';
export default {
    data() {
        return {
            monthYearRange: [],
            ApproveForGenerate: [],
            search: '',
            Approvesearch: '',
            Declinesearch: '',
            items: [],
            Approveitems: [],
            Declineitems: [],
            checkedIds: [],
            checkedIdsForApproved: [],
            checkedIdsForDecline: [],
            educationalRequest: [],
            emailList: '',
            contentStyle: {
                margin: 0,
                height: '160px',
                color: '#fff',
                lineHeight: '160px',
                textAlign: 'center',
                background: '#364d79',
            },
            previewedImage: {
                url: ''
            }
        };
    },
    components: {
        Side,
        Carousel,
        ConfigProvider,
        Popover,
        Tabs
    },
    mounted() {
        initTWE({
            Modal,
            Tooltip,

        });
        initFlowbite();
        this.fetchEducationalAssistance();
        this.fetchDeclineEducationalAssistance();
        this.fetchApprovedEducationalAssistance();
        this.fetchApproveForGenerate();
    },
    methods: {
        fetchApproveForGenerate(startDate, endDate) {
            return new Promise((resolve, reject) => {
                axios.get('/api/educational-assistance/get-all-approved_shcolarship-request-smart-grant', {
                        params: {
                            start_date: startDate,
                            end_date: endDate
                        },
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem('token')}`
                        }
                    })
                    .then(response => {
                        this.ApproveForGenerate = response.data;
                        resolve();
                    })
                    .catch(error => {
                        console.error('Error fetching approved educational assistance:', error);
                        reject(error);
                    });
            });
        },
        handleMonthChange(dates, dateStrings) {
            let startDate = null;
            let endDate = null;
            if (dates && dates.length === 2) {
                startDate = dates[0].startOf('month').format('YYYY-MM-DD');
                endDate = dates[1].endOf('month').format('YYYY-MM-DD');
            }
            this.fetchApproveForGenerate(startDate, endDate);
            this.fetchEducationalAssistance(startDate, endDate);
            this.fetchDeclineEducationalAssistance(startDate, endDate);
            this.fetchApprovedEducationalAssistance(startDate, endDate);
        },
        async generateExcelFiles() {
            if (!Array.isArray(this.ApproveForGenerate) || this.ApproveForGenerate.length === 0) {
                toastr.error('No data available to generate Excel file.');
                return;
            }
            const workbook = new ExcelJS.Workbook();
            const groupedData = {};
            this.ApproveForGenerate.forEach(item => {
                const municipality = item.municipality;
                if (!groupedData[municipality]) {
                    groupedData[municipality] = [];
                }
                groupedData[municipality].push(item);
            });
            let earliestDate = new Date();
            let latestDate = new Date(0);
            Object.keys(groupedData).forEach(municipality => {
                const data = groupedData[municipality];
                if (Array.isArray(data) && data.length > 0) {
                    const worksheet = workbook.addWorksheet(municipality);
                    worksheet.addRow(['', 'Representative Data', '', '', '', '', 'Beneficiary Data', '', '', '', '', '']).font = {
                        bold: true
                    };
                    worksheet.addRow(['No.', 'Last Name', 'Middle Name', 'First Name', 'Birthday', 'Age', 'Last Name', 'Middle Name', 'First Name', 'Birthday', 'Age', 'Relationship to Beneficiaries', 'Province', 'Municipality', 'Barangay', 'Sitio', 'College', 'Remarks', 'School', 'Contact Number']).font = {
                        bold: true
                    };
                    worksheet.mergeCells('B1:F1');
                    worksheet.mergeCells('G1:K1');
                    worksheet.getRow(2).height = 30;
                    for (let col = 1; col <= 11; col++) {
                        for (let row = 1; row <= 2; row++) {
                            worksheet.getCell(row, col).alignment = {
                                vertical: 'middle',
                                horizontal: 'center'
                            };
                        }
                    }
                    for (let col = 12; col <= 20; col++) {
                        for (let row = 1; row <= 2; row++) {
                            worksheet.getCell(row, col).alignment = {
                                vertical: 'top',
                                horizontal: 'center'
                            };
                        }
                    }
                    for (let col = 1; col <= 20; col++) {
                        const headerCell = worksheet.getCell(1, col);
                        headerCell.fill = {
                            type: 'pattern',
                            pattern: 'solid',
                            fgColor: {
                                argb: 'FFADD8E6'
                            }
                        };
                        headerCell.font = {
                            bold: true
                        };
                    }
                    for (let col = 7; col <= 11; col++) {
                        const headerCell = worksheet.getCell(1, col);
                        headerCell.fill = {
                            type: 'pattern',
                            pattern: 'solid',
                            fgColor: {
                                argb: 'FFFFFF00'
                            }
                        };
                        headerCell.font = {
                            bold: true
                        };
                    }
                    for (let col = 1; col <= 6; col++) {
                        worksheet.getCell(2, col).fill = {
                            type: 'pattern',
                            pattern: 'solid',
                            fgColor: {
                                argb: 'FFADD8E6'
                            }
                        };
                    }
                    for (let col = 7; col <= 11; col++) {
                        worksheet.getCell(2, col).fill = {
                            type: 'pattern',
                            pattern: 'solid',
                            fgColor: {
                                argb: 'FFFFFF00'
                            }
                        };
                    }
                    for (let col = 12; col <= 20; col++) {
                        const headerCell1 = worksheet.getCell(1, col);
                        const headerCell2 = worksheet.getCell(2, col);
                        switch (col) {
                            case 12:
                            case 13:
                            case 14:
                            case 15:
                            case 16:
                                headerCell1.fill = headerCell2.fill = {
                                    type: 'pattern',
                                    pattern: 'solid',
                                    fgColor: {
                                        argb: 'FF808080'
                                    }
                                };
                                break;
                            case 17:
                                headerCell1.fill = headerCell2.fill = {
                                    type: 'pattern',
                                    pattern: 'solid',
                                    fgColor: {
                                        argb: 'FFFFA500'
                                    }
                                };
                                break;
                            case 18:
                                headerCell1.fill = headerCell2.fill = {
                                    type: 'pattern',
                                    pattern: 'solid',
                                    fgColor: {
                                        argb: 'FFFFFF00'
                                    }
                                };
                                break;
                            case 19:
                                headerCell1.fill = headerCell2.fill = {
                                    type: 'pattern',
                                    pattern: 'solid',
                                    fgColor: {
                                        argb: 'FF8A2BE2'
                                    }
                                };
                                break;
                            case 20:
                                headerCell1.fill = headerCell2.fill = {
                                    type: 'pattern',
                                    pattern: 'solid',
                                    fgColor: {
                                        argb: 'FFFFC0CB'
                                    }
                                };
                                break;
                            default:
                                break;
                        }
                        headerCell1.font = headerCell2.font = {
                            bold: true
                        };
                    }
                    for (let col = 1; col <= 20; col++) {
                        worksheet.getCell(2, col).border = {
                            top: {
                                style: 'thin'
                            },
                            left: {
                                style: 'thin'
                            },
                            bottom: {
                                style: 'thin'
                            },
                            right: {
                                style: 'thin'
                            }
                        };
                    }
                    for (let col = 12; col <= 20; col++) {
                        worksheet.getCell(1, col).border = {
                            bottom: null
                        };
                    }
                    for (let col = 12; col <= 20; col++) {
                        worksheet.getCell(2, col).border = {
                            top: null
                        };
                    }
                    data.forEach((item, index) => {
                        const row = worksheet.addRow([
                            item.id,
                            item.representative_lastname,
                            item.representative_middlename,
                            item.representative_firstname,
                            item.representative_birthday,
                            item.representative_age,
                            item.beneficiary_lastname,
                            item.beneficiary_middlename,
                            item.beneficiary_firstname,
                            item.beneficiary_birthday,
                            item.beneficiary_age,
                            item.relationship_to_beneficiary,
                            item.province,
                            item.municipality,
                            item.barangay,
                            item.sitio,
                            item.school_level,
                            item.remarks,
                            item.school,
                            item.contact_number
                        ]);
                        row.eachCell({
                            includeEmpty: true
                        }, (cell) => {
                            cell.border = {
                                top: {
                                    style: 'thin'
                                },
                                left: {
                                    style: 'thin'
                                },
                                bottom: {
                                    style: 'thin'
                                },
                                right: {
                                    style: 'thin'
                                }
                            };
                        });
                        const itemDate = new Date(item.created_at);
                        if (itemDate < earliestDate) {
                            earliestDate = itemDate;
                        }
                        if (itemDate > latestDate) {
                            latestDate = itemDate;
                        }
                    });
                    worksheet.columns.forEach(column => {
                        column.width = 28;
                    });
                    worksheet.eachRow({
                        includeEmpty: true
                    }, (row) => {
                        row.alignment = {
                            vertical: 'middle',
                            horizontal: 'center'
                        };
                    });
                } else {
                    console.error(`Data for municipality '${municipality}' is not an array or is empty:`, data);
                }
            });
            workbook.xlsx.writeBuffer()
                .then(buffer => {
                    const blob = new Blob([buffer], {
                        type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    });
                    const url = window.URL.createObjectURL(blob);
                    const earliestMonth = earliestDate.toLocaleString('en-us', {
                        month: 'long'
                    });
                    const latestMonth = latestDate.toLocaleString('en-us', {
                        month: 'long'
                    });
                    const earliestYear = earliestDate.getFullYear();
                    const latestYear = latestDate.getFullYear();
                    let filename;
                    if (earliestMonth === latestMonth && earliestYear === latestYear) {
                        filename = `Smart Grant month of ${earliestMonth} ${earliestYear}.xlsx`;
                    } else if (earliestYear === latestYear) {
                        filename = `Smart Grant month of ${earliestMonth}-${latestMonth} ${earliestYear}.xlsx`;
                    } else {
                        filename = `Smart Grant month of ${earliestMonth} ${earliestYear} - ${latestMonth} ${latestYear}.xlsx`;
                    }
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = filename;
                    a.click();
                    window.URL.revokeObjectURL(url);
                })
                .catch(error => {
                    console.error('Error generating Excel file:', error);
                    toastr.error('Error generating Excel file. Please try again.');
                });
        },
        RequirementsModal(itemId) {
            axios.get(`/api/educational-assistance/requirements-path/${itemId}`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    this.educationalRequest = response.data;
                    const modal = document.getElementById('RequirementsModal');
                    modal.classList.remove('hidden');
                    modal.setAttribute('aria-hidden', 'false');
                    // Add event listener to close modal on close button click
                    modal.addEventListener('click', function (e) {
                        if (e.target && e.target.closest('[data-modal-hide="RequirementsModal"]')) {
                            modal.classList.add('hidden');
                            modal.setAttribute('aria-hidden', 'true');
                        }
                    });
                    this.educationalRequest.valid_id_imagepath = this.educationalRequest.valid_id_imagepath.map(imagePath => axios.defaults.baseURL + imagePath);
                    this.educationalRequest.barangay_indigency_imagepath = this.educationalRequest.barangay_indigency_imagepath.map(imagePath => axios.defaults.baseURL + imagePath);
                    this.educationalRequest.certificate_of_enrollment_imagepath = this.educationalRequest.certificate_of_enrollment_imagepath.map(imagePath => axios.defaults.baseURL + imagePath);
                    this.educationalRequest.certificate_of_registration_imagepath = this.educationalRequest.certificate_of_registration_imagepath.map(imagePath => axios.defaults.baseURL + imagePath);
                })
                .catch(error => {
                    console.error('Error fetching medical request data:', error);
                });
        },
        previewImage(imagePath) {
            this.previewedImage.url = imagePath;
            document.getElementById('RequirementsModal').classList.add('hidden');
            document.getElementById('preview-modal').classList.remove('hidden');
            document.getElementById('preview-modal').focus();

        },
        closePreviewModal() {
            document.getElementById('preview-modal').classList.add('hidden');
            document.getElementById('RequirementsModal').classList.remove('hidden');
            this.previewedImage.url = '';
        },
        handleTabChange(key) {

        },
        formatDateToWords(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        },
        fetchDeclineEducationalAssistance(startDate, endDate) {
            axios.get('/api/educational-assistance/get-all-decline_shcolarship-request-smart-grant', {
                params: {
                        start_date: startDate,
                        end_date: endDate
                    },
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    this.Declineitems = response.data;
                })
                .catch(error => {
                    console.error('Error fetching medical requests:', error);
                });
        },
        fetchApprovedEducationalAssistance(startDate, endDate) {
            axios.get('/api/educational-assistance/get-all-approved_shcolarship-request-smart-grant', {
                params: {
                        start_date: startDate,
                        end_date: endDate
                    },
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    this.Approveitems = response.data;
                })
                .catch(error => {
                    console.error('Error fetching medical requests:', error);
                });
        },
        fetchEducationalAssistance(startDate, endDate) {
            axios.get('/api/educational-assistance/get-all-pending_shcolarship-request-smart-grant', {
                params: {
                        start_date: startDate,
                        end_date: endDate
                    },
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
        emailModal(itemId) {
            this.itemId = itemId;
            let emails = [];
            if (Array.isArray(itemId)) {
                itemId.forEach(id => {
                    const item = this.Approveitems.find(item => item.id === id);
                    if (item) {
                        emails.push(item.student_email);
                    }
                });
            } else {
                const item = this.Approveitems.find(item => item.id === itemId);
                if (item) {
                    emails.push(item.student_email);
                }
            }
            this.emailList = emails.join(', ');
            const modal = document.getElementById('emailModal');
            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');
            modal.addEventListener('click', function (e) {
                if (e.target && e.target.closest('[data-modal-hide="emailModal"]')) {
                    modal.classList.add('hidden');
                    modal.setAttribute('aria-hidden', 'true');
                }
            });
        },
        sendEmail() {
            const itemId = this.itemId;
            if (itemId instanceof Event) {
                console.error("Invalid itemId:", itemId);
                return;
            }
            if (Array.isArray(itemId)) {
                itemId.forEach(id => {
                    this.sendEmailRequest(id);
                });
            } else {
                this.sendEmailRequest(itemId);
            }
        },
        sendEmailRequest(id) {
            const subject = document.getElementById('subject').value;
            const message = document.getElementById('message').value;
            axios.post(`/api/educational-assistance/send-email-to-student/${id}`, {
                    subject,
                    message
                }, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    toastr.success('Email Sent!');
                    this.checkedIds = [];
                    document.getElementById('subject').value = '';
                    document.getElementById('message').value = '';

                })
                .catch(error => {
                    console.error('Error sending email:', error);
                });
        },

        DeclineModal(itemId) {
            this.itemId = itemId;
            const modal = document.getElementById('declineModal');
            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');
            // Add event listener to close modal on close button click
            modal.addEventListener('click', function (e) {
                if (e.target && e.target.closest('[data-modal-hide="declineModal"]')) {
                    modal.classList.add('hidden');
                    modal.setAttribute('aria-hidden', 'true');
                }
            });
        },
        DeclineRequest() {
            const itemId = this.itemId;
            if (itemId instanceof Event) {
                console.error("Invalid itemId:", itemId);
                return;
            }
            if (Array.isArray(itemId)) {
                itemId.forEach(id => {
                    this.sendDeclineRequest(id);
                });
            } else {
                this.sendDeclineRequest(itemId);
            }
        },
        sendDeclineRequest(itemId) {
            const decline_reason = document.getElementById('Reason').value;
            axios.put(`/api/educational-assistance/decline-scholarship-request/${itemId}`, {
                    decline_reason
                }, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    toastr.success("Request Decline");
                    this.fetchEducationalAssistance();
                    this.checkedIds = [];
                })
                .catch(error => {
                    console.error(error.response.data);
                    toastr.error("Failed to decline request.");
                });
        },
        acceptApplication(itemId) {
            if (Array.isArray(itemId)) {
                itemId.forEach(id => {
                    const item = this.items.find(item => item.id === id);
                    if (item) {
                        this.sendApprovalRequest(id, item.amount);
                    }
                });
            } else {
                const item = this.items.find(item => item.id === itemId);
                if (item) {
                    this.sendApprovalRequest(itemId, item.amount);
                }
            }
        },
        sendApprovalRequest(id, amount) {
            axios.put(`/api/educational-assistance/approve-scholarship-request/${id}`, {
                    amount
                }, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    toastr.success("Application Approved");
                    this.fetchEducationalAssistance();
                    this.checkedIds = [];
                })
                .catch(error => {
                    console.error(error.response.data);
                    toastr.error("Failed to approve application.");
                });
        },
        checkAll(event) {
            const isChecked = event.target.checked;
            if (isChecked) {
                this.checkedIds = this.items.map((item) => item.id);
            } else {
                this.checkedIds = [];
            }
            this.$nextTick(() => {
                document.getElementById("check-all").checked = isChecked;
            });
        },
        toggleChecked(id) {
            if (this.checkedIds.includes(id)) {
                this.checkedIds = this.checkedIds.filter((checkedId) => checkedId !== id);
            } else {
                this.checkedIds.push(id);
            }
        },
        checkAllForApproved(event) {
            const isChecked = event.target.checked;
            if (isChecked) {
                this.checkedIdsForApproved = this.Approveitems.map((item) => item.id);
            } else {
                this.checkedIdsForApproved = [];
            }
            this.$nextTick(() => {
                document.getElementById("check-all-for-approved").checked = isChecked;
            });
        },
        toggleCheckedForApproved(id) {
            if (this.checkedIdsForApproved.includes(id)) {
                this.checkedIdsForApproved = this.checkedIdsForApproved.filter((checkedId) => checkedId !== id);
            } else {
                this.checkedIdsForApproved.push(id);
            }
        },
        checkAllForDecline(event) {
            const isChecked = event.target.checked;
            if (isChecked) {
                this.checkedIdsForDecline = this.Declineitems.map((item) => item.id);
            } else {
                this.checkedIdsForDecline = [];
            }
            this.$nextTick(() => {
                document.getElementById("check-all-for-Decline").checked = isChecked;
            });
        },
        toggleCheckedForDecline(id) {
            if (this.checkedIdsForDecline.includes(id)) {
                this.checkedIdsForDecline = this.checkedIdsForDecline.filter((checkedId) => checkedId !== id);
            } else {
                this.checkedIdsForDecline.push(id);
            }
        },
    },
    computed: {
        isCheckedAll() {
            return this.checkedIds.length === this.items.length && this.checkedIds.length > 0;
        },
        isCheckedAllForApproved() {
            return this.checkedIdsForApproved.length === this.Approveitems.length && this.checkedIdsForApproved.length > 0;
        },
        isCheckedAllForDecline() {
            return this.checkedIdsForDecline.length === this.Declineitems.length && this.checkedIdsForDecline.length > 0;
        },
    },
};
</script>

<style>
@media screen and (min-width: 1024px) {
    .action-column {
        position: sticky;
        right: -0.01vw;
        background-color: rgb(240, 176, 134);
        z-index: 1;
    }

    .requirements-column {
        position: sticky;
        right: 7vw;
        background-color: rgb(240, 176, 134);
        z-index: 0;
    }

    .check-column {
        position: sticky;
        left: 0vw;
        background-color: rgb(240, 176, 134);
        z-index: 0;
    }
}
</style>
