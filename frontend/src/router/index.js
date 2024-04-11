import { createRouter, createWebHistory } from 'vue-router'
import store from '@/store';

const routes = [
	{ path:'/', name:'Home Page', component:() => import('../views/UserView/Home/HomePage.vue')},
	{ path:'/medical-request', name:'Medical Request', component:() => import('../views/UserView/Medical/MedicalRequest.vue'),meta: { requiresAuth: true }},
	{ path:'/scholarship', name:'scholarship', component:() => import('../views/UserView/Scholarship/ScholarRequest.vue'),meta: { requiresAuth: true }},
	{ path: '/admin', name: 'Home', component: () => import('../views/AdminViews/Home/HomeView.vue') },
	{ path: '/login', name: 'Login', component: () => import('../views/Account/Login.vue') }, 
	{ path: '/register', name: 'Register', component: () => import('../views/Account/Register.vue') }, 
	{ path: '/forgot-password', name: 'Forgot Password', component: () => import('../views/Account/ForgotPassword.vue') }, 
	{ path: '/change-password', name: 'Change Password', component: () => import('../views/Account/ChangePassword.vue') }
]

const router = createRouter({
	history: createWebHistory(),
	routes
  });
  
  router.beforeEach((to, from, next) => {
	if (to.meta.requiresAuth) {
	  const token = localStorage.getItem('token');
  
	  if (!token) {
		next('/login');
	  } else {
		next();
	  }
	} else {
	  next();
	}
  });
  
  export default router;