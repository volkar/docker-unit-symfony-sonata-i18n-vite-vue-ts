import { createRouter, createWebHistory } from 'vue-router'

import IndexView from '@/views/IndexView.vue'
import CategoriesView from '@/views/CategoriesView.vue'
import CategoryView from '@/views/CategoryView.vue'
import AboutView from '@/views/AboutView.vue'
import { getInitialLocale } from "@/utils/locale";

const routes = [
    {
        path: '/',
        redirect: `/${getInitialLocale()}`,
    },
    {
        name: 'index',
        component: IndexView,
        path: '/:locale'
    },
    {
        name: 'categories',
        component: CategoriesView,
        path: '/:locale/categories'
    },
    {
        name: 'categoryDetails',
        component: CategoryView,
        path: '/:locale/category/:slug'
    },
    {
        name: 'about',
        component: AboutView,
        path: '/:locale/about'
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes: routes
})

export default router