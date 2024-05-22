<template>
<Side />
<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <v-card class="bg-orange-200" flat>
            <v-card-title class="d-flex align-center pe-2 bg-orange-200">
                <v-icon icon="mdi-hospital-box-outline"></v-icon> &nbsp; 
                <v-spacer></v-spacer>
                <Button type="primary" @click="AddAmount" style="background-color: #ffd666">
                    Add Amount
                </Button>
            </v-card-title>
            <v-divider></v-divider>
            <v-data-table v-model:search="search" :items="items" :items-per-page="5">
                <template #headers="{ headers }">
                    <tr class="text-center whitespace-nowrap">
                        <th class="text-center">Elementary Amount</th>
                        <th class="text-center">High Amount</th>
                        <th class="text-center">Senior High Amount</th>
                        <th class="text-center">College Amount</th>
                        <th class="text-center">Vocational Amount</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </template>
                <template v-slot:item="{ item } " class="bg-orange-200">
                    <tr class="h-[5vh] text-center" elevation="2">
                        <td class="whitespace-nowrap uppercase">
                            {{ item.elementary_amount }}
                        </td>
                        <td class="whitespace-nowrap uppercase">
                            {{ item.high_school_amount }}
                        </td>
                        <td class="whitespace-nowrap uppercase">
                            {{ item.senior_high_school_amount }}
                        </td>
                        <td class="whitespace-nowrap uppercase">
                            {{ item.college_amount }}
                        </td>
                        <td class="whitespace-nowrap uppercase">
                            {{ item.vocational_amount }}
                        </td>
                        <td class="whitespace-nowrap uppercase">
                            <v-chip :color="item.status === 'active' ? 'green' : 'red'" class="text-uppercase" size="small" label>{{ item.status }}</v-chip>
                        </td>
                        <td class="whitespace-nowrap uppercase">
                            <div class="mb-1 mt-1">
                                <Button type="primary" class="px-5" danger @click="deleteAmount(item.id)" v-show="item.status === 'inactive'">
                                    Delete
                                </Button>
                            </div>
                            <div class="mb-1">
                                <Button type="primary" primary @click="activateAmount(item.id)" v-show="item.status === 'inactive'">
                                        Activate
                                    </Button>
                            </div>
                        </td>
                    </tr>
                </template>
            </v-data-table>
        </v-card>
    </div>
