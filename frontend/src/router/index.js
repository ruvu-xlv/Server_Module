//import vue router
import { createRouter, createWebHistory } from 'vue-router'

//define a routes
const routes = [
    {
        path: '/',
        name: 'home',
        component: () => import( /* webpackChunkName: "home" */ '../views/home.vue')
    },
    {
        path: '/admin/game',
        name: 'admin.game.index',
        component: () => import( /* webpackChunkName: "index" */ '../views/game/index.vue')
    },
    {
        path: '/admin/game/create',
        name: 'admin.game.create',
        component: () => import( /* webpackChunkName: "create" */ '../views/game/create.vue')
    },
    {
        path: '/admin/game/edit/:id',
        name: 'admin.game.edit',
        component: () => import( /* webpackChunkName: "edit" */ '../views/game/edit.vue')
    }
]

//create router
const router = createRouter({
    history: createWebHistory(),
    routes // <-- routes,
})

export default router