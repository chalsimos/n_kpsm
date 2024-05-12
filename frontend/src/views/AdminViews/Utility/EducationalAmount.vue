
<template>
    <Side />
    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
            
        </div>
    </div>
    </template>
    
    <script>
    import {
        Modal,
        Tooltip,
        initTWE
    } from "tw-elements";
    import {
    } from "ant-design-vue";
    
    import {
        initFlowbite
    } from 'flowbite'
    // @ is an alias to /src
    import Side from '@/views/AdminViews/Home/Sidebar.vue'
    import Foot from "@/views/AdminViews/Home/Footer.vue";
    
    export default {
        components: {
            Side,
            Foot,
        },
        mounted() {
        initTWE({
            Modal,
            Tooltip
        });
        initFlowbite();
            document.title = "Manage Educational Amount";
        },
    };
    </script>
    