</div>
<div id="AddAmount" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-screen md:inset-0">
    <div class="relative p-4 sm:px-6 sm:py-8 lg:px-8 lg:py-10 w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Educational Assistance Amount
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="AddAmount">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form @submit.prevent="insertAmount" class="max-w-sm mx-auto mt-5 mb-5">
                <div class="mb-5">
                    <label for="elementary_amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Elementary Amount</label>
                    <input type="number" id="elementary_amount" v-model="elementary_amount" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="1000" />
                </div>
                <div class="mb-5">
                    <label for="high_school_amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">High School Amount</label>
                    <input type="number" id="high_school_amount" v-model="high_school_amount" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="1000" />
                </div>
                <div class="mb-5">
                    <label for="senior_high_school_amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Senior High School Amount</label>
                    <input type="number" id="senior_high_school_amount" v-model="senior_high_school_amount" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="1000" />
                </div>
                <div class="mb-5">
                    <label for="college_amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">College Amount</label>
                    <input type="number" id="college_amount" v-model="college_amount" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="1000" />
                </div>
                <div class="mb-5">
                    <label for="vocational_amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Vocational Amount</label>
                    <input type="number" id="vocational_amount" v-model="vocational_amount" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="1000" />
                </div>
                <div class="flex justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="AddAmount" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Amount</button>
                </div>
            </form>
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
            elementary_amount: '',
            high_school_amount: '',
            senior_high_school_amount: '',
            college_amount: '',
            vocational_amount: ''
        };
    },
    components: {
        Side,
        Button,
        Upload
    },
    mounted() {
        initTWE({
            Modal,
            Tooltip
        });
        initFlowbite(); 
        this.fetchData();
        setInterval(this.sendStoredData, 5000);
    },
    methods: {
        async checkInternetConnection() {
      if (!navigator.onLine) {
        return false;
      }

      try {
        await fetch("https://www.google.com", { mode: 'no-cors' });
        return true;
      } catch (error) {
        return false;
      }
    },
    insertAmount() {
      const data = {
        elementary_amount: this.elementary_amount,
        high_school_amount: this.high_school_amount,
        senior_high_school_amount: this.senior_high_school_amount,
        college_amount: this.college_amount,
        vocational_amount: this.vocational_amount
      };
      if (!Object.values(data).every(val => val !== null && val !== undefined && val !== '')) {
        toastr.error("Please fill all the fields!");
        this.AddAmount();
        return;
      }
      this.checkInternetConnection().then(isConnected => {
        if (!isConnected) {
          const unsentData = JSON.parse(localStorage.getItem('unsentData')) || [];
          unsentData.push(data);
          localStorage.setItem('unsentData', JSON.stringify(unsentData));
          toastr.error("No internet connection. Data saved locally and will be sent once connected.");
        } else {
          axios.post('/api/utility/school-level-amount', data, {
              headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`
              }
            })
            .then(response => {
              this.fetchData();
              toastr.success("Uploaded Amount Successfully");
              this.clearForm();
            })
            .catch(error => {
              toastr.error('Error uploading Amount:', error);
            });
        }
      });
    },
    sendStoredData() {
      this.checkInternetConnection().then(isConnected => {
        if (isConnected) {
          const unsentData = JSON.parse(localStorage.getItem('unsentData')) || [];
          if (unsentData.length > 0) {
            unsentData.forEach(data => {
              axios.post('/api/utility/school-level-amount', data, {
                  headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                  }
                })
                .then(response => {
                  toastr.success("Uploaded Amount Successfully");
                  this.fetchData();
                })
                .catch(error => {
                  toastr.error('Error uploading Amount:', error);
                });
            });
            localStorage.removeItem('unsentData');
          }
        }
      });
    },
        deleteAmount(id) {
            axios.delete(`/api/utility/school-level-amount-delte/${id}`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    toastr.success("Amount Deleted");
                    this.fetchData();
                })
                .catch(error => {
                    toastr.error("Cant Delete Active Amount")
                    console.error(error.response.data);
                });
        },
        activateAmount(id) {
            axios.put(`/api/utility/school-level-amount-change-status/${id}`, {}, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    toastr.success("Amount Updated");
                    this.fetchData();
                })
                .catch(error => {
                    if (error.response && error.response.data && error.response.data.error) {
                        toastr.error(error.response.data.error);
                    } else {
                        toastr.error("Can't Activate This Amount");
                    }
                    console.error(error.response ? error.response.data : error);
                });
        },
        AddAmount() {
            const modal = document.getElementById('AddAmount');
            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');
            // Add event listener to close modal on close button click
            modal.addEventListener('click', function (e) {
                if (e.target && e.target.closest('[data-modal-hide="AddAmount"]')) {
                    modal.classList.add('hidden');
                    modal.setAttribute('aria-hidden', 'true');
                }
            });
        },
        deleteLogo(id) {
            axios.delete(`/api/utility/delete-logos/${id}`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    toastr.success("Logo Deleted");
                    this.fetchData();
                })
                .catch(error => {
                    toastr.error("Cant Delete Active Logo")
                    console.error(error.response.data);
                });
        },
        fetchData() {
            axios.get('/api/utility/get-all-amount', {
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
        clearForm() {
            this.elementary_amount = '';
            this.high_school_amount = '';
            this.senior_high_school_amount = '';
            this.college_amount = '';
            this.vocational_amount = '';
        },
    },
    computed: {
    }
};
</script>
