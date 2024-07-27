<template>
<nav class="fixed top-0 z-50 w-full bg-white border-2 border-b-orange-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                    </svg>
                </button>
                <router-link to="#" class="flex ms-2 md:me-24">
                    <img src="../../../assets/kpms.png" class="h-8 me-3" alt="KPSM Logo" />
                    <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white hover:text-orange-500">KPSM</span>
                </router-link>
            </div>
            <div class="flex items-center">
                <div class="flex items-center ms-3">
                    <div>
                        <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                            <span class="sr-only">Open user menu</span>
                            <img class="w-8 h-8 rounded-full" src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="user photo" />
                        </button>
                    </div>
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown-user">
                        <div class="px-4 py-3" role="none">
                            <p class="text-sm text-gray-900 dark:text-white" role="none">
                                Neil Sims
                            </p>
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                                neil.sims@flowbite.com
                            </p>
                        </div>
                        <ul class="py-1" role="none">
                            <li>
                                <router-link to="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Dashboard</router-link>
                            </li>
                            <li>
                                <router-link to="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Settings</router-link>
                            </li>
                            <li>
                                <router-link to="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">Earnings</router-link>
                            </li>
                            <li>
                                <router-link to="/logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem" @click="logout">Sign out</router-link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r-orange-200 sm:translate-x-0 border-2 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            <li data-tooltip-target="dashboard" data-tooltip-placement="right">
                <router-link to="/admin" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <img width="32" height="32" src="https://img.icons8.com/external-flaticons-lineal-color-flat-icons/64/external-dashboards-productivity-flaticons-lineal-color-flat-icons.png" alt="external-dashboards-productivity-flaticons-lineal-color-flat-icons" />
                    <span class="ms-3 hover:text-orange-500">Dashboard</span>
                </router-link>
            </li>
            <div id="dashboard" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-yellow-400 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                Dashboard
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <!-- news start here -->
            <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="manage-request" data-collapse-toggle="manage-news">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512">
                    <path fill="#96A9B2" d="M223.308 219.461H25.22v253.083l.066.005c.956 15.068 13.474 26.996 28.783 26.996c13.906 0 25.511-9.839 28.24-22.935l140.999 10.039z" />
                    <path fill="#E5E4DF" d="M474.925 91.014h-1.366l-49.6-42.842v23.241l.011 19.601h-5.511l-13.962-48.905V20.448a8.655 8.655 0 0 0-8.655-8.655H82.765l.172 458.903l-.019.019c-.01 15.924-12.922 28.83-28.848 28.83h400.66c15.933 0 28.849-12.916 28.849-28.849V99.669a8.655 8.655 0 0 0-8.654-8.655" />
                    <path fill="#96A9B2" d="M431.531 200.87H134.358v-8.655h297.173zm0 256.587H134.358v8.655h297.173zM177.632 53.691h-43.273v8.655h43.273z" />
                    <path fill="#BFBCAF" d="M290.716 297.353H134.358v-17.309h156.358zm.059 25.964H134.417v17.309h156.358zm0 43.273H134.417v17.309h156.358zm0 43.273H134.417v17.309h156.358zm140.816 0H316.74v17.309h114.851z" />
                    <path fill="#597B91" d="M376.688 91.616v35.219h-.061c-.313 4.494-4.019 8.054-8.593 8.054h-225.02c-4.573 0-8.28-3.56-8.594-8.054h-.061V91.616a8.655 8.655 0 0 1 8.655-8.655h225.021a8.653 8.653 0 0 1 8.653 8.655M142.81 254.08h139.515a8.45 8.45 0 0 0 8.451-8.451v-17.716a8.45 8.45 0 0 0-8.451-8.451H142.81a8.45 8.45 0 0 0-8.451 8.451v17.716a8.45 8.45 0 0 0 8.451 8.451m288.781-25.966a8.654 8.654 0 0 0-8.654-8.652l-.014.001l-.001-.001h-97.549l-.001.001a8.654 8.654 0 0 0-8.631 8.651v147.131a8.653 8.653 0 0 0 8.631 8.653l.001.001h97.549l.001-.001l.014.001a8.655 8.655 0 0 0 8.655-8.655z" />
                    <path fill="#BFBCAF" d="M482.646 95.787h-80.199V14.971l78.464 78.463z" /></svg>
                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap hover:text-orange-500">News/Announcement</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                </svg>
            </button>
            <ul id="manage-news" class="hidden py-2 space-y-2">
                <li data-tooltip-target="News/Announcement" data-tooltip-placement="right">
                    <router-link to="/add-news" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" id="add-news">
                            <circle cx="23" cy="9" r="7" fill="#f4a261"></circle>
                            <path fill="#264653" d="M25.9 9.6h-1.7V7a2.81 2.81 0 0 0-2.8-2.8H7.9A2.81 2.81 0 0 0 5.1 7v11.7a1 1 0 0 0 2 0V7a.8.8 0 0 1 .8-.8h13.5a.8.8 0 0 1 .8.8v17.55a3.28 3.28 0 0 0 .25 1.25H9.7a1 1 0 0 0 0 2h15.75a3.26 3.26 0 0 0 3.25-3.25V12.4a2.81 2.81 0 0 0-2.8-2.8Zm.8 15a1.25 1.25 0 0 1-2.5 0v-13h1.7a.8.8 0 0 1 .8.8Z"></path>
                            <path fill="#264653" d="M9.7 25.1a1 1 0 0 0 0-2H8v-1.7a1 1 0 0 0-2 0v1.7H4.3a1 1 0 0 0 0 2H6v1.7a1 1 0 0 0 2 0v-1.7zm9.9-13.5a1 1 0 0 0 0-2h-7.2a1 1 0 0 0 0 2zM8.7 14.2a1 1 0 0 0 1 1h9.9a1 1 0 0 0 0-2H9.7a1 1 0 0 0-1 1z"></path>
                        </svg>
                        <span>Post</span>
                        <!-- <span data-modal-target="default-modal" data-modal-toggle="default-modal" class="flex-1 ms-3 whitespace-nowrap hover:text-orange-500">Post News/Announcement</span> -->
                    </router-link>
                </li>
                <div id="News/Announcement" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-yellow-400 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    Post new News or Announcement
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
                <li data-tooltip-target="Modify-News" data-tooltip-placement="right">
                    <router-link to="/all-news" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="32" height="32" viewBox="0 0 64 64">
                            <path fill="#cda1a7" d="M51,25h8a2,2,0,0,1,2,2V53a6,6,0,0,1-6,6h0a6,6,0,0,1-6-6V27a2,2,0,0,1,2-2Z"></path>
                            <path fill="#faefde" d="M52,59H11a6,6,0,0,1-6-6V8A3,3,0,0,1,8,5H46a3,3,0,0,1,3,3V56Z"></path>
                            <rect width="44" height="4" x="5" y="5" fill="#fff7f0" rx="2" ry="2"></rect>
                            <path fill="#efd8be" d="M49,49H5v4a6,6,0,0,0,6,6H52l-3-3Z"></path>
                            <path fill="#eb9697" d="M33 14h6a1 1 0 0 0 0-2H33a1 1 0 0 0 0 2zM13 14H29a1 1 0 0 0 0-2H13a1 1 0 0 0 0 2zM23 16H13a1 1 0 0 0 0 2H23a1 1 0 0 0 0-2z"></path>
                            <path fill="#8d6c9f" d="M23 24H13a1 1 0 0 0 0 2H23a1 1 0 0 0 0-2zM23 28H13a1 1 0 0 0 0 2H23a1 1 0 0 0 0-2zM23 32H13a1 1 0 0 0 0 2H23a1 1 0 0 0 0-2zM23 36H13a1 1 0 0 0 0 2H23a1 1 0 0 0 0-2zM23 40H13a1 1 0 0 0 0 2H23a1 1 0 0 0 0-2zM39 24H29a1 1 0 0 0 0 2H39a1 1 0 0 0 0-2zM39 28H29a1 1 0 0 0 0 2H39a1 1 0 0 0 0-2zM39 32H29a1 1 0 0 0 0 2H39a1 1 0 0 0 0-2zM40 37a1 1 0 0 0-1-1H29a1 1 0 0 0 0 2H39A1 1 0 0 0 40 37z"></path>
                            <path fill="#eb9697" d="M40,17a1,1,0,0,0-1-1H27a1,1,0,0,0,0,2H39A1,1,0,0,0,40,17Z"></path>
                            <path fill="#8d6c9f" d="M45,48H41a1,1,0,0,0,0,2h4a1,1,0,0,0,0-2Z"></path>
                            <path fill="#8d6c9f" d="M58,24H50V7a3,3,0,0,0-3-3H7A3,3,0,0,0,4,7V53a7,7,0,0,0,7,7H55a7,7,0,0,0,7-7V28A4,4,0,0,0,58,24ZM11,58a5,5,0,0,1-5-5V50H37a1,1,0,0,0,0-2H6V7A1,1,0,0,1,7,6H47a1,1,0,0,1,1,1V53a7,7,0,0,0,2,5Zm49-5a5,5,0,0,1-5,5,4.84,4.84,0,0,1-5-5V26h4.56A4,4,0,0,0,54,28V45a1,1,0,0,0,2,0V28a2,2,0,0,1,4,0Z"></path>
                            <path fill="#8d6c9f" d="M10 52a1 1 0 0 0-1 1v2a1 1 0 0 0 2 0V53A1 1 0 0 0 10 52zM15 52a1 1 0 0 0-1 1v2a1 1 0 0 0 2 0V53A1 1 0 0 0 15 52zM20 52a1 1 0 0 0-1 1v2a1 1 0 0 0 2 0V53A1 1 0 0 0 20 52zM25 52a1 1 0 0 0-1 1v2a1 1 0 0 0 2 0V53A1 1 0 0 0 25 52zM30 52a1 1 0 0 0-1 1v2a1 1 0 0 0 2 0V53A1 1 0 0 0 30 52zM35 52a1 1 0 0 0-1 1v2a1 1 0 0 0 2 0V53A1 1 0 0 0 35 52zM40 52a1 1 0 0 0-1 1v2a1 1 0 0 0 2 0V53A1 1 0 0 0 40 52zM45 52a1 1 0 0 0-1 1v2a1 1 0 0 0 2 0V53A1 1 0 0 0 45 52z"></path>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap hover:text-orange-500">Modify</span>
                    </router-link>
                </li>
                <div id="Modify-News" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-yellow-400 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    Modify New's or Announcements
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
            </ul>
            <!-- end news -->
            <li>
                <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="manage-request" data-collapse-toggle="manage-request">
                    <img width="32" height="32" src="https://img.icons8.com/nolan/96/ask-question.png" alt="ask-question" />
                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap hover:text-orange-500">Medical</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <ul id="manage-request" class="hidden py-2 space-y-2">
                    <li data-tooltip-target="Medical" data-tooltip-placement="right">
                        <router-link to="/manage-medical-request" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512">
                                <path fill="#AFC1C9" d="M483.114 208.091H149.055c-7.953 0-14.4 6.447-14.4 14.4v80.147H34.069c-7.953 0-14.4 6.447-14.4 14.4V482.6c0 7.953 6.447 14.4 14.4 14.4h449.046c7.953 0 14.4-6.447 14.4-14.4V222.491c-.001-7.953-6.449-14.4-14.401-14.4" />
                                <path fill="#95AAAD" d="M498.737 188.996H214.701a7.2 7.2 0 0 0-7.2 7.2v16.99a8.505 8.505 0 0 0 8.505 8.505h281.427a8.505 8.505 0 0 0 8.505-8.505v-16.99a7.201 7.201 0 0 0-7.201-7.2M18.445 279.932h284.037a7.2 7.2 0 0 1 7.2 7.2v16.99a8.505 8.505 0 0 1-8.505 8.505H19.75a8.505 8.505 0 0 1-8.505-8.505v-16.99a7.2 7.2 0 0 1 7.2-7.2" />
                                <path fill="#CFDBE2" d="M316.414 30.003H58.699c-4.162 0-7.536 3.994-7.536 8.92V488.08c0 4.926 3.374 8.92 7.536 8.92h257.715c4.162 0 7.536-3.994 7.536-8.92V38.923c0-4.926-3.374-8.92-7.536-8.92" />
                                <path fill="#FF473E" d="M234.917 113.538h-33.14v-33.14a7.2 7.2 0 0 0-7.2-7.2h-14.04a7.2 7.2 0 0 0-7.2 7.2v33.14h-33.14a7.2 7.2 0 0 0-7.2 7.2v14.04a7.2 7.2 0 0 0 7.2 7.2h33.14v33.14a7.2 7.2 0 0 0 7.2 7.2h14.04a7.2 7.2 0 0 0 7.2-7.2v-33.14h33.14a7.2 7.2 0 0 0 7.2-7.2v-14.04a7.2 7.2 0 0 0-7.2-7.2" />
                                <path fill="#0096D1" d="M463.893 368.367H358.115a7.2 7.2 0 0 1-7.2-7.2v-42.429a7.2 7.2 0 0 1 7.2-7.2h105.779a7.2 7.2 0 0 1 7.2 7.2v42.429a7.201 7.201 0 0 1-7.201 7.2m8.439 81.968v-42.429a7.2 7.2 0 0 0-7.2-7.2H356.876a7.2 7.2 0 0 0-7.2 7.2v42.429a7.2 7.2 0 0 0 7.2 7.2h108.256a7.2 7.2 0 0 0 7.2-7.2m0-181.17V255.15a7.2 7.2 0 0 0-7.2-7.2H356.876a7.2 7.2 0 0 0-7.2 7.2v14.015a7.2 7.2 0 0 0 7.2 7.2h108.256a7.2 7.2 0 0 0 7.2-7.2" />
                                <path fill="#2B3B47" d="M100.843 421.106H274.27V497H100.843z" />
                                <path fill="#00B1FF" d="M205.639 368.367h-35.71a7.2 7.2 0 0 1-7.2-7.2v-44.863a7.2 7.2 0 0 1 7.2-7.2h35.71a7.2 7.2 0 0 1 7.2 7.2v44.863a7.2 7.2 0 0 1-7.2 7.2m85.161-7.2v-44.863a7.2 7.2 0 0 0-7.2-7.2h-35.71a7.2 7.2 0 0 0-7.2 7.2v44.863a7.2 7.2 0 0 0 7.2 7.2h35.71a7.2 7.2 0 0 0 7.2-7.2m-155.921 0v-44.863a7.2 7.2 0 0 0-7.2-7.2h-35.71a7.2 7.2 0 0 0-7.2 7.2v44.863a7.2 7.2 0 0 0 7.2 7.2h35.71a7.2 7.2 0 0 0 7.2-7.2m-19.774-92.002v-44.863a7.2 7.2 0 0 0-7.2-7.2H91.969a7.2 7.2 0 0 0-7.2 7.2v44.863a7.2 7.2 0 0 0 7.2 7.2h15.936a7.2 7.2 0 0 0 7.2-7.2m58.565 0v-44.863a7.2 7.2 0 0 0-7.2-7.2h-15.936a7.2 7.2 0 0 0-7.2 7.2v44.863a7.2 7.2 0 0 0 7.2 7.2h15.936a7.2 7.2 0 0 0 7.2-7.2m58.565 0v-44.863a7.2 7.2 0 0 0-7.2-7.2h-15.936a7.2 7.2 0 0 0-7.2 7.2v44.863a7.2 7.2 0 0 0 7.2 7.2h15.936a7.2 7.2 0 0 0 7.2-7.2m58.565 0v-44.863a7.2 7.2 0 0 0-7.2-7.2h-15.936a7.2 7.2 0 0 0-7.2 7.2v44.863a7.2 7.2 0 0 0 7.2 7.2H283.6a7.2 7.2 0 0 0 7.2-7.2" />
                                <path fill="#67747C" d="M274.27 429.12H100.843v-8.22c0-5.442 4.412-9.854 9.854-9.854h153.718c5.442 0 9.854 4.412 9.854 9.854z" />
                                <path fill="#95AAAD" d="M329.803 20.062H45.766a7.2 7.2 0 0 0-7.2 7.2v16.99a8.505 8.505 0 0 0 8.505 8.505h281.427a8.505 8.505 0 0 0 8.505-8.505v-16.99a7.2 7.2 0 0 0-7.2-7.2" /></svg>
                            <span class="flex-1 ms-3 whitespace-nowrap hover:text-orange-500">Medical</span>
                        </router-link>
                    </li>
                    <div id="Medical" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-yellow-400 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Manage Medical Assistance
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </ul>
            </li>
            <li>
                <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="educational-assitance" data-collapse-toggle="educational-assitance">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                        <g fill="none">
                            <rect width="30" height="22" x="1" y="8" fill="#B4ACBC" rx="1.5" />
                            <rect width="28" height="18" x="2" y="10" fill="#CDC4D6" rx="1" />
                            <path fill="#E1D8EC" d="m30 26.4l-12.971-7.783a2 2 0 0 0-2.058 0L2 26.4V28a1 1 0 0 0 1 1h26a1 1 0 0 0 1-1z" />
                            <path fill="#998EA4" d="M2 12.766V11h28v1.766L17.544 20.24a3 3 0 0 1-3.088 0z" />
                            <path fill="#F3EEF8" d="M2 11.6V10a1 1 0 0 1 1-1h26a1 1 0 0 1 1 1v1.6l-12.971 7.783a2 2 0 0 1-2.058 0z" />
                            <path fill="#F92F60" d="M18.94 3.47v7.1c0 .16.13.28.28.28h.98c.62 0 .95.74.53 1.2l-4.01 4.41a.72.72 0 0 1-1.06 0l-4.02-4.41a.718.718 0 0 1 .53-1.2h.98c.16 0 .28-.13.28-.28v-7.1c0-.26.21-.47.47-.47h4.58c.25 0 .46.21.46.47" />
                        </g>
                    </svg>
                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap hover:text-orange-500">Educational</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <ul id="educational-assitance" class="hidden py-2 space-y-2">
                    <li data-tooltip-target="Education" data-tooltip-placement="right">
                        <router-link to="/manage-scholarship" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 64 64">
                                <path fill="#86a7ac" d="M31.791 24.612v38.919c0 .32.227.589.491.589h31.473c.265 0 .487-.269.487-.589V24.613a.604.604 0 0 0-.132-.402s-.011-.006-.011-.001c0 0-.001-.012-.02-.018a.405.405 0 0 0-.325-.16H32.279c-.263 0-.49.271-.49.59" />
                                <path fill="#6c888c" d="M51.856 34.411h3.98c.033 0 .064-.036.064-.071v-4.502c0-.039-.031-.069-.064-.069h-3.98s-.035.008-.045.021v.004c-.008.014-.018.025-.018.043v4.502c0 .037.028.072.063.072m0 7.579h3.98c.033 0 .064-.035.064-.07v-4.502c0-.04-.031-.069-.064-.069h-3.98s-.035.008-.045.022v.004c-.008.014-.018.025-.018.043v4.502c0 .034.028.07.063.07m6.644-7.579h3.981c.028 0 .062-.036.062-.071v-4.502c0-.039-.033-.069-.062-.069H58.5s-.035.008-.046.021v.004c-.008.014-.016.025-.016.043v4.502c0 .037.027.072.062.072m0 7.579h3.981c.028 0 .062-.035.062-.07v-4.502c0-.04-.033-.069-.062-.069H58.5s-.035.008-.046.022v.004c-.008.014-.016.025-.016.043v4.502c0 .034.027.07.062.07m-6.644 6.532h3.98c.033 0 .064-.036.064-.071v-4.502a.067.067 0 0 0-.064-.068h-3.98s-.035.008-.045.021v.004c-.008.014-.018.025-.018.043v4.502c0 .035.028.071.063.071m0 7.579h3.98c.033 0 .064-.035.064-.07v-4.502c0-.04-.031-.069-.064-.069h-3.98s-.035.008-.045.021v.004c-.008.015-.018.026-.018.044v4.502c0 .035.028.07.063.07m6.644-7.579h3.981c.028 0 .062-.036.062-.071v-4.502c0-.039-.033-.068-.062-.068H58.5s-.035.008-.046.021v.004c-.008.014-.016.025-.016.043v4.502c0 .035.027.071.062.071m0 7.579h3.981c.028 0 .062-.035.062-.07v-4.502c0-.04-.033-.069-.062-.069H58.5s-.035.008-.046.021v.004c-.008.015-.016.026-.016.044v4.502c0 .035.027.07.062.07" />
                                <path fill="#86a7ac" d="M14.871 24.612v38.919c0 .32.225.589.488.589h31.477c.263 0 .485-.269.485-.589V24.613a.598.598 0 0 0-.132-.402l-.008-.006s-.013-.016-.022-.022a.401.401 0 0 0-.323-.16H15.361c-.262 0-.487.271-.487.59" />
                                <path fill="#6c888c" d="M34.935 34.411h3.98c.031 0 .064-.036.064-.071v-4.502c0-.039-.033-.069-.064-.069h-3.98s-.037.008-.045.021v.004c-.008.014-.018.025-.018.043v4.502c0 .037.025.072.063.072m0 7.579h3.98c.031 0 .064-.035.064-.07v-4.502c0-.04-.033-.069-.064-.069h-3.98s-.037.008-.045.022v.004c-.008.014-.018.025-.018.043v4.502c0 .034.025.07.063.07m6.643-7.579h3.981c.032 0 .063-.036.063-.071v-4.502c0-.039-.031-.069-.063-.069h-3.981a.057.057 0 0 0-.045.021v.004c-.009.014-.017.025-.017.043v4.502c0 .037.027.072.062.072m0 7.579h3.981c.032 0 .063-.035.063-.07v-4.502c0-.04-.031-.069-.063-.069h-3.981a.055.055 0 0 0-.045.022v.004c-.009.014-.017.025-.017.043v4.502c0 .034.027.07.062.07m-6.643 6.532h3.98c.031 0 .064-.036.064-.071v-4.502c0-.039-.033-.068-.064-.068h-3.98s-.037.008-.045.021v.004c-.008.014-.018.025-.018.043v4.502c0 .035.025.071.063.071m0 7.579h3.98c.031 0 .064-.035.064-.07v-4.502c0-.04-.033-.069-.064-.069h-3.98s-.037.008-.045.021v.004c-.008.015-.018.026-.018.044v4.502c0 .035.025.07.063.07m6.643-7.579h3.981c.032 0 .063-.036.063-.071v-4.502c0-.039-.031-.068-.063-.068h-3.981a.057.057 0 0 0-.045.021v.004c-.009.014-.017.025-.017.043v4.502c0 .035.027.071.062.071m0 7.579h3.981c.032 0 .063-.035.063-.07v-4.502c0-.04-.031-.069-.063-.069h-3.981a.057.057 0 0 0-.045.021v.004c-.009.015-.017.026-.017.044v4.502c0 .035.027.07.062.07" />
                                <path fill="#a2c3cb" d="M0 8.265V63.24c0 .456.258.833.562.833h36.145c.305 0 .561-.377.561-.833V8.265c0-.247-.059-.437-.149-.568l-.017-.016c0-.014-.008-.016-.02-.023a.438.438 0 0 0-.375-.226H.562c-.304 0-.562.379-.562.833" />
                                <path fill="#405967" d="M13.62 64.094h10.247c.079 0 .154-.051.154-.116v-7.362c0-.063-.075-.112-.154-.112H13.62a.167.167 0 0 0-.107.033l-.006.004h-.004c-.016.021-.042.048-.042.075v7.362c0 .065.076.116.159.116" />
                                <g fill="#86a7ac">
                                    <path d="M14.897 60.452h1.78s.027-.017.027-.032v-2.012l-.027-.031h-1.8v.002l-.008.012v2.02c0 .014 0 .031.028.031M2.43 37.202h32.841c.257 0 .52-.045.52-.089V31.48c0-.049-.263-.086-.52-.086H2.43c-.13 0-.286 0-.365.027v.004c-.063.018-.13.034-.13.055v5.632c0 .045.209.09.495.09m-.022 9.48h31.475c.251 0 .5-.045.5-.089V40.96c0-.049-.249-.086-.5-.086H2.408c-.128 0-.278.001-.351.027v.006c-.062.016-.125.031-.125.053v5.633c0 .044.197.089.476.089" />
                                    <path d="M10.322 37.218h4.979c.042 0 .079-.045.079-.089v-5.632c0-.049-.038-.087-.079-.087h-4.98c-.023 0-.047 0-.057.027v.004c0 .018-.02.033-.02.055v5.632c0 .044.03.09.078.09m0 9.484h4.979c.042 0 .079-.045.079-.088v-5.633c0-.05-.038-.087-.079-.087h-4.98c-.023 0-.047 0-.057.027v.006c0 .016-.02.031-.02.054v5.633c0 .043.03.088.078.088m19.898-9.484h4.981c.036 0 .079-.045.079-.089v-5.632c0-.049-.043-.087-.079-.087H30.22c-.02 0-.043 0-.056.027v.004c0 .018-.02.033-.02.055v5.632c0 .044.033.09.076.09m0 9.484h4.981c.036 0 .079-.045.079-.088v-5.633c0-.05-.043-.087-.079-.087H30.22c-.02 0-.043 0-.056.027v.006s-.02.031-.02.054v5.633c0 .043.033.088.076.088m-8.258-9.484h4.981c.042 0 .081-.045.081-.089v-5.632c0-.049-.04-.087-.081-.087h-4.981c-.02 0-.043.001-.055.027v.004c-.008.018-.02.033-.02.055v5.632c0 .044.032.09.075.09m0 9.484h4.981c.042 0 .081-.045.081-.088v-5.633c0-.05-.04-.087-.081-.087h-4.981c-.02 0-.043.001-.055.027v.006c-.008.016-.02.031-.02.054v5.633c0 .043.032.088.075.088m-1.229 13.75h1.78s.027-.017.027-.032v-2.012l-.016-.031h-1.792l-.018.004l-.004.008l-.006.012v2.02c0 .014.011.031.029.031" />
                                </g>
                                <path fill="#dfe6eb" d="M28.21 19.408c0 5.289-4.291 9.576-9.58 9.576a9.576 9.576 0 0 1-9.576-9.576A9.575 9.575 0 0 1 18.63 9.83c5.289 0 9.58 4.287 9.58 9.578" />
                                <path fill="#d0d6d9" d="M25.2 24.308c-5.292 0-9.582-4.287-9.582-9.576c0-1.758.487-3.402 1.311-4.819c-4.453.825-7.83 4.721-7.83 9.41c0 5.291 4.291 9.578 9.58 9.578c3.531 0 6.606-1.917 8.268-4.761a9.432 9.432 0 0 1-1.747.168" />
                                <path fill="#97a8b3" d="M18.635 9.07c-5.7 0-10.34 4.638-10.34 10.338c0 5.7 4.64 10.337 10.34 10.337s10.334-4.638 10.334-10.337c0-5.7-4.635-10.338-10.334-10.338m0 18.663c-4.594 0-8.329-3.736-8.329-8.325c0-4.591 3.734-8.327 8.329-8.327c4.589 0 8.323 3.736 8.323 8.327c0 4.588-3.734 8.325-8.323 8.325" />
                                <path fill="#84929b" d="M19.241 26.18c0 .463-.272.841-.614.841c-.335 0-.608-.377-.608-.841v-6.813c0-.466.272-.841.608-.841c.341 0 .614.375.614.841z" />
                                <path fill="#788187" d="M20.322 14.283c.205-.417.62-.632.92-.484c.302.15.381.61.173 1.026l-2.188 4.417c-.206.417-.618.632-.92.483c-.302-.148-.379-.61-.171-1.024z" />
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap hover:text-orange-500">Educational Assistance</span>
                        </router-link>
                    </li>
                    <div id="Education" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-yellow-400 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Manage Educational Assistance
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    <li data-tooltip-target="SG" data-tooltip-placement="right">
                        <router-link to="/manage-smart-grant" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <img width="32" height="32" src="https://img.icons8.com/stickers/100/school--v1.png" alt="school--v1" />
                            <span class="flex-1 ms-3 whitespace-nowrap hover:text-orange-500">Smart Grant</span>
                        </router-link>
                    </li>
                    <div id="SG" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-yellow-400 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Manage Smart Grant
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    <li data-tooltip-target="TD" data-tooltip-placement="right">
                        <router-link to="/manage-tulong-dunong" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <img width="32" height="32" src="https://img.icons8.com/dusk/64/school.png" alt="school" />
                            <span class="flex-1 ms-3 whitespace-nowrap hover:text-orange-500">Tulong Dunong</span>
                        </router-link>
                    </li>
                    <div id="TD" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-yellow-400 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Manage Tulong Dunong
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </ul>
            </li>
            <li>
                <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="manage-dole" data-collapse-toggle="manage-dole">
                    <img src="../../../assets/dole.png" class="h-8 me-3" alt="KPSM Logo" />
                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap hover:text-orange-500">Dole</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <ul id="manage-dole" class="hidden py-2 space-y-2">
                    <li data-tooltip-target="Tupad" data-tooltip-placement="right">
                        <router-link to="/manage-tupad" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <img src="../../../assets/tupad.jpg" class="h-8 me-3" alt="KPSM Logo" />
                            <span class="flex-1 ms-3 whitespace-nowrap hover:text-orange-500">Tupad</span>
                            <span class="inline-flex items-center justify-center px-2 ms-3 text-sm font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300">Pro</span>
                        </router-link>
                    </li>
                    <div id="Tupad" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-yellow-400 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Manage Tupad
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    <!-- <li data-tooltip-target="GIP" data-tooltip-placement="right">
                        <router-link to="/gip" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <img src="../../../assets/gip.jpg" class="h-8 me-3" alt="KPSM Logo" />
                            <span class="flex-1 ms-3 whitespace-nowrap hover:text-orange-500">GIP</span>
                        </router-link>
                    </li>
                    <div id="GIP" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-yellow-400 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Manage GIP
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div> -->
                </ul>
            </li>
            <li data-tooltip-target="Emails" data-tooltip-placement="right">
                <router-link to="/manage-emails" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512">
                        <path fill="#96A9B2" d="M465.624 390.73c2.375-4.033-140.634-133.403-140.634-133.403c-17.984-15.829-29.211-16.078-53.943 0c0 0-199.388 129.266-198.819 133.244l-.041.029c.01.035.034.058.05.09c.589 3.992 1.91 7.668 3.859 10.884c.832 1.373 1.944 2.523 2.995 3.719l-.075.049c.084.093.214.136.298.229c4.476 4.962 10.787 8.176 18.379 9.093c.119.015.203.078.322.093h.47c1.16.113 2.224.398 3.438.398h323.456c15.927 0 31.615-10.016 40.049-24.057c.087-.105.202-.18.284-.287z" />
                        <path fill="#B9C5C6" d="M301.505 242.48L73.339 389.467l45.592-208.232c4.444-20.296 24.496-36.747 44.792-36.747h318.472c20.296 0 33.145 16.45 28.701 36.747l-45.592 208.232z" />
                        <path fill="#EDECE6" d="m124.015 168.458l138.552 131.427c17.707 15.585 28.761 15.831 53.112 0l195.795-131.219c-1.748-5.254-5.179-9.405-9.416-12.715l2.693-1.801c-4.491-5.105-10.935-8.416-18.706-9.27l-326.329.011c-8.12.843-16.028 4.165-22.74 9.259l1.892 1.778c-5.621 3.266-10.813 7.345-14.853 12.53" />
                        <path fill="#DCE2E2" d="M123.9 168.734c-2.339 3.971 138.467 131.347 138.467 131.347c17.707 15.585 28.761 15.831 53.112 0c0 0 196.315-127.274 195.755-131.19l.041-.029c-.01-.034-.033-.057-.049-.089c-.58-3.931-1.88-7.549-3.799-10.717c-.819-1.352-1.914-2.484-2.949-3.662l.074-.049c-.083-.091-.211-.134-.294-.226c-4.407-4.885-10.621-8.05-18.095-8.953c-.117-.014-.2-.077-.317-.091h-.463c-1.142-.111-2.19-.392-3.385-.392H163.525c-15.682 0-31.128 9.862-39.431 23.686c-.085.103-.199.177-.279.283z" />
                        <path fill="#59CAFC" d="M94.447 208.62H14.44c-6.627 0-12-5.373-12-12s5.373-12 12-12h80.007c6.627 0 12 5.373 12 12s-5.372 12-12 12m-13.108 70.236c0-6.627-5.373-12-12-12H14.44c-6.627 0-12 5.373-12 12s5.373 12 12 12h54.899c6.628 0 12-5.373 12-12m-18.215 82.237c0-6.627-5.373-12-12-12H14.44c-6.627 0-12 5.373-12 12s5.373 12 12 12h36.684c6.627 0 12-5.373 12-12" />
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap hover:text-orange-500">Emails</span>
                    <!-- <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">3</span> -->
                </router-link>
            </li>
            <div id="Emails" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-yellow-400 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                Emails
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <li v-show="this.information.type === 'superadmin'" data-tooltip-target="Budget-Allocation" data-tooltip-placement="right">
                <router-link to="/manage-budget" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 20 20">
                        <g fill="#888888" fill-rule="evenodd" clip-rule="evenodd">
                            <g opacity=".2">
                                <path d="M11.5 4h-5V2h5a5 5 0 0 1 5 5v1a5 5 0 0 1-5 5h-5v-2h5a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3" />
                                <path d="M6.5 2a1 1 0 0 1 1 1v15.5a1 1 0 1 1-2 0V3a1 1 0 0 1 1-1" />
                                <path d="M2.5 5.936a1 1 0 0 1 1-1h14a1 1 0 1 1 0 2h-14a1 1 0 0 1-1-1m0 3a1 1 0 0 1 1-1h14a1 1 0 1 1 0 2h-14a1 1 0 0 1-1-1" />
                            </g>
                            <path d="M10.5 2.5h-5v-1h5A4.5 4.5 0 0 1 15 6v1a4.5 4.5 0 0 1-4.5 4.5h-5v-1h5A3.5 3.5 0 0 0 14 7V6a3.5 3.5 0 0 0-3.5-3.5" />
                            <path d="M5.5 1.5A.5.5 0 0 1 6 2v15.5a.5.5 0 0 1-1 0V2a.5.5 0 0 1 .5-.5" />
                            <path d="M2 4.936a.5.5 0 0 1 .5-.5h14a.5.5 0 0 1 0 1h-14a.5.5 0 0 1-.5-.5m0 3a.5.5 0 0 1 .5-.5h14a.5.5 0 0 1 0 1h-14a.5.5 0 0 1-.5-.5" />
                        </g>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap hover:text-orange-500">Budget Allocation</span>
                </router-link>
            </li>
            <div id="Budget-Allocation" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-yellow-400 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                Manage Budget Allocation
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <li>
                <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="utility" data-collapse-toggle="utility">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 48 48">
                        <circle cx="24" cy="24" r="3.97" fill="none" stroke="orange" stroke-linecap="round" stroke-linejoin="round" />
                        <path fill="none" stroke="orange" stroke-linecap="round" stroke-linejoin="round" d="M34.89 30.29V17.71L24 11.43l-10.89 6.28v12.58L24 36.57z" />
                        <path fill="none" stroke="orange" stroke-linecap="round" stroke-linejoin="round" d="M41.61 21.3c.58-.92.97-2 1.1-3.2c.32-3.08-1.43-6.11-4.26-7.36c-1.1-.49-2.23-.69-3.33-.64c-1.97.09-3.79-1.09-4.73-2.83c-.49-.9-1.19-1.72-2.11-2.39c-2.52-1.84-6.05-1.84-8.57 0c-.92.67-1.61 1.49-2.11 2.39c-.94 1.74-2.76 2.92-4.73 2.83c-1.09-.05-2.23.15-3.33.64C6.72 12 4.96 15.03 5.28 18.1c.12 1.19.51 2.27 1.1 3.19a5.1 5.1 0 0 1 0 5.4c-.58.92-.97 2-1.1 3.2c-.32 3.07 1.43 6.11 4.26 7.36c1.1.49 2.23.69 3.33.64c1.97-.09 3.79 1.09 4.73 2.83c.49.9 1.19 1.72 2.11 2.39c2.52 1.84 6.05 1.84 8.57 0c.92-.67 1.62-1.49 2.11-2.39c.94-1.74 2.76-2.92 4.73-2.83c1.09.05 2.23-.15 3.33-.64c2.83-1.26 4.58-4.29 4.26-7.36a7.3 7.3 0 0 0-1.1-3.2a5.1 5.1 0 0 1 0-5.4Z" /></svg>
                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap hover:text-orange-500">Utilities</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <ul id="utility" class="hidden py-2 space-y-2">
                    <li data-tooltip-target="logo" data-tooltip-placement="right">
                        <router-link to="/manage-logo" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="32" height="32" viewBox="0 0 48 48">
                                <radialGradient id="52OGP6ofDoPraLbQHhywRa_kzOUpp1wcsyz_gr1" cx="48.477" cy="36.475" r="22.942" gradientUnits="userSpaceOnUse">
                                    <stop offset="0" stop-color="#ffcf7b"></stop>
                                    <stop offset=".195" stop-color="#fecd76"></stop>
                                    <stop offset=".439" stop-color="#fac666"></stop>
                                    <stop offset=".71" stop-color="#f3bc4d"></stop>
                                    <stop offset=".997" stop-color="#eaad29"></stop>
                                    <stop offset="1" stop-color="#eaad29"></stop>
                                </radialGradient>
                                <path fill="url(#52OGP6ofDoPraLbQHhywRa_kzOUpp1wcsyz_gr1)" d="M40,6H8C6.895,6,6,6.895,6,8v32c0,1.105,0.895,2,2,2h32c1.105,0,2-0.895,2-2V8	C42,6.895,41.105,6,40,6z"></path>
                                <path fill="#d6742d" d="M32.065,23.065c-1.149-1.149-3.005-1.174-4.185-0.057L18,32.368V42h22c1.105,0,2-0.895,2-2v-7	L32.065,23.065z"></path>
                                <circle cx="30.5" cy="14.5" r="3.5" fill="#fff8de"></circle>
                                <linearGradient id="52OGP6ofDoPraLbQHhywRb_kzOUpp1wcsyz_gr2" x1="23.91" x2="23.91" y1="18.133" y2="42.415" gradientUnits="userSpaceOnUse">
                                    <stop offset="0" stop-color="#c26715"></stop>
                                    <stop offset=".508" stop-color="#b85515"></stop>
                                    <stop offset="1" stop-color="#ad3f16"></stop>
                                </linearGradient>
                                <path fill="url(#52OGP6ofDoPraLbQHhywRb_kzOUpp1wcsyz_gr2)" d="M8,42h32c0.811,0,1.507-0.485,1.82-1.18L20.065,19.065c-1.149-1.149-3.005-1.174-4.185-0.057	L6,28.368V40C6,41.105,6.895,42,8,42z"></path>
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap hover:text-orange-500">Logo</span>
                            <span class="inline-flex items-center justify-center px-2 ms-3 text-sm font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300">Pro</span>
                        </router-link>
                    </li>
                    <div id="logo" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-yellow-400 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Manage Website Logo
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    <li data-tooltip-target="Amount" data-tooltip-placement="right">
                        <router-link to="/manage-educational-amount" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <img width="32" height="32" src="https://img.icons8.com/ultraviolet/80/peso-symbol.png" alt="peso-symbol" />
                            <span class="flex-1 ms-3 whitespace-nowrap hover:text-orange-500">Educational Amount</span>
                        </router-link>
                    </li>
                    <div id="Amount" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-yellow-400 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Manage Educational Amount
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    <li data-tooltip-target="Hospital-Manage" data-tooltip-placement="right">
                        <router-link to="/manage-hospital" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 48 48">
                                <path fill="#45413c" d="M3.5 45.5a20.5 1.5 0 1 0 41 0a20.5 1.5 0 1 0-41 0" opacity=".15" />
                                <path fill="#8ca4b8" d="M4 15h40v3H4Z" />
                                <path fill="#adc4d9" d="M43 15H5a1 1 0 0 0-1 1v1a1 1 0 0 0 0 .25a1 1 0 0 1 1-.75h38a1 1 0 0 1 1 .75a1 1 0 0 0 0-.25v-1a1 1 0 0 0-1-1" />
                                <path fill="none" stroke="#45413c" stroke-linecap="round" stroke-linejoin="round" d="M4 15h40v3H4Z" />
                                <path fill="#fff" d="M5 18h38v25.5a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1z" />
                                <path fill="#e0e0e0" d="M5 18h38v2.25H5z" />
                                <path fill="none" stroke="#45413c" stroke-linecap="round" stroke-linejoin="round" d="M5 18h38v25.5a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1z" />
                                <path fill="#fff" d="M13.5 12.5h21v32h-21z" />
                                <path fill="#e0e0e0" d="M13.5 12.5h21v1.79h-21z" />
                                <path fill="none" stroke="#45413c" stroke-linecap="round" stroke-linejoin="round" d="M13.5 12.5h21v32h-21z" />
                                <path fill="#00b8f0" d="M18 33.5h12v11H18z" />
                                <path fill="#4acfff" d="M20.44 44.5h5.2L30 33.93v-.43h-5.03z" />
                                <path fill="none" stroke="#45413c" stroke-linecap="round" stroke-linejoin="round" d="M18 33.5h12v11H18z" />
                                <path fill="#8ca4b8" d="M17 30h14v3.5H17Z" />
                                <path fill="#adc4d9" d="M30 30H18a1 1 0 0 0-1 1v1.5a.53.53 0 0 0 0 .12a1 1 0 0 1 1-.87h12a1 1 0 0 1 1 .87a.53.53 0 0 0 0-.12V31a1 1 0 0 0-1-1" />
                                <path fill="none" stroke="#45413c" stroke-linecap="round" stroke-linejoin="round" d="M17 30h14v3.5H17Z" />
                                <path fill="#8ca4b8" d="M12.5 9.5h23v3h-23Z" />
                                <path fill="#adc4d9" d="M34.5 9.5h-21a1 1 0 0 0-1 1v1a1 1 0 0 0 .05.25a1 1 0 0 1 .95-.75h21a1 1 0 0 1 1 .75a1 1 0 0 0 0-.25v-1a1 1 0 0 0-1-1" />
                                <path fill="none" stroke="#45413c" stroke-linecap="round" stroke-linejoin="round" d="M12.5 9.5h23v3h-23Z" />
                                <path fill="#ff6242" stroke="#45413c" stroke-linecap="round" stroke-linejoin="round" d="M27.5 19H26a.5.5 0 0 1-.5-.5V17a.5.5 0 0 0-.5-.5h-2a.5.5 0 0 0-.5.5v1.5a.5.5 0 0 1-.5.5h-1.5a.5.5 0 0 0-.5.5v2a.5.5 0 0 0 .5.5H22a.5.5 0 0 1 .5.5V24a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-1.5a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 0-.5-.5" />
                                <path fill="#00b8f0" d="M8 20.5h2.5V25H8Z" />
                                <path fill="#4acfff" d="M8.5 25H10a.5.5 0 0 0 .5-.5V21a.5.5 0 0 0-.11-.3l-2.22 4.17a.49.49 0 0 0 .33.13" />
                                <path fill="#00b8f0" d="M8 27.5h2.5V32H8Z" />
                                <path fill="#4acfff" d="M8.5 32H10a.5.5 0 0 0 .5-.5V28a.5.5 0 0 0-.11-.3l-2.22 4.17a.49.49 0 0 0 .33.13" />
                                <path fill="#00b8f0" d="M8 34.5h2.5V39H8Z" />
                                <path fill="#4acfff" d="M8.5 39H10a.5.5 0 0 0 .5-.5V35a.5.5 0 0 0-.11-.3l-2.22 4.17a.49.49 0 0 0 .33.13" />
                                <path fill="none" stroke="#45413c" stroke-linecap="round" stroke-linejoin="round" d="M8 20.5h2.5V25H8Zm0 7h2.5V32H8Zm0 7h2.5V39H8Z" />
                                <path fill="#00b8f0" d="M37.5 20.5H40V25h-2.5Z" />
                                <path fill="#4acfff" d="M38 25h1.5a.5.5 0 0 0 .5-.5V21a.5.5 0 0 0-.11-.3l-2.22 4.17A.49.49 0 0 0 38 25" />
                                <path fill="#00b8f0" d="M37.5 27.5H40V32h-2.5Z" />
                                <path fill="#4acfff" d="M38 32h1.5a.5.5 0 0 0 .5-.5V28a.5.5 0 0 0-.11-.3l-2.22 4.17A.49.49 0 0 0 38 32" />
                                <path fill="#00b8f0" d="M37.5 34.5H40V39h-2.5Z" />
                                <path fill="#4acfff" d="M38 39h1.5a.5.5 0 0 0 .5-.5V35a.5.5 0 0 0-.11-.3l-2.22 4.17A.49.49 0 0 0 38 39" />
                                <path fill="none" stroke="#45413c" stroke-linecap="round" stroke-linejoin="round" d="M37.5 20.5H40V25h-2.5Zm0 7H40V32h-2.5Zm0 7H40V39h-2.5Zm-13.5-1v11" /></svg>
                            <span class="flex-1 ms-3 whitespace-nowrap hover:text-orange-500">Hospitals</span>
                        </router-link>
                    </li>
                    <div id="Hospital-Manage" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-yellow-400 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Manage Hospital
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    <li data-tooltip-target="Hospital-Offer" data-tooltip-placement="right">
                        <router-link to="/hospital-request" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 64 64">
                                <path fill="#e8e8e8" d="M40 18H14c-2.2 0-4 1.8-4 4v38h34V22c0-2.2-1.8-4-4-4" />
                                <path fill="#62727a" d="M60 36H26c-1.1 0-2 .9-2 2v22h38V38c0-1.1-.9-2-2-2M7 36c-.6 0-1.2.4-1.6.8l-2.9 4.3c-.3.5-.5 1.4-.5 1.9v17h8V36z" />
                                <path fill="#b4d7ee" d="M12 53h10v7H12z" />
                                <path fill="#62727a" d="M63 60H1c-.6 0-1 .5-1 1v2c0 .6.4 1 1 1h62c.5 0 1-.4 1-1v-2c0-.5-.5-1-1-1" />
                                <path fill="#b4d7ee" d="M14 34.5c0 .3-.2.5-.5.5h-1c-.3 0-.5-.2-.5-.5v-5c0-.3.2-.5.5-.5h1c.3 0 .5.2.5.5zm4 0c0 .3-.2.5-.5.5h-1c-.3 0-.5-.2-.5-.5v-5c0-.3.2-.5.5-.5h1c.3 0 .5.2.5.5zm4 0c0 .3-.2.5-.5.5h-1c-.3 0-.5-.2-.5-.5v-5c0-.3.2-.5.5-.5h1c.3 0 .5.2.5.5zm4 0c0 .3-.2.5-.5.5h-1c-.3 0-.5-.2-.5-.5v-5c0-.3.2-.5.5-.5h1c.3 0 .5.2.5.5zm4 0c0 .3-.2.5-.5.5h-1c-.3 0-.5-.2-.5-.5v-5c0-.3.2-.5.5-.5h1c.3 0 .5.2.5.5zm-16 8c0 .3-.2.5-.5.5h-1c-.3 0-.5-.2-.5-.5v-5c0-.3.2-.5.5-.5h1c.3 0 .5.2.5.5zm4 0c0 .3-.2.5-.5.5h-1c-.3 0-.5-.2-.5-.5v-5c0-.3.2-.5.5-.5h1c.3 0 .5.2.5.5zm4 0c0 .3-.2.5-.5.5h-1c-.3 0-.5-.2-.5-.5v-5c0-.3.2-.5.5-.5h1c.3 0 .5.2.5.5zm-8 8c0 .3-.2.5-.5.5h-1c-.3 0-.5-.2-.5-.5v-5c0-.3.2-.5.5-.5h1c.3 0 .5.2.5.5zm4 0c0 .3-.2.5-.5.5h-1c-.3 0-.5-.2-.5-.5v-5c0-.3.2-.5.5-.5h1c.3 0 .5.2.5.5zm4 0c0 .3-.2.5-.5.5h-1c-.3 0-.5-.2-.5-.5v-5c0-.3.2-.5.5-.5h1c.3 0 .5.2.5.5zM32 44h30v16H32zM7 46.5c0 .3-.2.5-.5.5h-1c-.3 0-.5-.2-.5-.5v-5c0-.3.2-.5.5-.5h1c.3 0 .5.2.5.5zm0 9c0 .3-.2.5-.5.5h-1c-.3 0-.5-.2-.5-.5v-5c0-.3.2-.5.5-.5h1c.3 0 .5.2.5.5z" />
                                <g fill="#fff">
                                    <path d="M21 53h-9v7h1v-6h3.5v6h1v-6H21v6h1v-7z" />
                                    <path d="M17.5 56h-1c-.3 0-.5.2-.5.5v1c0 .3.2.5.5.5h1c.3 0 .5-.2.5-.5v-1c0-.3-.2-.5-.5-.5" />
                                </g>
                                <path fill="#b2c1c0" d="M13 60h8v2h-8z" />
                                <path fill="#e8e8e8" d="M13 62h8v2h-8z" />
                                <path fill="#fff" d="M33 44h29v-2H31c-.5 0-1 .5-1 1v17h2v-3c0-.5.5-1 1-1h29v-2H33c-.5 0-1-.4-1-1v-2c0-.5.5-1 1-1h29v-2H33c-.5 0-1-.5-1-1v-2c0-.5.5-1 1-1" />
                                <path fill="#b4d7ee" d="M14 26.5c0 .3-.2.5-.5.5h-1c-.3 0-.5-.2-.5-.5v-5c0-.3.2-.5.5-.5h1c.3 0 .5.2.5.5zm4 0c0 .3-.2.5-.5.5h-1c-.3 0-.5-.2-.5-.5v-5c0-.3.2-.5.5-.5h1c.3 0 .5.2.5.5zm4 0c0 .3-.2.5-.5.5h-1c-.3 0-.5-.2-.5-.5v-5c0-.3.2-.5.5-.5h1c.3 0 .5.2.5.5zm4 0c0 .3-.2.5-.5.5h-1c-.3 0-.5-.2-.5-.5v-5c0-.3.2-.5.5-.5h1c.3 0 .5.2.5.5zm4 0c0 .3-.2.5-.5.5h-1c-.3 0-.5-.2-.5-.5v-5c0-.3.2-.5.5-.5h1c.3 0 .5.2.5.5zm4 8c0 .3-.2.5-.5.5h-1c-.3 0-.5-.2-.5-.5v-5c0-.3.2-.5.5-.5h1c.3 0 .5.2.5.5zm0-8c0 .3-.2.5-.5.5h-1c-.3 0-.5-.2-.5-.5v-5c0-.3.2-.5.5-.5h1c.3 0 .5.2.5.5zm4 8c0 .3-.2.5-.5.5h-1c-.3 0-.5-.2-.5-.5v-5c0-.3.2-.5.5-.5h1c.3 0 .5.2.5.5zm0-8c0 .3-.2.5-.5.5h-1c-.3 0-.5-.2-.5-.5v-5c0-.3.2-.5.5-.5h1c.3 0 .5.2.5.5zm4 8c0 .3-.2.5-.5.5h-1c-.3 0-.5-.2-.5-.5v-5c0-.3.2-.5.5-.5h1c.3 0 .5.2.5.5zm0-8c0 .3-.2.5-.5.5h-1c-.3 0-.5-.2-.5-.5v-5c0-.3.2-.5.5-.5h1c.3 0 .5.2.5.5z" />
                                <path fill="#b2c1c0" d="M19 8h16v10H19z" />
                                <circle cx="27" cy="8" r="8" fill="#e8e8e8" />
                                <path fill="#f15744" d="M32 6h-3V3c0-.5-.5-1-1-1h-2c-.5 0-1 .5-1 1v3h-3c-.5 0-1 .4-1 1v2c0 .6.5 1 1 1h3v3c0 .6.5 1 1 1h2c.5 0 1-.4 1-1v-3h3c.5 0 1-.4 1-1V7c0-.6-.5-1-1-1" />
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap hover:text-orange-500">Hospital Offers</span>
                        </router-link>
                    </li>
                    <div id="Hospital-Offer" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-yellow-400 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Manage Hospital Offers
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    <li data-tooltip-target="tupad-header" data-tooltip-placement="right">
                        <router-link to="/manage-tupad-headers" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                                <defs>
                                    <linearGradient id="vscodeIconsFileTypeExcel0" x1="4.494" x2="13.832" y1="-2092.086" y2="-2075.914" gradientTransform="translate(0 2100)" gradientUnits="userSpaceOnUse">
                                        <stop offset="0" stop-color="#18884f" />
                                        <stop offset=".5" stop-color="#117e43" />
                                        <stop offset="1" stop-color="#0b6631" />
                                    </linearGradient>
                                </defs>
                                <path fill="#185c37" d="M19.581 15.35L8.512 13.4v14.409A1.19 1.19 0 0 0 9.705 29h19.1A1.19 1.19 0 0 0 30 27.809V22.5Z" />
                                <path fill="#21a366" d="M19.581 3H9.705a1.19 1.19 0 0 0-1.193 1.191V9.5L19.581 16l5.861 1.95L30 16V9.5Z" />
                                <path fill="#107c41" d="M8.512 9.5h11.069V16H8.512Z" />
                                <path d="M16.434 8.2H8.512v16.25h7.922a1.2 1.2 0 0 0 1.194-1.191V9.391A1.2 1.2 0 0 0 16.434 8.2" opacity=".1" />
                                <path d="M15.783 8.85H8.512V25.1h7.271a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191" opacity=".2" />
                                <path d="M15.783 8.85H8.512V23.8h7.271a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191" opacity=".2" />
                                <path d="M15.132 8.85h-6.62V23.8h6.62a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191" opacity=".2" />
                                <path fill="url(#vscodeIconsFileTypeExcel0)" d="M3.194 8.85h11.938a1.193 1.193 0 0 1 1.194 1.191v11.918a1.193 1.193 0 0 1-1.194 1.191H3.194A1.19 1.19 0 0 1 2 21.959V10.041A1.19 1.19 0 0 1 3.194 8.85" />
                                <path fill="#fff" d="m5.7 19.873l2.511-3.884l-2.3-3.862h1.847L9.013 14.6c.116.234.2.408.238.524h.017q.123-.281.26-.546l1.342-2.447h1.7l-2.359 3.84l2.419 3.905h-1.809l-1.45-2.711A2.4 2.4 0 0 1 9.2 16.8h-.024a1.7 1.7 0 0 1-.168.351l-1.493 2.722Z" />
                                <path fill="#33c481" d="M28.806 3h-9.225v6.5H30V4.191A1.19 1.19 0 0 0 28.806 3" />
                                <path fill="#107c41" d="M19.581 16H30v6.5H19.581Z" />
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap hover:text-orange-500">Tupad Excel Header</span>
                            <!-- <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">3</span> -->
                        </router-link>
                    </li>
                    <div id="tupad-header" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-yellow-400 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Manage Tupad Excel Headers
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </ul>
            </li>
            <li v-show="this.information.type === 'admin'" data-tooltip-target="Add-Account" data-tooltip-placement="right">
                <router-link to="/register-admin" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                        <path fill="#888888" d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12c5.16-1.26 9-6.45 9-12V5Zm0 3.9a3 3 0 1 1-3 3a3 3 0 0 1 3-3m0 7.9c2 0 6 1.09 6 3.08a7.2 7.2 0 0 1-12 0c0-1.99 4-3.08 6-3.08" /></svg>
                    <span class="flex-1 ms-3 whitespace-nowrap hover:text-orange-500">New Admin Account</span>
                </router-link>
            </li>
            <div id="Add-Account" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-yellow-400 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                Add New Admin Account
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
            <li v-show="this.information.type === 'superadmin'" data-tooltip-target="Add-Account" data-tooltip-placement="right">
                <router-link to="/register-superadmin" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                        <path fill="#888888" d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12c5.16-1.26 9-6.45 9-12V5Zm0 3.9a3 3 0 1 1-3 3a3 3 0 0 1 3-3m0 7.9c2 0 6 1.09 6 3.08a7.2 7.2 0 0 1-12 0c0-1.99 4-3.08 6-3.08" /></svg>
                    <span class="flex-1 ms-3 whitespace-nowrap hover:text-orange-500">New Superadmin Account</span>
                </router-link>
            </li>
            <div id="Add-Account" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-yellow-400 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                Add New Superadmin Account
                <div class="tooltip-arrow" data-popper-arrow></div>
            </div>
        </ul>
    </div>
