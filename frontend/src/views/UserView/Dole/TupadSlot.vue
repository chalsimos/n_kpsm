<template>
<div class="flex flex-col min-h-screen">

    <Head />
    <div class="flex-grow p-4 mt-[5vh]">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14 w-full">
            <div class="md:flex">
                <ul class="flex-column space-y space-y-4 text-sm font-medium text-gray-500 dark:text-gray-400 md:me-4 mb-4 md:mb-0">
                    <li>
                        <a href="#" class="whitespace-nowrap inline-flex items-center px-4 py-3 rounded-lg hover:text-gray-900 w-full dark:hover:text-white" :class="{ 'bg-blue-700 text-white': activeTab === 'TupadSlot', 'bg-gray-50': activeTab !== 'TupadSlot', 'dark:bg-blue-600': activeTab === 'TupadSlot', 'dark:bg-gray-800': activeTab !== 'TupadSlot' }" @click="toggleTab('TupadSlot')">
                            <img src="../../../assets/tupad.jpg" class="h-8 me-3" alt="KPSM Logo" />
                            Tupad Slot
                        </a>
                    </li>
                    <li>
                        <a href="#" class="whitespace-nowrap inline-flex items-center px-4 py-3 rounded-lg hover:text-gray-900 w-full dark:hover:text-white" :class="{ 'bg-blue-700 text-white': activeTab === 'TupadInvites', 'bg-gray-50': activeTab !== 'TupadInvites', 'dark:bg-blue-600': activeTab === 'TupadInvites', 'dark:bg-gray-800': activeTab !== 'TupadInvites' }" @click="toggleTab('TupadInvites')">
                            <img src="../../../assets/tupad.jpg" class="h-8 me-3" alt="KPSM Logo" />
                            Tupad Invites
                        </a>
                    </li>
                </ul>
                <div id="TupadSlotContent" class="p-6 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg w-full md:w-[86vw] md:h-[70vh]" v-show="activeTab === 'TupadSlot'">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        New Tupad Slot Available: <span class=" bg-orange-100 text-orange-600 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">{{ totalNoCodeSlots }}</span>
                        <Flex v-show="totalNoCodeSlots !== 0 " gap="small" wrap="wrap">
                        </Flex>
                        <!-- <Button v-show="totalNoCodeSlots !== 0 " @click="excelGenerate" class="bg-orange-400 hover:bg-orange-600 text-white border border-orange-900">Generate {{ totalNoCodeSlots }} Code</Button> -->
                        <Button v-show="totalNoCodeSlots !== 0 " @click="generateExcel" class="bg-orange-400 hover:bg-orange-600 text-white border border-orange-900">Generate Excel Form {{ totalNoCodeSlots }} Slots</Button>
                    </h2>
                    <div v-if="isSlotIdsPresent" class="p-2 border-2 border-orange-200 border-solid rounded-lg dark:border-gray-700 mt-5">
                        <a-upload name="file" :fileList="fileList" multiple :beforeUpload="beforeUpload" :on-change="handleChange" :on-drop="handleDrop" class="w-full h-96 flex flex-col justify-center items-center border-dashed border-4 border-gray-400 rounded-lg">
                            <p class="ant-upload-drag-icon mb-8 text-4xl flex justify-center items-center">
                                <InboxOutlined />
                            </p>
                            <p class="ant-upload-text text-center text-lg mb-4">
                                Pindutin o Ilagay ang files para maiupload
                            </p>
                            <p class="ant-upload-hint text-center text-base">
                                Ilagay dito yung EXCEL file form na nadownload pagkatapos magfill-up, kasama ang picture ng id ng lahat ng nasa slot.
                            </p>
                        </a-upload>
                        <a-tooltip :title="tooltipMessage" placement="top">
                            <a-button type="primary" @click="handleUpload" :disabled="isUploadDisabled" class="text-white mt-4">
                                Upload Files
                            </a-button>
                        </a-tooltip>
                    </div>
                    <div v-else class="flex justify-center items-center mt-[10vh]">
                        <Tag color="red" class="whitespace-normal text-xl md:text-1xl lg:text-2xl xl:text-3xl">Wala kapang Tupad Slot kaya hindi lalabas ang uploadan ng files.</Tag>
                    </div>
                </div>
                <div id="TupadInvitesContent" class="p-6 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg w-full md:w-[86vw] md:h-[70vh]" v-show="activeTab === 'TupadInvites'">
                    <div class="flex">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            Total Invited:
                            <Tooltip title="Total Invited" color=volcano key=volcano>
                                <span class="cursor-pointer whitespace-nowrap bg-orange-100 text-orange-600 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">{{ totalInvites }}</span>
                            </Tooltip>
                        </h2>
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            Total Accepted:
                            <Tooltip title="Total Accepted" color=volcano key=volcano>
                                <span class="cursor-pointer whitespace-nowrap bg-orange-100 text-orange-600 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-blue-400 border border-blue-400">{{ totalAccepted }}</span>
                            </Tooltip>
                        </h2>
                    </div>
                    <div class="p-2 border-2 border-orange-200 border-solid rounded-lg dark:border-gray-700 mt-5">
                        <v-card flat>
                            <v-card-title class="d-flex align-center pe-2 bg-orange-200">
                                <img src="../../../assets/tupad.jpg" class="h-8 me-3" alt="KPSM Logo" />&nbsp; Manage Tupad Invites
                                <v-spacer></v-spacer>
                                <v-text-field v-model="searchTupadInvites" density="compact" label="Search" prepend-inner-icon="mdi-magnify" variant="solo-filled" flat hide-details single-line></v-text-field>
                            </v-card-title>
                            <v-divider></v-divider>
                            <v-data-table v-model:search="searchTupadInvites" :items="tupad_invites" :items-per-page="5">
                                <template #headers="{ headers }">
                                    <tr class="text-center whitespace-nowrap">
                                        <th v-for="header in dynamicHeaders" :key="header.key" class="text-center whitespace-nowrap">
                                            {{ header.header }}
                                        </th>
                                    </tr>
                                </template>
                                <template v-slot:item="{ item }">
                                    <tr class="h-[2vh]">
                                        <td v-for="header in dynamicHeaders" :key="header.key" class="whitespace-nowrap text-center">
                                            {{ item[header.key] }}
                                        </td>
                                    </tr>
                                </template>
                            </v-data-table>
                        </v-card>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <Foot />
    </div>
