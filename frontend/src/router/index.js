import { createRouter, createWebHistory } from 'vue-router'
import store from '@/store';
import axios from '../main.js';
import {
	useToast
} from 'vue-toastification'   
const toastr = useToast()

const routes = [
	//Account
	{ path: '/login', name: 'Login', component: () => import('../views/Account/Login.vue') }, 
	{ path: '/register', name: 'Register', component: () => import('../views/Account/Register.vue') }, 
	{ path: '/forgot-password', name: 'Forgot Password', component: () => import('../views/Account/ForgotPassword.vue') }, 
	{ path: '/change-password', name: 'Change Password', component: () => import('../views/Account/ChangePassword.vue') },

	//User Side
	{ path:'/', name:'Home Page', component:() => import('../views/UserView/Home/HomePage.vue')},
	{ path:'/medical-request', name:'Medical Request', component:() => import('../views/UserView/Medical/MedicalRequest.vue'),meta: { requiresAuth: true }},
	{ path:'/scholarship', name:'scholarship', component:() => import('../views/UserView/Scholarship/ScholarRequest.vue'),meta: { requiresAuth: true }},

	//Brgy. Captain Side
	{ path:'/tupad', name:'Tupad', component:() => import('../views/UserView/Dole/Tupad.vue'),meta: { requiresAuth: true, requiresCaptain: true }},
	{ path:'/gip', name:'GIP', component:() => import('../views/UserView/Dole/GIP.vue'),meta: { requiresAuth: true, requiresCaptain: true }},

	//Admin
	{ path: '/admin', name: 'Home', component: () => import('../views/AdminViews/Home/HomeView.vue') ,meta: { requiresAuth: true, requiresAdmin: true }},
	{ path: '/manage-medical-request', name: 'Manage Medical Request', component: () => import('../views/AdminViews/Medical/ManageMedicalRequest.vue') ,meta: { requiresAuth: true, requiresAdmin: true }},

]

const router = createRouter({
	history: createWebHistory(),
	routes
  });
  
  router.beforeEach(async (to, from, next) => {
    if (to.meta.requiresAuth) {
        const token = localStorage.getItem('token');
        if (!token) {
            next('/login');
        } else {
            try {
                const response = await axios.get('/api/getUserType', {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });
                const userType = response.data.type;
                if (to.meta.requiresAdmin && userType !== 'admin') {
					toastr.error('Sorry but this page is only for ADMIN.');
                    next({ name: 'Home Page' });
                } else if (to.meta.requiresCaptain && userType !== 'captain') {
					toastr.error('Sorry but this page is only for BRGY. CAPTAIN.');
                    next({ name: 'Home Page' });
                } else {
                    next();
                }
            } catch (error) {
                console.error('Error fetching user data:', error);
                next('/login'); 
            }
        }
    } else {
        next();
    }
});




  export default router;