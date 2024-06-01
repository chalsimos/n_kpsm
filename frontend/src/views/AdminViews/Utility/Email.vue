<template>
<Side />
<div>
    <div class="p-4 sm:ml-64 flex-grow overflow-y-auto ">
        <div class="p-2 border-2 border-orange-200 border-solid rounded-lg dark:border-gray-700 mt-14 ">
            <v-card flat>
                <v-card-title class="d-flex align-center pe-2 bg-orange-200">
                    <v-icon icon="mdi-hospital-box-outline"></v-icon>
                    <v-spacer></v-spacer>
                    <v-text-field v-model="search" density="compact" label="Search" prepend-inner-icon="mdi-magnify" variant="solo-filled" flat hide-details single-line></v-text-field>
                    <Button type="primary" @click="addEmail" class="ml-5" style="background-color: #ffd666">
                        Add Email
                    </Button>
                </v-card-title>
                <v-divider></v-divider>
                <v-data-table v-model:search="search" :items="items" :items-per-page="5">
                    <template #headers="{ headers }">
                        <tr class="text-center whitespace-nowrap">
                            <th class="text-center"> <input @change="checkAll" :checked="isCheckedAll" id="check-all" type="checkbox" value="" class="w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"></th>
                            <th class="text-center">Acronym</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </template>
                    <template v-slot:item="{ item }">
                        <tr class="h-[10vh] text-center">
                            <td class="whitespace-nowrap uppercase">
                                <input @change="toggleChecked(item.id)" :checked="checkedIds.includes(item.id)" id="single-check" type="checkbox" value="" class="single-check w-4 h-4 text-orange-600 bg-gray-100 border-gray-300 rounded focus:ring-orange-500 dark:focus:ring-orange-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            </td>
                            <td class="whitespace-nowrap uppercase">{{ item.acronym }}</td>
                            <td class="whitespace-nowrap uppercase">{{ item.name }}</td>
                            <td class="whitespace-nowrap uppercase">{{ item.email }}</td>
                            <td class="whitespace-nowrap uppercase">
                                <div class="mb-1">
                                    <button @click="emailModal(checkedIds.length > 0 ? checkedIds : item.id)" v-show="item.status === 'active'" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm mt-1 px-3 py-2 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" type="button">
                                        Send Email
                                    </button>
                                </div>
                                <div class="mb-1">
                                    <Button type="primary" class="px-5" danger @click="deleteEmail(item.id)" v-show="item.status === 'inactive'">
                                        Delete
                                    </Button>
                                </div>
                                <div class="mb-1">
                                    <Button type="primary" primary @click="ActivateEmail(item.id)" v-show="item.status === 'inactive'">
                                        Activate
                                    </Button>
                                    <Button type="primary" primary @click="DectivateEmail(item.id)" v-show="item.status === 'active'">
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
                    <a-upload name="file" :fileList="fileList" multiple :beforeUpload="beforeUpload" :onChange="handleChange" :onDrop="handleDrop" class="w-full h-24 flex flex-col justify-center items-center border-dashed border-4 border-gray-400 rounded-lg">
                        <div class="w-full h-full flex justify-center items-center cursor-pointer">
                            <p class="text-sm flex justify-center items-center">
                                Click here to input files if need to send single/multiple files
                            </p>
                        </div>
                    </a-upload>

                    <div class="flex justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button data-modal-hide="emailModal" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="addEmail" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-screen md:inset-0">
    <div class="relative p-4 sm:px-6 sm:py-8 lg:px-8 lg:py-10 w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Add New Hospital
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="addEmail">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form @submit.prevent="insertEmail" class="w-full px-4 py-6 sm:px-6 sm:py-8 lg:px-8 lg:py-10">
                <div class="mb-5">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                    <input v-model="name" type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Name" required />
                </div>
                <div class="mb-5">
                    <label for="acronym" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Acronym</label>
                    <input v-model="acronym" type="text" id="acronym" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Acronym" required />
                </div>
                <div class="mb-5">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                    <input v-model="email" type="text" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500" placeholder="Email" required />
                </div>
                <div class="flex justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="addEmail" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Email</button>
                </div>
            </form>
        </div>
    </div>
</div>
</template>

<script>
import {
    Button,
    Upload,
    Carousel,
    ConfigProvider,
    Popover
} from "ant-design-vue";
import {
    Modal,
    Tooltip,
    initTWE
} from "tw-elements";

