<template>
<Side />
<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
        <v-card class="bg-orange-200" flat>
            <v-card-title class="d-flex align-center pe-2 bg-orange-200">
                <v-icon icon="mdi-hospital-box-outline"></v-icon> &nbsp; Website Logo
                <v-spacer></v-spacer>
                <Button type="primary" @click="AddLogo" style="background-color: #ffd666">
                    Add Logo
                </Button>
            </v-card-title>
            <v-divider></v-divider>
            <v-data-table v-model:search="search" :items="items" :items-per-page="5">
                <template #headers="{ headers }">
                    <tr class="text-center whitespace-nowrap">
                        <th class="text-center">Image</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </template>
                <template v-slot:item="{ item } " class="bg-orange-200">
                    <tr class="h-[5vh] text-center" elevation="2">
                        <td class="whitespace-nowrap uppercase">
                            <v-img :src="getImageUrl(item.image_path)" height="60" class="my-5" alt="Image"></v-img>
                        </td>
                        <td class="whitespace-nowrap uppercase">
                            <v-chip :color="item.status === 1 ? 'green' : 'red'" :text="item.status === 1 ? 'Active' : 'Inactive'" class="text-uppercase" size="small" label></v-chip>
                        </td>
                        <td class="whitespace-nowrap uppercase">
                            <div class="mb-1">
                                <Button type="primary" class="px-5" danger @click="deleteLogo(item.id)" v-show="item.status === 0">
                                    Delete
                                </Button>
                            </div>
                            <div>
                                <Button type="primary" primary @click="ActivateLogo(item.id)" v-show="item.status === 0">
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
<div id="AddLogo" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-screen md:inset-0">
    <div class="relative p-4 sm:px-6 sm:py-8 lg:px-8 lg:py-10 w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-2xl max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Add New Logo
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="AddLogo">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form @submit.prevent="insertLogo" class="max-w-sm mx-auto mt-5 ml-10 mb-5">
                <div class="mb-5">
                    <label for="websiteLogo" class="block text-sm font-medium text-gray-900 dark:text-white">Logo</label>
                    <input type="file" required id="websiteLogo" ref="fileInput" accept="image/*" multiple @change="handleLogoUpload">
                </div>
                <div v-for="(image, index) in allImages" :key="index" class="flex flex-col items-center">
                    <img :src="image.url" @click="previewImage(image)" class="w-full h-full object-cover" style="max-width: 100px; max-height: 100px; cursor: pointer;">
                    <button @click="removeImage(index)" class="mt-1 relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-pink-500 to-orange-400 group-hover:from-pink-500 group-hover:to-orange-400 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800">
                        <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                            Remove
                        </span>
                    </button>
                </div>
                <div class="flex justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="AddLogo" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Logo</button>
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
            previewedImage: {}
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
    },
    methods: {
        AddLogo() {
            const modal = document.getElementById('AddLogo');
            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');
            // Add event listener to close modal on close button click
            modal.addEventListener('click', function (e) {
                if (e.target && e.target.closest('[data-modal-hide="AddLogo"]')) {
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
        ActivateLogo(id) {
            axios.put(`/api/utility/active-logos/${id}`, {}, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    toastr.success("Logo Updated");
                    this.fetchData();
                })
                .catch(error => {
                    if (error.response && error.response.data && error.response.data.error) {
                        toastr.error(error.response.data.error);
                    } else {
                        toastr.error("Can't Activate This Logo");
                    }
                    console.error(error.response ? error.response.data : error);
                });
        },
        fetchData() {
            axios.get('/api/utility/get-logos', {
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
        insertLogo() {
            if (this.logoImages.length !== 1) {
                console.error('Please select one image to upload');
                return;
            }
            let formData = new FormData();
            formData.append('image', this.logoImages[0].logoimage);
            console.log('FormData:', formData);
            axios.post('/api/utility/add-logos', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'Authorization': `Bearer ${localStorage.getItem('token')}`
                    }
                })
                .then(response => {
                    this.fetchData();
                    toastr.success("Uploaded Logo Successfully")
                })
                .catch(error => {
                    console.error('Error uploading logo:', error);
                });
        },
        getImageUrl(imagePath) {
            return `${axios.defaults.baseURL}${imagePath}`;
        },
        handleLogoUpload(event) {
            const files = event.target.files;
            this.logoImages = [];
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
                    const imageName = 'logo.' + fileExtension;
                    const blob = file.slice(0, file.size, file.type);
                    const newFile = new File([blob], imageName, {
                        type: file.type
                    });
                    this.logoImages.push({
                        url: imageUrl,
                        logoimage: newFile,
                        name: imageName
                    });
                };
                reader.readAsDataURL(file);
                break;
            }
        },
        removeImage(index) {
            this.logoImages.splice(index, 1);
        },
        previewImage(image) {
            if (image && image.url) {
                this.previewedImage = image;
                document.getElementById('preview-modal').classList.remove('hidden');
            } else {
                console.error('Invalid image object:', image);
            }
        },
        closePreviewModal() {
            this.previewedImage = '';
            document.getElementById('preview-modal').classList.add('hidden');
        },
    },
    computed: {
        allImages() {
            return [
                ...this.logoImages,
            ];
        }
    }
};
</script>
