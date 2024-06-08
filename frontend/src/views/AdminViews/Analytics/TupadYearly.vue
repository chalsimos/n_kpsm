<template>
<div class="container mx-auto px-4">
    <div class="flex justify-center">
        <div class="w-full py-10 bg-gray-50 dark:bg-gray-800 rounded">
            <div class="collapse-wrapper">
                <a-collapse accordion>
                    <a-collapse-panel v-for="year in yearsData" :key="year.year" :header="`Year: ${year.year} - Total: ${year.total_per_year}`">
                        <div class="custom-content">
                            <a-collapse accordion>
                                <a-collapse-panel v-for="date in year.dates" :key="date.date" :header="`Date: ${date.date} - Total: ${date.total_per_date}`">
                                    <div class="custom-content">
                                        <a-collapse accordion>
                                            <a-collapse-panel v-for="address in date.addresses" :key="address.address" :header="`Address: ${address.address} - Total: ${address.total_per_address}`">
                                                <a-table :columns="columns" :dataSource="address.details" rowKey="id" :scroll="{ x: 'max-content' }" />
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
                    title: 'Civil Status',
                    dataIndex: 'civil_status',
                    key: 'civil_status',
                    ...this.getColumnSearchProps('civil_status')
                },
                {
                    title: 'Contact Number',
                    dataIndex: 'contact_number',
                    key: 'contact_number',
                    ...this.getColumnSearchProps('contact_number')
                },
                {
                    title: 'Beneficiary Name',
                    dataIndex: 'benificiary_name',
                    key: 'benificiary_name',
                    ...this.getColumnSearchProps('benificiary_name')
                },
                {
                    title: 'ID Type',
                    dataIndex: 'id_type',
                    key: 'id_type',
                    ...this.getColumnSearchProps('id_type')
                },
                {
                    title: 'ID Number',
                    dataIndex: 'id_number',
                    key: 'id_number',
                    ...this.getColumnSearchProps('id_number')
                },
                {
                    title: 'Sitio',
                    dataIndex: 'sitio',
                    key: 'sitio',
                    ...this.getColumnSearchProps('sitio')
                },
                {
                    title: 'Address',
                    dataIndex: 'address',
                    key: 'address',
                    ...this.getColumnSearchProps('address')
                },
                {
                    title: 'Given by Captain',
                    dataIndex: 'given_by_captain',
                    key: 'given_by_captain',
                    ...this.getColumnSearchProps('given_by_captain')
                },
            ],
        };
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        async fetchData() {
            try {
                const response = await axios.get('/api/dashboard/getData', {
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
                    this.searchedColumn === dataIndex && this.searchText ?
                    [
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

/* Hide the arrow icon */
.ant-collapse-arrow {
    display: none;
}
</style>
