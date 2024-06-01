<template>
<section class="flex justify-center pt-28">
    <div class="container h-full">
        <div class="flex h-full flex-wrap items-center justify-center text-neutral-800 dark:text-neutral-200">
            <div class="w-full">
                <div class="block rounded-lg bg-white shadow-lg dark:bg-neutral-800">
                    <div class="g-0 lg:flex lg:flex-wrap">
                        <div class="px-4 md:px-0 lg:w-6/12">
                            <div class="md:mx-6 md:p-12">
                                <div class="text-center">
                                    <img class="mx-auto w-48" src="../../assets/kpms.png" alt="logo" />
                                    <h4 class="mb-12 mt-1 pb-1 text-xl text-orange-600 font-semibold">
                                        KPSM
                                    </h4>
                                </div>
                                <form class="max-w-sm mx-auto" @submit.prevent="login">
                                    <div v-if="error" class="text-red-600">{{ error }}</div>
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
                                </form>
                            </div>
                        </div>
                        <div class="right-card mt-1 flex items-center rounded-b-lg lg:w-6/12 lg:rounded-e-lg lg:rounded-bl-none">
                            <img class="mx-auto h-[62vh] w-[65vh]" src="../../assets/congPA.jpg" alt="logo" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</template>

<script>
import axios from '../../main.js'; // use main.js instead of axios para magamit yung base.url at sa axios e hindi na ilalagay doamin ng backend api link nalang

export default {
    data() {
        return {
            email: '',
            password: '',
            error: ''
        };
    },
    mounted() {
    },
    methods: {
        async login() {
    try {
        const response = await axios.post('/api/login', {
            email: this.email,
            password: this.password
        });
        const { user, token } = response.data;
        localStorage.setItem('token', token);
        if (user.type === 'admin') {
            this.$router.push('/admin');
        } else {
            this.$router.push('/');
        }
    } catch (error) {
        console.error('Login failed:', error.response.data.message);
        this.error = error.response.data.message;
    }
}

    }
};
</script>

<style>
.signup-button {
    background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);
}

.right-card {
    background: #e5aa35;
    background: linear-gradient(135deg, #e5aa35, #fcc071);
}
</style>
