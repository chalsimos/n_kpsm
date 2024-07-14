import { createRouter, createWebHistory } from 'vue-router'
import store from '@/store';
import axios from '../main.js';
import {
	useToast
} from 'vue-toastification'
import { Components } from 'ant-design-vue/es/date-picker/generatePicker/index.js';
const toastr = useToast()

const router = createRouter({
	history: createWebHistory(),
	routes: [
        //need invitation code from captain
        // { path:'/tupad', name:'Tupad', component:() => import('../views/UserView/Dole/Tupad.vue')},
        { path:'/test', name:'test', component:() => import('../views/test.vue')},
        { path:'/tupad', name:'Tupad', component:() => import('../views/UserView/Dole/Tupad.vue')},
        //Account
        { path: '/login', name: 'Login', component: () => import('../views/Account/Login.vue') },
        { path: '/register', name: 'Register', component: () => import('../views/Account/Register.vue') },
        { path: '/forgot-password', name: 'Forgot Password', component: () => import('../views/Account/ForgotPassword.vue') }, 
        { path: '/change-password', name: 'Change Password', component: () => import('../views/Account/ChangePassword.vue') },

        //User Side
        { path:'/', name:'HomePage', component:() => import('../views/UserView/Home/HomePage.vue')},
        { path:'/medical-request', name:'Medical Request', component:() => import('../views/UserView/Medical/MedicalRequest.vue'),meta: { requiresClient: true}},
        { path:'/scholarship', name:'scholarship', component:() => import('../views/UserView/Scholarship/ScholarRequest.vue'),meta: { requiresClient: true}},

        // Brgy. Captain Side
        { path:'/gip', name:'GIP', component:() => import('../views/UserView/Dole/GIP.vue'),meta: {  requiresCaptain: true }},
        // { path:'/tupad-slot', name:'GIP', component:() => import('../views/UserView/Dole/TupadSlot.vue'),meta: {  requiresCaptain: true }},

        //Admin
        // { path: '/manage-tupad', name: 'Manage Tupad', component: () => import('../views/AdminViews/Dole/ManageTupad.vue') ,meta: {  requiresAdmin: true }},
        { path:'/', name:'Home Page', component:() => import('../views/UserView/Home/HomePage.vue')},
        // { path: '/article/:id', name: 'ArticlePage', component:() => import('../components/ArticlePage.vue') },
        { path:'/arts/:id', name:'Article', component:() => import('../components/ArticlePage.vue')},
        { path:'/medical-request', name:'Medical Request', component:() => import('../views/UserView/Medical/MedicalRequest.vue')},
        { path:'/educational-assistance', name:'Scholarship Request', component:() => import('../views/UserView/Scholarship/ScholarRequest.vue')},
    
        //Brgy. Captain Side
        { path:'/gip', name:'GIP', component:() => import('../views/UserView/Dole/GIP.vue'),meta: {  requiresCaptain: true }},
        { path:'/tupad-slot', name:'GIP', component:() => import('../views/UserView/Dole/TupadSlot.vue'),meta: {  requiresCaptain: true }},
    
        //Admin
        { path: '/manage-tupad', name: 'Manage Tupad', component: () => import('../views/AdminViews/Dole/ManageTupad.vue') ,meta: {  requiresAdmin: true }},
        { path: '/admin', name: 'Home', component: () => import('../views/AdminViews/Home/HomeView.vue') ,meta: {  requiresAdmin: true }},
        { path: '/manage-scholarship', name: 'Manage Scholarship', component: () => import('../views/AdminViews/Education/ManageScholar.vue') ,meta: {  requiresAdmin: true }},
        { path: '/manage-medical-request', name: 'Manage Medical Request', component: () => import('../views/AdminViews/Medical/ManageMedicalRequest.vue') ,meta: {  requiresAdmin: true }},
        // news
        { path: '/admin/all-news', name: 'NewsPage', component: () => import('../views/AdminViews/News/NewsManagement.vue') ,meta: {  requiresAdmin: true }},
        { path: '/admin/manage-article', name: 'ArticlePage', component: () => import('../views/AdminViews/News/NewsManagement.vue') ,meta: {  requiresAdmin: true }},
        { path: '/admin/manage-events', name: 'EventsPage', component: () => import('../views/AdminViews/News/NewsManagement.vue') ,meta: {  requiresAdmin: true }},
        { path: '/admin/manage-announcement', name: 'AnnouncementPage', component: () => import('../views/AdminViews/News/NewsManagement.vue') ,meta: {  requiresAdmin: true }},
        { path: '/admin/manage-updates', name: 'UpdatesPage', component: () => import('../views/AdminViews/News/NewsManagement.vue') ,meta: {  requiresAdmin: true }},
        { path: '/admin/manage-draft', name: 'DraftPage', component: () => import('../views/AdminViews/News/NewsManagement.vue') ,meta: {  requiresAdmin: true }},

        { path: '/admin/add-news', name: 'Home', component: () => import('../views/AdminViews/News/AddNews.vue') ,meta: {  requiresAdmin: true }},

    ]
});

router.beforeEach(async (to, from, next) => {
    if (to.meta.requiresAdmin || to.meta.requiresCaptain || to.meta.requiresClient) {
        const token = localStorage.getItem('token');
        if (!token) {
            next('/login');
            return;
        }
        try {
            const response = await axios.get('/api/getUserType', {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            });
            const userType = response.data.type;
            if (to.meta.requiresAdmin && userType !== 'admin') {
                toastr.error('Sorry but this page is only for ADMIN.');
                next('/login');
            } else if (to.meta.requiresCaptain && userType !== 'captain') {
                toastr.error('Sorry but this page is only for BRGY. CAPTAIN.');
                next('/login');
            } else if (to.meta.requiresClient && userType !== 'client') {
                toastr.error('Sorry but this page is only for Client.');
                next('/login');
            }else {
                next();
            }
        } catch (error) {
            console.error('Error fetching user data:', error);
            next('/login');
        }
    } else {
        next();
    }
});

export default router;
