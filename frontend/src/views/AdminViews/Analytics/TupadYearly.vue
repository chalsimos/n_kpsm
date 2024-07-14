<template>
<div>
    <div class="flex justify-center">
        <div class="w-full py-10 bg-gray-50 dark:bg-gray-800 rounded px-4">
            <div class="collapse-wrapper">
                <a-collapse accordion>
                    <a-collapse-panel v-for="year in yearsData" :key="year.year" :header="`Year: ${year.year} - Total: ${year.total_per_year}`">
                        <a-collapse accordion>
                            <a-collapse-panel v-for="month in year.months" :key="month.month" :header="`Month: ${month.month} - Total: ${month.total_per_month}`">
                                <a-collapse accordion>
                                    <a-collapse-panel v-for="municipality in month.municipalities" :key="municipality.municipality" :header="`Municipality: ${municipality.municipality} - Total: ${municipality.total_per_municipality}`">
                                        <a-collapse accordion>
                                            <a-collapse-panel v-for="barangay in municipality.barangays" :key="barangay.barangay" :header="`Barangay: ${barangay.barangay} - Total: ${barangay.total_per_barangay}`">
                                                <a-table :columns="columns" :dataSource="barangay.details" rowKey="id" :scroll="{ x: 'max-content' }" />
                                            </a-collapse-panel>
                                        </a-collapse>
                                    </a-collapse-panel>
                                </a-collapse>
                            </a-collapse-panel>
                        </a-collapse>
                    </a-collapse-panel>
                </a-collapse>
            </div>
        </div>
    </div>
</div>
</template>

  
<script>
import {
    defineComponent,
    h
} from 'vue';
import {
    Collapse,
    Input,
    Button,
    Space,
    Table
} from 'ant-design-vue';
import {
    SearchOutlined
} from '@ant-design/icons-vue';
import axios from "../../../main.js";

export default defineComponent({
    components: {
        'a-collapse': Collapse,
        'a-collapse-panel': Collapse.Panel,
        'a-input': Input,
        'a-button': Button,
        'a-space': Space,
        'a-table': Table,
        'search-outlined': SearchOutlined,
    },
    data() {
        return {
            yearsData: [],
            searchText: '',
            searchedColumn: '',
            columns: [],
        };
    },
    mounted() {
        this.fetchTupadYearlyData();
        this.fetchActiveHeaders().then(keys => {
            this.columns = keys.map(key => ({
                title: key.charAt(0).toUpperCase() + key.slice(1),
                dataIndex: key,
                key: key,
                ...this.getColumnSearchProps(key)
            }));
        });
    },
    methods: {
        async fetchTupadYearlyData(startDate, endDate) {
            try {
                const response = await axios.get('/api/dashboard/getData', {
                        params: {
                            start_date: startDate,
                            end_date: endDate
                        },
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('token')}`
                    },
                });
                this.yearsData = response.data;
            } catch (error) {
                console.error("Error fetching data:", error);
            }
        },
        async fetchActiveHeaders() {
            try {
                const response = await axios.get('/api/dole/get-active-header');
                if (response.status === 200) {
                    return response.data.headers.map(item => item.key);
                } else {
                    throw new Error('Failed to fetch active headers');
                }
            } catch (error) {
                console.error('Error fetching active headers:', error);
                toastr.error('Failed to fetch active headers');
                return [];
            }
        },
        handleSearch(selectedKeys, confirm, dataIndex) {
            confirm();
            this.searchText = selectedKeys[0];
            this.searchedColumn = dataIndex;
        },
        handleReset(clearFilters, confirm) {
            clearFilters();
            this.searchText = '';
            this.searchedColumn = '';
            confirm();
        },
        renderColumn({
            text
        }, dataIndex) {
            if (dataIndex === 'birthday') {
                const birthday = new Date(text);
                const options = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                return h('span', birthday.toLocaleDateString('en-US', options));
            } else {
                return h(
                    'span',
                    this.searchedColumn === dataIndex && this.searchText ? [
                        h('span', {
                            style: {
                                backgroundColor: '#ffc069',
                                padding: 0
                            }
                        }, this.searchText),
                        text.replace(new RegExp(this.searchText, 'i'), ''),
                    ] :
                    text
                );
            }
        },
        getColumnSearchProps(dataIndex) {
            return {
                filterDropdown: ({
                        setSelectedKeys,
                        selectedKeys,
                        confirm,
                        clearFilters,
                        close
                    }) =>
                    h('div', {
                        style: {
                            padding: 8
                        }
                    }, [
                        h(Input, {
                            placeholder: `Search ${dataIndex}`,
                            value: selectedKeys[0],
                            onInput: (e) => setSelectedKeys(e.target.value ? [e.target.value] : []),
                            onPressEnter: () => this.handleSearch(selectedKeys, confirm, dataIndex),
                            style: {
                                marginBottom: 8,
                                display: 'block'
                            },
                        }),
                        h(Space, [
                            h(
                                Button, {
                                    type: 'primary',
                                    icon: h(SearchOutlined),
                                    size: 'small',
                                    style: {
                                        width: 90
                                    },
                                    onClick: () => this.handleSearch(selectedKeys, confirm, dataIndex),
                                },
                                'Search'
                            ),
                            h(
                                Button, {
                                    onClick: () => this.handleReset(clearFilters, confirm),
                                    size: 'small',
                                    style: {
                                        width: 90
                                    },
                                },
                                'Reset'
                            ),
                            h(
                                Button, {
                                    size: 'small',
                                    style: {
                                        width: 90
                                    },
                                    onClick: close,
                                },
                                'Close'
                            ),
                        ]),
                    ]),
                filterIcon: (filtered) => h(SearchOutlined, {
                    style: {
                        color: filtered ? '#1890ff' : undefined
                    }
                }),
                onFilter: (value, record) => record[dataIndex].toString().toLowerCase().includes(value.toLowerCase()),
                customRender: ({
                    text
                }) => this.renderColumn({
                    text
                }, dataIndex),
            };
        },
    },
});
</script>

  
<style scoped>
.collapse-wrapper .ant-collapse {
    display: flex;
    flex-direction: column;
}

.custom-content {
    width: 100%;
}

.ant-collapse-arrow {
    display: none;
}
</style>
