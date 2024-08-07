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
                                            <a-collapse-panel show-arrow="false" v-for="school in month.school" :key="school.school" :header="`School: ${school.school} - Total: ${school.total_per_school}`">
                                                <div class="custom-content">
                                                    <a-collapse accordion>
                                                        <a-collapse-panel show-arrow="false" v-for="municipality in school.municipalities" :key="municipality.municipality" :header="`Municipality: ${municipality.municipality} - Total: ${municipality.total_per_municipality}`">
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
                    title: 'Representative Last Name',
                    dataIndex: 'representative_lastname',
                    key: 'representative_lastname',
                    ...this.getColumnSearchProps('representative_lastname')
                },
                {
                    title: 'Representative First Name',
                    dataIndex: 'representative_firstname',
                    key: 'representative_firstname',
                    ...this.getColumnSearchProps('representative_firstname')
                },
                {
                    title: 'Representative Middle Name',
                    dataIndex: 'representative_middlename',
                    key: 'representative_middlename',
                    ...this.getColumnSearchProps('representative_middlename')
                },
                {
                    title: 'Representative Age',
                    dataIndex: 'representative_age',
                    key: 'representative_age',
                    ...this.getColumnSearchProps('representative_age')
                },
                {
                    title: 'Representative Birthday',
                    dataIndex: 'representative_birthday',
                    key: 'representative_birthday',
                    ...this.getColumnSearchProps('representative_birthday')
                },
                {
                    title: 'Representative Gender',
                    dataIndex: 'representative_gender',
                    key: 'representative_gender',
                    ...this.getColumnSearchProps('representative_gender')
                },
                {
                    title: 'Beneficiary Last Name',
                    dataIndex: 'beneficiary_lastname',
                    key: 'beneficiary_lastname',
                    ...this.getColumnSearchProps('beneficiary_lastname')
                },
                {
                    title: 'Beneficiary First Name',
                    dataIndex: 'beneficiary_firstname',
                    key: 'beneficiary_firstname',
                    ...this.getColumnSearchProps('beneficiary_firstname')
                },
                {
                    title: 'Beneficiary Middle Name',
                    dataIndex: 'beneficiary_middlename',
                    key: 'beneficiary_middlename',
                    ...this.getColumnSearchProps('beneficiary_middlename')
                },
                {
                    title: 'Beneficiary Age',
                    dataIndex: 'beneficiary_age',
                    key: 'beneficiary_age',
                    ...this.getColumnSearchProps('beneficiary_age')
                },
                {
                    title: 'Beneficiary Birthday',
                    dataIndex: 'beneficiary_birthday',
                    key: 'beneficiary_birthday',
                    ...this.getColumnSearchProps('beneficiary_birthday')
                },
                {
                    title: 'Beneficiary Gender',
                    dataIndex: 'beneficiary_gender',
                    key: 'beneficiary_gender',
                    ...this.getColumnSearchProps('beneficiary_gender')
                },
                {
                    title: 'Relationship to Beneficiary',
                    dataIndex: 'relationship_to_beneficiary',
                    key: 'relationship_to_beneficiary',
                    ...this.getColumnSearchProps('relationship_to_beneficiary')
                },
                {
                    title: 'Contact Number',
                    dataIndex: 'contact_number',
                    key: 'contact_number',
                    ...this.getColumnSearchProps('contact_number')
                },
                {
                    title: 'School Level',
                    dataIndex: 'school_level',
                    key: 'school_level',
                    ...this.getColumnSearchProps('school_level')
                },
                {
                    title: 'Year Level',
                    dataIndex: 'year_level',
                    key: 'year_level',
                    ...this.getColumnSearchProps('year_level')
                },
                {
                    title: 'Academic Year Stage',
                    dataIndex: 'academic_year_stage',
                    key: 'academic_year_stage',
                    ...this.getColumnSearchProps('academic_year_stage')
                },
            ],
        };
    },
    mounted() {
        this.fetchEducationalYearlyData();
    },
    methods: {
        async fetchEducationalYearlyData(startDate, endDate) {
            try {
                const response = await axios.get('/api/dashboard/educational-requests-data', {
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
            if (dataIndex === 'representative_birthday' || dataIndex === 'beneficiary_birthday') {
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
