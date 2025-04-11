// Import vue-router
import { createRouter, createWebHistory } from 'vue-router'

// Define routes
const routes = [
  {
    path: '/login',
    name: 'login',
    component: () => import('../views/Login.vue'), // Lazy-loaded
  },
  {
    path:'/dashboard',
    name:'/dashboard',
    component:()=>import('../views/admin/Dashboard.vue'),
  }
]

// Create router instance
const router = createRouter({
  history: createWebHistory(), // Using HTML5 history mode
  routes, // Short-hand for routes: routes
})

export default router