</div>
</template>

<script>
import {
    Button,
    Flex,
    Tooltip,
    Upload,
    message,
    Tag
} from "ant-design-vue";
import {
    InboxOutlined
} from '@ant-design/icons-vue';
import {
    initFlowbite
} from "flowbite";
import Head from "@/views/UserView/Home/Header.vue";
import {
    useToast
} from "vue-toastification";
import Foot from "@/views/UserView/Home/Footer.vue";
const toastr = useToast();
import axios from "../../../main.js";
import ExcelJS from 'exceljs';
import {
    read,
    utils
} from 'xlsx';
// import {
//     saveRequest,
//     getRequests,
//     clearRequests
// } from '@/utils/captain_tupad_excel_form.js';
// import {
//     saveTupadRequest,
//     getTupadRequests,
//     clearTupadRequests
// } from '@/utils/tupadDB.js';
export default {
    components: {
        Head,
        Foot,
        Button,
        Flex,
        Tooltip,
        Tag,
        'a-upload': Upload,
        'a-button': Button,
        InboxOutlined
    },
    data() {
        return {
            activeTab: 'TupadSlot',
            search: "",
            searchTupadInvites: '',
            totalNoCodeSlots: 0,
            totalInvites: '',
            totalAccepted: '',
            items: [],
            slots: [],
            dynamicHeaders: [],
            tupad_invites: [],
            slotIds: null,
            fileList: [],
            slotGet: 0,
        };
    },
    async mounted() {
        initFlowbite();
        this.loadSlotIds();
        this.getSlotInfo();
        this.fetchTupadCode();
        this.fetchTupadSlot();
        this.fetchTupadInvites();
        const slotIds = JSON.parse(localStorage.getItem('slot_ids'));
        if (slotIds !== null) {
            this.slotIds = slotIds;
        }
        try {
            this.dynamicHeaders = await this.fetchActiveHeaders();
        } catch (error) {
            console.error('Error fetching headers:', error);
        }
        // setInterval(this.sendStoredData, 5000);
        // setInterval(this.sendTupadStoredData, 5000);
    },
    methods: {
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
        loadSlotIds() {
            const slotIds = JSON.parse(localStorage.getItem('slot_ids'));
            if (slotIds !== null) {
                this.slotIds = slotIds;
            }
        },
        // async extractExcelData(file) {
        //     try {
        //         const buffer = await file.arrayBuffer();
        //         const workbook = await read(buffer, {
        //             type: 'array'
        //         });
        //         const sheetName = 'Captain Slots';
        //         if (!workbook.SheetNames.includes(sheetName)) {
        //             toastr.error(`Sheet named "${sheetName}" not found`);
        //             throw new Error(`Sheet named "${sheetName}" not found`);
        //         }
        //         const worksheet = workbook.Sheets[sheetName];
        //         const rawData = utils.sheet_to_json(worksheet, {
        //             header: 1,
        //             dateNF: 'mm/dd/yyyy'
        //         });
        //         const tupadSlotId = JSON.parse(localStorage.getItem('slot_ids'));
        //         let formData = new FormData();
        //         formData.append('tupad_slot_id', tupadSlotId);
        //         const response = await axios.post('/api/dole/get-captain-slot', formData, {
        //             headers: {
        //                 Authorization: `Bearer ${localStorage.getItem('token')}`,
        //             },
        //         });
        //         const slot_get = response.data.slot_get;
        //         console.log('Slot count:', slot_get);
        //         const headerRow = rawData[0];
        //         const requiredHeaders = ['SLOT', 'FIRST NAME', 'MIDDLE NAME', 'LAST NAME', 'CONTANCT NUMBER', 'BIRTH DATE', 'ADDRESS', 'SITIO', 'TYPE OF I.D', 'I.D NUMBER', 'SEX', 'CIVIL STATUS', 'AGE', 'NAME OF BENEFICIARY'];
        //         const missingHeaders = requiredHeaders.filter(header => !headerRow.includes(header));
        //         if (missingHeaders.length > 0) {
        //             toastr.error(`Required headers are missing: ${missingHeaders.join(', ')}`);
        //             throw new Error(`Required headers are missing: ${missingHeaders.join(', ')}`);
        //         }
        //         let dataRows = rawData.slice(1);
        //         console.log('Data rows length:', dataRows.length);
        //         console.log('Data rows:', dataRows);
        //         if (dataRows.some(row => requiredHeaders.some((header, index) => !row[index]))) {
        //             toastr.error(`Some data rows are incomplete. Please provide all required data.`);
        //             return;
        //         } else if (dataRows.length > slot_get) {
        //             toastr.error(`Your slot is only ${slot_get} and you passed ${dataRows.length} data. The only accepted data is the first ${slot_get} because that is your slot.`);
        //             dataRows = dataRows.slice(0, slot_get);
        //         }
        //         const data = dataRows.map(row => {
        //             const rowData = {};
        //             Object.keys(headerRow).forEach((key, index) => {
        //                 const value = row[index];
        //                 if (headerRow[key] === 'BIRTH DATE' && !isNaN(value) && value >= 25569) {
        //                     const date = this.excelSerialToJSDate(value);
        //                     rowData[key] = date.toLocaleDateString('en-US');
        //                 } else {
        //                     rowData[key] = value || '';
        //                 }
        //             });
        //             return rowData;
        //         });
        //         console.log('Extracted data:', data);
        //         for (const item of data) {
        //             const slotData = {
        //                 slot_id: tupadSlotId,
        //                 firstname: item[1],
        //                 middlename: item[2],
        //                 lastname: item[3],
        //                 age: item[12],
        //                 birthday: item[5],
        //                 gender: item[10],
        //                 civilstatus: item[11],
        //                 contactnumber: item[4],
        //                 benificiaryfullname: item[13],
        //                 idType: item[8],
        //                 idNum: item[9],
        //                 sitio: item[7],
        //                 address: item[6],
        //             };
        //             // const isConnected = await this.checkInternetConnection();
        //             // if (!isConnected) {
        //             //     await saveTupadRequest(slotData);
        //             //     toastr.warning("No internet connection. Data saved locally and will be sent once connected.");
        //             // } else {
        //             axios.post('/api/dole/save-captain-tupad-member', slotData, {
        //                     headers: {
        //                         Authorization: `Bearer ${localStorage.getItem('token')}`,
        //                     },
        //                 })
        //                 .then(response => {
        //                     toastr.success('Slot saved successfully');
        //                     this.fileList = [];
        //                     localStorage.removeItem('slot_ids');
        //                     this.loadSlotIds();
        //                     this.getSlotInfo();
        //                     this.fetchTupadCode();
        //                     this.fetchTupadSlot();
        //                     this.fetchTupadInvites();
        //                     this.slotIds = null;
        //                 })
        //                 .catch(error => {
        //                     console.error('Error saving slot:', error.response.data.error);
        //                     toastr.error('Failed to save slot:', error.response.data.error);
        //                 });
        //             // }
        //         }
        //         return data;
        //     } catch (error) {
        //         return Promise.reject(error);
        //     }
        // },
        async extractExcelData(file) {
            try {
                const buffer = await file.arrayBuffer();
                const workbook = await read(buffer, {
                    type: 'array'
                });
                const sheetName = 'Captain Slots';
                if (!workbook.SheetNames.includes(sheetName)) {
                    toastr.error(`Sheet named "${sheetName}" not found`);
                    throw new Error(`Sheet named "${sheetName}" not found`);
                }
                const worksheet = workbook.Sheets[sheetName];
                const rawData = utils.sheet_to_json(worksheet, {
                    header: 1,
                    dateNF: 'mm/dd/yyyy'
                });
                const activeHeaders = await this.fetchActiveHeaders();
                const headers = activeHeaders.map(header => header.header);
                const headerMap = activeHeaders.reduce((acc, header) => {
                    acc[header.header.toUpperCase().replace(/\s+/g, '')] = header.key;
                    return acc;
                }, {});
                const headerRow = rawData[1].map(header => header.toUpperCase().replace(/\s+/g, ''));
                const missingHeaders = headers.filter(header => !headerRow.includes(header.toUpperCase().replace(/\s+/g, '')));
                if (missingHeaders.length > 0) {
                    toastr.error(`Required headers are missing: ${missingHeaders.join(', ')}`);
                    throw new Error(`Required headers are missing: ${missingHeaders.join(', ')}`);
                }
                const tupadSlotId = JSON.parse(localStorage.getItem('slot_ids'));
                let formData = new FormData();
                formData.append('tupad_slot_id', tupadSlotId);
                const response = await axios.post('/api/dole/get-captain-slot', formData, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`,
                    },
                });
                const slot_get = response.data.slot_get;
                console.log('Slot count:', slot_get);
                let dataRows = rawData.slice(2);
                console.log('Data rows length:', dataRows.length);
                console.log('Data rows:', dataRows);
                if (dataRows.some(row =>
                        headers.some((header, index) => {
                            const headerKey = header.toUpperCase().replace(/\s+/g, '');
                            const requiredIndex = headerRow.indexOf(headerKey);
                            return requiredIndex !== -1 && !row[requiredIndex];
                        })
                    )) {
                    toastr.error(`Some data rows are incomplete. Please provide all required data.`);
                    throw new Error('Incomplete data rows found');
                } else if (dataRows.length > slot_get) {
                    toastr.error(`Your slot is only ${slot_get} and you passed ${dataRows.length} data. The only accepted data is the first ${slot_get} because that is your slot.`);
                    dataRows = dataRows.slice(0, slot_get);
                }
                const data = dataRows.map(row => {
                    const rowData = {};
                    headerRow.forEach((header, index) => {
                        const key = headerMap[header];
                        if (key) {
                            const value = row[index];
                            if (header === 'BIRTHDAY' && !isNaN(value) && value >= 25569) {
                                const date = this.excelSerialToJSDate(value);
                                rowData[key] = date.toLocaleDateString('en-US');
                            } else {
                                rowData[key] = value || '';
                            }
                        }
                    });
                    return rowData;
                });
                console.log('Extracted data:', data);
                for (const item of data) {
                    const slotData = {
                        slot_id: tupadSlotId
                    };
                    activeHeaders.forEach(header => {
                        const key = header.key;
                        slotData[key] = item[key];
                    });
                    axios.post('/api/dole/save-captain-tupad-member', slotData, {
                            headers: {
                                Authorization: `Bearer ${localStorage.getItem('token')}`,
                            },
                        })
                        .then(response => {
                            toastr.success('Slot saved successfully');
                            this.fileList = [];
                            localStorage.removeItem('slot_ids');
                            this.loadSlotIds();
                            this.getSlotInfo();
                            this.fetchTupadCode();
                            this.fetchTupadSlot();
                            this.fetchTupadInvites();
                            this.slotIds = null;
                        })
                        .catch(error => {
                            console.error('Error saving slot:', error.response.data.error);
                            toastr.error('Failed to save slot:', error.response.data.error);
                        });
                }
                return data;
            } catch (error) {
                console.error('Error extracting Excel data:', error);
                return Promise.reject(error);
            }
        },
        // async sendTupadStoredData() {
        //     const isConnected = await this.checkInternetConnection();
        //     if (isConnected) {
        //         const unsentData = await getTupadRequests();
        //         if (unsentData.length > 0) {
        //             for (const data of unsentData) {
        //                 try {
        //                     await axios.post('/api/dole/save-captain-tupad-member', data);
        //                     toastr.success('Slot saved successfully');
        //                     localStorage.removeItem('scholarGranted');
        //                     this.fileList = [];
        //                     localStorage.removeItem('slot_ids');
        //                     this.loadSlotIds();
        //                     this.getSlotInfo();
        //                     this.fetchTupadCode();
        //                     this.fetchTupadSlot();
        //                     this.fetchTupadInvites();
        //                     this.slotIds = null;
        //                 } catch (error) {
        //                     toastr.error('Error uploading Educational Assistance Request:', error);
        //                 }
        //             }
        //             await clearTupadRequests();
        //         }
        //     }
        // },
        excelSerialToJSDate(serial) {
            const utcDays = Math.floor(serial - 25569);
            const utcValue = utcDays * 86400;
            const dateInfo = new Date(utcValue * 1000);
            const fractionalDay = serial - Math.floor(serial) + 0.0000001;
            let totalSeconds = Math.floor(86400 * fractionalDay);
            const seconds = totalSeconds % 60;
            totalSeconds -= seconds;
            const hours = Math.floor(totalSeconds / (60 * 60));
            const minutes = Math.floor(totalSeconds / 60) % 60;
            return new Date(dateInfo.getFullYear(), dateInfo.getMonth(), dateInfo.getDate(), hours, minutes, seconds);
        },
        beforeUpload(file) {
            const isExcel = file.type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
            const isImage = file.type.startsWith('image/');
            if (!isExcel && !isImage) {
                this.$message.error('You can only upload Excel files and images!');
                return false;
            }
            if (isExcel) {
                const existingExcel = this.fileList.find(item => item.type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                if (existingExcel || this.fileList.filter(item => item.type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet').length > 0) {
                    this.$message.error('You can only upload one Excel file!');
                    return false;
                }
            }
            return false;
        },
        handleChange(info) {
            const {
                status
            } = info.file;
            if (status !== 'uploading') {
                console.log(info.file, info.fileList);
            }
            if (status === 'done') {
                this.$message.success(`${info.file.name} file uploaded successfully.`);
            } else if (status === 'error') {
                this.$message.error(`${info.file.name} file upload failed.`);
            }
            const isExcel = info.file.type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
            const existingExcel = this.fileList.some(item => item.type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            if (isExcel && existingExcel) {
                this.fileList = this.fileList.filter(file => file.uid !== info.file.uid);
                this.$message.error('You can only upload one Excel file!');
                return;
            }
            const isImage = info.file.type.startsWith('image/');
            const isSupportedFileType = isExcel || isImage;
            if (!isSupportedFileType) {
                this.fileList = this.fileList.filter(file => file.uid !== info.file.uid);
                this.$message.error('Only Excel files and images are allowed!');
                return;
            }
            const tupadSlotId = JSON.parse(localStorage.getItem('slot_ids'));
            let formData = new FormData();
            formData.append('tupad_slot_id', tupadSlotId);
            axios.post('/api/dole/get-captain-slot', formData, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`,
                    },
                })
                .then(response => {
                    const slot_get = response.data.slot_get;
                    const uploadedImagesCount = this.fileList.filter(file => file.type.startsWith('image/')).length;
                    if (isImage && uploadedImagesCount >= slot_get) {
                        this.$message.error(`You can only upload ${slot_get} image(s)!`);
                        this.fileList = this.fileList.filter(file => file.uid !== info.file.uid);
                        return;
                    }
                    this.fileList = info.fileList;
                })
                .catch(error => {
                    console.error('Error fetching slot_get:', error);
                    this.$message.error('Failed to fetch slot_get value. Please try again.');
                });
        },
        async handleUpload() {
            const excelFile = this.fileList.find(file => file.type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            if (!excelFile) {
                return;
            }
            try {
                const extractedData = await this.extractExcelData(excelFile.originFileObj);
                console.log('Extracted data:', extractedData);
            } catch (error) {
                console.error('Error extracting Excel data:', error);
                this.$message.error('Failed to extract Excel data.');
                return;
            }
            const imageFiles = this.fileList.filter(file => file.type.startsWith('image/'));
            const tupadSlotId = JSON.parse(localStorage.getItem('slot_ids'));
            axios.post('/api/dole/get-captain-slot', {
                    tupad_slot_id: tupadSlotId
                }, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`,
                    },
                })
                .then(response => {
                    const slot_get = response.data.slot_get;
                    const uploadedImagesCount = imageFiles.length;
                    const imageShortage = slot_get - uploadedImagesCount;
                    if (imageShortage > 0) {
                        this.$message.error(`You need to upload ${imageShortage} more image(s) to meet the requirement of ${slot_get}.`);
                        return;
                    }
                    let formData = new FormData();
                    formData.append('tupad_slot_id', tupadSlotId);
                    if (excelFile) {
                        formData.append('excel_file', excelFile.originFileObj);
                    }
                    imageFiles.forEach(file => {
                        formData.append('image_files[]', file.originFileObj);
                    });
                    axios.post('/api/dole/captain-upload-file', formData, {
                            headers: {
                                Authorization: `Bearer ${localStorage.getItem('token')}`,
                                'Content-Type': 'multipart/form-data',
                            },
                        })
                        .then(response => {
                            this.$message.success('Files uploaded successfully.');
                            this.fileList = [];
                        })
                        .catch(error => {
                            console.error('Upload error:', error);
                            this.$message.error('File upload failed.');
                        });
                })
                .catch(error => {
                    console.error('Error fetching slot_get:', error);
                    this.$message.error('Failed to fetch slot_get value. Please try again.');
                });
        },
        //         handleUpload() {
        //     const excelFile = this.fileList.find(file => file.type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //     if (!excelFile) {
        //         return;
        //     }

        //     this.extractExcelData(excelFile.originFileObj)
        //         .then(extractedData => {
        //             console.log('Extracted data:', extractedData);
        //         })
        //         .catch(error => {
        //             console.error('Error handling upload and extraction:', error);
        //         });

        //     const imageFiles = this.fileList.filter(file => file.type.startsWith('image/'));
        //     const tupadSlotId = JSON.parse(localStorage.getItem('slot_ids'));

        //     axios.post('/api/dole/get-captain-slot', {
        //         tupad_slot_id: tupadSlotId
        //     }, {
        //         headers: {
        //             Authorization: `Bearer ${localStorage.getItem('token')}`,
        //         },
        //     })
        //     .then(async response => {
        //         const slot_get = response.data.slot_get;
        //         const uploadedImagesCount = imageFiles.length;
        //         const imageShortage = slot_get - uploadedImagesCount;

        //         if (imageShortage > 0) {
        //             this.$message.error(`You need to upload ${imageShortage} more image(s) to meet the requirement of ${slot_get}.`);
        //             return;
        //         }

        //         let formData = new FormData();
        //         formData.append('tupad_slot_id', tupadSlotId);

        //         if (excelFile) {
        //             formData.append('excel_file', excelFile.originFileObj);
        //         }

        //         imageFiles.forEach(file => {
        //             formData.append('image_files[]', file.originFileObj);
        //         });

        //         axios.post('/api/dole/captain-upload-file', formData, {
        //             headers: {
        //                 Authorization: `Bearer ${localStorage.getItem('token')}`,
        //                 'Content-Type': 'multipart/form-data',
        //             },
        //         })
        //         .then(response => {
        //             this.$message.success('Files uploaded successfully.');
        //             this.fileList = [];
        //         })
        //         .catch(error => {
        //             console.error('Upload error:', error);
        //             this.$message.error('File upload failed.');
        //         });
        //     })
        //     .catch(async error => {
        //         console.error('Error fetching slot_get:', error);
        //         this.$message.error('Failed to fetch slot_get value. Please try again.');

        //         // Save data to IndexedDB
        //         const data = {
        //             excelFile: excelFile.originFileObj, // Pass the file itself, not the File object
        //             imageFiles: imageFiles.map(file => file.originFileObj), // Pass the files themselves, not the File objects
        //             tupadSlotId
        //         };
        //         await saveRequest(data); // Save to IndexedDB
        //         toastr.warning("No internet connection. Data saved locally and will be sent once connected.");
        //     });
        // },
        //         async fileToBase64(file) {
        //             const reader = new FileReader();
        //             return new Promise((resolve, reject) => {
        //                 reader.readAsDataURL(file);
        //                 reader.onload = () => resolve(reader.result.split(',')[1]);
        //                 reader.onerror = error => reject(error);
        //             });
        //         },
        //         async base64ToFile(base64, filename) {
        //             const arr = base64.split(',');
        //             const mime = arr[0].match(/:(.*?);/)[1];
        //             const bstr = atob(arr[1]);
        //             let n = bstr.length;
        //             const u8arr = new Uint8Array(n);
        //             while (n--) {
        //                 u8arr[n] = bstr.charCodeAt(n);
        //             }
        //             return new File([u8arr], filename, {
        //                 type: mime
        //             });
        //         },
        //         async sendStoredData() {
        //             const unsentData = await getRequests();
        //             if (unsentData.length > 0) {
        //                 unsentData.forEach(async data => {
        //                     const excelBase64 = await this.fileToBase64(data.excelFile);
        //                     const imageFilesBase64 = await Promise.all(data.imageFiles.map(imageFile => this.fileToBase64(imageFile)));
        //                     const formData = new FormData();
        //                     formData.append('excelFile', this.base64ToFile(excelBase64, 'excel_file.xlsx'));
        //                     imageFilesBase64.forEach((imageBase64, index) => {
        //                         formData.append(`imageFile${index}`, this.base64ToFile(imageBase64, `image_${index}.png`));
        //                     });
        //                     axios.post('/api/upload-stored-data', formData)
        //                         .then(response => {
        //                             console.log('Stored data sent successfully:', response.data);
        //                             toastr.success("Uploaded Tupad Form Successfully");
        //                             clearRequests();
        //                         })
        //                         .catch(error => {
        //                             console.error('Error sending stored data:', error);
        //                         });
        //                 });
        //                 await clearRequests();
        //             }
        //         },
        handleDrop(e) {
            console.log('Dropped files', e.dataTransfer.files);
        },
        toggleTab(tabName) {
            this.activeTab = tabName;
        },
        fetchTupadInvites() {
            axios.get('/api/dole/captain-tupad-invited', {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    this.tupad_invites = response.data.data;
                    this.totalInvites = this.calculatetotalInvites(this.tupad_invites);
                    this.totalAccepted = this.calculatetotalAccepted(this.tupad_invites);
                })
                .catch(error => {
                    console.error('Error fetching tupad slot:', error);
                });
        },
        calculatetotalAccepted(invites) {
            let total = 0;
            invites.forEach(tupad_invites => {
                if (tupad_invites.status === 'Submit by Captain') {
                    total++;
                }
            });
            return total;
        },
        calculatetotalInvites(invites) {
            let total = 0;
            invites.forEach(tupad_invites => {
                if (tupad_invites.use_code_id !== '') {
                    total++;
                }
            });
            return total;
        },
        fetchTupadCode() {
            axios
                .get("/api/dole/tupad-code-list", {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem("token")}`,
                    },
                })
                .then((response) => {
                    this.items = response.data.data;
                })
                .catch((error) => {
                    console.error("Error fetching tupad slot:", error);
                });
        },
        excelGenerate() {
            axios.post('/api/dole/generate-excel', {}, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    toastr.success("Excel Form Generated and Downloaded Successfully!");
                    this.fetchTupadCode();
                    this.fetchTupadSlot();
                    axios.get('/api/dole/get-nocode-slot', {
                            headers: {
                                Authorization: `Bearer ${localStorage.getItem('token')}`
                            }
                        })
                        .then(response => {
                            const slotIds = response.data;
                            localStorage.setItem('slot_ids', JSON.stringify(slotIds));
                            this.slotIds = slotIds;
                            this.getSlotInfo();
                            this.$forceUpdate();
                        })
                        .catch(error => {
                            console.error('Error fetching tupad slot:', error);
                        });
                })
                .catch(error => {
                    console.error('Error generating codes:', error);
                });
        },
        // async generateExcel() {
        //     try {
        //         const slotCount = await this.fetchTupadSlot();
        //         if (slotCount === 0) {
        //             toastr.error('No available slots to generate Excel');
        //             return;
        //         }
        //         const workbook = new ExcelJS.Workbook();
        //         const worksheet = workbook.addWorksheet('Captain Slots');
        //         worksheet.columns = [{
        //                 header: 'SLOT',
        //                 key: 'slot_available',
        //                 width: 6
        //             },
        //             {
        //                 header: 'FIRST NAME',
        //                 key: 'firstname',
        //                 width: 20
        //             },
        //             {
        //                 header: 'MIDDLE NAME',
        //                 key: 'middlename',
        //                 width: 20
        //             },
        //             {
        //                 header: 'LAST NAME',
        //                 key: 'lastname',
        //                 width: 20
        //             },
        //             {
        //                 header: 'CONTANCT NUMBER',
        //                 key: 'number',
        //                 width: 20
        //             },
        //             {
        //                 header: 'BIRTH DATE',
        //                 key: 'birthday',
        //                 width: 20
        //             },
        //             {
        //                 header: 'ADDRESS',
        //                 key: 'address',
        //                 width: 30
        //             },
        //             {
        //                 header: 'SITIO',
        //                 key: 'sitio',
        //                 width: 20
        //             },
        //             {
        //                 header: 'TYPE OF I.D',
        //                 key: 'type_of_id',
        //                 width: 20
        //             },
        //             {
        //                 header: 'I.D NUMBER',
        //                 key: 'id_number',
        //                 width: 20
        //             },
        //             {
        //                 header: 'SEX',
        //                 key: 'sex',
        //                 width: 10
        //             },
        //             {
        //                 header: 'CIVIL STATUS',
        //                 key: 'civil_status',
        //                 width: 15
        //             },
        //             {
        //                 header: 'AGE',
        //                 key: 'age',
        //                 width: 10
        //             },
        //             {
        //                 header: 'NAME OF BENEFICIARY',
        //                 key: 'beneficiary',
        //                 width: 30
        //             },
        //         ];
        //         let slotsAdded = 0;
        //         for (let i = 0; i < this.slots.length && slotsAdded < slotCount; i++) {
        //             const slot = this.slots[i];
        //             if (slot.status === 'No Code') {
        //                 for (let j = 0; j < slot.slot_get && slotsAdded < slotCount; j++) {
        //                     const birthday = slot.birthday ? new Date(slot.birthday) : null;
        //                     const formattedBirthday = birthday ? birthday.toLocaleDateString('en-US') : '';
        //                     worksheet.addRow({
        //                         slot_available: slotsAdded + 1,
        //                         firstname: slot.firstname || '',
        //                         middlename: slot.middlename || '',
        //                         lastname: slot.lastname || '',
        //                         number: slot.number || '',
        //                         birthday: formattedBirthday,
        //                         address: slot.address || '',
        //                         sitio: slot.sitio || '',
        //                         type_of_id: slot.type_of_id || '',
        //                         id_number: slot.id_number || '',
        //                         sex: slot.sex || '',
        //                         civil_status: slot.civil_status || '',
        //                         age: slot.age || '',
        //                         beneficiary: slot.beneficiary || '',
        //                     });
        //                     slotsAdded++;
        //                 }
        //             }
        //         }
        //         worksheet.eachRow((row, rowNumber) => {
        //             row.eachCell((cell, colNumber) => {
        //                 cell.protection = {
        //                     locked: false
        //                 };
        //             });
        //         });
        //         worksheet.getRow(1).eachCell(cell => {
        //             cell.protection = {
        //                 locked: true
        //             };
        //         });
        //         worksheet.eachRow((row, rowNumber) => {
        //             if (rowNumber > 1) {
        //                 row.getCell('A').protection = {
        //                     locked: true
        //                 };
        //                 row.eachCell((cell, colNumber) => {
        //                     if (colNumber !== 1) {
        //                         cell.protection = {
        //                             locked: false
        //                         };
        //                     }
        //                 });
        //             }
        //         });
        //         worksheet.protect('your_password_here', {
        //             selectLockedCells: true,
        //             selectUnlockedCells: true,
        //             formatCells: false,
        //             formatColumns: false,
        //             formatRows: false,
        //             insertColumns: false,
        //             insertRows: false,
        //             insertHyperlinks: false,
        //             deleteColumns: false,
        //             deleteRows: false
        //         });
        //         const buffer = await workbook.xlsx.writeBuffer();
        //         const blob = new Blob([buffer], {
        //             type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        //         });
        //         this.excelGenerate();
        //         const link = document.createElement('a');
        //         link.href = URL.createObjectURL(blob);
        //         link.download = 'tupad_form.xlsx';
        //         document.body.appendChild(link);
        //         link.click();
        //         document.body.removeChild(link);
        //     } catch (error) {
        //         console.error('Error generating Excel:', error);
        //         toastr.error('Failed to generate Excel');
        //     }
        // },
        fetchTupadSlot() {
            return new Promise((resolve, reject) => {
                axios.get('/api/dole/captain-slot-list', {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem('token')}`
                        }
                    })
                    .then(response => {
                        const slots = response.data.data;
                        this.slots = slots;
                        this.totalNoCodeSlots = this.calculateTotalNoCodeSlots(slots);
                        this.userInfo = this.getusersinfo(slots);
                        resolve(this.totalNoCodeSlots);
                        resolve(this.userInfo);
                    })
                    .catch(error => {
                        console.error('Error fetching tupad slot:', error);
                        reject(error);
                    });
            });
        },
        calculateTotalNoCodeSlots(slots) {
            let total = 0;
            slots.forEach(slot => {
                if (slot.status === 'No Code') {
                    total += slot.slot_get;
                }
            });
            return total;
        },
        getusersinfo(slots) {
            let filteredSlots = slots.filter(slot => slot.status === 'No Code');
            filteredSlots.forEach(slot => {
                if (slot.users_info) {
                    slot.users_info = {
                        firstname: slot.users_info.firstname,
                        middlename: slot.users_info.middlename,
                        lastname: slot.users_info.lastname,
                        age: slot.users_info.age,
                        sex: slot.users_info.sex,
                        birthday: slot.users_info.birthday,
                        contactnumber: slot.users_info.contactnumber,
                        province: slot.users_info.province,
                        municipality: slot.users_info.municipality,
                        barangay: slot.users_info.barangay,
                        district: slot.users_info.district
                    };
                }
            });
            console.log(filteredSlots);
            return filteredSlots;
        },
        async fetchActiveHeaders() {
            try {
                const response = await axios.get('/api/dole/get-active-header');
                if (response.status === 200) {
                    return response.data.headers;
                } else {
                    throw new Error('Failed to fetch active headers');
                }
            } catch (error) {
                console.error('Error fetching active headers:', error);
                toastr.error('Failed to fetch active headers');
                return [];
            }
        },
        async generateExcel() {
            try {
                const slotCount = await this.fetchTupadSlot();
                if (slotCount === 0) {
                    toastr.error('No available slots to generate Excel');
                    return;
                }
                const activeHeaders = await this.fetchActiveHeaders();
                const worksheetColumns = activeHeaders.map(header => ({
                    header: header.header,
                    key: header.key,
                    width: 20
                }));
                worksheetColumns.unshift({
                    header: 'SLOT',
                    key: 'slot_available',
                    width: 6
                });
                const workbook = new ExcelJS.Workbook();
                const worksheet = workbook.addWorksheet('Captain Slots');
                worksheet.columns = worksheetColumns;
                const firstSlotWithNoCode = this.slots.find(slot => slot.status === 'No Code');
                if (!firstSlotWithNoCode) {
                    toastr.error('No slots with status "No Code" found');
                    return;
                }
                const userInfo = firstSlotWithNoCode.users_info;
                const numDynamicHeaders = worksheetColumns.length;
                const parentHeaderRange = `A1:${String.fromCharCode(64 + numDynamicHeaders)}1`;
                const parentHeaderRow = worksheet.getRow(1);
                parentHeaderRow.getCell('A').value = `CAPTAIN: ${userInfo.lastname}, ${userInfo.firstname} ${userInfo.middlename} 
                CONTACT NUMBER: ${userInfo.contactnumber} 
                ADDRESS: ${userInfo.province} ${userInfo.municipality} ${userInfo.barangay} ${userInfo.district} district `;
                worksheet.mergeCells(parentHeaderRange);
                parentHeaderRow.eachCell((cell) => {
                    cell.fill = {
                        type: 'pattern',
                        pattern: 'solid',
                        fgColor: {
                            argb: 'FFFF00'
                        }
                    };
                    cell.font = {
                        bold: true
                    };
                    cell.alignment = {
                        vertical: 'middle',
                        horizontal: 'center'
                    };
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
                const headerRow = worksheet.getRow(2);
                headerRow.values = worksheetColumns.map(col => col.header);
                headerRow.eachCell((cell) => {
                    cell.fill = {
                        type: 'pattern',
                        pattern: 'solid',
                        fgColor: {
                            argb: 'FFFF00'
                        }
                    };
                    cell.font = {
                        bold: true
                    };
                    cell.alignment = {
                        vertical: 'middle',
                        horizontal: 'center'
                    };
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
                let slotsAdded = 0;
                for (let i = 0; i < this.slots.length && slotsAdded < slotCount; i++) {
                    const slot = this.slots[i];
                    if (slot.status === 'No Code') {
                        for (let j = 0; j < slot.slot_get && slotsAdded < slotCount; j++) {
                            const rowData = {};
                            worksheetColumns.forEach(column => {
                                const {
                                    key
                                } = column;
                                if (key === 'slot_available') {
                                    rowData[key] = slotsAdded + 1;
                                } else if (key === 'birthday') {
                                    const birthday = slot.birthday ? new Date(slot.birthday) : null;
                                    rowData[key] = birthday ? birthday.toLocaleDateString('en-US') : '';
                                } else {
                                    rowData[key] = slot[key] || '';
                                }
                            });
                            const row = worksheet.addRow(rowData);
                            row.eachCell((cell) => {
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
                                cell.alignment = {
                                    vertical: 'middle',
                                    horizontal: 'center'
                                };
                            });
                            slotsAdded++;
                        }
                    }
                }
                worksheet.eachRow((row, rowIndex) => {
                    row.eachCell((cell, colIndex) => {
                        const isHeaderRow = rowIndex <= 2;
                        const isSlotColumn = colIndex === 1;
                        cell.protection = {
                            locked: isHeaderRow || isSlotColumn
                        };
                    });
                });
                worksheet.protect('your_password_here', {
                    selectLockedCells: true,
                    selectUnlockedCells: true,
                    formatCells: false,
                    formatColumns: false,
                    formatRows: false,
                    insertColumns: false,
                    insertRows: false,
                    insertHyperlinks: false,
                    deleteColumns: false,
                    deleteRows: false
                });
                const buffer = await workbook.xlsx.writeBuffer();
                const blob = new Blob([buffer], {
                    type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                });
                this.excelGenerate();
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = 'tupad_form.xlsx';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } catch (error) {
                console.error('Error generating Excel:', error);
                toastr.error('Failed to generate Excel');
            }
        },
        getSlotInfo() {
            const tupadSlotId = JSON.parse(localStorage.getItem('slot_ids'));
            axios.post('/api/dole/get-captain-slot', {
                    tupad_slot_id: tupadSlotId
                }, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`,
                    },
                })
                .then(response => {
                    this.slotGet = response.data.slot_get;
                })
                .catch(error => {
                    console.error('Error fetching slot_get:', error);
                    this.$message.error('Failed to fetch slot_get value. Please try again.');
                });
        },
    },
    watch: {},

    computed: {
        isSlotIdsPresent() {
            return this.slotIds !== null && this.slotIds !== '';
        },
        isUploadDisabled() {
            const excelFiles = this.fileList.filter(file => file.type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            const imageFiles = this.fileList.filter(file => file.type.startsWith('image/'));
            const hasExcel = excelFiles.length === 1;
            const hasMultipleExcel = excelFiles.length > 1;
            const hasRequiredImages = imageFiles.length === this.slotGet;
            return !hasExcel || hasMultipleExcel || !hasRequiredImages;
        },
        tooltipMessage() {
            const excelFiles = this.fileList.filter(file => file.type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            const imageFiles = this.fileList.filter(file => file.type.startsWith('image/'));
            const excelRequired = excelFiles.length === 0 ? 1 : 0;
            const imagesRequired = this.slotGet - imageFiles.length;
            const hasMultipleExcel = excelFiles.length > 1;
            let message = '';
            if (hasMultipleExcel) {
                message = `You only need to upload 1 Excel file. Please remove the extra file(s) before you can upload.`;
            } else if (excelRequired > 0 && imagesRequired > 0) {
                message = `You still need to upload ${imagesRequired} image${imagesRequired > 1 ? 's' : ''} and ${excelRequired} Excel file.`;
            } else if (excelRequired > 0) {
                message = `You still need to upload ${excelRequired} Excel file.`;
            } else if (imagesRequired > 0) {
                message = `You still need to upload ${imagesRequired} image${imagesRequired > 1 ? 's' : ''}.`;
            }
            return message;
        }
    },
};
</script>

<style>
@media screen and (min-width: 1024px) {
    .action-column {
        position: sticky;
        right: -0.01vw;
        background-color: rgb(226, 178, 88);
        z-index: 1;
    }
}

.ant-upload-drag {
    width: 100%;
    height: 200px;
    border: 1px dashed #d9d9d9;
    border-radius: 4px;
    background-color: #fafafa;
    text-align: center;
    padding: 16px;
}
</style>
