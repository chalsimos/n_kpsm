
<template>
<nav class="fixed top-0 z-50 w-full bg-white border-b-2 border-orange-200 dark:bg-gray-800 dark:border-gray-700 ">
    <div class="flex flex-wrap items-center justify-between max-w-screen-xl mx-auto p-4">
        <router-link to="/" class="flex items-center space-x-3 rtl:space-x-reverse mr-1">
            <img :src="logoUrl" class="h-8" alt="Flowbite Logo" />
            <span class="self-center text-2xl font-semibold whitespace-nowrap hover:text-orange-400 dark:text-white">KPSM</span>
        </router-link>
        <div class="flex items-center md:order-2 space-x-1 md:space-x-2 rtl:space-x-reverse md:mt-3 ">

            <div v-show="isLoggedIn">
                <button id="dropdownAvatarNameButton" data-dropdown-toggle="dropdownAvatarName" class="flex items-center text-sm pe-1 font-medium text-gray-900 rounded-full md:me-0 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-white" type="button">
                    <span class="sr-only">Open user menu</span>
                    <img class="w-12 h-12 rounded-full" src="../../../assets/kpms.png" alt="user photo">
                    <p class="hover:text-orange-400">{{ information.name }}</p>
                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <!-- Dropdown menu -->
                <div id="dropdownAvatarName" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                    <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                        <div class="font-medium ">{{ information.type }}</div>
                        <div class="truncate">{{ information.email }}</div>
                    </div>
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownInformdropdownAvatarNameButtonationButton">
                        <li>
                            <a href="#" class="block px-4 py-2 hover:text-orange-300 dark:hover:bg-gray-600 dark:hover:text-white">privacy</a>
                        </li>
                        <li>
                            <a href="#" data-modal-target="default-modal" data-modal-toggle="default-modal" class="block px-4 py-2 hover:text-orange-300 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 hover:text-orange-300 dark:hover:bg-gray-600 dark:hover:text-white">Earnings</a>
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
            <div>
                <!-- login -->

                <router-link v-show="!isLoggedIn" to="/login" class="text-white bg-orange-500 mr-1 dark:text-white hover:bg-orange-700 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-2  py-2 md:px-5 md:py-2.5 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">
                    Login
                </router-link>
                <router-link v-show="!isLoggedIn" to="/register" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-2 md:px-5 md:py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
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
                    <router-link to="/" class="block py-2 px-3 border-b border-gray-100 hover:text-orange-300 md:hover:bg-transparent md:border-0 md:hover:text-orange-400 md:p-0 dark:text-blue-500 md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-gray-700 test-class" aria-current="page">Home</router-link>
                </li>
                <li>
                    <button id="mega-menu-dropdown-button" data-dropdown-toggle="mega-menu-dropdown" class="flex items-center justify-between w-full py-2 px-3 font-medium border-b border-gray-100 md:w-auto hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-orange-400 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-gray-700">
                        Assistance
                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <div id="mega-menu-dropdown" class="absolute z-10 grid hidden w-auto grid-cols-2 text-sm bg-white border border-gray-100 rounded-lg shadow-md dark:border-gray-700 md:grid-cols-3 dark:bg-gray-700">
                        <div class="p-4 pb-0 text-black md:pb-4 dark:text-white">
                            <ul class="space-y-4" aria-labelledby="mega-menu-dropdown-button">
                                <li>
                                    <router-link to="/medical-request" class="text-gray-500 dark:text-gray-400  hover:text-orange-400  dark:hover:text-blue-500">
                                        Medical Assistance
                                    </router-link>
                                    <!-- Pag ganito ang gamit e hindi na kailangan magrefresh para gumana yung mga dropdown, etc. -->
                                    <!-- <a :href="$router.resolve({name: 'Medical Request'}).href" class="text-gray-500 dark:text-gray-400  hover:text-orange-400  dark:hover:text-blue-500">Medical Assistance</a> -->
                                </li>
                                <li>
                                    <router-link to="/scholarship" class="text-gray-500 dark:text-gray-400  hover:text-orange-400  dark:hover:text-blue-500">
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
                <li  v-show="this.information.type === 'captain'">
                    <button id="mega-menu-dropdown-button-dole" data-dropdown-toggle="mega-menu-dropdown-dole" class="flex items-center justify-between w-full py-2 px-3 font-medium border-b border-gray-100 md:w-auto hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-orange-400 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-gray-700">
                        Dole
                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <div id="mega-menu-dropdown-dole" class="absolute z-10 grid hidden w-auto grid-cols-2 text-sm bg-white border border-gray-100 rounded-lg shadow-md dark:border-gray-700 md:grid-cols-3 dark:bg-gray-700">
                        <div class="p-4 pb-0 text-black md:pb-4 dark:text-white">
                            <ul class="space-y-4" aria-labelledby="mega-menu-dropdown-button-dole">
                                <li>
                                    <router-link to="/tupad" class="text-gray-500 dark:text-gray-400  hover:text-orange-400  dark:hover:text-blue-500">
                                        Tupad
                                    </router-link>
                                </li>
                                <li>
                                    <router-link to="/gip" class="text-gray-500 dark:text-gray-400  hover:text-orange-400  dark:hover:text-blue-500">
                                        GIP
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
                    <a href="#" class="block py-2 px-3 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-orange-400 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-gray-700">KPSM Update</a>
                </li>
                <li>
                    <a href="#" class="block py-2 px-3 border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-orange-400 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-gray-700">Announcement</a>

                </li>
            </ul>
        </div>
    </div>
