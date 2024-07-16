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
        //Account
        { path: '/login', name: 'Login', component: () => import('../views/Account/Login.vue') },
        { path: '/register', name: 'Register', component: () => import('../views/Account/Register.vue') },
        { path: '/forgot-password', name: 'Forgot Password', component: () => import('../views/Account/ForgotPassword.vue') }, 
        { path: '/change-password', name: 'Change Password', component: () => import('../views/Account/ChangePassword.vue') },
        //User Side
        { path:'/', name:'HomePage', component:() => import('../views/UserView/Home/HomePage.vue')},
        { path:'/tupad', name:'Tupad', component:() => import('../views/UserView/Dole/Tupad.vue')}, //need invitation code from captain
        { path:'/medical-request', name:'Medical Request', component:() => import('../views/UserView/Medical/MedicalRequest.vue')},
        { path:'/educational-assistance', name:'Scholarship Request', component:() => import('../views/UserView/Scholarship/ScholarRequest.vue')},
        { path:'/smart-grant', name:'Smart Grant Request', component:() => import('../views/UserView/Scholarship/SmartGrant.vue')},
        { path:'/tulong-dunong', name:'Tulong Dunong Request', component:() => import('../views/UserView/Scholarship/TulongDunong.vue')},
        // Brgy. Captain Side
        { path:'/gip', name:'GIP', component:() => import('../views/UserView/Dole/GIP.vue'),meta: {  requiresCaptain: true }},
        { path:'/tupad-slot', name:'Tupad Slot', component:() => import('../views/UserView/Dole/TupadSlot.vue'),meta: {  requiresCaptain: true }},
        // news
        // { path: '/article/:id', name: 'ArticlePage', component:() => import('../components/ArticlePage.vue') },
        { path:'/arts/:id', name:'Article', component:() => import('../components/ArticlePage.vue')},
        { path: '/admin/all-news', name: 'NewsPage', component: () => import('../views/AdminViews/News/NewsManagement.vue') ,meta: {  requiresAdminOrSuperAdmin: true }},
        { path: '/admin/manage-article', name: 'ArticlePage', component: () => import('../views/AdminViews/News/NewsManagement.vue') ,meta: {  requiresAdminOrSuperAdmin: true }},
        { path: '/admin/manage-events', name: 'EventsPage', component: () => import('../views/AdminViews/News/NewsManagement.vue') ,meta: {  requiresAdminOrSuperAdmin: true }},
        { path: '/admin/manage-announcement', name: 'AnnouncementPage', component: () => import('../views/AdminViews/News/NewsManagement.vue') ,meta: {  requiresAdminOrSuperAdmin: true }},
        { path: '/admin/manage-updates', name: 'UpdatesPage', component: () => import('../views/AdminViews/News/NewsManagement.vue') ,meta: {  requiresAdminOrSuperAdmin: true }},
        { path: '/admin/manage-draft', name: 'DraftPage', component: () => import('../views/AdminViews/News/NewsManagement.vue')},
        { path: '/admin/add-news', name: 'AddNews', component: () => import('../views/AdminViews/News/AddNews.vue') ,meta: {  requiresAdminOrSuperAdmin: true }},
        //Admin
        { path: '/manage-tupad', name: 'Manage Tupad', component: () => import('../views/AdminViews/Dole/ManageTupad.vue') ,meta: {  requiresAdminOrSuperAdmin: true }},
        { path: '/admin', name: 'Home', component: () => import('../views/AdminViews/Home/HomeView.vue') ,meta: {  requiresAdminOrSuperAdmin: true }},
        { path: '/manage-scholarship', name: 'Manage Scholarship', component: () => import('../views/AdminViews/Education/ManageScholar.vue') ,meta: {  requiresAdminOrSuperAdmin: true }},
        { path: '/manage-smart-grant', name: 'Manage Smart Grant', component: () => import('../views/AdminViews/Education/ManageSmartGrant.vue') ,meta: {  requiresAdminOrSuperAdmin: true }},
        { path: '/manage-tulong-dunong', name: 'Manage Tulong Dunong', component: () => import('../views/AdminViews/Education/ManageTulongDunong.vue') ,meta: {  requiresAdminOrSuperAdmin: true }},
        { path: '/manage-medical-request', name: 'Manage Medical Request', component: () => import('../views/AdminViews/Medical/ManageMedicalRequest.vue') ,meta: {   }},
        { path: '/manage-logo', name: 'Manage Logo', component: () => import('../views/AdminViews/Utility/Logo.vue') ,meta: {  requiresAdminOrSuperAdmin: true }},
        { path: '/manage-emails', name: 'Emails', component: () => import('../views/AdminViews/Utility/Email.vue') ,meta: {  requiresAdminOrSuperAdmin: true }},
        { path: '/manage-tupad-headers', name: 'Tupad Header', component: () => import('../views/AdminViews/Utility/TupadHeader.vue') ,meta: {  requiresAdminOrSuperAdmin: true }},
        { path: '/manage-budget', name: 'Budget Allocation', component: () => import('../views/AdminViews/Utility/Budget.vue') ,meta: {  requiresAdminOrSuperAdmin: true }},
        { path: '/manage-educational-amount', name: 'Manage Educational Amount', component: () => import('../views/AdminViews/Utility/EducationalAmount.vue') ,meta: {  requiresAdminOrSuperAdmin: true }},
        { path: '/manage-hospital', name: 'Manage Hospital', component: () => import('../views/AdminViews/Utility/ManageHospital.vue') ,meta: {  requiresAdminOrSuperAdmin: true }},
        { path: '/hospital-request', name: 'Manage Hospital Request', component: () => import('../views/AdminViews/Utility/ManageHospitalRequest.vue') ,meta: {  requiresAdminOrSuperAdmin: true }},
    ]
});
router.beforeEach(async (to, from, next) => {
    document.title = to.name || 'KPSM';
    if (to.meta.requiresAdminOrSuperAdmin || to.meta.requiresCaptain || to.meta.requiresClient ) {
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
            if (to.meta.requiresAdminOrSuperAdmin && userType !== 'admin' && userType !== 'superadmin' ) {
                toastr.error('Sorry but this page is only for ADMIN or SUPERADMIN.');
                next('/login');
            } else if (to.meta.requiresCaptain && userType !== 'captain') {
                toastr.error('Sorry but this page is only for BRGY. CAPTAIN.');
                next('/login');
            } else if (to.meta.requiresClient && userType !== 'client') {
                toastr.error('Sorry but this page is only for Client.');
                next('/login');
            } else {
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