import {
    InboxOutlined
} from '@ant-design/icons-vue';
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
            search: '',
            items: [],
            checkedIds: [],
            emailList: '',
            name: '',
            acronym: '',
            email: '',
            fileList: [],
            contentStyle: {
                margin: 0,
                height: '160px',
                color: '#fff',
                lineHeight: '160px',
                textAlign: 'center',
                background: '#364d79',
            },
        };
    },
    components: {
        Button,
        Upload,
        Side,
        Carousel,
        ConfigProvider,
        Popover,
        InboxOutlined
    },
    mounted() {
        initTWE({
            Modal,
            Tooltip,
        });
        initFlowbite();
        this.fetchEmail();
    },
    methods: {
        beforeUpload(file) {
            return false;
        },
        handleChange(info) {
            let newFileList = [...info.fileList];
            this.fileList = newFileList;
        },
        handleDrop(e) {
            console.log('Dropped files', e.dataTransfer.files);
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
        async sendEmailRequest(id) {
            const subject = document.getElementById('subject').value;
            const message = document.getElementById('message').value;
            const formData = new FormData();
            formData.append('subject', subject);
            formData.append('message', message);
            this.fileList.forEach((file, index) => {
                formData.append(`files[${index}]`, file.originFileObj);
            });
            try {
                const response = await axios.post(`/api/utility/send-emails/${id}`, formData, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`,
                        'Content-Type': 'multipart/form-data',
                    }
                });
                toastr.success('Email Sent!');
                this.checkedIds = [];
                document.getElementById('subject').value = '';
                document.getElementById('message').value = '';
            } catch (error) {
                console.error('Error sending email:', error);
            }
        },
        emailModal(itemId) {
            this.itemId = itemId;
            let emails = [];
            if (Array.isArray(itemId)) {
                itemId.forEach(id => {
                    const item = this.items.find(item => item.id === id);
                    if (item) {
                        emails.push(item.email);
                    }
                });
            } else {
                const item = this.items.find(item => item.id === itemId);
                if (item) {
                    emails.push(item.email);
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
        deleteEmail(id) {
            axios.delete(`/api/utility/delete-emails/${id}`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    toastr.success("Email Deleted");
                    this.fetchEmail();
                })
                .catch(error => {
                    toastr.error("Cant Delete Active Email")
                    console.error(error.response.data);
                });
        },
        ActivateEmail(id) {
            axios.put(`/api/utility/active-emails/${id}`, {}, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    toastr.success("Email Updated");
                    this.fetchEmail();
                })
                .catch(error => {
                    if (error.response && error.response.data && error.response.data.error) {
                        toastr.error(error.response.data.error);
                    } else {
                        toastr.error("Can't Activate This Email");
                    }
                    console.error(error.response ? error.response.data : error);
                });
        },
        DectivateEmail(id) {
            axios.put(`/api/utility/deactive-emails/${id}`, {}, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    toastr.success("Email Updated");
                    this.fetchEmail();
                })
                .catch(error => {
                    if (error.response && error.response.data && error.response.data.error) {
                        toastr.error(error.response.data.error);
                    } else {
                        toastr.error("Can't Activate This Email");
                    }
                    console.error(error.response ? error.response.data : error);
                });
        },
        insertEmail() {
            const formData = new FormData();
            formData.append('name', this.name);
            formData.append('acronym', this.acronym);
            formData.append('email', this.email);
            axios.post('/api/utility/create-emails', formData, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    this.name = '';
                    this.acronym = '';
                    this.email = '';
                    toastr.success('Email Save Successfully');
                    this.fetchEmail();
                })
                .catch(error => {
                    console.error(error.response.data);
                    toastr.error(error.response.data);
                });
        },
        addEmail() {
            const modal = document.getElementById('addEmail');
            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');
            // Add event listener to close modal on close button click
            modal.addEventListener('click', function (e) {
                if (e.target && e.target.closest('[data-modal-hide="addEmail"]')) {
                    modal.classList.add('hidden');
                    modal.setAttribute('aria-hidden', 'true');
                }
            });
        },
        fetchEmail() {
            axios.get('/api/utility/get-emails', {
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
    },
    computed: {
        isCheckedAll() {
            return this.checkedIds.length === this.items.length && this.checkedIds.length > 0;
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
