<template>
<div>
    <div class="flex justify-center">
        <div class="w-full py-10 bg-gray-50 dark:bg-gray-800 rounded px-4">
            <div class="collapse-wrapper">
                <a-collapse accordion>
                    <a-collapse-panel show-arrow="false" v-for="year in yearsData" :key="year.year" :header="`Year: ${year.year} - Total: ${year.total_per_year}`">
                        <div class="custom-content">
                            <a-collapse accordion>
                                <a-collapse-panel show-arrow="false" v-for="month in year.months" :key="month.month" :header="`Month: ${month.month} - Total: ${month.total_per_month}`">
                                    <div class="custom-content">
                                        <a-collapse accordion>
                                            <a-collapse-panel show-arrow="false" v-for="hospital in month.hospitals" :key="hospital.hospital" :header="`Hospital: ${hospital.hospital} - Total: ${hospital.total_per_hospital}`">
                                                <div class="custom-content">
                                                    <a-collapse accordion>
                                                        <a-collapse-panel show-arrow="false" v-for="municipality in hospital.municipalities" :key="municipality.municipality" :header="`Municipality: ${municipality.municipality} - Total: ${municipality.total_per_municipality}`">
                                                            <div class="custom-content">
                                                                <a-collapse accordion>
                                                                    <a-collapse-panel show-arrow="false" v-for="barangay in municipality.barangays" :key="barangay.barangay" :header="`Barangay: ${barangay.barangay} - Total: ${barangay.total_per_barangay}`">
                                                                        <a-table :columns="columns" :dataSource="barangay.details" rowKey="id" :scroll="{ x: 'max-content' }" />
                                                                    </a-collapse-panel>
                                                                </a-collapse>
                                                            </div>
                                                        </a-collapse-panel>
                                                    </a-collapse>
                                                </div>
                                            </a-collapse-panel>
                                        </a-collapse>
                                    </div>
                                </a-collapse-panel>
                            </a-collapse>
                        </div>
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
            columns: [{
                    title: 'Hor Code',
                    dataIndex: 'Hor_code',
                    key: 'Hor_code',
                    ...this.getColumnSearchProps('Hor_code')
                },
                {
                    title: 'First Name',
                    dataIndex: 'firstname',
                    key: 'firstname',
                    ...this.getColumnSearchProps('firstname')
                },
                {
                    title: 'Middle Name',
                    dataIndex: 'middlename',
                    key: 'middlename',
                    ...this.getColumnSearchProps('middlename')
                },
                {
                    title: 'Last Name',
                    dataIndex: 'lastname',
                    key: 'lastname',
                    ...this.getColumnSearchProps('lastname')
                },
                {
                    title: 'Age',
                    dataIndex: 'age',
                    key: 'age',
                    ...this.getColumnSearchProps('age')
                },
                {
                    title: 'Birthday',
                    dataIndex: 'birthday',
                    key: 'birthday',
                    ...this.getColumnSearchProps('birthday')
                },
                {
                    title: 'Gender',
                    dataIndex: 'gender',
                    key: 'gender',
                    ...this.getColumnSearchProps('gender')
                },
                {
                    title: 'Representative Full Name',
                    dataIndex: 'representativefullname',
                    key: 'representativefullname',
                    ...this.getColumnSearchProps('representativefullname')
                },
                {
                    title: 'Contact Number',
                    dataIndex: 'contactnumber',
                    key: 'contactnumber',
                    ...this.getColumnSearchProps('contactnumber')
                },
                {
                    title: 'Diagnosis',
                    dataIndex: 'diagnosis',
                    key: 'diagnosis',
                    ...this.getColumnSearchProps('diagnosis')
                },
                {
                    title: 'Hospital',
                    dataIndex: 'hospital',
                    key: 'hospital',
                    ...this.getColumnSearchProps('hospital')
                },
                {
                    title: 'Request',
                    dataIndex: 'request',
                    key: 'request',
                    ...this.getColumnSearchProps('request')
                },
            ],
        };
    },
    mounted() {
        this.fetchDataHospitalYearly();
    },
    methods: {
        async fetchDataHospitalYearly(startDate, endDate) {
            try {
                const response = await axios.get('/api/dashboard/medical-requests-data', {
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
                    h(
                        'div', {
                            style: {
                                padding: 8
                            }
                        },
                        [
                            h(Input, {
                                placeholder: `Search ${dataIndex}`,
                                value: selectedKeys[0],
                                onInput: e => setSelectedKeys(e.target.value ? [e.target.value] : []),
                                onPressEnter: () => this.handleSearch(selectedKeys, confirm, dataIndex),
                                style: {
                                    marginBottom: 8,
                                    display: 'block'
                                },
                            }),
                            h(
                                Space,
                                [
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
                                ]
                            ),
                        ]
                    ),
                filterIcon: filtered => h(SearchOutlined, {
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

/* Hide the arrow icon */
.ant-collapse-arrow {
    display: none;
}
</style>
