<template>
<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="flex flex-wrap items-center justify-between max-w-screen-xl mx-auto p-4">
        <router-link to="/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img :src="logoUrl" class="h-8" alt="Flowbite Logo" />
            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">KPSM</span>
        </router-link>
        <div class="flex items-center md:order-2 space-x-1 md:space-x-2 rtl:space-x-reverse mt-4">

            <div v-if="isLoggedIn">
                <button id="dropdownAvatarNameButton" data-dropdown-toggle="dropdownAvatarName" class="flex items-center text-sm pe-1 font-medium text-gray-900 rounded-full hover:text-blue-600 dark:hover:text-blue-500 md:me-0 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-white" type="button">
                    <span class="sr-only">Open user menu</span>
                    <img class="w-12 h-12 rounded-full" src="../../../assets/kpms.png" alt="user photo">
                    <p>{{ information.name }}</p>
                </button>
                <!-- Dropdown menu -->
                <div id="dropdownAvatarName" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                    <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                        <div class="font-medium ">{{ information.type }}</div>
                        <div class="truncate">{{ information.email }}</div>
                    </div>
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownInformdropdownAvatarNameButtonationButton">
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Earnings</a>
                        </li>
                    </ul>
                    <div class="py-2">
                        <router-link to="/logout" class="text-gray-800 dark:text-white hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 md:px-5 md:py-2.5 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800" @click="logout">
                            Logout
                        </router-link>

                    </div>
                </div>

                <!-- Display other user info here -->
            </div>
            <div v-else>
                <!-- login -->

                <router-link v-if="!isLoggedIn" to="/login" class="text-white bg-orange-500 mr-1 dark:text-white hover:bg-orange-700 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2 md:px-5 md:py-2.5 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">
                    Login
                </router-link>
                <router-link v-if="!isLoggedIn" to="/register" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 md:px-5 md:py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Sign up
                </router-link>

            </div>

            <button data-collapse-toggle="mega-menu" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="mega-menu" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
        </div>
        <div id="mega-menu" class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1">
            <ul class="flex flex-col mt-4 font-medium md:flex-row md:mt-0 md:space-x-7 rtl:space-x-reverse">
                <li>
                    <router-link to="/" class="block py-2 px-3 text-black border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 md:p-0 dark:text-blue-500 md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-gray-700" aria-current="page">Home</router-link>
                </li>
                <li>
                    <button id="mega-menu-dropdown-button" data-dropdown-toggle="mega-menu-dropdown" class="flex items-center justify-between w-full py-2 px-3 font-medium text-black border-b border-gray-100 md:w-auto hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-gray-700">
                        Assistance
                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <div id="mega-menu-dropdown" class="absolute z-10 grid hidden w-auto grid-cols-2 text-sm bg-white border border-gray-100 rounded-lg shadow-md dark:border-gray-700 md:grid-cols-3 dark:bg-gray-700">
                        <div class="p-4 pb-0 text-black md:pb-4 dark:text-white">
                            <ul class="space-y-4" aria-labelledby="mega-menu-dropdown-button">
                                <li>
                                    <router-link to="/medical-request" class="text-gray-500 dark:text-gray-400  hover:text-orange-700  dark:hover:text-blue-500">
                                        Medical Assistance
                                    </router-link>
                                </li>
                                <li>
                                    <router-link to="/scholarship" class="text-gray-500 dark:text-gray-400  hover:text-orange-700  dark:hover:text-blue-500">
                                        Scholarship
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                        <div class="p-4 pb-0 text-black md:pb-4 dark:text-white">
                            <ul class="space-y-4">
                                <li></li>
                            </ul>
                        </div>
                        <div class="p-4">
                            <ul class="space-y-4">
                                <li></li>
                            </ul>
                        </div>
                    </div>
                </li>
                <li>
                    <router-link to="/medical-request" class="block py-2 px-3 text-black border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-gray-700">Dole Tupad</router-link>
                </li>
                <li>
                    <a href="#" class="block py-2 px-3 text-black border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-gray-700">KPSM Update</a>
                </li>
                <li>
                    <a href="#" class="block py-2 px-3 text-black border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-gray-700">Announcement</a>

                </li>
            </ul>
        </div>
    </div>
</nav>
</template>

<script>
import axios from '../../../main.js'; // use main.js instead of axios para magamit yung base.url at sa axios e hindi na ilalagay doamin ng backend api link nalang

export default {
    data() {
        return {
            isLoggedIn: false,
            token: '',
            information: [],
            logoUrl: ''
        };
    },
    mounted() {
        this.fetchActiveLogos();
        this.token = localStorage.getItem('token');
        if (this.token) {
            this.isLoggedIn = true;
            this.getUser();
        }
    },
    methods: {
        getUser() {
            const config = {
                headers: {
                    Authorization: `Bearer ${this.token}`
                }
            };
            axios.get('/api/getuser', config)
                .then(response => {
                    console.log('User Data:', response.data);
                    this.information = response.data.user;
                })
                .catch(error => {
                    console.error('Error retrieving user data:', error);
                    if (error.response) {
                        console.error('Response status:', error.response.status);
                        console.error('Response data:', error.response.data);
                    } else if (error.request) {
                        console.error('Request made but no response received:', error.request);
                    } else {
                        console.error('Error setting up request:', error.message);
                    }
                });
        },
        fetchActiveLogos() {
            axios.get('/api/active-logos')
                .then(response => {
                    if (response.data && response.data.image_url) {
                        this.logoUrl = axios.defaults.baseURL + response.data.image_url;
                    } else {
                        console.error('Invalid response data:', response.data);
                    }
                })
                .catch(error => {
                    console.error('Error fetching active logos:', error);
                });
        },
        logout() {
            localStorage.removeItem('token');
            this.isLoggedIn = false;
            this.$router.push('/');
        }
    },
};
</script>
