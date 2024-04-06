import { createRouter, createWebHistory } from 'vue-router'

const routes = [
	{
		path: '/',
		name: 'Home',
		component: () => import('../views/AdminViews/Home/HomeView.vue')
	},
	{
		path: '/login',
		name: 'Login',
		component: () => import('../views/Account/Login.vue')
	}, 
	{
		path: '/register',
		name: 'Register',
		component: () => import('../views/Account/Register.vue')
	}
]

const router = createRouter({
	history: createWebHistory(process.env.BASE_URL),
	routes
})

export default router
