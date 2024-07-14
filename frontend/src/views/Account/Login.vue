<template>
<section class="register-wizard bg-cover bg-center min-h-screen flex items-center justify-center">
    <div class="flex items-center justify-center h-screen w-full">
        <a-card class="custom-card rounded-lg p-5 shadow-md h-6/6 md:w-[25vw] mx-auto">
            <div class="text-center mb-4">
                <img class="w-20 mx-auto" src="../../assets/kpms.png" alt="logo" />
                <h4 class="text-xl text-orange-600 font-semibold">KPSM</h4>
            </div>
            <a-form @submit.prevent="login" layout="vertical">
                <div class="mb-5">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                    <input type="email" id="email" v-model="email" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" placeholder="name@gmail.com" required />
                </div>
                <div class="mb-5">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                    <input type="password" id="password" v-model="password" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required />
                </div>
                <div class="mb-6 flex items-center justify-between">
                    <div class="mb-[0.125rem] block min-h-[1.5rem] ps-[1.5rem]">
                        <input class="relative float-left -ms-[1.5rem] me-[6px] mt-[0.15rem] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-secondary-500 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-checkbox before:shadow-transparent before:content-[''] checked:border-primary checked:bg-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:-mt-px checked:after:ms-[0.25rem] checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-l-0 checked:after:border-t-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-black/60 focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-black/60 focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-checkbox checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:-mt-px checked:focus:after:ms-[0.25rem] checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-l-0 checked:focus:after:border-t-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent rtl:float-right dark:border-neutral-400 dark:checked:border-primary dark:checked:bg-primary" type="checkbox" value="" id="exampleCheck3" />
                        <label class="inline-block ps-[0.15rem] hover:cursor-pointer" for="exampleCheck3">
                            Remember me
                        </label>
                    </div>
                    <router-link to="/forgot-password" class="text-primary focus:outline-none dark:text-primary-400">Forgot password?</router-link>
                </div>
                <button type="submit" class="inline-block w-full rounded bg-primary px-7 pb-2.5 pt-3 text-sm font-medium uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out hover:bg-primary-accent-300 hover:shadow-primary-2 focus:bg-primary-accent-300 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:bg-primary-600 active:shadow-primary-2 dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong" data-twe-ripple-init data-twe-ripple-color="light">
                    Sign in
                </button>
                <router-link to="/register" class="inline-block w-full rounded bg-success px-7 pb-2.5 pt-3 mt-2 text-center text-sm font-medium uppercase leading-normal text-white shadow-primary-3 transition duration-150 ease-in-out hover:bg-primary-accent-300 hover:shadow-primary-2 focus:bg-primary-accent-300 focus:shadow-primary-2 focus:outline-none focus:ring-0 active:bg-primary-600 active:shadow-primary-2 dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong" data-twe-ripple-init data-twe-ripple-color="light">
                    Register</router-link>
            </a-form>
        </a-card>
    </div>

</section>
</template>

<script>
import Flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
import axios from '../../main.js';
import {
    Form,
    Input,
    Button,
    Alert,
    Card,
    Row,
    Col,
    Select,
    DatePicker,
    Checkbox,
    Modal,
} from "ant-design-vue";
import {
    ref
} from 'vue';

import {
    useToast
} from 'vue-toastification'
import SelectPhilippinesAddress from 'select-philippines-address';
const toastr = useToast()
import {
    cities,
    barangays
} from 'select-philippines-address';
export default {
    data() {
        return {
            email: '',
            password: '',
            error: ''
        };
    },
    components: {
        SelectPhilippinesAddress,
        'a-form': Form,
        'a-form-item': Form.Item,
        'a-input': Input,
        'a-button': Button,
        'a-alert': Alert,
        'a-card': Card,
        'a-row': Row,
        'a-col': Col,
        'a-select': Select,
        'a-select-option': Select.Option,
        'a-date-picker': DatePicker,
        'a-checkbox': Checkbox,
        'a-modal': Modal,
    },
    mounted() {
        initFlowbite();
    },
    methods: {
        async login() {
            try {
                const response = await axios.post('/api/login', {
                    email: this.email,
                    password: this.password
                });
                const {
                    user,
                    token
                } = response.data;
                localStorage.setItem('token', token);
                if (user.type === 'admin') {
                    this.$router.push('/admin');
                } else if (user.type === 'superadmin') {
                    this.$router.push('/admin');
                } else {
                    this.$router.push('/');
                }
            } catch (error) {
                console.error('Login failed:', error.response.data.message);
                this.error = error.response.data.message;
            }
        }
    },
    watch: {

    },
};
</script>

<style scoped>
@media only screen and (min-width: 1024px) {
    .register-wizard {
        background-image: url('../../assets/congPA.jpg');
        background-size: 50%;
    }

    .custom-card {
        margin-top: 45vh;
        background-color: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(5px);
    }
}

.custom-card {
    background-color: rgba(255, 255, 255, 0.5);
    backdrop-filter: blur(5px);
}
</style>