</aside>
<!-- Main modal -->
<div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Terms of Service
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                    With less than a month to go before the European Union enacts new consumer privacy laws for its citizens, companies around the world are updating their terms of service agreements to comply.
                </p>
                <!-- <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                    The European Union’s General Data Protection Regulation (G.D.P.R.) goes into effect on May 25 and is meant to ensure a common set of data rights in the European Union. It requires organizations to notify users as soon as possible of high-risk data breaches that could personally affect them.
                </p> -->
                <!-- <img alt="Vue logo" src="./assets/logo.png"> -->
                <!-- <editor
                api-key="tjh6y7k4ssd8bp02fmeohr8mpccvozf6f0b9pab6qbxqkkte"
                :init="{
                height: 500,
                menubar: false,
                plugins: [
                    'a11ychecker','advlist','advcode','advtable','autolink','checklist','export',
                    'lists','link','image','charmap','preview','anchor','searchreplace','visualblocks',
                    'powerpaste','fullscreen','formatpainter','insertdatetime','media','table','help','wordcount'
                ],
                toolbar:
                    'undo redo | casechange blocks | bold italic backcolor | \
                    alignleft aligncenter alignright alignjustify | \
                    bullist numlst checklist outdent indent | removeformat | a11ycheck code table image uploadImage help',
                image_upload_url: '/upload/image' // Specify the URL for image upload
                }"
                initial-value="Enter your news / announcement content here"
                v-model="editorContent"
            /> -->
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button data-modal-hide="default-modal" @click="postDataToBackend" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">I accept</button>
                <!-- <button data-modal-hide="default-modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">I accept</button> -->
                <button data-modal-hide="default-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Decline</button>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import Editor from '@tinymce/tinymce-vue'
import axios from '../../../main.js'
import {
    initFlowbite
} from 'flowbite'
export default {
    data() {
        return {
            editorContent: '',
            information: [],
        };
    },
    components: {
        'editor': Editor
    },
    mounted() {
        initFlowbite();
        this.token = localStorage.getItem('token');
        if (this.token) {
            this.isLoggedIn = true;
            this.getUser();
        }
    },
    methods: {

        async postDataToBackend() {
            try {
                const response = await axios.post('/api/post-news', {
                    body: this.editorContent
                });
                console.log(response);
            } catch (error) {
                console.log('error', error);
            }
        },

        getUser() {
            const config = {
                headers: {
                    Authorization: `Bearer ${this.token}`
                }
            };
            axios.get('/api/getuser', config)
                .then(response => {
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
        logout() {
            localStorage.removeItem('token');
            this.isLoggedIn = false;
            this.$router.push('/');
        }
    }
};
</script>
