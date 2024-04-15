<template>
<Side />

<Foot />
</template>

    
<script>
// @ is an alias to /src
import Side from '@/views/AdminViews/Home/Sidebar.vue'
import Foot from "@/views/AdminViews/Home/Footer.vue";
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net';
DataTable.use(DataTablesCore);
export default {
    components: {
        Side,
        Foot,
    },
    mounted() {
        document.title = "Home";
    },
};
</script>
