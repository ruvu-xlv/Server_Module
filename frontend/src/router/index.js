//import vue router
import { createRouter, createWebHistory } from 'vue-router'

//define a routes
const routes = [
    {
        path: '/',
        name: 'home',
        component: () => import('../views/home.vue')
    },
    {
        path: '/admin/game',
        name: 'admin.game.index',
        component: () => import( '../views/game/index.vue')
    },
    {
        path: '/admin/game/create',
        name: 'admin.game.create',
        component: () => import('../views/game/create.vue')
    },
    {
        path: '/admin/game/edit/:id',
        name: 'admin.game.edit',
        component: () => import('../views/game/edit.vue')
    },
    {
        path: '/show/game/:id',
        name: 'show.game',
        component: () =>import('../views/game/show.vue')

    },
]

//create router
const router = createRouter({
    history: createWebHistory(),
    routes // <-- routes,
})

export default router