import { createRouter, createWebHistory } from 'vue-router'

const routes = [
	{path:'/', name:'HomPage', component:() => import('../views/HomePage.vue')},
	{ path: '/admin', name: 'Home', component: () => import('../views/AdminViews/Home/HomeView.vue') },
	{ path: '/login', name: 'Login', component: () => import('../views/Account/Login.vue') }, 
	{ path: '/register', name: 'Register', component: () => import('../views/Account/Register.vue') }, 
	{ path: '/forgot-password', name: 'Forgot Password', component: () => import('../views/Account/ForgotPassword.vue') }, 
	{ path: '/change-password', name: 'Change Password', component: () => import('../views/Account/ChangePassword.vue') }
]

const router = createRouter({
	history: createWebHistory(process.env.BASE_URL),
	routes
})

export default router
