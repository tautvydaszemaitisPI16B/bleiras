import { createRouter, createWebHistory } from 'vue-router'
import { getUser } from '../services/auth'

import Home from '../pages/Home.vue'
import Login from '../pages/auth/Login.vue'
import News from '../pages/admin/News.vue'

const router = createRouter({
    history: createWebHistory(),

    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
            meta: {
                guest: true,
            },
        },
        {
            path: '/admin',
            name: 'admin.news',
            component: News,
            meta: {
                auth: true,
            },
        },
    ],
})

let currentUser = undefined

router.beforeEach(async (to) => {
    if (currentUser === undefined) {
        try {
            currentUser = await getUser()
        } catch {
            currentUser = null
        }
    }

    if (to.meta.auth && !currentUser) {
        return {
            name: 'login',
            query: {
                redirect: to.fullPath,
            },
        }
    }

    if (to.meta.guest && currentUser) {
        return {
            name: 'admin.news',
        }
    }
})

export const setCurrentUser = (user) => {
    currentUser = user
}

export const getCurrentUser = () => {
    return currentUser
}

export default router
