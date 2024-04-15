<template>
<Side />
<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">

        <DataTable class="display shadow-lg rounded-lg overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">First</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Second</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- Dynamically generate table rows from data array -->
                        <tr v-for="(row, index) in data" :key="index" class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">{{ row[0] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ row[1] }}</td>
                        </tr>
                    </tbody>
                </DataTable>

    </div>
</div>
<Foot />
</template>

<script>
// @ is an alias to /src
import Side from '@/views/AdminViews/Home/Sidebar.vue'
import Foot from "@/views/AdminViews/Home/Footer.vue";
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net';
import 'datatables.net-select';
import 'datatables.net-responsive';
DataTable.use(DataTablesCore);
const data = [
            [1, 2],
            [3, 4],
        ];

export default {
    components: {
        Side,
        Foot,
        DataTable
    },
    mounted() {
        document.title = "Manage Medical Request";
    },
    data() {
    return {
      data: data
    };
  }
};
</script>