</nav>
<div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Account Panel
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->

            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="account-tab" data-tabs-target="#account" type="button" role="tab" aria-controls="account" aria-selected="false">Account</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="privacy-tab" data-tabs-target="#privacy" type="button" role="tab" aria-controls="privacy" aria-selected="false">privacy</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="security-tab" data-tabs-target="#security" type="button" role="tab" aria-controls="security" aria-selected="false">Security and Permission</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="request-tab" data-tabs-target="#request" type="button" role="tab" aria-controls="request" aria-selected="false">Request</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="notification-tab" data-tabs-target="#notification" type="button" role="tab" aria-controls="notification" aria-selected="false">Notification</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="ac-tab" data-tabs-target="#ac" type="button" role="tab" aria-controls="ac" aria-selected="false">Account Center</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="language-tab" data-tabs-target="#language" type="button" role="tab" aria-controls="language" aria-selected="false">Language</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="help-tab" data-tabs-target="#help" type="button" role="tab" aria-controls="help" aria-selected="false">help</button>
                    </li>
                </ul>
            </div>
            <div id="default-tab-content">
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="account" role="tabpanel" aria-labelledby="account-tab">
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ information.name }} <br></p>
                    <ul class="w-90 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-900 dark:border-gray-600 dark:text-white">
                        <li class="w-full px-4 py-2 border-b border-gray-200 rounded-t-lg dark:border-gray-600">Account Information</li>
                        <li class="w-full px-4 py-2 border-b border-gray-200 rounded-t-lg dark:border-gray-600">Password</li>
                        <li class="w-full px-4 py-2 border-b border-gray-200 rounded-t-lg dark:border-gray-600">Deactivate or Delete account</li>
                    </ul>
                </div>
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="privacy" role="tabpanel" aria-labelledby="privacy-tab">
                    <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Profile tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
                </div>
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="security" role="tabpanel" aria-labelledby="security-tab">
                    <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Profile tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
                </div>
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="request" role="tabpanel" aria-labelledby="request-tab">
                    <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Profile tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
                </div>
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="notification" role="tabpanel" aria-labelledby="notification-tab">
                    <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Profile tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
                </div>
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="ac" role="tabpanel" aria-labelledby="ac-tab">
                    <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Profile tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
                </div>
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="language" role="tabpanel" aria-labelledby="language-tab">
                    <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Profile tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
                </div>
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="help" role="tabpanel" aria-labelledby="help-tab">
                    <p class="text-sm text-gray-500 dark:text-gray-400">This is some placeholder content the <strong class="font-medium text-gray-800 dark:text-white">Profile tab's associated content</strong>. Clicking another tab will toggle the visibility of this one for the next. The tab JavaScript swaps classes to control the content visibility and styling.</p>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <!-- <button data-modal-hide="default-modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">I accept</button> -->
                <button data-modal-hide="default-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Decline</button>
            </div>
        </div>
    </div>
</div>
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
    computed: {
  },
    methods: {
        async getNews(){
            const news = await axios.get('api/admin/ge-news',{
                
            })
        },
        getUser() {
            const config = {
                headers: {
                    Authorization: `Bearer ${this.token}`
                }
            };
            axios.get('/api/getuser', config)
                .then(response => {
                    // console.log('User Data:', response.data);
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
